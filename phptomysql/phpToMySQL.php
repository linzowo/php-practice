<?php
// 使用php操作mysql数据

// 建立连接
// mysqli_connect ($host = '', $user = '', $password = '', $database = '', $port = '', $socket = '')
$connection = mysqli_connect('localhost','root','111111','demo');
// var_dump($connection);
if(!$connection){
    exit('<h1>连接数据库失败</h1>');
}
// 查询数据库
// mysqli_query ($link, $query==>mysql的查询语句, $resultmode = MYSQLI_STORE_RESULT)
$query = mysqli_query($connection,'SELECT * FROM users;');
var_dump($query);

// 新增
// $query = mysqli_query($connection,"INSERT INTO users VALUES(NULL,'ufo','小五',29,1);");
// // 新增成功===》true
// var_dump($query);

// 修改
// $query = mysqli_query($connection,"UPDATE users SET title = 'BBQ' WHERE id IN (7);");
// // 修改成功===》true
// var_dump($query);

// 删除
// $query = mysqli_query($connection,"DELETE FROM users WHERE id IN (7);");
// // 删除成功===》true
// var_dump($query);

if(!$query){
    exit('<h1>查询数据库失败</h1>');

}
// 遍历数据集
while($row = mysqli_fetch_assoc($query)){
    var_dump($row);
}

// 清空数据暂存区
mysqli_free_result($query);

