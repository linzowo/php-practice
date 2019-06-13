<?php include_once 'musicList_nav.php'; ?>
<?php
// 获取用户提交的ID===========================
$id = $_GET['id'];

// 连接数据库================================
$conn = mysqli_connect('localhost','root','111111','demo');

// 如果连接数据库失败
if(!$conn){
    exit("<h1>网页出错了，请稍后再试！</h1>");
}

// 删除文件==================================
// 查询该id数据
$query = mysqli_query($conn,"SELECT * FROM musiclist WHERE id = '{$id}';");
// 初始化错误信息存储变量
$error_message = '';
// 获取该行数据
while($row = mysqli_fetch_row($query)){//为后续删除多行数据准备
    // 获取文件路径
    $picPath = $row[2];
    $source = $row[4];
    // 删除文件
    if(!unlink('.'.substr($picPath,10))){
        $error_message .= '删除ID：'.$row[0].'图片失败。';
    }
    if(!unlink('.'.substr($source,10))){
        $error_message .= '删除ID：'.$row[0].'音乐失败。';    
    }

}

if($error_message !== ''){
    echo $error_message;
}

// 删除指定索引数据====================================
$query = mysqli_query($conn,"DELETE FROM musiclist WHERE id = '{$id}';");

// 判断是否删除成功
if(!$query){
    exit("<h1>删除数据失败</h1>");
}

// 跳转回主页面
header('location: musicList_index.php');


// ===============================================================================================


// 配合mysql数据库
// 处理删除音乐的页面

// // 获取连接传递过来的值
// $index = $_GET['index'];

// // 解码数据库==》索引数组
// $origin = json_decode(file_get_contents('musicDataBase.json'), true);

// $error_message = '';
// // 删除指定索引的文件
// if (!unlink('.'.substr($origin[$index]['picPath'],10))) {
//     $error_message .= '===>删除图片失败';
// }

// if (!unlink('.'.substr($origin[$index]['songPath'],10))) {
//     $error_message .= '===>删除音乐失败';
// }

// // 如果有错误就停止运行，并显示错误
// if($error_message != ''){
//     exit('<h1>'.$error_message.'</h1>');
// }
// // 删除数据库文件信息
// array_splice($origin, $index, 1);

// // 将新数据重新编码===》json
// $newJson = json_encode($origin);

// // 将新的数据库文件写入数据库
// file_put_contents('musicDataBase.json', $newJson);

// // 跳转回主页面
// header('location: musicList_index.php');
