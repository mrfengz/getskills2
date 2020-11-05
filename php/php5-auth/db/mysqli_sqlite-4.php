<?php
/**
 *  数据类型： integer和something else(其他系统中的varchar 可以超过255个字符)
 * sqlite_open()
 * $sqlite = new SQLiteDatabase() 连接脚本到sqlite数据库，数据库不存在会创建一个新的数据库
 *      参数： 1）路径/文件名    2）unixchmod风格的权限    3）错误信息(通过引用传出给该参数)
 *
 * sqlite_close() 把脚本从一个SQLite数据库连接中断开，参数数描述符
 *
 * 查询
 *  $sqlite->query();       //多条记录查询
 *  $sqlite->singleQuery(); //执行一个查询，并返回第一行第一个字段的值
 *  $sqlite->unbufferedQuery(); //执行一个查询，不支持客户端缓冲结果
 *  $sqlite->queryExec();       //执行一个查询链，多个查询用;分开
 *  $sqlite->arrayQuery();      //执行一个查询，并返回一个包含行和所有字段的二维数组
 *
 * 获取数据
 *  $sqlite->fetch();       //用数组的形式返回下一个数据行 类型 SQLITE_ASSOC, SQLITE_NUM, SQLITE_BOTH
 *  $sqlite->fetchObject(className, constructorParamsArr); //用一个chosen类将下一个数据行作为对象返回
 *  $sqlite->fetchSingle(); //返回下一个数据行的第一个字段的值
 *  $sqlite->fetchAll();    //返回整个结果集，并存放在二维数组中。类型 SQLITE_ASSOC, SQLITE_NUM, SQLITE_BOTH
 *
 * 获取数据库对象
 *  select * from sqlite_master;
 *  可以获取数据库对象(表、索引、触发器。。。)
 *
 * 优化
 *  1.PRAGMA count_change = 0;    //关闭计算更改单的记录数的功能，可以提高速度
 *  2.数据存储到硬盘的方式
 *      off             sqlite几乎不会直接写入硬盘，由操作系统来处理
 *      on|normal(默认)  sqlite将在每一段时间内通过fsync()系统调用来确认一次数据是否被提交到硬盘中
 *      FULL            sqlite使用额外的fsync()检查，可以降低突然断电时数据丢失的风险
 *  3. 读取大量数据时，增加缓存的大小，默认2000个页面
 *      PRAGMA cache_size=5000(当前设置，断开连接值丢失)
 *      default_cache_size  长期有效
 */

$db = new SQLiteDatebase("./crm.db", 0666, $error) or die("Failed: $error");

if ($argc < 2) {
    echo "Usage: \n\t php script.php <filename>\n\n";
    die;
}


$create_sql = "
    create table document (
      id integer primary key,
      title,
      intro,
      body
    );
    
    create table dictionary(
      id integer primary key,
      word
    );
    
    create table lookup(
      document_id integer primary key,
      word_id integer,
      position integer,
    );
    
    create unique index word on dictionary(word);
";

$db->query($create_sql);

unset($db);

//从文件中读取邮件集合
$body = file_get_contents($argv[1]);
$mails = preg_split("/^From /m", $body);
unset($body);

$db->query("BEGIN"); //使用事务，
foreach($mails as $id=>$mail) {
    $safe_email = sqlite_escape_string($mail); //数据转义

    $insert_sql = "insert into document(title, intro, body) values('Title', 'This is an intro', '{$safe_email}')";
    echo "Indexing mail #$id.\n";
    $db->query($insert_sql);
}
$db->query("COMMIT");

/**
 * 触发器: 创建一个触发器，在插入docuemnt后
 * $trigger_sql = "
    create trigger index_new
    after insert on document
    BEGIN
        SELECT php_index(new.id, new.title, new.intro, new.body);
    END;
 * ";
 *
 */

/*
 支持自定义函数
    绑定一个sql函数到你php脚本中自定义的函数
    sqlite_create_function($db, $sqlite_func_name, $php_func_name, $argc)
    $sqlite->create_function($sqlite_func_name, $php_func_name, $argc)

 */

$trigger_sql = "
    create trigger index_new
    after insert on document
    BEGIN
        SELECT php_index(new.id, new.title, new.intro, new.body);
    END;";
$db->create_function("php_index", "index_document", 4);

//去掉不需要的字符，所有字符转为小写，标点符号改为空格
function normalize($body)
{
    $body = strtolower($body);
    $body = preg_replace(
        '/[.;,:!?\[\]@\(\)]/', ' ', $body
    );
    $body = preg_replace('/[^a-z0-9 -]/', '_', $body);

    return $body;
}

