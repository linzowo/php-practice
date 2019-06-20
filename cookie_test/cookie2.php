<?php
// 接收数据
// 方案1、方案2
// var_dump($_GET['msg']);
// 方案3
// var_dump($_COOKIE['msg']);
// 方案4：
session_start();//开始session存储
var_dump($_SESSION['msg']);
session_destroy();//结束session存储并删除数据
