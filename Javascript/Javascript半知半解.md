1 <script>属性 
	async	加载外部文件	多个的时候，会乱序加载，并行加载，加载完毕后会阻塞文档解析，执行后会继续解析文档
	defer	加载外部文件	多个的时候，按照顺序加载，并行加载，但是会等到文档渲染完毕后才会执行
Javascript 
	语法
	数据类型
	表达式
	运算符
	语句
	对象 
	数组 
	函数

#### 基本语法
	1 严格模式
		"use strict"; //在整个脚本中开启严格模式，ES5中引入
		function doSomething(){
			"use strict"; 
			//函数体
		}

	2 语句结尾可以用;分割，也可以省略，当代码无法正常解析时，会自动在语句末尾添加;分号。但是有些时候，可能会出错。

	3 函数定义的变量，如果没有添加var操作符，相当于定义了一个全局变量，在函数外的任何地方都可以访问到。不推荐省略
		function test(){
			var a = b = 0;
		}
		test();
		// 从右向左执行，b是全局变量，a不是
		console.log(a,b); //ReferenceError: a is not defined

		使用var创建的全局变量不能删除
		不使用var创建的隐含全局变量可以使用delete删除(因为它不是真正的变量，而是全局对象window的属性)

	4 变量提升
		变量提升指的是所有变量的声明语句，都会被提升到代码的头部。
			console.log(a); //undefined
			var a = 1;
		JS变量分为声明和执行阶段，上面的代码是这么解释滴
			var a;
			console.log(a);
			a = 1;

	5 复制变量值
		//值传递
		var num1 = 3;
		var num2 = mum1; 

		//引用传递
		var obj1 = new Object();
		var obj2 = obj1;
		obj2.name = 'tg';
		console.log(obj1.name); // tg

		对象和原始值(布尔值、数字、字符串、null和undefined)之间的区别在于比较方式。
		原始值比较的是指，只要编码相同，则认为相同
		而对象比较的是引用(也可以说是地址引用)

	6 Unicode转义序列码
		JavaScript定义了一种特殊序列，使用6个ASCII字符来代表任意16位Unicode内码。这些Unicode序列码均以\u为前缀，其后跟随4个十六进制

#### 数据类型
	5种简单数据类型： undefined, Null, Boolean, Number, String
	复杂数据类型：Object
	注：ES6中增加了Symbol

	typeof操作符
		检测变量的数据类型
		undefined	这个值未定义
		boolean 	这个值是布尔值
		string 		这个值是字符串
		number 		这个值是数值
		object 		这个值时对象或者null typeof null/new Object 
		function 	这个值是函数	typeof function(){}

		undefined == null //true
		"" == 0 //true
		"" == undefined/null // false

	ifFinity() 检测这个数是否是无穷的
		Number.MIN_VALUE(5e-324) / Number.MAX_VALUE(1.7976931348623157e+308) 之外的数都看做无穷的 

	NaN
		表示非数值，这个数值用于表示一个本来要返回数值的操作数未返回数值的情况
		注意：（1）任何涉及NaN的操作都会返回NaN（2）NaN与任何值都不相等，包括NaN本身（3）用isNaN(param)判断是否非数值,param可以是任意类型  该函数会尝试将参数转为数值，如果不能转换为数字，则会返回true; // "10" true 都会返回false
	
	数值转换
		非数值转换为数值的3个函数 Number()  parseInt()  pasreFloat()
		-----Number()-----
		Number(true/false) 	1/0
		Number(undefined)  	NaN 
		Number(null)		返回0
		如果是数字值，只是简单的传入和返回
		如果是字符串
			1）只包含数字(包括符号)，将其转换为十进制数
			2）如果包含浮点数，则将其转为对应的浮点数
			3）如果字符串是空的，返回0
			4）如果是上述格式以外的字符，返回NaN
			5）如果是空字符串，返回0

		-----parseInt()和parseFloat()-----
		parseInt()可以提供第二个参数，指定需要转换的进制
		parseInt('070', 8); //56
		parseInt('AD'); //NaN
		parseInt('343AS'); //343
		parseInt()和parseFloat()类似，也是从第一个字符(位置0开始解析每个字符，而一直解析到字符串末尾，或者解析到遇到一个无效的浮点数字字符为止)

	String 
		ES5可以写在多行 但是必须以\结尾每行
		// ES 5
		'Hello \
		world'

		\unnnn 以十六进制代码nnnn表示的一个Unicode字符

		转换为字符串
		1）p.toString() 可以传入一个参数，输出数值的基数 num.toString(2) // 1010
		2）String(p) 如果有toString()，则调用toString()并返回相应的结果
			String(null) //null
			String(undefined) //undefined
			String({}) // "[object Object]"
			String([]) // ""
		3）p+'' //加号操作符

	Object 
		var obj = new Object();

		Object的每个实例都有下列属性和方法
			1 Constructor: 保存着用于创建当前对象的函数，比如上面的例子，构造函数就是Object()
			2 hasOwnProperty(propertyName): 用于检查给定的属性在当前对象实例中是否存在(而不是在实例的原型中)，参数必须是字符串形式
			3 isPrototypeOf(object): 用于检查传入的对象是否是另一个对象的原型
			4 propertyIsEnumerable(propertyName): 用于检查给定的属性是否能够使用 for-in 语句来枚举，参数必须为字符串形式
			5 toLocaleString(): 返回对象的字符串表示，该字符串与执行环境的地区对应
			6 toString(): 返回对象的字符串表示 
			7 valueOf(): 返回对象的字符串、数值或布尔值表示，通常和toString()返回的值相同
