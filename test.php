<?php
/*
 * 生成随机字符串
 * @param int $length 生成随机字符串的长度
 * @param string $char 组成随机字符串的字符串
 * @return string $string 生成的随机字符串
 */
// function str_rand($length = 32, $char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
//     if(!is_int($length) || $length < 0) {//判断输入的长度是否有效，如果无效就退出函数
//         return false;
//     }

//     $string = '';//声明一个存储结果的字符串
//     for($i = $length; $i > 0; $i--) {
//         $string .= $char[mt_rand(0, strlen($char) - 1)];//在字符串的长度范围内随机返回一个字符，并追加到结果字符串中
//     }

//     return $string;
// }

// echo str_rand(mt_rand(3,10)),"<br />";

// /*
//  * 生成32位唯一字符串
//  */
// $uniqid = md5(uniqid(microtime(true),true));
// echo $uniqid;

// phpinfo();

// define('', '');
echo join('|',$_POST);
