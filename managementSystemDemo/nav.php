<!--
 * @Author: linzwo
 * @Date: 2019-06-14 10:38:11
 * @LastEditors: linzwo
 * @LastEditTime: 2019-06-15 10:02:56
 * @Description: 公共导航栏
 -->

<?php include_once '../common.php'; ?>
<!-- 输出：function getAge()、function getDataFromDB($queryConmnet,$host='localhost',$user = 'root',$password='111111',$base='demo') -->

 <!-- 定义变量及函数区域===》输入：无 -->
<?php
    // 变量声明区======================================================

    // 初始化默认显示第几页
    $page = 1;
    // 确定本页要显示的是什么数据===users||goods
    $GLOBALS['sheetName'] = ((empty($_GET['sheetName'])) || ($_GET['sheetName'] !== 'msd_goods')) ? 'msd_users' : 'msd_goods';

    // 函数定义区===================================================
    function setIndex()
    { //设置主页展示的内容和一些标签的展示状态

        // users被选中
        if ($GLOBALS['sheetName'] === 'msd_users') {
            // 设置侧边栏选中
            $GLOBALS['usersActive'] = ' active';
            // 将表头设置为users_header
            $GLOBALS['tableHeader'] = array('头像', '性别', '年龄');
        }

        // goods被选中
        if (($GLOBALS['sheetName'] === 'msd_goods')) {
            // 设置侧边栏选中
            $GLOBALS['goodsActive'] = ' active';
            // 将表头设置为goods_header
            $GLOBALS['tableHeader'] = array('图片', '类别', '价格');
        }
    }

?>
<!-- 输出：$page = 1、$sheetName、function setIndex() -->

<!-- 输入：$_GET['add']、$sheetName -->
<?php
    $addUsers = '';
    $addGoods = '';
    if (isset($_GET['add'])) {
        ($sheetName === 'msd_users')?$addUsers = ' active':$addGoods = ' active';
    };
?>
<!-- 输出：$addUsers = ' active'||$addGoods = ' active' -->


<!-- html区 -->
<!DOCTYPE html>
<html lang="zh">
    <head>
        <meta charset="UTF-8" />
        <title>XX管理系统</title>
        <link rel="stylesheet" href="../bootstrap4.3.css">
    </head>

    <body>
        <!-- 公共导航栏开始 -->
        <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php">XX管理系统</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item<?php echo $addUsers; ?>">
                        <a class="nav-link" href="add.php?sheetName=msd_users&add">新增用户</a>
                    </li>
                    <li class="nav-item<?php echo $addGoods; ?>">
                        <a class="nav-link" href="add.php?sheetName=msd_goods&add">新增商品</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled danger" href="#">批量删除</a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- 公共导航栏结束 -->

        <!-- 信息输出区 -->
        <?php echo !empty($_GET['msg'])?"<div class='alert alert-success' role='alert'>{$_GET['msg']}</div>":''; ?>
    </body>

</html>

<!-- 输出：
导航栏样式===》包含：新增按钮、批量删除按钮
新增按钮===》输出：$sheetName、$_GET['add']、新增页面
批量删除按钮===》输出：$id、$sheetName、删除页面
-->