#### 运算符
	自增、自减运算符
		1 当操作数是包含有效数字字符的字符串时，系统会将其转换为数字值，再执行递增或递减
		2 当操作数是一个不包含有效数字字符的字符串，系统将变量的值设置为NaN
		3 当操作数是布尔值时，会将其转为数值(true转为1，false转为0)再操作
		4 当操作数是浮点数值，直接执行递减或递增
		5 当操作数是对象，先调用对象的valueOf()方法取得一个可供操作的值，然后再遵循上面的3条规则。如果是NaN,则在调用toString()方法再遵循上面的规则转换
		var a = "334a"; a--; //NaN
		var a = true; --a; // 0

	有符号整数 32位的那种，首位表示符号，0表示正数，1表示负数

	乘性运算符 乘法、除法和求模
		如果操作数是非数值，会自动执行类型转换，使用Number()方法转换
		----乘法----
		1*NaN // NaN
		Infinity*0 //NaN
		Infinity*2 //Infinity
		如果操作数不是数值，则会先将其转换为数值型，再进行计算

	加法
		一定要注意 '3' + '3' = '33' 此时相当于连接符
		可以使用 parseInt('3') + parseInt('3')

	in 运算符 
		如果右操作数对象拥有一个名为左操作数的属性名，则返回true
		var o = {x:1};
		"x" in o // true

	instanceof 运算符
		左操作数为一个对象，右操作数标识对象的类。如果左侧的对象是右侧类的实例，则表达式返回true
		var a = new Array();
		a instanceof Object // true 虽有对象都是object的实例

	typeof 运算符
		typeof 变量 

	delete 运算符
		var o = {x:1};
		delete o.x;
		"x" in o // false

#### 表达式
	属性访问表达式
	var arr = [1];
	var obj = {x:1};
	arr[0];
	obj.x
	//在"."和"["之前的表达式总是会首先计算，如果计算结果是null或者undefined,表达式会抛出一个类型错误异常，因为这两个值都不能包含任何异常

#### 语句
	for ... in 语句 
		for(property in object){
			statement //ESMAScript对象的属性是没有顺序的，因此通过for...in输出的属性名的顺序是不可预测的
		}

	跳转语句
		break [label]
		continue [label]

	标签语句
		label: statement
		var num = 0; 
		tip: for(var i = 0; i < 10; i++){
			num += i; 
			console.log(i); // 0 1 2 3 4 5
			if(i==5){
				break tip; //跳出tip对应的层
			}
		} 
		console.log(num); //15

