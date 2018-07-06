select if(@score1 >= 60, '及格', '不及格'),if(@score2 >= 60, '及格', '不及格')

select ifnull(@score_null, '没有成绩');

select version(),@@version,@@pseudo_thread_id,connection_id(),database(),schema();

select user(),current_user(),system_user(),session_user();

select curdate(),current_date(),curtime(),current_time(),now(),current_timestamp(),localtime(),sysdate()
# 2018-05-17	2018-05-17	12:49:06	12:49:06	2018-05-17 12:49:06	2018-05-17 12:49:06	2018-05-17 12:49:06	2018-05-17 12:49:06