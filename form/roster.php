<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8">
    <title>花名册</title>
    <style>

    </style>
</head>

<body>
    <?php 
    // 判断是否有提价数据，决定是否执行php代码
    // if(strlen($_POST['name'])!=0):
    if($_SERVER['REQUEST_METHOD'] === 'POST'):
    // 打开文件
    $my_flie = fopen('roster.txt', "a+");
    //获取最后一行的索引值，并加1产生一个新的索引值
    $index = (count(file('roster.txt')))+1;
    // 将获取到的数据格式化
    $userData = "\n".$index.'|'.trim(join('|',$_POST));
    // 将数据加入数据库
    fwrite($my_flie,$userData);
    // 关闭文件 
        fclose($my_flie);
    endif;
    ?>
    <h1>系统花名册</h1>
    <table border='1' cellpadding='0' cellspacing='0' style="text-align: center">   
        <thead>
            <tr>
                <th>序号</th>
                <th>姓名</th>
                <th>年龄</th>
                <th>邮箱</th>
                <th>网址</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $my_flie = fopen('roster.txt', "r");
            while (!feof($my_flie)) :

                $lineTxt = fgets($my_flie); //读取其中一行字符并将光标下移一行
                $lineTxtArr = explode("|", $lineTxt);
                $link = strtolower($lineTxtArr[4]);
                $no = $lineTxtArr[0];
                if (strlen($lineTxtArr[0]) == 1) {
                    $no = "00" . $lineTxtArr[0];
                }
                if (strlen($lineTxtArr[0]) == 2) {
                    $no = "0" . $lineTxtArr[0];
                }
                ?>

                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $lineTxtArr[1]; ?></td>
                    <td><?php echo $lineTxtArr[2]; ?></td>
                    <td><?php echo $lineTxtArr[3]; ?></td>
                    <td>
                        <a href="<?php echo strtolower($lineTxtArr[4]); ?>"><?php echo substr($lineTxtArr[4],4); ?></a>
                    </td>
                </tr>
            <?php endwhile; ?>
            <?php fclose($my_flie); ?>
        </tbody>
    </table>
</body>

</html>