function index_document($id, $title, $intro, $body)
{
    global $db;
    $id = $db->singleQuery("SELECT max(id) from document");
    //因为 sqlite库有一个bug，不能相信sqlite_last_insert_row_id()的结果
    $body = substr($body, 0, 32000);
    $body = normalize($body);

    //把正文切割为不同的词，并计算出他们在信息中的位置
    $words = preg_split(
        '@([\W]+)@', $body, -1,
        PREG_SPLIT_OFFSET_CAPTURE | PREG_SPLIT_NO_EMPTY
    );

    foreach($words as $word) {
        $safe_word = sqlite_escape_string($word[0]);
        //如果没有下划线且长度小于24个字符，就只输入索引部分
        if((strpos($safe_word. '_') === false ) && (strlen($safe_word) < 24)){
            $result = @$db->query(
                "insert into dictionary(word) values('$safe_word');"
            );

            if ($result != SQLITE_OK) {
                //已经存在，需要获取ID
                $word_id = $db->singleQuery("select id from dictionary where word='$safe_word'");
            } else {
                $word_id = $db->lastInsertRowId();
            }

            $db->query("insert into lookup (document_id, word_id, position) values($id, $word_id, {$word[1]})");
        }
    }
}
?>


<?php
//read data from sqlite

$db = new SQLiteDatabase("./crm.db", 0666, $error) or exit("Failed: $error\n");

class Article
{
    private $id;
    private $title;
    private $intro;
    private $body;
    private $fromDb;

    function save($db)
    {
        $intro = sqlite_escape_string($this->intro);
        $db->query(
            "update document set intro = '$intro' where id = {$this->id};",
        );
    }
}

$db->query(
    "select * from document where body like '%conf%'",
);
//将查询的结果传给Article类，没有参数
$obj1 = $result->fetchObject("Article", NULL);

$obj1->intro =  "This is a changed intro";
$obj1->save($db);

/**
 * 迭代器 另一种遍历结果集的方法，不需要调用任何函数，比使用一个获取数据的函数来得快
 */
$db2 = new SQLiteDatabase("./crm.db", 0666, $error) or die("Failed: $error");
if($argc < 2) {
    echo "Usage: \t php search.php <search words>\r\n";
    die;
}

//按引用传递，对数据进行转义，保证安全
function escape_words(&$value)
{
    $value = sqlite_escape_string($value);
}

//转义要查询的单词
$search_words = array_splice($argv, 1);
array_walker($search_words, 'escape_word');
$words = implode("', '", $search_words);

$search_query = "
    select document_id, count(*) as cnt
    from dictionary d, lookup l 
    where d.id=l.word_id
      and word in ('$words')
      group by document_id
      order by cnt DESC 
      limit 10
";

$doc_ids = [];
$rank = $db->query($search_query, SQLITE_NUM);
foreach($rank as $key => $row){
    $doc_ids[$key] = $row[0];
}

$doc_ids = implode(', ', $doc_ids);

/**
 * 自己编写迭代 Interator 迭代器 traversable 可遍历的
 */
$details_sql = "
    select document_id, substr(doc.body, position-20, 100)
    from dictionary d, lookup l, document doc
    where d.id=l.word_id
      and document_id in ($doc_ids)
      and document_id=doc.id
  group by document_id, doc.body
";
//迭代器绑定到了 result对象
$result = $db->unbufferedQuery($details_sql, SQLITE_NUM);
//循环获取结果
while($result->valid()){
    $record = $result->current();
    $list[$record[0]] = $record[1];
    $result->next();
}

/**
 * 聚合用户自定义的函数
 */
function average_length_step(&$ctxt, $string)
{
    if(!isset($ctxt['count'])){
        $ctxt['count'] = 0;
    }
    if(!isset($ctxt['length'])){
        $ctxt['length'] = 0;
    }

    $ctxt['count']++;
    $ctxt['length'] += strlen($string);
}

function average_length_finalize(&$ctxt)
{
    return sprintf("Avg. over {$ctxt['count']} wprds is %.3f chars.", $ctxt['length'] / $ctxt['count']);
}

$db->creaetAggreate(
    'average_length',//在sql语句中使用的聚合函数名称
    'average_length_step',//每一个记录执行的函数
    'average_length_finalize' //所有的记录都选出时调用的函数的名称
);

$avg = $db->singleQuery(
    "select average_length(word) from dictionary"
);

echo $avg."\n";
?>
