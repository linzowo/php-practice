
<!--
 * @Author: linzwo
 * @Date: 2019-06-14 10:19:43
 * @LastEditors: linzwo
 * @LastEditTime: 2019-06-14 10:19:43
 * @Description: file content
 -->

 <title>编辑数据</title>
<?php 
  include_once 'nav.php';
  // 输出：$sheetName、

  // 输入$sheetName、
  // 设置页面输出内容
  switch ($sheetName) {
    case 'msd_users':
        $field1 = 'gender';
        $field2 = 'birthday';
        $output1 = '性别';
        $output2 = '生日';
        $optionList = array('请选择性别', '男', '女');
        break;
    case 'msd_goods':
        $field1 = 'type';
        $field2 = 'price';
        $output1 = '类别';
        $output2 = '价格';
        $optionList = array('请选择类型', '杂货', '艺术', '建材', '表情', '珠宝');
        break;
  }

  // 根据用户输入确定页面展示什么数据
  function setEdit(){
    // 判断用户获取页面时传入的参数是否合法
    if(empty($_GET['id']) || !intval($_GET['id'])){
      $GLOBALS['errormsg'] = '未选择要修改的数据。';
      return;
    }
  // 连接数据库获取需要编辑的文件并将其输出到页面中展示
  $queryContent = "SELECT * FROM {$GLOBALS['sheetName']} WHERE id = {$_GET['id']};";
  $query = getDataFromDB($queryContent);
  while($row = mysqli_fetch_row($query)){
    $GLOBALS['name'] = $row[1];
    $GLOBALS['picPath'] = $row[2];
    $GLOBALS['option'] = $row[3]=="1"?'男':($row[3]=="0"?'女':$row[3]);
    $GLOBALS['birOrPri'] = $row[4];
  }

  }

  // 调用处理函数
  setEdit();
?>
<!-- 输出：要编辑的信息、$name $picPath $option $birOrPri -->

<!-- 输入：用户编辑后的信息 -->
<?php 
function checkUploadData(){
  // 校验name
  if(empty($_POST['name'])){
    $GLOBALS['errormsg'] = '名称不能为空';
    return;
  }
  if($_POST['name'] !== $GLOBALS['name']){
    $GLOBALS['name'] = $_POST['name'];
  }
  // 输出：$name
  // 校验图片
  if(!empty($_FILES['img']['name'])){//如果用户上传了图片
    // var_dump($_FILES['img']);
    /* 
      array(5) {
        ["name"]=&gt;
        string(7) "tx1.jpg"
        ["type"]=&gt;
        string(10) "image/jpeg"
        ["tmp_name"]=&gt;
        string(27) "C:\Windows\Temp\phpD97E.tmp"
        ["error"]=&gt;
        int(0)
        ["size"]=&gt;
        int(13278)
      }
    */
    // 校验文件类型
      $allowedType = array("image/jpeg","image/png","image/gif");
      if(!in_array($_FILES['img']['type'],$allowedType)){
        $GLOBALS['errormsg'] = '文件类型不支持';
        return;
      }
    // 校验文件大小
      if($_FILES['img']['size'] > (10 * 1024 *1024)){
        $GLOBALS['errormsg'] = '图片文件过大';
        return;
      }

    // 运行至此说明文件符合要求
    // 移除旧文件
    // if(!unlink($GLOBALS['picPath'])){
    //   $GLOBALS['msg'] .= "删除原图片失败,可能图片已被删除";
    // };
    // 将新文件按照原来文件的名称存入原路径。如果原文件存在就会覆盖掉原文件
    // 需要将图片路径转换为相对路径才能进行移动
    if(!move_uploaded_file($_FILES['img']['tmp_name'],(".".substr($GLOBALS['picPath'],21)))){
        $GLOBALS['msg'] .= "由于未知原因修改图片失败";
    }
    // 运行至此修改图片成功
  }
  // 校验option
  if($_POST[$GLOBALS['field1']] !== $GLOBALS['option']){// 如果用户修改了类型，就使用新类型
    if(!in_array($_POST[$GLOBALS['field1']],$GLOBALS['optionList'])){
      $GLOBALS['errormsg'] = '请选择正确的类型';
      return;
    }
    $GLOBALS['option'] = $_POST[$GLOBALS['field1']];
  }
  // 校验生日/价格
  if($_POST[$GLOBALS['field2']] !== $GLOBALS['birOrPri']){//用户输入了新的生日或价格
    // 检验是否是一个合法的内容
    if(($GLOBALS['field2'] === "birthday") && (!strtotime($_POST[$GLOBALS['field2']]))){
      $GLOBALS['errormsg'] = '请输入有效的生日';
      return;
    }
    if(($GLOBALS['field2'] === "price") && (strlen($_POST[$GLOBALS['field2']]) > 11)){
      $GLOBALS['errormsg'] = '请输入有效的价格';
      return;
    }

    // 运行至此说明用户输入的信息符合要求
    $GLOBALS['birOrPri'] = $_POST[$GLOBALS['field2']];
  }

  // 运行至此说明用户输入的信息全部校验完毕，将校验完成后的信息存入数据库
  $GLOBALS['option'] = ($_POST[$GLOBALS['field1']]=='男')?1:($_POST[$GLOBALS['field1']]=='女'?0:$_POST[$GLOBALS['field1']]);
  $setContent = "`name` = '{$GLOBALS['name']}',`picPath` = '{$GLOBALS['picPath']}',{$GLOBALS['field1']} = {$GLOBALS['option']},{$GLOBALS['field2']} = '{$GLOBALS['birOrPri']}'";
  $queryContent = "UPDATE {$GLOBALS['sheetName']} SET {$setContent} WHERE id = {$_GET['id']};";
  // var_dump($queryContent);
  getDataFromDB($queryContent);
  // 完成全部上传任务，跳转回主页面
  $location = "location: index.php?sheetName={$GLOBALS['sheetName']}&page={$_GET['page']}#{$_GET['id']}";
  header($location);
}

