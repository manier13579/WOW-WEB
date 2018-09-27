<?php
//开启数据库连接
function DbOpen()
{
    //sqlite数据库文件名
    $db_name = '../clank.db';
    //打开sqlite数据库
    $db = new SQLite3($db_name);
    //错误处理
    if (!$db) {
        die('不能连接SQlite文件');
    }
    return $db;
}

//单条sql语句执行
function DbSelect($db, $query)
{
    $sql = $db->query($query);
    //错误处理
    if (!$sql) {
        printf("Error");
        exit();
    }
    return $sql;
}


//关闭数据库连接
function DbClose($db)
{
    sqlite_close($db);
}

//返回数据量大的查询可以用来清空内存
//mysqli_free_result($sql);
