<!-- 
  @Author: linzwo
  @Date: 2019-06-14 10:18:31
  @LastEditors: linzwo
  @LastEditTime: 2019-06-17 17:08:16
  @Description: 新增数据页面。输入：$sheetName===>输出：add_success、$id、$errormsg、用户上传的文件、数据库新增的信息
 -->
<?php
include_once 'nav.php';
// 输出：$sheetName、

// 输入$sheetName
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
// 输出$field1、$field2、$output1、$output2、$optionList

function checkUploadData()
{
    /* 
    $_POST===>
        array(4) {
        ["name"]=&gt;
        string(10) " 林除夕"
        ["type"]=&gt;
        string(1) "杂货"
        ["price"]=&gt;
        string(3) "100"
        ["sheetName"]=&gt;
        string(9) "msd_goods"
        }

    $_FILES===>
        array(1) {
            ["img"]=&gt;
            array(5) {
            ["name"]=&gt;
            string(16) "知行合一.jpg"
            ["type"]=&gt;
            string(10) "image/jpeg"
            ["tmp_name"]=&gt;
            string(27) "C:\Windows\Temp\phpE079.tmp"
            ["error"]=&gt;
            int(0)
            ["size"]=&gt;
            int(105043)
            }
        }   



    */

    if (empty($_POST['sheetName'])) {
        // 说明用户还没有提交信息===>结束函数运行
        return;
    }

    // 效验用户的内容是否合法===》
    // 姓名
    if (empty($_POST['name']) || strlen($_POST['name']) > 50) { //没有填名称或名称长度超过默认值
        $GLOBALS['errormsg'] = '请输入规范的名称';
        return;
    }
    // 图片
    if (empty($_FILES['img']['name'])) { //
        $GLOBALS['errormsg'] = '请上传图片';
        return;
    }
    $allowedImg = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($_FILES['img']['type'], $allowedImg)) { // 上传的图片类型不在允许的范围内
        $GLOBALS['errormsg'] = '图片类型不支持，请重新上传';
        return;
    }
    // 类别/性别
    if (($_POST['sheetName'] === 'msd_users') && in_array($_POST['gender'], $GLOBALS['optionList']) && ($_POST['gender'] === '请选择性别')) {
        // 用户未选择性别
        $GLOBALS['errormsg'] = '请选择性别';
        return;
    }

    if (($_POST['sheetName'] === 'msd_goods') && in_array($_POST['type'], $GLOBALS['optionList']) && ($_POST['type'] === '请选择类型')) {
        // 用户未选择类型
        $GLOBALS['errormsg'] = '请选择类型';
        return;
    }

    // 价格/年龄
    if (($_POST['sheetName'] === 'msd_users') && (empty($_POST['birthday']))) {
        $GLOBALS['errormsg'] = '请输入生日';
        return;
    }
    if (($_POST['sheetName'] === 'msd_goods') && (empty($_POST['price']))) {
        $GLOBALS['errormsg'] = '请输入价格';
        return;
    }
    // 判断价格/年龄是否合法
    if (($_POST['sheetName'] === 'msd_users') && (!strtotime($_POST['birthday']))) {
        $GLOBALS['errormsg'] = '请输入有效的生日';
        return;
    }
    if (($_POST['sheetName'] === 'msd_goods') && (strlen($_POST['price']) > 11)) {
        $GLOBALS['errormsg'] = '请输入有效的价格';
        return;
    }
    // 运行至此说明数据合法，开始移动文件至服务器文件夹===》
    // 提取文件信息
    $picPath = "/managementSystemDemo/images/";
    $arr = explode('.', $_FILES['img']['name']);
    $imgtype = array_pop($arr);
    if (($_POST['sheetName'] === 'msd_users')) {
        $picPath .= 'users/' . uniqid() . '.' . $imgtype;
        $name = $_POST['name'];
        $gender = $_POST['gender'] === '男' ? 1 : 0;
        $birthday = $_POST['birthday'];
        $queryContent = "INSERT INTO msd_users (`name`,`picPath`,gender,birthday) VALUES ('{$name}','{$picPath}',{$gender},'{$birthday}');";
    }

    if (($_POST['sheetName'] === 'msd_goods')) {
        $picPath .= 'goods/' . uniqid() . '.' . $imgtype;
        $name = $_POST['name'];
        $type = $_POST['type'];
        $price = $_POST['price'];
        $queryContent = "INSERT INTO msd_goods (`name`,`picPath`,`type`,price) VALUES ('{$name}','{$picPath}','{$type}',{$price});";
    }

    // 开始移动
    if (!move_uploaded_file($_FILES['img']['tmp_name'], ('..' . $picPath))) {// ===>C:/file/OneDrive/codeing/phpPractice/managementSystemDemo/images/users/id.jpg===》超级绝对路径：规定到服务上的顶级盘符中进行查找
        $GLOBALS['errormsg'] = '上传文件至服务器失败';
        return;
    }
    // if (!move_uploaded_file($_FILES['img']['tmp_name'], ("/managementSystemDemo/{$picPath}"))) {// ===>/managementSystemDemo/images/users/id.jpg===》从根目录开始查找文件夹===>不行
    //     $GLOBALS['errormsg'] = '上传文件至服务器失败';
    //     return;
    // }
    // if (!move_uploaded_file($_FILES['img']['tmp_name'], ("$picPath"))) {// ===>images/users/id.jpg可行===》与处理文件同级的文件夹可以
    //     $GLOBALS['errormsg'] = '上传文件至服务器失败';
    //     return;
    // }
    // 运行至此说明数据合法且上传至服务器成功，上传数据至数据库===》
    $query =  getDataFromDB($queryContent);
    // 释放缓存
    mysqli_free_result($query);

    // 查询新添加数据的id===》用于返回展示页时定位新数据位置
    $queryContent = "select id from msd_users order by id DESC limit 1;";
    $query =  getDataFromDB($queryContent);
    $id = mysqli_fetch_row($query)[0];
    // 释放缓存
    mysqli_free_result($query);

    // 完成全部上传任务，跳转回主页面
    $location = "location: index.php?sheetName={$_POST['sheetName']}&add_success#{$id}";
    header($location);
}
// 输出：add_success、$id

// 接收上传数据的区域======================================
checkUploadData();

?>


<!-- html区域=============================================== -->
<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8">
    <title>新增数据</title>
</head>

<body>
    <!-- 错误信息显示区 -->
    <?php echo empty($errormsg) ? '' : "<div class='alert alert-danger' role='alert'>{$errormsg}</div>"; ?>

    <div class="container mt-5">
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <!-- 名称 -->
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">名称</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name='name' placeholder="名称" value="<?php echo empty($_POST['name']) ? '' : $_POST['name']; ?>">
                </div>
            </div>
            <!-- 头像/图片 -->
            <div class="form-group row">
                <label for="img" class="col-sm-2 col-form-label">上传图片</label>
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
                            <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
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
                    <input type="<?php echo $field2 === 'birthday' ? 'date' : 'text'; ?>" value="<?php echo empty($_POST['price']) ? '' : $_POST['price']; ?>" class="form-control" id="<?php echo $field2; ?>" name='<?php echo $field2; ?>' placeholder="<?php echo $output2; ?>">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary" name="sheetName" value="<?php echo $sheetName; ?>">添加</button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>