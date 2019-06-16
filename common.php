<?php

function getAge($brithday)
{
    /**
     * @description: 输入生日返回年龄
     * @param {string} $brithday
     * @return: int|false
     */
    if (!strtotime($brithday)) {
        return false;
    }
    // 获取生日的年月日
    list($y1, $m1, $d1) = explode('-', date('Y-m-d', strtotime($brithday)));
    // 获取当前的年月日
    list($y2, $m2, $d2) = explode('-', date('Y-m-d', strtotime("now")));
    // 计算差值
    $age = $y2 - $y1;
    // 判断过了今年的生日了吗===》当前日期中的月份-生日月份是否小于0===》当前日期中的天数-生日的天数是否小于0===》小于0就在年份-年份的基础上减1==》否则就是年份-年份
    if (($m2 - $m1) < 0 && ($d2 - $d1) < 0) {
        $age--;
    }
    return $age;
}

function getDataFromDB($queryConmnet,$host='localhost',$user = 'root',$password='111111',$base='demo')
{
    /**
     * @description: 
     * @param {type} 
     * @return: 
     */
    $conn = mysqli_connect($host, $user, $password, $base);
    if (!$conn) { // 检测数据库连接是否成功
        exit('<h1>连接数据库失败</h1>');
    }
    $query = mysqli_query($conn, $queryConmnet);
    if (!$query) { // 检测标识获取是否成功
        exit('<h1>从数据库获取数据失败</h1>');
    }
    return $query;
}
