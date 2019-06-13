<?php include_once 'musicList_nav.php'; ?>
<?php
// <!-- 音乐列表重构 -->

// <!-- 单独添加新增页面 -->

// <!-- 数据处理代码 -->
// 【?php
// function addMusic()
// {
//     $GLOBALS['error_message'] = '';
//     // 检验文件是否符合要求
//     // 校验是否上传了文件
//     if (empty($_POST['songName'])) { //没有输入歌名
//         $GLOBALS['error_message'] = '请输入歌名';
//         return;
//     }

//     if (empty($_POST['singer'])) { //没有输入歌手名
//         $GLOBALS['error_message'] = '请输入歌手名';
//         return;
//     }

//     if ($_FILES['songPic']['error'] === UPLOAD_ERR_NO_FILE) { //没有上传图片
//         $GLOBALS['error_message'] = '请上传图片';
//         return;
//     }

//     // 校验图片类型
//     $allowedPicType = array('image/jpeg', 'image/png', 'image/gif');
//     if (!in_array($_FILES['songPic']['type'], $allowedPicType)) { //此图片格式不支持
//         $GLOBALS['error_message'] = '此图片格式不支持';
//         return;
//     }

//     if ($_FILES['uploadSong']['error'] === UPLOAD_ERR_NO_FILE) { //没有上传歌曲
//         $GLOBALS['error_message'] = '请上传歌曲';
//         return;
//     }

//     // 校验音频类型
//     $allowedSongType = array('audio/mp3', 'audio/wma');
//     if (!in_array($_FILES['uploadSong']['type'], $allowedSongType)) { //此音乐格式不支持
//         $GLOBALS['error_message'] = '此音乐格式不支持';
//         return;
//     }

//     if ($_FILES['uploadSong']['size'] > 10 * 1024 * 1024) { //上传歌曲太大
//         $GLOBALS['error_message'] = '上传歌曲太大';
//         return;
//     }

//     if ($_FILES['uploadSong']['size'] > 10 * 1024 * 1024) { //上传歌曲太小
//         $GLOBALS['error_message'] = '上传歌曲太小';
//         return;
//     }

//     // 执行到此说明用户输入和选择的文件符合要求
//     // 开始上传文件至数据库
//     // 设置默认id
//     $id = uniqid();

//     // 上传图片
//     $defaultPicDir = './picture/';
//     $picPath = $defaultPicDir . $id . '-' . $_FILES['songPic']['name'];
//     if (!(move_uploaded_file($_FILES['songPic']['tmp_name'], $picPath))) {
//         $GLOBALS['error_message'] = '上传封面图片失败';
//         return;
//     }

//     // 上传歌曲
//     $defaultPicDir = './music/';
//     $songPath = $defaultPicDir . $id . '-' . $_FILES['uploadSong']['name'];
//     if (!(move_uploaded_file($_FILES['uploadSong']['tmp_name'], $songPath))) {
//         $GLOBALS['error_message'] = '上传歌曲失败';
//         return;
//     }

//     // 执行到此说明用户的文件已经上传成功
//     // 开始写入数据库信息
//     // $picPath = ('/musicList' . substr($picPath, 1));
//     // $songPath = ('/musicList' . substr($songPath, 1));

//     // 将原数据库文件信息读出
//     // 读出==>解码===>索引数组
//     $origin = json_decode(file_get_contents('musicDataBase.json'), true);
//     // 修改文件信息==>向数组内追加一个关联数组
//     $origin[] = array(
//         'id' => $id, //继续使用上面存储数据时使用的id
//         'name' => $_POST['songName'],
//         'singer' => $_POST['singer'],
//         'picPath' => ('/musicList' . substr($picPath, 1)), //继续使用上面存储数据时使用的路径
//         'songPath' => ('/musicList' . substr($songPath, 1)) //继续使用上面存储数据时使用的路径
//     );
//     // 将关联数组编码为json格式
//     $json = json_encode($origin);
//     // 追加写入文件中
//     file_put_contents('musicDataBase.json', $json);

//     // 至此完成全部上传工作

//     header('location:musicList_index.php'); // 跳转至主页面
// }

// // 不符合返回提示信息

// // 符合将文件信息写入数据库===》将文件存储至数据库===》跳转至主页面

// // 将文件存储至数据库

// // 跳转至主页面
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     // var_dump($_POST);
//     // var_dump($_FILES);
//     /* 
//     var_dump($_POST)===>

