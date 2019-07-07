<?php
    // version1.0===========================================================
    // // 设置返回类型为js代码
    // header('Content-Type: application/javascript');
    // // 加载json文件到变量
    // $jsonFile = file_get_contents("douban_movie_top250.json");
    // // 输出变量
    // echo "getData({$jsonFile});";
    // // 输出符合js语法的的字符串=》将js代码写在字符串中
    // echo "getData(1);";

    // version2.0================================================
    // 设置返回类型为js代码
    // header('Content-Type: application/javascript');
    // // 加载json文件到变量
    // $jsonFile = file_get_contents("douban_movie_top250.json");
    // // 获取用户传递过来的回调函数名称
    // $funcName = $_GET['callBack'];
    // // 输出变量
    // echo "{$funcName}({$jsonFile})";

    // version3.0================================================
    // 加载json文件到变量
    $jsonFile = file_get_contents("douban_movie_top250.json");
    // 判断用户是否传递了处理函数
    if(empty($_GET['callBack'])){//没有传递
        // 设置返回类型为json
        header('Content-Type: application/json');
        echo $jsonFile;
         exit();//不再执行后续的代码
    }
    // 设置返回类型为js代码
    header('Content-Type: application/javascript');
    // 输出js代码===》判断用户传入的是否是一个函数名===》是===》再执行后面的代码
    echo "typeof {$_GET['callBack']} === 'function' && {$_GET['callBack']}({$jsonFile})";