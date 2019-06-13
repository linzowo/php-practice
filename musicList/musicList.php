<?php
// // <!-- 动态生成数据库文本 -->
// // <!-- 将文件的名称全部读出来然后做成一个相互关联的文本文档作为模拟数据库 -->
// // <!-- 打开文件 -->
// $myfile = fopen('musicDataBase.txt',"a");
// $x = opendir('music');
// while (($file = readdir($x)) !== false) :
//   if ($file == '.' || $file == '..') { //跳过前两个非文件数据
//     continue;
//   }
//   $songNameArr = explode('-', $file); /* 将文件名分割成数组方便提取歌手和歌名 */
//   $singer = trim($songNameArr[0]); /* 提取歌手名 */
//   $songName = trim((explode('.', $songNameArr[1]))[0]); /* 提取歌名 */
//   $songID = uniqid();
//   $songPath = 'music/'.$file;
//   $dataStr = $songID . '|' . $songName . '|' . $singer . '|' . $songPath."\n";
//   fwrite($myfile,$dataStr);
// endwhile;
// // <!-- 关闭文件 -->
// fclose($myfile); 
?>
<?php
if ($_SERVER['REQUEST_METHOD'] === "POST") {
  // var_dump($_POST);
  /* 
  $_POST==>
  array(4) {
  ["songID"]=>
  string(13) "5cfa199f0a777"
  ["songName"]=>
  string(9) "小时候"
  ["singer"]=>
  string(9) "五月天"
  ["addComplete"]=>
  string(0) ""
}
  */

  /* $_FILES ==>
  array(1) {
  ["uploadSong"]=>
  array(5) {
    ["name"]=>
    string(25) "五月天 - 小时候.mp3"
    ["type"]=>
    string(9) "audio/mp3"
    ["tmp_name"]=>
    string(61) "C:\file\OneDrive\codeing\phpPractice\musicList\tmp\phpC1F.tmp"
    ["error"]=>
    int(0)
    ["size"]=>
    int(12262099)
  }
}
  */
  // 处理用户上传音乐的模块
  if (!empty($_FILES["uploadSong"])) { //判断如果用户上传的文件不为空
    // 默认文件存储文件夹
    $defaultDir = 'music/'; // 实际开发中这种数据可以写入配置文件中作为一个不可变数据存在
    // 将用户上传的基本信息写入数据库
    $userData = trim(join("|", $_POST)) . $defaultDir . $_FILES["uploadSong"]["name"] . "\n";
    file_put_contents('musicDataBase.txt', $userData, FILE_APPEND);
    // 将文件存至制定目录
    if (file_exists($defaultDir . $_FILES["uploadSong"]["name"])) { //如果文件已存在
      $message = '此文件已存在';
    } else { //文件不存在
      move_uploaded_file($_FILES["uploadSong"]["tmp_name"], $defaultDir . $_FILES["uploadSong"]["name"]); //将临时文件更名并移至默认文件夹
      $message = '上传成功';
    }
  }

  // 处理用户删除音乐的模块
  if (isset($_POST['delete'])) :
    $oldFile = 'musicDataBase.txt';
    // 第一种方法===》创建一个新文本==遍历数组==将数组内的文件逐行写入==删除原文件
    $fileArr = file($oldFile); //将文件读入数组
    $newFileTxt = ''; //用于存储新文档的文本
    // 遍历数组
    for ($i = 0; $i < count($fileArr); $i++) :
      if ($i == $_POST['delete']) {
        continue;
      }
      $newFileTxt .= $fileArr[$i];
    endfor;
    unlink($oldFile); //删除原文件
    file_put_contents($oldFile, $newFileTxt, FILE_APPEND); //新创建一个文件，并将新内容写入其中    
  endif;
}

?>
<!DOCTYPE html>
<html lang="zh">

<head>
  <meta charset="UTF-8" />
  <title>音乐列表</title>
  <link rel="stylesheet" href="../bootstrap4.3.css" />

  <style>
    td {
      vertical-align: middle !important;
    }
  </style>
</head>