#### 对象
	var o = {
		//对象属性名不用加引号
		go:function(){
			return "go where";
		},
		desc: "test"
	}
	调用对象属性、方法
	o.go() //调用方法 go where
	o.desc //调用属性 "test"

	对象创建
		1 对象直接量 		var o = {} //最后一个属性后面可以不加逗号，如果多一个逗号，在ie中会报错
		2 关键字 new  	var o = new Object(); // Object()是构造函数
		3 Object.create()函数 	var o = Object.create(null)

	对象常见用法
		创建 create
		设置 set 
		查找 query 
		删除 delete 
		检测 test 
		枚举 enumerate

	提取方法
		var obj = {
			name: 'a',
			get: function(){
				console.log(this.name);
			}
		}
		o.get(); // a
		var f = obj.get;
		f(); //undefined 此时的this指向的是window。严格模式下，this是undefined

	属性特性
		可写(writable attribute): 可设置该属性的值
		可枚举(enumerable attribute): 可以通过 for...in 循环返回该属性
		可配置(configurable attribute): 可删除或修改属性

	读取属性
		1 obj.name 
		2 obj['name']
		注：数值键不能使用"."运算符，会被当做小数点

	属性的查询和设置
		var o = {
			name: 'a',
			age: 12
		};
		1 for ... in 
			for(var i in o) {
				console.log(o[i]);
			}
		2 查看所有属性 Object.keys(o) //也可以枚举方法属性
		3 删除运算 delete o.name //只能删除自由属性，不能删除继承属性
			delete 删除一个不存在的属性，不报错，返回true
			只有一种情况返回false,该属性存在，且不得删除
		4 属性检测
			有多种方法 可以用 !==undefined来判断一个属性是否undefiend
		5 hasOwnProperty() 方法 
			判断一个对象是否具有指定名称的属性(不包括原型链)。如果有，返回true，否则返回false
			o.hasOwnProperty('name'); // true
		6 propertyIsEnumerable() 方法 
			检测到是自有属性， 且这个属性的可枚举性史true时才返回true 
			o.propertyIsEnumerable('name') // true
			o.propertyIsEnumerable('toString') // false
		7 in 运算符 
			in运算符左侧的属性名(字符串)，是右侧对象的自身属性、或者继承而来的属性，都返回true

	对象的三个属性
		每一个对象都有与之相关的原型(prototype)、类(class)和 可扩展性(extensible attribute)
		Object.getPrototypeOf()可以查询他的原型 // {constructor: ƒ, __defineGetter__: ƒ, __defineSetter__: ƒ, hasOwnProperty: ƒ, __lookupGetter__: ƒ, …}
		检测一个对象是否是另一个对象的原型，可以使用isPrototypeOf() //Object.prototype.isPrototypeOf(o) true
	
	序列化对象
		JSON.stringify() 	//序列化对象, 只能序列化对象可枚举的自有属性。对于一个不能序列化的属性来说，在序列化后的输出字符串中，会将这个属性省略掉
		JSON.parse() 		//还原序列化后的对象
		var o = {
			name:'a',
			age:12,
			intro:[false, null,'']
		}; 
		var p = JSON.stringify(o); //"{"name":"a","age":12,"intro":[false,null,""]}"
		JSON.parse(p)		// {name: "a", age: 12, intro: Array(3)}
	
	构造函数
		构造函数，是用来生成"对象"的函数。一个构造函数可以生成多个对象，这些对象都有相同的结构
		构造函数的特点
			1 函数体内使用了this关键字，代表了所要生成的对象实例
			2 生成对象时，必须使用new命令
			3 构造函数名字的第一个字母通常大写

		function Car(color){
			this.color = color;
		}
		var c = new Car('red');

		this关键字
			this总是返回一个对象，就是返回属性或者方法"当前"所在的对象
			this.property this就代表property属性当前所在的对象
			由于对象的属性可以赋给另一个对象，所以属性所在的当前对象是可变的，即this的指向是可变的
			var A = {
				name: '张三',
				describe:function(){
					return this.name;
				}
			};
			var B = {
				name: "李四"
			};
			B.describe = A.describe;
			B.describe(); //李四 this指向对象B
			如果是在一个全局环境中运行，那么this就是指向顶层对象(浏览器中为window对象)

		改变this指向的3中方法
			1 function.prototype.call()
				第一个参数obj是this要指向的对象，也就是想指定的上下文； arg1，arg2都是要传入的参数。如果为空、null和undefined则默认传入全局对象
				call(obj,arg1,arg2, ...)

			2 function.prototype.apply()
				与call()方法相似，只不过参数是数组
				apply(obj[,arg1, arg2, ...])

			3 function.prototype.bind() 
				用于将函数体内的this绑定到某个对象，然后再返回一个新函数
				bind(obj)

		原型
			----------------------
			每一个对象(除null之外)，都和另一个对象关联，也可以说成是继承自另一个对象。
			这个另一个对象就是我们熟知的 原型(prototype)

			通过关键字new和构造函数调用创建的对象的原型就是构造函数的prototype属性的值。
			比如通过new Object()创建的对象继承自Object.prototype；new Array()创建的对象继承自Array.prototype；

			所有的内置构造函数，都具有一个继承自Object.prototype的原型

			------ 原型链 ------
			对象的属性和方法，可能定义在自身，也有可能是定义在它的原型对象。由于原型对象本身也是对象，也有自己的原型，所以形成了一条原型链(prototype  chain)。
			如果一层层地向上追溯，那么所有对象的原型最终都可以上溯到Object.prototype，即Object构造函数的prototype属性指向的那个对象。
			Object.prototype对象有无原型呢？ 它也有，不过这个原型是没有任何属性和方法的null对象，而null没有自己的原型

			原型链的作用：
				当读取某个对象的属性时，JavaScript引擎先寻找对象本身的属性，如果找不到，就去原型找。如果到最顶层的Object.prototype还是找不到，就返回undefined

			继承
				如果查询对象一个不存在属性时，会返回undefined
				如果对象自身和它的原型都定义了同一个属性，那么优先读取自身的属性。这叫做”覆盖(overriding)“

			constructor属性
				prototype对象与一个constructor属性，默认指向prototype对象所在的构造函数

			操作符
				function Car(){
					this.color = "red"
				}
				1 instanceof 运算符
					var c = new Car();
					c instanceof Car; //true

				2 Object.getPrototypeOf(newObj) //返回一个实例化对象的原型
					Object.getPrototypeOf(c); //{constructor:ƒ Car(), __proto__:Object}
					Object.getPrototypeOf(c) === Car.prototype; // true
				
				3 Object.setPrototypeOf(obj, prototype) 可以为现有对象设置原型，返回一个新对象

				4 Object.create() 用于从原型对象生成新的实例对象，可以替代new命令
					它接受一个对象作为参数，返回一个新对象，后者完全继承前者的属性
					Rectangle.prototype = Object.create(Shape.prototype)

				5 Object.prototype.isPrototypeOf(实例化对象)
					对象实例的isPrototypeOf方法，用来判断一个对象是否是另一个对象的原型
					Object.prototype.isPrototypeOf({}); // true

				6 Object.prototype.proto 
					__proto__属性可以修改某个对象的原型对象

				7 Object.getOwnPropertyNames(实例化对象) 
					返回一个数组，成员是对象本身的所有属性的键名，不包含继承的属性键名
					Object.getOwnPropertyNames(rect) // ["x", "y"]

				8 Object.prototype.hasOwnProperty(prop) 
					返回某个对象是否有一个非继承的自有属性  rect.hasOwnProperty("x"); //
			// Shape - 父类(superclass)
			function Shape() {
				this.x = 0;
				this.y = 0;
			}

			// 父类的方法
			Shape.prototype.move = function(x, y){
				this.x += x;
				this.y += y;
				console.info("Rect moves");
			}

			// 子类 (subclass)
			function Rectangle(){
				Shape.call(this); //调用父类的构造方法
			}

			// 子类继承父类
			Rectangle.prototype = Object.create(Shape.prototype); //原型中的构造方法完全继承自父类
			Rectangle.prototype.constructor = Rectangle; //修改构造方法为Rectangle
