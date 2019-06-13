<?php
// 测试获取文件夹目录下的所有文件
// 打开文件夹
// $mydir = opendir('music');

// var_dump(scandir('music'));

// // 关闭文件夹
// closedir($mydir);

// 初始化json字符串,添加数组开头
// $jsonTxt = '[';
// $picPath = 'picture/五月天.jpg';
// // 将文本文件转为json文件
// $fileArr = file('musicDataBase.txt');
// for($i=0;$i<count($fileArr);$i++){
//     // 将文件的每一行转换为一个数组，并提取每个属性
//     $lineArr = explode('|',$fileArr[$i]);
//     $id = $lineArr[0];
//     $name = $lineArr[1];
//     $singer = $lineArr[2];
//     $songPath = trim($lineArr[3]);

//     // 将属性重组形成一个新的js格式，追加到json文本中
//     // 格式：{"id":"id值","name":"name值","singer":"singer值","pic":"pic值","song":"song值",}
//     $jsonTxt.= '{"id":"'.$id.'","name":"'.$name.'","singer":"'.$singer.'","picPath":"'.$picPath.'","songPath":"'.$songPath.'"},';
// }
// // 添加数组结尾
// $jsonTxt .= ']';
// // 创建一个文件将内容写入
// file_put_contents('musicDataBase.json',$jsonTxt);


// 比较获取文件内容方式的差异
// $data = file_get_contents('musicDataBase.json',false);
// var_dump($data);
// $dataJson = json_decode($data,true);
// var_dump($dataJson);

/* 
$data = file_get_contents('musicDataBase.json',true/false);
string(1747) "[{"id":"5cfa0c6dc8a87","name":"伤心的人别听慢歌","singer":"五月天","picPath":"picture/五月天.jpg","songPath":"music/五月天 - 伤心的人别听慢歌.mp3"},{"id":"5cfa0c6dc8b00","name":"入阵曲","singer":"五月天","picPath":"picture/五月天.jpg","songPath":"music/五月天 - 入阵曲.mp3"},{"id":"5cfa0c6dc8b12","name":"听不到","singer":"五月天","picPath":"picture/五月天.jpg","songPath":"music/五月天 - 听不到.mp3"},{"id":"5cfa0c6dc8b1d","name":"恋爱ing","singer":"五月天","picPath":"picture/五月天.jpg","songPath":"music/五月天 - 恋爱ing.mp3"},{"id":"5cfa0c6dc8b28","name":"时光机","singer":"五月天","picPath":"picture/五月天.jpg","songPath":"music/五月天 - 时光机.mp3"},{"id":"5cfa0c6dc8b32","name":"温柔","singer":"五月天","picPath":"picture/五月天.jpg","songPath":"music/五月天 - 温柔.mp3"},{"id":"5cfa0c6dc8b3c","name":"相信","singer":"五月天","picPath":"picture/五月天.jpg","songPath":"music/五月天 - 相信.mp3"},{"id":"5cfa0c6dc8b47","name":"能不能不要说","singer":"五月天","picPath":"picture/五月天.jpg","songPath":"music/五月天 - 能不能不要说.mp3"},{"id":"5cfa0c6dc8b51","name":"We Can Make It!","singer":"岚","picPath":"picture/五月天.jpg","songPath":"music/岚 - We Can Make It!.mp3"},{"id":"5cfa43de19b11","name":"庐州月","singer":"许嵩","picPath":"picture/五月天.jpg","songPath":"music/许嵩 - 庐州月.mp3"},{"id":"5cfa43f28066b","name":"洁癖","singer":"五月天、严爵","picPath":"picture/五月天.jpg","songPath":"music/严爵、五月天 - 洁癖.mp3"},{"id":"5cfb100c5076a","name":"小时候","singer":"五月天","picPath":"picture/五月天.jpg","songPath":"music/五月天 - 小时候.mp3"}]"

$data = file_get_contents('musicDataBase.json');
string(1747) "[{"id":"5cfa0c6dc8a87","name":"伤心的人别听慢歌","singer":"五月天","picPath":"picture/五月天.jpg","songPath":"music/五月天 - 伤心的人别听慢歌.mp3"},{"id":"5cfa0c6dc8b00","name":"入阵曲","singer":"五月天","picPath":"picture/五月天.jpg","songPath":"music/五月天 - 入阵曲.mp3"},{"id":"5cfa0c6dc8b12","name":"听不到","singer":"五月天","picPath":"picture/五月天.jpg","songPath":"music/五月天 - 听不到.mp3"},{"id":"5cfa0c6dc8b1d","name":"恋爱ing","singer":"五月天","picPath":"picture/五月天.jpg","songPath":"music/五月天 - 恋爱ing.mp3"},{"id":"5cfa0c6dc8b28","name":"时光机","singer":"五月天","picPath":"picture/五月天.jpg","songPath":"music/五月天 - 时光机.mp3"},{"id":"5cfa0c6dc8b32","name":"温柔","singer":"五月天","picPath":"picture/五月天.jpg","songPath":"music/五月天 - 温柔.mp3"},{"id":"5cfa0c6dc8b3c","name":"相信","singer":"五月天","picPath":"picture/五月天.jpg","songPath":"music/五月天 - 相信.mp3"},{"id":"5cfa0c6dc8b47","name":"能不能不要说","singer":"五月天","picPath":"picture/五月天.jpg","songPath":"music/五月天 - 能不能不要说.mp3"},{"id":"5cfa0c6dc8b51","name":"We Can Make It!","singer":"岚","picPath":"picture/五月天.jpg","songPath":"music/岚 - We Can Make It!.mp3"},{"id":"5cfa43de19b11","name":"庐州月","singer":"许嵩","picPath":"picture/五月天.jpg","songPath":"music/许嵩 - 庐州月.mp3"},{"id":"5cfa43f28066b","name":"洁癖","singer":"五月天、严爵","picPath":"picture/五月天.jpg","songPath":"music/严爵、五月天 - 洁癖.mp3"},{"id":"5cfb100c5076a","name":"小时候","singer":"五月天","picPath":"picture/五月天.jpg","songPath":"music/五月天 - 小时候.mp3"}]"


*/


// 将原数据库文件信息读出
    // 读出==>解码===>索引数组
    // echo 1;
    // $origin = json_decode(file_get_contents('test.json'), true);
    // var_dump($origin);
    // // 修改文件信息==>向数组内追加一个关联数组
    // $origin[] = array(
    //     '$id' => uniqid(), //继续使用上面存储数据时使用的id
    //     '$name' => '123',
    //     '$singer' => '456',
    //     '$picPath' => '789', //继续使用上面存储数据时使用的路径
    //     '$songPath' => '101112' //继续使用上面存储数据时使用的路径
    // );
    // var_dump($origin);

    // // 将关联数组编码为json格式
    // $json = json_encode($origin);
    // var_dump($json);

    // // 写入文件中
    // file_put_contents('test.json',$json);
    // echo 2;

    // $arr1 = array(0,1,2,3,4);
    // array_splice($arr1,1,1);
    // var_dump($arr1);