// 用户点击了提交按钮
if(!empty($_POST)){
  // 调用检查函数，判断用户传入的数据是否合法
  checkUploadData();
}
?>
<!-- 输出：存储编辑后的信息到数据库、存储用户修改后的文件到服务器、跳转回主页面、输出报错信息 -->
<body>
    <!-- 错误信息显示区 -->
    <?php echo empty($errormsg) ? '' : "<div class='alert alert-danger' role='alert'>{$errormsg}</div>"; ?>

    <div class="container mt-5">
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <!-- 名称 -->
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">名称</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name='name' value="<?php echo empty($_POST['name']) ? $name : $_POST['name']; ?>">
                </div>
            </div>
            <!-- 头像/图片 -->
            <div class="form-group row">
                <label for="img" class="col-sm-2 col-form-label">上传图片<img src="<?php echo $picPath; ?>" width="100px" height="100px"></label>
                <div class="col-sm-10">
                    <input type="file" class="form-control" id="img" name='img' placeholder="上传图片" accept="image/*">
                </div>
            </div>
            <!-- 性别/类别 -->
            <div class="form-group row">
                <label for="<?php echo $field1; ?>" class="col-sm-2 col-form-label"><?php echo $output1; ?></label>
                <div class="col-sm-10">
                    <select class="custom-select" required id="<?php echo $field1; ?>" name="<?php echo $field1; ?>">

                        <!-- 生成下拉选项开始============================================ -->
                        <?php foreach ($optionList as $value) :; ?>
                            <option value="<?php echo $value; ?>" <?php echo $value === $option?'selected':''; ?>><?php echo $value; ?></option>
                        <?php endforeach; ?>
                        <!-- 生成下拉选项结束============================================ -->

                    </select>
                </div>
                <!-- <div class="invalid-feedback">Example invalid custom select feedback</div> -->
            </div>
            <!-- 生日/价格 -->
            <div class="form-group row">
                <label for="<?php echo $field2; ?>" class="col-sm-2 col-form-label"><?php echo $output2; ?></label>
                <div class="col-sm-10">
                    <input type="<?php echo $field2 === 'birthday' ? 'date' : 'text'; ?>" value="<?php echo empty($_POST[$field2]) ? $birOrPri : $_POST[$field2]; ?>" class="form-control" id="<?php echo $field2; ?>" name='<?php echo $field2; ?>'>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary" name="sheetName" value="<?php echo $sheetName; ?>">提交修改</button>
                </div>
            </div>
        </form>
    </div>
</body>