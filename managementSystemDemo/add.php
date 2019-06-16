<?php
// TODO 增加页
include_once 'nav.php';
include_once '../common.php';


// 变量声明区===============================================


// 函数声明区===============================================
function setAdd()
{ //设置主页展示的内容和一些标签的展示状态
    /**
     * @description: 
     * @param {type} 
     * @return: 
     */

    if (empty($_GET['addtitle']) || (($_GET['addtitle'] != 'addUsers') && ($_GET['addtitle'] != 'addGoods'))) {
        $GLOBALS['message'] = '请选择要新增的类型';
        exit("<div class='alert alert-danger' role='alert'>请选择要新增的类型</div>");
    }
    // 新增users
    if ((!empty($_GET['addtitle'])) || ($_GET['addtitle'] === 'addUsers')) {
        // 设置对应参数值
        $GLOBALS['field1'] = 'gender';
        $GLOBALS['field2'] = 'birthday';
        $GLOBALS['output1'] = '性别';
        $GLOBALS['output2'] = '生日';
        $GLOBALS['optionList'] = array('请选择性别', '男', '女');
        // 确定要设置数据表
        $GLOBALS['sheetName'] = 'msd_users';
    }

    // 新增goods
    if ((!empty($_GET['addtitle'])) && ($_GET['addtitle'] === 'addGoods')) {
        // 设置对应参数值
        $GLOBALS['field1'] = 'type';
        $GLOBALS['field2'] = 'price';
        $GLOBALS['output1'] = '类别';
        $GLOBALS['output2'] = '价格';
        $GLOBALS['optionList'] = array('请选择类型', '杂货', '艺术', '建材', '表情', '珠宝');
        // 确定要设置数据表
        $GLOBALS['sheetName'] = 'msd_goods';
    }
}

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
    if (empty($_POST['name']) || strlen($_POST['name']) > 20) { //没有填名称或名称长度超过默认值
        $GLOBALS['message'] = '请输入规范的名称';
        return;
    }
    // 图片
    if (empty($_FILES['img']['name'])) { //
        $GLOBALS['message'] = '请上传图片';
        return;
    }
    $allowedImg = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($_FILES['img']['type'], $allowedImg)) { // 上传的图片类型不在允许的范围内
        $GLOBALS['message'] = '图片类型不支持，请重新上传';
        return;
    }
    // 类别/性别
    if (($_POST['sheetName'] === 'msd_users') && in_array($_POST['gender'], $GLOBALS['optionList']) && ($_POST['gender'] === '请选择性别')) {
        // 用户未选择性别
        $GLOBALS['message'] = '请选择性别';
        return;
    }

    if (($_POST['sheetName'] === 'msd_goods') && in_array($_POST['type'], $GLOBALS['optionList']) && ($_POST['type'] === '请选择类型')) {
        // 用户未选择类型
        $GLOBALS['message'] = '请选择类型';
        return;
    }

    // 价格/年龄
    if (($_POST['sheetName'] === 'msd_users') && (empty($_POST['birthday']))) {
        $GLOBALS['message'] = '请输入生日';
        return;
    }
    if (($_POST['sheetName'] === 'msd_goods') && (empty($_POST['price']))) {
        $GLOBALS['message'] = '请输入价格';
        return;
    }
    // 判断价格/年龄是否合法
    if (($_POST['sheetName'] === 'msd_users') && (!strtotime($_POST['birthday']))) {
        $GLOBALS['message'] = '请输入有效的生日';
        return;
    }
    if (($_POST['sheetName'] === 'msd_goods') && (strlen($_POST['price']) > 11)) {
        $GLOBALS['message'] = '请输入有效的价格';
        return;
    }
    // 运行至此说明数据合法，开始移动文件至服务器文件夹===》
    // 提取文件信息
    $picPath = "images/";
    $arr = explode('.',$_FILES['img']['name']);
    $imgtype = array_pop($arr);
    if (($_POST['sheetName'] === 'msd_users')) {
        $picPath .= 'users/' . uniqid() . '.' . $imgtype;
        $name = $_POST['name'];
        $gender = $_POST['gender'] === '男'?1:0;
        $birthday = $_POST['birthday'];
        $queryContent = "INSERT INTO msd_users (`name`,`picPath`,gender,birthday) VALUES ('{$name}','/managementSystemDemo/{$picPath}',{$gender},'{$birthday}');";
    }

    if (($_POST['sheetName'] === 'msd_goods')) {
        $picPath .= 'goods/' . uniqid() . '.' . $imgtype;   
        $name = $_POST['name'];
        $type = $_POST['type'];
        $price = $_POST['price'];
        $queryContent = "INSERT INTO msd_goods (`name`,`picPath`,`type`,price) VALUES ('{$name}','/managementSystemDemo/{$picPath}','{$type}',{$price});";
    }

    // 开始移动
    if (!move_uploaded_file($_FILES['img']['tmp_name'], ('./'.$picPath))) {
        $GLOBALS['message'] = '上传文件至服务器失败';
        return;
    }
    // 运行至此说明数据合法且上传至服务器成功，上传数据至数据库===》
    $query =  getDataFromDB($queryContent);
    // 释放缓存
    mysqli_free_result($query);

    // 查询新添加数据的id
    $queryContent = "select id from msd_users order by id DESC limit 1;";
    $query =  getDataFromDB($queryContent);
    $id = mysqli_fetch_row($query)[0];
    // 释放缓存
    mysqli_free_result($query);

    // 完成全部上传任务，跳转回主页面
    $location = 'location: index.php?title='.substr($_POST['sheetName'],4)."&add_success#{$id}";
    header($location);
}

// 调用设置页面内容的函数======================================
setAdd();

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
    <?php echo empty($message) ? '' : "<div class='alert alert-danger' role='alert'>{$message}</div>"; ?>

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