#### 数组
	var arr = [1, 'a', {name: 'lily'}, function(){}];

	数组清空的一个有效方法 
		var arr = [1,34];
		arr.length = 0; // []

	数组元素的添加和删除
		arr.push();  //从末尾添加一个元素或多个元素
		arr.shift()  //删除数组中的第一个元素

	遍历数组
		1 for 
			for(var i=0; i<arr.length; i++){
				console.log(arr[i]);
			}

		2 while
			var i = 0;
			while(i<arr.length){
				console.log(i);
				i++;
			}

		3 for .. in 
			for(var i in a) {
				console.log(a[i])
			}

		4 forEach
			a.forEach(function(v){
				console.log(v)
			})

	类数组对象
		具有length属性,且不会随着成员数量的变化而变化。也无法使用数组的方法，因为没有继承Array.prototype
		var o = {
			0: "a",
			1: 'b',
			2: 'c',
			length: 3
		}
		典型的类数组对象，包括函数的arguments,以及大多数DOM元素集，还有字符串
		不过我们可以间接使用 Function.call方法调用
		Array.prototype.slice.call(o)

#### 函数
	function test(name) {
		return name;
	}
	test("tg");  //除了实参之外，每次调用还会拥有一个 上下文，这个就是this关键字的值 这里是 this.test("tg")
	函数可以有多个return语句，但是只能返回一个，当没有返回语句时，最终返回undefined
	如果函数挂载在一个对象上，就将作为对象的一个属性，也就是对象的方法。

	函数定义 
		function name(){}
	函数表达式
		var f = function (x){console.log(x);}
	注意：1）如果一个函数被定义多次(声明)，后面的定义会覆盖前面的定义(声明)
		2）函数会被提前解析，所以可以在调用后面某处声明
	嵌套函数(闭包实现原理)
		function test() {
			var name = 'tg';
			function test_inside(){
				var age = 15;
				console.log(name); //tg
			}
			console.log(age); // uncaught referenceError: age is not defined
		}

	函数调用
		作为函数 test()
		作为方法	o.test()
		作为构造函数	new Test()
		通过他们的call()和apply()方法间接调用

	函数参数
		可选形参
		function go(x, y) {
			x = x || 1;
			y = y || 2;
			console.log(x, y)
		}

		实参对象
		// arguments实参对象，是一个类数组对象
		function go(x) {
			console.log(arguments[0]);
			console.log(arguments[1]);
			console.log(arguments.length); // 2
			console.log(arguments);
		}
		go('ab', 'cd'); // ab cd 

		callee 和 caller 属性 

		//类数组可以通过Array.prototype，即数组的原型对象这种方法，调用数组的方法
		function go(x) {
			console.log(Array.prototype.slice.call(arguments, 0));
			console.log([].slice.call(arguments, 2)) // 简化写法
		}

		参数的传递类型 
		按值传递(复制值，形参不改变实参)和按引用传递(将值得地址复制给一个局部变量，指向同一处)
		// 一旦形参对象指向了别的地方，就不再指向原来内存中的地址了
		function test(obj) {
			obj.name = 'test'; // 此处，obj指向person对象
			obj = new Object();	// obj又指向了一个新对象
			obj.name = 'new';
		}

		var person = new Object();
		test(person);
		console.log(person.name);

		变量提升 
			如果函数外部没有定义，就是局部变量，即便不是在第一行声明的，也会提升到第一行声明。
			如果与全局变量同名，则内部变量会覆盖全局变量
		【没有】函数重载
			函数重载，指为同一个函数编写两个定义，只要这两个函数定义的签名(接收的参数类型和数量)不同即可。
			在JS中如果定义了两个相同的函数，后面的会覆盖前面的函数定义。