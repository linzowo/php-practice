<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>一个表单</title>
</head>
<body>
    
    <!-- <form action="roster.php" method="post"> -->
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <table border='1' cellpadding='0' cellspacing='0' style="text-align: center">
            <tr>
                <td>姓名</td>
                <td><input type="text" name="name"></td>
            </tr>
            <tr>
                <td>年龄</td>
                <td><input type="text" name="age"></td>
            </tr>
            <tr>
                <td>邮箱</td>
                <td><input type="text" name="email"></td>
            </tr>
            <tr>
                <td>网址</td>
                <td><input type="text" name="website"></td>
            </tr>
            <tr>
                <td></td>
                <td><button id="btn">提交</button></td>
            </tr>
        </table>
    </form>

    <script>
        var btn = document.getElementById("btn");
        var inputList = document.getElementsByTagName("input");
        btn.onclick= function(){
            for(var i=0;i<inputList.length;i++){
                if(!inputList[i].value){
                    alert("请输入内容");
                    return false;
                }
            }};
    </script>
</body>
</html>