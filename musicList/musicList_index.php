<?php
// if ($_SERVER['REQUEST_METHOD'] === "POST") {
//   // var_dump($_POST);
//   /* 
//   $_POST==>
//   array(4) {
//   ["songID"]=>
//   string(13) "5cfa199f0a777"
//   ["songName"]=>
//   string(9) "小时候"
//   ["singer"]=>
//   string(9) "五月天"
//   ["addComplete"]=>
//   string(0) ""
// }
//   */

//   /* $_FILES ==>
//   array(1) {
//   ["uploadSong"]=>
//   array(5) {
//     ["name"]=>
//     string(25) "五月天 - 小时候.mp3"
//     ["type"]=>
//     string(9) "audio/mp3"
//     ["tmp_name"]=>
//     string(61) "C:\file\OneDrive\codeing\phpPractice\musicList\tmp\phpC1F.tmp"
//     ["error"]=>
//     int(0)
//     ["size"]=>
//     int(12262099)
//   }
// }
//   */
// // 处理用户上传音乐的模块
// if (isset($_POST['add'])) { //用户点击了添加按钮
//   header('location:musicList_add.php'); // 跳转至添加页面
// }

// }

// ?】
// <!DOCTYPE html>
// <html lang="zh">

// <head>
//   <meta charset="UTF-8" />
//   <title>音乐列表</title>
//   <link rel="stylesheet" href="../bootstrap4.3.css" />

//   <style>
//     td {
//       vertical-align: middle !important;
//     }
//   </style>
// </head>

// <body>
//   <div class="container mt-5">
//     <!-- 标题 -->
//     <h1>音乐播放器</h1>

//     <!-- 开始提交音乐表单 -->
//     <form action="【?php $_SERVER['PHP_SELF']; ?】" method="post" enctype="multipart/form-data">

//       <div class="form-row align-items-center my-4">
//         <!-- 添加按钮 -->
//         <button type="submit" class="btn btn-primary" name="add">添加</button>
//       </div>
//       <!-- 结束提交音乐表单 -->

//       <!-- 表格主体 -->
//       <table class="table table-striped table-hover text-center">
//         <thead>
//           <tr class="thead-dark">
//             <th>序号</th>
//             <th>歌名</th>
//             <th>封面</th>
//             <th>歌手</th>
//             <th>播放</th>
//             <th>删除</th>
//           </tr>
//         </thead>
//         <tbody>
//           <!-- 根据数据库信息生成相应的数量的行数 -->
//           【?php
//           // 读出==>解码===>索引数组
//           $dataArr = json_decode(file_get_contents('musicDataBase.json'), true);
//           for ($i = 0; $i < count($dataArr); $i++) :
//             // 将数据拆分成需要的的内容
//             $lineArr = $dataArr[$i]; //将读取到的数据分割成一个数组
//             //{"id":"5cfc80b670d51","name":"\u5e90\u5dde\u6708","singer":"\u8bb8\u5d69","picPath":"picture","songPath":"music"}
//             $songIndex = $i + 1;
//             $songName = $lineArr['name'];
//             $picPath = $lineArr['picPath'];
//             $singer = $lineArr['singer'];
//             $songPath = $lineArr['songPath'];

//             ?】
//             <tr>
//               <td>【?php echo $songIndex; ?】</td><!-- 生成随机编码 -->
//               <td>【?php echo $songName; ?】</td>
//               <td><img src="【?php echo $picPath; ?】" alt="" width="100px"></td>
//               <td>【?php echo $singer; ?】</td>

//               <td><audio src="【?php echo $songPath; ?】" controls></audio></td>
//               <td>
//                 <!-- <input type="submit" value="删除" class="btn btn-danger btn-sm" name="delete" /> -->
//                 <!-- <button class="btn btn-danger btn-sm" name="delete" value="【?php //echo $i; ?】">删除</button> -->
//                 <a class="btn btn-danger btn-sm" name="delete" href="musicList_delete.php?index=【?php echo $i; ?】">删除</a>
//               </td>
//             </tr>
//           【?php
//         // endwhile;
//         // fclose($data);//关闭文件
//         endfor;
//         ?】
//         </tbody>
//       </table>
//     </form>
//   </div>
// </body>

// </html>
?>
<!-- ========================================================================================================================================== -->

<!-- TODO: 添加多条删除功能  -->
<!-- TODO:  添加编辑按钮 -->
<!-- TODO:   -->

<!-- 配合mysql数据库=====并新增编辑功能 -->
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
  <?php include_once 'musicList_nav.php'; ?>
  <div class="container mt-5">
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">

      <!-- 表格主体 -->
      <table class="table table-striped table-hover text-center">
        <thead>
          <tr class="thead-dark">
            <th>#</th>
            <th>歌名</th>
            <th>封面</th>
            <th>歌手</th>
            <th>播放</th>
            <th>删除</th>
          </tr>
        </thead>
        <tbody>
          <!-- 根据数据库信息生成相应的数量的行数 -->
          <?php
          // TODO: 
          // 连接数据库
          /* 
            mysqli_connect($host = '',$user = '',$password = '',$database = '',$port = '',$socket = ''
            */
          $conn = mysqli_connect('localhost', 'root', '111111', 'demo');

          if (!$conn) {
            exit("<h1>网页出错了，请稍后再试！</h1>");
          }

          // 获取数据库查询
          // mysqli_query ($link, $query, $resultmode = MYSQLI_STORE_RESULT)
          $query = mysqli_query($conn, 'SELECT * FROM musiclist;');

          if (!$query) {
            exit("<h1>没有找到想要的信息！</h1>");
          }

          // 遍历数据
          while ($row = mysqli_fetch_row($query)) :
            // 获取数据
            $id = $row[0];
            $songName = $row[1];
            $picPath = $row[2];
            $singer = $row[3];
            $songPath = $row[4];
            ?>
            <tr>
              <td><?php echo $id; ?></td>
              <td><?php echo $songName; ?></td>
              <td><img src="<?php echo $picPath; ?>" alt="" width="100px"></td>
              <td><?php echo $singer; ?></td>

              <td><audio src="<?php echo $songPath; ?>" controls></audio></td>
              <td>
                <a class="btn btn-primary btn-sm" name="delete" href="musicList_update.php?id=<?php echo $id; ?>">编辑</a>
                <a class="btn btn-danger btn-sm" name="delete" href="musicList_delete.php?id=<?php echo $id; ?>">删除</a>
              </td>
            </tr>
          <?php
        endwhile;
        // 清除暂存
        mysqli_free_result($query);
        // fclose($data);//关闭文件
        // endfor;
        ?>
        </tbody>
      </table>
    </form>
  </div>
</body>

</html>