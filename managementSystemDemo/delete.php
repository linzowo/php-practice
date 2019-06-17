<!--
 * @Author: linzwo
 * @Date: 2019-06-14 10:19:05
 * @LastEditors: linzwo
 * @LastEditTime: 2019-06-14 10:19:05
 * @Description: 处理删除信息的文件。输入：===》$_GET['id']===》输出：$message、删除服务器上的文件、删除数据库中的信息
 -->
<?php
// TODO 删除页
include_once 'nav.php';
// 输出：$sheetName

// 初始化
$msg = '';
$errormsg = '';

// 创建处理函数
function delete()
{
  /**
   * @description: 
   * @param {type} 
   * @return: 
   */
  // 检测id是否合法
  if (empty($_GET['id']) || !intval($_GET['id'])) {
    $GLOBALS['errormsg'] = '请选择有效的数据';
    return;
  }
  // 连接数据库
  $sheetName = $GLOBALS['sheetName'];
  $queryConmnet = "SELECT * FROM {$sheetName} WHERE id IN ({$_GET['id']});";
  // 获取该数据的信息
  $query = getDataFromDB($queryConmnet);
  // 遍历数据
  while ($row = mysqli_fetch_row($query)) {
    // var_dump($row);
    /* 
    array(5) {
      [0]=&gt;
      string(1) "1"
      [1]=&gt;
      string(6) "张三"
      [2]=&gt;
      string(45) "/managementSystemDemo/images/userdata/tx1.jpg"
      [3]=&gt;
      string(1) "1"
      [4]=&gt;
      string(10) "1994-12-01"
    }
    */
    // 获取图片路径
    $picPath = '.'.substr($row[2],21);
    // 根据路径删除图片
    if(!unlink($picPath)){
      $GLOBALS['msg'] .= '删除图片失败,可能图片已被删除';
    };
  };
  // 释放缓存
  mysqli_free_result($query);
  // 删除该数据在数据库中的信息
  $queryConmnet = "DELETE FROM {$sheetName} WHERE id IN ({$_GET['id']});";
  getDataFromDB($queryConmnet);
  // 释放缓存
  mysqli_free_result($query);

// 执行至此说明数据库中的信息及服务器上的文件都已删除
  $GLOBALS['msg'] .= '该信息已删除'; 
  // 跳转回主页
  header("location: index.php?sheetName={$sheetName}&msg={$GLOBALS['msg']}");
}

// 调用处理函数
delete();
// 检测是否存在报错，如果存在就显示报错
echo empty($errormsg) ? '' : "<div class='alert alert-danger' role='alert'>{$errormsg}</div>";
