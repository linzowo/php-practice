<!--
 * @Author: linzwo
 * @Date: 2019-06-14 10:38:11
 * @LastEditors: linzwo
 * @LastEditTime: 2019-06-15 10:02:56
 * @Description: 公共导航栏
 -->

<!-- php代码区 -->
<?php
function setNavBtnChecked()
{
    /**
     * @description: 获取用户在新增哪个类别
     * @param {type} $_GET['title']
     * @return: null|false
     */
    if (empty($_GET['addtitle'])) {
        $GLOBALS['addUsers'] = '';
        $GLOBALS['addGoods'] = '';
        return;
    };

    $title = $_GET['addtitle'];
    // 判断当前的title是什么
    if (!empty($title) && $title == 'addUsers') {
        $GLOBALS['addUsers'] = ' active';
        $GLOBALS['addGoods'] = '';
        return;
    }

    if (!empty($title) && $title == 'addGoods') {
        $GLOBALS['addUsers'] = '';
        $GLOBALS['addGoods'] = ' active';
        return;
    }

    return false;
}

// 设置导航栏选中的是哪个按钮
setNavBtnChecked();

?>


<!-- html区 -->

<head>
    <link rel="stylesheet" href="../bootstrap4.3.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">XX管理系统</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item<?php echo $addUsers; ?>">
                    <a class="nav-link" href="add.php?addtitle=addUsers">新增用户</a>
                </li>
                <li class="nav-item<?php echo $addGoods; ?>">
                    <a class="nav-link" href="add.php?addtitle=addGoods">新增商品</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled danger" href="#">批量删除</a>
                </li>
            </ul>
        </div>
    </nav>
</body>

</html>