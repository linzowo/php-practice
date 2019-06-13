<?php include_once 'musicList_nav.php'; ?>

<?php



// if($_SERVER['REQUEST_METHOD']==="GET"){
//     var_dump($_GET);
// }
// TODO: 添加内容编辑页面
// 根据用户传入的id获取内容
// 获取id
$id = $_GET['id'];

// 连接数据库
$conn = mysqli_connect('localhost', 'root', '111111', 'demo');

// 判断是否连接成功
if (!$conn) {
    exit("<h1>网页出现了问题请稍后再试！</h1>");
}

// 获取查询索引
$query = mysqli_query($conn, "SELECT * FROM musiclist WHERE id = {$id};");
if (!$query) {
    exit("<h1>没有找到想要的数据！</h1>");
}

$row = mysqli_fetch_row($query);
if (!$row) {
    exit("<h1>没有找到想要的数据！</h1>");
}
mysqli_free_result($query);

// 将原始数据存储起来
$songName = $row[1];
$picPath = $row[2];
$singer = $row[3];
$songPath = $row[4];


// 测试
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // var_dump($_POST);
    // var_dump($_FILES);

    // 检测用户是否修改原有内容
    if (!empty($_POST['songName']) && $_POST['songName'] !==$songName) {
        $songName = $_POST['songName'];
    }
    
    if (!empty($_POST['singer']) && $_POST['singer'] !==$singer) {
        $singer = $_POST['singer'];
    }

    // 如果修改了文件域的内容
    if(!empty($_FILES['songPic']['name'])){
        // 删除原有文件
        if(!unlink('.'.substr($picPath,10))){
            echo '文件未能删除成功，可能是该文件已不存在。';
        }

        // 移动新文件
        $newPicPath = './picture/'.substr($picPath,19,13).'-'.$_FILES['songPic']['name'];//==>保证能保留上一次该元素的随机id
        if(!move_uploaded_file($_FILES['songPic']['tmp_name'],$newPicPath)){
            echo '<h1>移动图片失败</h1>';
        }
        // 生成一个新路径
        $picPath = '/musicList'.substr($newPicPath,1);
    }
    
    if(!empty($_FILES['uploadSong']['name'])){
        // 删除原有文件
        if(!unlink('.'.substr($songPath,10))){
            echo '文件未能删除成功，可能是该文件已不存在。';
        }

        // 移动新文件
        $newPath = './picture/'.substr($songPath,19,13).'-'.$_FILES['songPic']['name'];//==>保证能保留上一次该元素的随机id
        // /musicList/picture/5d00fbd4734d6 19 13
        if(!move_uploaded_file($_FILES['songPic']['tmp_name'],$newPicPath)){
            echo '<h1>移动音乐失败</h1>';
        }
        // 生成一个新路径
        $songPath = '/musicList'.substr($newPath,1);
    }

    // 修改数据库信息
    $query = mysqli_query($conn,"UPDATE musiclist SET title = '{$songName}', picPath = '{$picPath}', singer = '{$singer}', source = '{$songPath}' WHERE id IN ({$id});");
    if(!$query){
        exit('<h1>修改数据库失败</h1>');
    }
    mysqli_free_result($query);

    // 至此所有上传流程均成功
    header('location: musicList_index.php');
}
?>


<!-- 主体结构 -->
<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8">
    <title>编辑内容</title>
    <link rel="stylesheet" href="../bootstrap4.3.css" />
</head>

<body>
    <div class="container mt-5">
        <h1 class="my-4">编辑“<?php echo $songName; ?>”</h1>
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
                <input type="text" class="form-control" id="songName" name="songName" placeholder="歌名" value="<?php echo $songName; ?>">
            </div>

            <div class="form-group">
                <label for="singer">歌手</label>
                <input type="text" class="form-control" id="singer" name="singer" placeholder="歌手" value="<?php echo $singer; ?>">
            </div>
            <div class="form-group">
                <label for="songPic"><img src="<?php echo $picPath; ?>" alt="" width="100px" id='img'></label>
                <input type="file" class="form-control-file" id="songPic" name="songPic" accept="image/*"><!-- 默认显示图片文件 -->
            </div>
            <div class="form-group">
                <label for="uploadSong">选择音乐</label>
                <input type="file" class="form-control-file" id="uploadSong" name="uploadSong" accept="audio/*"><!-- 默认显示音频文件 -->
            </div>

            <button type="submit" class="btn btn-primary mb-2">确认修改</button>
        </form>
    </div>
</body>

</html>