//     array(4) { ["songName"]=> string(0) "" ["singer"]=> string(0) "" ["songPic"]=> string(0) "" ["uploadSong"]=> string(0) "" }

//     var_dump($_FILES)==>

//     array(2) {
//   ["songPic"]=>
//   array(5) {
//     ["name"]=>
//     string(13) "五月天.jpg"
//     ["type"]=>
//     string(10) "image/jpeg"
//     ["tmp_name"]=>
//     string(62) "C:\file\OneDrive\codeing\phpPractice\musicList\tmp\php815E.tmp"
//     ["error"]=>
//     int(0)
//     ["size"]=>
//     int(21014)
//   }
//   ["uploadSong"]=>
//   array(5) {
//     ["name"]=>
//     string(25) "五月天 - 小时候.mp3"
//     ["type"]=>
//     string(9) "audio/mp3"
//     ["tmp_name"]=>
//     string(62) "C:\file\OneDrive\codeing\phpPractice\musicList\tmp\php815F.tmp"
//     ["error"]=>
//     int(0)
//     ["size"]=>
//     int(12262099)
//   }
// }
//     */

//     addMusic(); //处理用户的上传内容

// }
// ?】
// 【? php; ?】

// <!-- 页面主体结构 -->
// <!DOCTYPE html>
// <html lang="zh">

// <head>
//     <meta charset="UTF-8">
//     <title>添加音乐</title>
//     <link rel="stylesheet" href="../bootstrap4.3.css" />

// </head>

// <body>
//     <div class="container mt-5">
//         <h1 class="my-4">上传音乐</h1>
//         【?php
//         // if ($_SERVER['REQUEST_METHOD'] === 'POST') :
//         if (!empty($error_message)) :
//             ?】
//             <div class="alert alert-danger" role="alert">
//                 【?php echo $error_message; ?】
//             </div>
//         【?php endif; ?】
//         <form action="【?php $_SERVER['PHP_SELF']; ?】" method="post" enctype="multipart/form-data">
//             <!-- 将页面数据先上传至当前页面检查如果没有问题再跳转至主页面 -->
//             <div class="form-group">
//                 <label for="songName">歌名</label>
//                 <input type="text" class="form-control" id="songName" name="songName" placeholder="歌名" value="【?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : echo $_POST['songName'];
//                                                                                                                 endif; ?】">
//             </div>

//             <div class="form-group">
//                 <label for="singer">歌手</label>
//                 <input type="text" class="form-control" id="singer" name="singer" placeholder="歌手" value="【?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : echo $_POST['singer'];
//                                                                                                             endif; ?】">
//             </div>
//             <div class="form-group">
//                 <label for="songPic">选择封面</label>
//                 <input type="file" class="form-control-file" id="songPic" name="songPic" accept="image/*"><!-- 默认显示图片文件 -->
//             </div>
//             <div class="form-group">
//                 <label for="uploadSong">选择音乐</label>
//                 <input type="file" class="form-control-file" id="uploadSong" name="uploadSong" accept="audio/*"><!-- 默认显示音频文件 -->
//             </div>

//             <button type="submit" class="btn btn-primary mb-2">上传</button>
//         </form>
//     </div>
// </body>

// </html>

?>

<!-- ================================================================================================================================= -->




<!-- 音乐列表重构 -->

<!-- 单独添加新增页面 -->

