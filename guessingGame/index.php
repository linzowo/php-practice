<!--
 * @Author: linzwo
 * @Date: 2019-06-22 15:15:04
 * @LastEditors: linzwo
 * @LastEditTime: 2019-06-22 15:15:04
 * @Description: 一个猜数游戏
 -->
<?php
session_start();
if (empty($_SESSION['answer'])) {
    // 游戏开始时初始化一个随机数
    $answer = random_int(1, 100);
    // 将随机数存储到session保证内容不会暴露
    $_SESSION['answer'] = $answer;
}
// var_dump($_SESSION['answer']);
// 获取用户输入的值 并判断该值是否与现在的值匹配

if (!empty($_GET['num'])) {
    $num = $_GET['num'];
    $result = (int)$num - $_SESSION['answer'];
    $input = empty($_COOKIE['input']) ? (string)$num : $_COOKIE['input'] . ',' . (string)$num;
    setcookie('input', $input);
}

// 获取当前用户输入次数
$inputArrLen = empty($_COOKIE['input']) ? 1 : count(explode(",", $input));
// echo $inputArrLen;
if($inputArrLen >=10){// 如果输入了10次就提示用户已经用完了次数
    $msg = "对不起次数已经用完,如果想开始下一次游戏请直接输入你的答案。";
    session_destroy(); //结束session存储并删除数据
    // 删除这个cookie
    setcookie('input');
}else{
    // 根据结果返回提示信息
    if (isset($result)) {
        if ($result > 0) {
            $msg = "输入的数字大了";
        }
        if ($result < 0) {
            $msg = "输入的数字小了";
        }
        if ($result == 0) {
            $msg = "恭喜你答对了,如果想开始下一次游戏请直接输入。";
            session_destroy(); //结束session存储并删除数据
            // 删除这个cookie
            setcookie('input');
        }
    }

}

// 限制次数为10次

// 记录每次输入的值并输出

?>
<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8">
    <title>猜数游戏</title>

    <link rel="stylesheet" href="../bootstrap4.3.css">

    <style>
        div.row {
            margin-left: 360px;
        }
    </style>
</head>

<body class="bg-dark text-white">
    <div class="container mt-5 text-center">
        <h1>欢迎来到猜数游戏</h1>
        <h3 class="alert alert-secondary mt-5">我已经准备好了一个1-100之间的数字，你现在有10次机会来猜一下这个数字是多少，准备好了就在下面的输入框内输入内容吧。</h3>
        <?php if (!empty($msg)) :; ?>
            <h3 class="alert alert-secondary mt-5"><?php echo $msg; ?></h3>
        <?php endif; ?>
        <form action="index.php" method="get">
            <div class="row mt-5">
                <div class="col-3">
                    <input type="number" class="form-control" min="1" max="100" name="num" autofocus="autofocus" />
                </div>
                <button class="col-3">试一下</button>
            </div>
            <div class='row'><?php echo empty($input) ? '' : $input; ?></div>
        </form>
    </div>
</body>

</html>