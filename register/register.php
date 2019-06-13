<!-- // 实现的功能 -->
<!-- 判断用户是否提交内容，如果提交内容就处理并展示处理结果 -->
<?php
function is_complete()
{// 判断用户是否完整的填写表单
    if (empty($_POST['name'])) { //如果没有输入名称
        $GLOBALS['message'] = '请输入名称';
        return;
    }

    if (empty($_POST['password'])) { //如果没有输入密码
        $GLOBALS['message'] = '请输入密码';
        return;
    }

    if (empty($_POST['confirm'])) { //如果没有输入确认密码
        $GLOBALS['message'] = '请确认密码';
        return;
    }
    
    if($_POST['password'] !==$_POST['confirm']){
        $GLOBALS['message'] = '密码不一致';
        return;
    }
    if (empty($_POST['clause'])) { //如果没有确认条款
        $GLOBALS['message'] = '请确认条款';
        return;
    }

    // 将用户的信息写入数据库
    file_put_contents('register.txt',join('|',$_POST)."\n",FILE_APPEND);
    // 告知用户注册成功
    $GLOBALS['message'] = '注册成功';
    
}

// 存储用户已经输入的值
$name = '';
$password = '';
$confirm = '';
$clause = '';
// if(!isset($_POST)){//如果有值
if ($_SERVER['REQUEST_METHOD'] === 'POST') { //判断是否有请求方法进来且方法与所规定的方法一致
    $name = $_POST['name'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    $clause = empty($_POST['clause'])?'':'checked';

    // 判断用户输入是否完整，不完整无法执行下一步
    is_complete();
}; ?>
<!-- // html页面 -->
<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8">
    <title>注册页面</title>
    <link rel="stylesheet" href="../bootstrap.css">
    <style>
        form {
            width: 500px;
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <form class="form-horizontal center-block" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="form-group">
            <label for="exampleInputName2" class="col-sm-2 control-label">姓名</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="exampleInputName2" placeholder="姓名" name="name" value="<?php echo $name; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputPassword3" placeholder="Password" name="password" value="<?php echo $password; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword4" class="col-sm-2 control-label">confirm</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputPassword4" placeholder="confirm" name="confirm" value="<?php echo $confirm; ?>">
            </div>
        </div>
        <div class="form-group"><?php echo empty($message) ? '' : $message; ?></div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="clause" value="1" <?php echo $clause;?>> 同意用户条款
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">注册</button>
            </div>
        </div>
    </form>
</body>

</html>