<?php 
    // 多页面间的数据共享方案
    
?>
<!-- 方案1：使用$_GET的方式获取url地址中的内容 -->
<a href="cookie2.php?msg='这是通过连接中的url传递的信息'">跳转到cookie2，并传递信息</a>

<!-- 方案2：使用表单 -->
<form action="cookie2.php?msg=这是通过表单提交传递的数据" method="post">
    <button>通过表单action传递数据</button>
</form>

<!-- 方案3：使用cookie -->
<?php 
// setcookie ($name, $value = "", $expire = 0, $path = "", $domain = "", $secure = false, $httponly = false)
setcookie('msg','这是通过cookie传递的信息');
?>
<a href="cookie2.php">通过cookie传递信息</a>

<!-- 方案4：使用session -->
<?php 
session_start();
$_SESSION['msg'] = '这是通过session传递的信息';
?>
<a href="cookie2.php">这是通过session传递的信息</a>