<!-- 数据处理代码 -->
<?php
function addMusic()
{
    $GLOBALS['error_message'] = '';
    // 检验文件是否符合要求
    // 校验是否上传了文件
    if (empty($_POST['songName'])) { //没有输入歌名
        $GLOBALS['error_message'] = '请输入歌名';
        return;
    }

    if (empty($_POST['singer'])) { //没有输入歌手名
        $GLOBALS['error_message'] = '请输入歌手名';
        return;
    }

    if ($_FILES['songPic']['error'] === UPLOAD_ERR_NO_FILE) { //没有上传图片
        $GLOBALS['error_message'] = '请上传图片';
        return;
    }

    // 校验图片类型
    $allowedPicType = array('image/jpeg', 'image/png', 'image/gif');
    if (!in_array($_FILES['songPic']['type'], $allowedPicType)) { //此图片格式不支持
        $GLOBALS['error_message'] = '此图片格式不支持';
        return;
    }

    if ($_FILES['uploadSong']['error'] === UPLOAD_ERR_NO_FILE) { //没有上传歌曲
        $GLOBALS['error_message'] = '请上传歌曲';
        return;
    }

    // 校验音频类型
    $allowedSongType = array('audio/mp3', 'audio/wma');
    if (!in_array($_FILES['uploadSong']['type'], $allowedSongType)) { //此音乐格式不支持
        $GLOBALS['error_message'] = '此音乐格式不支持';
        return;
    }

    if ($_FILES['uploadSong']['size'] > 10 * 1024 * 1024) { //上传歌曲太大
        $GLOBALS['error_message'] = '上传歌曲太大';
        return;
    }

    if ($_FILES['uploadSong']['size'] > 10 * 1024 * 1024) { //上传歌曲太小
        $GLOBALS['error_message'] = '上传歌曲太小';
        return;
    }

    // 执行到此说明用户输入和选择的文件符合要求
    // 开始上传文件至数据库
    // 设置默认id
    $id = uniqid();

    // 上传图片
    $defaultPicDir = './picture/';
    $picPath = $defaultPicDir . $id . '-' . $_FILES['songPic']['name'];
    if (!(move_uploaded_file($_FILES['songPic']['tmp_name'], $picPath))) {
        $GLOBALS['error_message'] = '上传封面图片失败';
        return;
    }

    // 上传歌曲
    $defaultPicDir = './music/';
    $songPath = $defaultPicDir . $id . '-' . $_FILES['uploadSong']['name'];
    if (!(move_uploaded_file($_FILES['uploadSong']['tmp_name'], $songPath))) {
        $GLOBALS['error_message'] = '上传歌曲失败';
        return;
    }

    // 执行到此说明用户的文件已经上传成功
    // 开始写入数据库信息
    $name = $_POST['songName'];
    $singer = $_POST['singer'];
    $picPath = ('/musicList' . substr($picPath, 1)); //继续使用上面存储数据时使用的路径
    $songPath = ('/musicList' . substr($songPath, 1)); //继续使用上面存储数据时使用的路径
    // 将原数据库文件信息读出
    // 建立数据库连接
    $conn = mysqli_connect('localhost', 'root', '111111', 'demo');

    // 如果连接数据库失败
    if (!$conn) {
        exit("<h1>网页出错了，请稍后再试！</h1>");
    }

    // 直接插入数据
    $query = mysqli_query($conn, "INSERT INTO musiclist VALUES (null,'{$name}','{$picPath}','{$singer}','{$songPath}');");

    // 判断是否插入成功
    if (!$query) {
        exit("<h1>提交数据失败</h1>");
    }

    // 至此完成全部上传工作

    header('location:musicList_index.php'); // 跳转至主页面
}


// 符合将文件信息写入数据库===》将文件存储至数据库===》跳转至主页面

// 将文件存储至数据库

// 跳转至主页面
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    addMusic(); //处理用户的上传内容

}
?>
<? php; ?>

<!-- 页面主体结构 -->
<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8">
    <title>添加音乐</title>
    <link rel="stylesheet" href="../bootstrap4.3.css" />

</head>

<body>
    <div class="container mt-5">
        <h1 class="my-4">上传音乐</h1>
        <?php
        // if ($_SERVER['REQUEST_METHOD'] === 'POST') :
        if (!empty($error_message)) :
            ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <!-- 将页面数据先上传至当前页面检查如果没有问题再跳转至主页面 -->
            <div class="form-group">
                <label for="songName">歌名</label>
                <input type="text" class="form-control" id="songName" name="songName" placeholder="歌名" value="<?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : echo $_POST['songName'];
                                                                                                                endif; ?>">
            </div>

            <div class="form-group">
                <label for="singer">歌手</label>
                <input type="text" class="form-control" id="singer" name="singer" placeholder="歌手" value="<?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : echo $_POST['singer'];
                                                                                                            endif; ?>">
            </div>
            <div class="form-group">
                <label for="songPic">选择封面</label>
                <input type="file" class="form-control-file" id="songPic" name="songPic" accept="image/*"><!-- 默认显示图片文件 -->
            </div>
            <div class="form-group">
                <label for="uploadSong">选择音乐</label>
                <input type="file" class="form-control-file" id="uploadSong" name="uploadSong" accept="audio/*"><!-- 默认显示音频文件 -->
            </div>

            <button type="submit" class="btn btn-primary mb-2">上传</button>
        </form>
    </div>
</body>

</html>