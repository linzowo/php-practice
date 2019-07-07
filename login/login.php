<!--
 * @Author: linzwo
 * @Date: 2019-06-22 21:41:33
 * @LastEditors: linzwo
 * @LastEditTime: 2019-06-22 21:41:33
 * @Description: 登录页面
 -->
<?php
if (!empty($_GET['flag'])) {
    switch ($_GET['flag']) {
        case 0:
            $msg = '请输入用户名及密码。';
            break;
        case 1:
            $msg = '您输入的密码或账户有误请重新输入。';
            break;
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Signin Template · Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="../bootstrap4.3.css" rel="stylesheet">


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
</head>

<body class="text-center">
    <form class="form-signin" action="main.php" method="post">
        <!-- 登录图片 -->
        <img class="mb-4" src="tx1.jpg" alt="" width="72" height="72">
        <!-- 登录头 -->
        <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
        <?php if (!empty($msg)) :; ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $msg; ?>
            </div>
        <?php endif; ?>
        <!-- 邮箱地址 -->
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus name="email" value="<?php echo empty($_COOKIE['username'])?'':$_COOKIE['username']; ?>">
        <!-- 密码 -->
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required name="password">
        <!-- 记住用户 -->
        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me" name="remember"> Remember me
            </label>
        </div>
        <!-- 登录按钮 -->
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        <!-- 版权声明 -->
        <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
    </form>
</body>

</html>