<?php
// echo 'hello world';
// echo '<br/>';
// echo 'hello world';

// 动态生成表格

// 动态生成一个文本文件
// 文本结构
// 序号|姓名|年龄|邮箱|域名
// 随机邮箱：随机用户名（3-10）@随机组名（3-10）.com
// 随机域名：www.随机域名（3-12）。com

/* // 创建文件
$myflie = fopen('roster.txt', "a+");

// 创建一个姓名列表
$nameList = ["齐桓公（小白）", "管仲", "隰朋", "鲍叔牙", "易牙", "竖刁", "郑庄公（寤生）", "太叔段", "祭足", "颍考叔", "公子纠", "宫之奇", "公孙无知", "晋文公（重耳）", "狐突", "狐偃", "狐毛", "介子推", "里克", "邳郑", "宋襄公", "秦穆公", "楚庄王", "石碏", "石厚", "州吁", "郑突", "郑忽", "老子", "孔子", "孙武", "左丘明", "伍子胥", "范蠡", "西施", "勾践", "阖闾", "夫差", "文种", "专诸", "要离", "庆忌", "吴王僚", "伊尹", "烛之武", "公子光", "魏舒", "晏婴", "庆父", "乐毅", "吴起", "孙膑", "庞涓", "廉颇", "赵牧", "赵奢", "赵括", "项燕", "田单", "韩非", "荀子", "庄子", "墨子", "惠子", "孟子", "燕丹", "荆轲", "高渐离", "樊於期", "孟尝君", "春申君", "信陵君", "平原君", "邹忌", "白起", "商鞅", "李悝", "蔺相如", "屈原", "魏斯", "乐羊", "西门豹", "孔伋", "杨朱", "聂政", "申不害", "尸佼", "赵武灵王", "匡章", "淳于髡", "张仪", "苏秦", "田辟疆", "田忌", "鬼谷子", "甘德", "石申", "李冰", "扁鹊", "范雎", "蔡泽", "郭隗", "唐蔑", "宋玉", "触龙", "毛遂", "鲁仲连", "公孙龙"];
// 根据姓名列表的长度生成年龄邮箱域名
for ($i = 0; $i < count($nameList); $i++) { 
    // 随机生成年龄
    $age = mt_rand(18,28);
    // 随机生成邮箱
    $randEmail = str_rand(mt_rand(3,10)).'@'.str_rand(mt_rand(3,10)).'.com';
    // 随机生成域名
    $randWebsite = 'www.'.str_rand(mt_rand(3,10)).'.com';
    $txt = $i.'|'.$nameList[$i].'|'.$age.'|'.$randEmail.'|'.$randWebsite."\n";
    // 将内容写入文本文件
    fwrite($myflie, $txt);
}
// 关闭文件
fclose($myflie); */
// 完成动态文件生成

// 输出表头
echo "<table border='1' cellpadding = '0' cellspacing = '0' style='text-align: center'><thead><tr><th>序号</th><th>姓名</th><th>年龄</th><th>邮箱</th><th>网址</th></tr></thead><tbody>";
// 读取文件
// 以只读方式打开我的文件
$myflie = fopen("roster.txt","r");
// 逐行遍历文本文件
while(!feof($myflie)){
    $lineTxt = fgets($myflie);//读取其中一行字符并将光标下移一行
    $lineTxtArr = explode("|",$lineTxt);
    $link = strtolower($lineTxtArr[4]); 
    $no = $lineTxtArr[0];
    if(strlen($lineTxtArr[0])==1){
        $no = "00".$lineTxtArr[0];
    }
    if(strlen($lineTxtArr[0])==2){
        $no = "0".$lineTxtArr[0];
    }
    $tr = "<tr><td>$no</td><td>$lineTxtArr[1]</td><td>$lineTxtArr[2]</td><td>$lineTxtArr[3]</td><td><a href = '$link'>$link</a></td></tr>";
    echo $tr;
}
// 关闭文件
fclose($myflie);
//输出表尾
echo "<tbody></table>";


// ===========函数区===========
// 动态生成随机文本
/* function str_rand($length = 32, $char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
    if(!is_int($length) || $length < 0) {//判断输入的长度是否有效，如果无效就退出函数
        return false;
    }

    $string = '';//声明一个存储结果的字符串
    for($i = $length; $i > 0; $i--) {
        $string .= $char[mt_rand(0, strlen($char) - 1)];//在字符串的长度范围内随机返回一个字符，并追加到结果字符串中
    }

    return $string; 
} */