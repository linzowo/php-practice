<?php
// echo $_GET;
// echo $_POST;
// echo 'hello world';
// var_dump($_POST);
// $data = $_POST['key1'];
// echo $data;

// 加载json文件到变量
$jsonFile = file_get_contents("douban_movie_top250.json");
// 为了让客户端知道这是json格式的数据
header('Content-Type: application/json');
echo $jsonFile;