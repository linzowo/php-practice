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

  <script>
    // 为复选框设置全选全不选功能
    window.onload = function() {
      // 获取元素
      var ckbAllObj = document.getElementById("checkAll");
      var ckbList = document.getElementsByTagName('tbody')[0].getElementsByTagName('input');
      // console.log(ckbAllObj);
      // console.log(ckbList);

      // 创建一个数组用来存储用户选取的id
      var idlist = [];

      // 用户点击全选按钮时
      ckbAllObj.onclick = function() {
        var tmpIdList = [];
        // 检查当前是否是被选中状态，如果是就设置所有的checkbox为选中状态
        for (var i = 0; i < ckbList.length; i++) {
          ckbList[i].checked = this.checked;
          tmpIdList.push(ckbList[i].parentNode.parentNode.children[0].innerHTML);
        }


        if (this.checked) {
          // 用户全选
          // 将当前页所有id加入其中
          idlist = tmpIdList;
        } else { // 用户全部取消
          // 删除数组中所有的数据
          idlist.splice(0);
        }
        // console.log(idlist);
        choosedCkbHandle();
      };


      // 当复选框没有被全部选中时，全选框为未选中状态===>为每个复选框注册点击事件
      for (var i = 0; i < ckbList.length; i++) {
        ckbList[i].onclick = ckbClickHandle;
      }

      // 检查是否有元素被选中，如果有休显示批量删除按钮

      // 为每个复选框的点击事件创建一个处理函数===》节省空间
      function ckbClickHandle() {

        // 获取当前点击行的id
        var ckbID = this.parentNode.parentNode.children[0].innerHTML;
        if (this.checked) { // 用户选中了这一行的数据
          // 将选中行的id加入数组
          idlist.push(ckbID);
        } else { //用户取消了选中这一行
          // 删除取消行的ID
          var delIndex = idlist.indexOf(ckbID);
          idlist.splice(delIndex, 1);
        }
        // console.log(idlist);
        choosedCkbHandle();

        // 检查是否到达了全选状态
        ckbAllObj.checked = true;
        for (var i = 0; i < ckbList.length; i++) {
          if (!ckbList[i].checked) { //如果有一个没有选中就修改全选框为未选中状态
            ckbAllObj.checked = false;
            break;
          }
        }
      }

      // 当复选框被选中时的处理函数==》节省空间
      function choosedCkbHandle() {
        var bdbtn = document.getElementById('bulkeDletions');
        var link = 'musicList_delete.php?id=' + idlist.join();
        if (!(idlist.length == 0)) { //数组不为空
          bdbtn.setAttribute('class', 'nav-link');
        } else { //数组为空
          bdbtn.setAttribute('class', 'nav-link disabled');
        }
        bdbtn.setAttribute('href', link);
      }

    };
  </script>
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
            <th><input type="checkbox" name="" id="checkAll"></th>
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
          // 连接数据库
          /* 
            mysqli_connect($host = '',$user = '',$password = '',$database = '',$port = '',$socket = ''
            */
          $conn = mysqli_connect('localhost', 'root', '111111', 'demo');

          if (!$conn) {
            exit("<h1>网页出错了，请稍后再试！</h1>");
          }

          // 获取数据库查询===获取数据总条数
          // mysqli_query ($link, $query, $resultmode = MYSQLI_STORE_RESULT)
          $query = mysqli_query($conn, 'SELECT * FROM musiclist;');

          if (!$query) {
            exit("<h1>没有找到想要的信息！</h1>");
          }
          // var_dump($query);
          // object(mysqli_result)#2 (5) { ["current_field"]=> int(0) ["field_count"]=> int(5) ["lengths"]=> NULL ["num_rows"]=> int(6) ["type"]=> int(0) }
          // echo $query->num_rows;
          $count_rows = $query->num_rows; //获取了数据库中总的数据行数
          $pages = ceil($count_rows / 10); // 计算出总页数===》向上取整保证哪怕只有1条数据也能展示

          // 清除暂存区为下一次查询腾出空间
          mysqli_free_result($query);

          // 进行分页查询==============================================
          // echo $num_rows;
          // 初始化页码
          $page = 1;
          // echo $page;
          if (!empty($_GET['page']) && intval($_GET['page'])) { //防止恶意传入负数或非数字
            // 如果传入了页码
            $page = $_GET['page'];
            // echo "进来了";
          }
          // 跳过条数
          $pass_rows = ($page - 1) * 10;
          // 查询当前页码对应的数据
          $query = mysqli_query($conn, "SELECT * FROM musiclist LIMIT {$pass_rows},10;");

          // 遍历数据
          $ckbid = 0; //用于生成每个复选框的id
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
              <td><input type="checkbox" name="" id="ckb<?php echo $ckbid; ?>"></td>
              <td><?php echo $songName; ?></td>
              <td><img src="<?php echo $picPath; ?>" alt="" width="100px"></td>
              <td><?php echo $singer; ?></td>

              <td><audio src="<?php echo $songPath; ?>" controls></audio></td>
              <td>
                <a class="btn btn-primary btn-sm" name="delete" href="musicList_update.php?id=<?php echo $id; ?>">编辑</a>
                <a class="btn btn-danger btn-sm" name="delete" href="musicList_delete.php?id=<?php echo $id; ?>&page=<?php echo $page; ?>">删除</a>
              </td>
            </tr>
            <?php
            $ckbid++;
          endwhile;
          // 清除暂存
          mysqli_free_result($query);
          // fclose($data);//关闭文件
          // endfor;
          ?>
        </tbody>
      </table>
    </form>
    <div class="container">
      <nav aria-label="Page navigation example ">
        <ul class="pagination justify-content-center">
          <li class="page-item">
            <a class="page-link" href="musicList_index.php?page=<?php echo ($page - 1) < 1 ? 1 : ($page - 1); ?>" aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
              <span class="sr-only">Previous</span>
            </a>
          </li>
          <!-- 根据数据库的总行数的运算结果生成对应的分页数 -->
          <?php
          for ($i = 1; $i <= $pages; $i++) :; ?>
            <li class="page-item"><a class="page-link" href="musicList_index.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
          <?php endfor; ?>
          <li class="page-item">
            <a class="page-link" href="musicList_index.php?page=<?php echo ($page + 1) > $pages ? $pages : ($page + 1); ?>" aria-label="Next">
              <span aria-hidden="true">&raquo;</span>
              <span class="sr-only">Next</span>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </div>




</body>

</html>