<body>
  <div class="container mt-5">
    <!-- 标题 -->
    <h1>音乐播放器</h1>

    <!-- 开始提交音乐表单 -->
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">

      <div class="form-row align-items-center my-4">
        <!-- 添加按钮 -->
        <button type="submit" class="btn btn-primary" name="add">添加</button>
        <?php if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_FILES['uploadSong'])) {
          echo '<div class="alert alert-primary" role="alert">' . $message . '</div>';
        } ?>
        <?php if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['add'])) : ?>
          <!-- 如果有请求过来且请求内容为添加 -->
          <!-- 填写添加内容的表单 -->
          <!-- <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-text">ID：<input type="text" name='songID' value="<?php echo $songID = uniqid(); ?>" disabled></div>
                    </div> -->
          <div class="input-group mb-2 mr-sm-2">
            <div class="input-group-prepend">
              <label class="input-group-text" for="songID">ID</label>
            </div>
            <?php $songID = uniqid(); ?>
            <!-- 生成id -->
            <input type="text" class="form-control" id="songID" name="songID" value="<?php echo $songID; ?>" readonly>
          </div>
          <div class="input-group mb-2 mr-sm-2">
            <div class="input-group-prepend">
              <label class="input-group-text" for="songName">歌名</label>
            </div>
            <input type="text" class="form-control" id="songName" name="songName" placeholder="歌名">
          </div>
          <div class="input-group mb-2 mr-sm-2">
            <div class="input-group-prepend">
              <label class="input-group-text" for="singer">歌手</label>
            </div>
            <input type="text" class="form-control" id="singer" name="singer" placeholder="歌手">
          </div>
          <div class="input-group mb-2 mr-sm-2">
            <div class="input-group-prepend">
              <label class="input-group-text" for="uploadSong"><input type="file" id="uploadSong" name="uploadSong"></label>
            </div>
          </div>

          <button type="submit" class="btn btn-primary mb-2" name="addComplete">上传</button>
        <?php endif; ?>
      </div>
      <!-- 结束提交音乐表单 -->

      <!-- 表格主体 -->
      <table class="table table-striped table-hover text-center">
        <thead>
          <tr class="thead-dark">
            <th>id</th>
            <th>歌名</th>
            <th>歌手</th>
            <th>播放</th>
            <th>删除</th>
          </tr>
        </thead>
        <tbody>
          <!-- 根据数据库信息生成相应的数量的行数 -->
          <?php
          // 第一种方式===》一行一行的将文件读出然后进行处理
          // 打开数据库文件
          // $data = fopen('musicDataBase.txt', "r"); //以只读方式打开文件
          // while (!feof($data)) :
          //   $line = fgets($data); // 读取其中一行并将光标下移
          //   if (strlen($line) == 0) {
          //     continue;
          //   }
          // $lineArr = explode('|', $line); //将读取到的数据分割成一个数组
          // $songID = $lineArr[0];
          // $songName = $lineArr[1];
          // $singer = $lineArr[2];
          // $songPath = $lineArr[3];


          // 第二种方式===》将数据库读到一个数组中，遍历数组
          $dataArr = file('musicDataBase.txt');
          for ($i = 0; $i < count($dataArr); $i++) :
            // 将数据拆分成需要的的内容
            $line = $dataArr[$i];
            if (strlen($line) == 0) {
              continue;
            }
            $lineArr = explode('|', $line); //将读取到的数据分割成一个数组
            $songID = $lineArr[0];
            $songName = $lineArr[1];
            $singer = $lineArr[2];
            $songPath = $lineArr[3];

            ?>
            <tr>
              <td><?php echo $songID; ?></td><!-- 生成随机编码 -->
              <td><?php echo $songName; ?></td>
              <td><?php echo $singer; ?></td>

              <td><audio src="<?php echo $songPath; ?>" controls></audio></td>
              <td>
                <!-- <input type="submit" value="删除" class="btn btn-danger btn-sm" name="delete" /> -->
                <button class="btn btn-danger btn-sm" name="delete" value="<?php echo $i; ?>">删除</button>
              </td>
            </tr>
          <?php
        // endwhile;
        // fclose($data);//关闭文件
        endfor;
        ?>
        </tbody>
      </table>
    </form>
  </div>
</body>

</html>