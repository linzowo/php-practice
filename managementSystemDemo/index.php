<?php
/*
 * @Author: linzwo
 * @Date: 2019-06-14 10:17:15
 * @LastEditors: linzwo
 * @LastEditTime: 2019-06-15 22:32:50
 * @Description: 管理系统主页
 */
// 变量声明区======================================================
// $users_header = array('头像', '性别', '年龄');
// $goods_header = array('图片', '类别', '价格');

// 初始化默认显示页数
$page = 1;
$title = 'users';

// 函数定义区===================================================
function setIndex()
{ //设置主页展示的内容和一些标签的展示状态

    // users被选中
    if ((empty($_GET['title'])) || ($_GET['title'] !== 'goods')) {
        // 设置侧边栏选中
        // title为空，或者title不为goods的其他所有情况下选中users
        $GLOBALS['usersActive'] = ' active';
        // 将表头设置为users_header
        $GLOBALS['tableHeader'] = array('头像', '性别', '年龄');
        // 设置要取出的数据表
        $GLOBALS['sheetName'] = 'msd_users';
    }

    // goods被选中
    if ((!empty($_GET['title'])) && ($_GET['title'] === 'goods')) {
        // 设置侧边栏选中
        //传入了title且为goods使goods为选中状态
        $GLOBALS['goodsActive'] = ' active';
        $GLOBALS['title'] = 'goods';
        // 将表头设置为goods_header
        $GLOBALS['tableHeader'] = array('图片', '类别', '价格');
        // 设置要取出的数据表
        $GLOBALS['sheetName'] = 'msd_goods';
    }
}

function getAge($birthday)
{
    /**
     * @description: 输入生日返回年龄
     * @param {string} $birthday
     * @return: int|false
     */
    if (!strtotime($birthday)) {
        return false;
    }
    // 获取生日的年月日
    list($y1, $m1, $d1) = explode('-', date('Y-m-d', strtotime($birthday)));
    // 获取当前的年月日
    list($y2, $m2, $d2) = explode('-', date('Y-m-d', strtotime("now")));
    // 计算差值
    $age = $y2 - $y1;
    // 判断过了今年的生日了吗===》当前日期中的月份-生日月份是否小于0===》当前日期中的天数-生日的天数是否小于0===》小于0就在年份-年份的基础上减1==》否则就是年份-年份
    if (($m2 - $m1) < 0 && ($d2 - $d1) < 0) {
        $age--;
    }
    return $age;
}

?>



<?php

// 设置页面内容    
setIndex();

// 获取用户选择的页数
if(!empty($_GET['page']) && intval($_GET['page'])){// 判断是否有传入页数参数,且传入的参数是有效的
    $page = $_GET['page'];
}

// 数据库操作区==========================================================================

// 连接数据库
$conn = mysqli_connect('localhost', 'root', '111111', 'demo');
if (!$conn) { // 检测数据库连接是否成功
    exit('<h1>连接数据库失败</h1>');
}

// 计算页数
// 根据标识获取查询索引
$query = mysqli_query($conn, "SELECT * FROM {$sheetName};");
if (!$query) { // 检测标识获取是否成功
    exit('<h1>从数据库获取数据失败</h1>');
}

// 获取数据行数===》计算总页数
$countRows = $query->num_rows;
$pages = ceil($countRows / 10); // 向上取整

// 如果用户刚刚添加了一条新数据回来===>将页面定位到最后一页
if(isset($_GET['add_success'])){// 判断是否有添加成功的标识，有就跳转到最后一页
    $page = $pages;
}

// 结束页数获取
mysqli_free_result($query);


// 开始分页获取
// 跳过条数
$passRow = ($page - 1)*10;
$query = mysqli_query($conn, "SELECT * FROM {$sheetName} LIMIT {$passRow},10;");

if (!$query) { // 检测标识获取是否成功
    exit('<h1>从数据库获取数据失败</h1>');
}


    // 数据库结构
    // picPath /managementSystemDemo/images/userdata/tx1.jpg
; ?>



<!-- ============================html区域==================================== -->
<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8" />
    <title>XX管理系统</title>
    <style>
        td {
            vertical-align: middle !important;
        }
    </style>

    <script>
        window.onload = function() {
            
        };
    </script>
</head>

<body>
    <!-- 引入公共导航栏 -->
    <?php include_once 'nav.php'; ?>
    <div class="container">
        <div class="row mt-3">
            <div class="col-3">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link<?php echo $usersActive; ?>" id="v-pills-users-tab" data-toggle="pill" href="index.php?title=users" role="tab" aria-controls="v-pills-users" aria-selected="false">users</a>
                    <a class="nav-link<?php echo $goodsActive; ?>" id="v-pills-goods-tab" data-toggle="pill" href="index.php?title=goods" role="tab" aria-controls="v-pills-goods" aria-selected="false">goods</a>
                    <!-- <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a> -->
                </div>
            </div>
            <div class="col-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                        <div class="row mt-5">
                            <div class="col-sm-3  mx-4">
                                <div class="card" style="width: 18rem;">
                                    <img class="card-img-top" src="images/user.jpg" alt="Card image cap" width="180px" />
                                    <div class="card-body">
                                        <h5 class="card-title">用户管理</h5>
                                        <p class="card-text">开始管理你的用户数据</p>
                                        <a href="index.php?title=users" class="btn btn-primary">用户管理</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3  mx-4">
                                <div class="card" style="width: 18rem;">
                                    <img class="card-img-top" src="images/goods.jpg" alt="Card image cap" width="180px" />
                                    <div class="card-body">
                                        <h5 class="card-title">商品管理</h5>
                                        <p class="card-text">开始管理你的商品数据</p>
                                        <a href="index.php?title=goods" class="btn btn-primary">商品管理</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade show active" id="v-pills-users" role="tabpanel" aria-labelledby="v-pills-users-tab">
                        <div class="container">
                            <form action="">
                                <table class="table table-striped table-hover text-center">
                                    <thead>
                                        <tr class="thead-dark">
                                            <th><input type="checkbox" name="" id="checkAll"></th>
                                            <th>#</th>
                                            <th>名称</th>

                                            <?php
                                            // ===============================================
                                            // 动态生成表头中有差异的部分
                                            for ($i = 0; $i < count($tableHeader); $i++) :; ?>
                                                <th><?php echo $tableHeader[$i]; ?></th>
                                            <?php endfor
                                            // ===============================================
                                        ; ?>


                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        // 开始将数据库数据读取到页面=============================================
                                        while ($row = mysqli_fetch_row($query)) :
                                            /* 
                                            $row===》array(5) {
                                                [0]=&gt;
                                                string(1) "1"
                                                [1]=&gt;
                                                string(6) "张三"
                                                [2]=&gt;
                                                string(45) "/managementSystemDemo/images/userdata/tx1.jpg"
                                                [3]=&gt;
                                                string(1) "1"
                                                [4]=&gt;
                                                string(10) "1994-12-01"
                                                }
                                            */
                                            $id = $row[0];
                                            $name = $row[1];
                                            $picPath = $row[2];
                                            // <!-- 判断表名==>确定差异数据的输出内容 -->
                                            if($sheetName === 'msd_goods'){
                                                $output1 = $row[3];// ==>商品类型
                                                $output2 = '￥'.sprintf("%.2f",$row[4]);// ==>商品价格
                                            }else{
                                                $output1 = (intval($row[3]) == 0) ? "♀" : "♂";// ==>用户性别
                                                $output2 = getAge($row[4]);// ==>用户年龄
                                            }
                                            ?>

                                            
                                            <tr id="<?php echo $id; ?>">
                                                <td><input type="checkbox" name="" id="ckb<?php echo "删除" ?>"></td>
                                                <td><?php echo $id ?></td>
                                                <td><?php echo $name ?></td>
                                                <td><img src="<?php echo $picPath ?>" width="100px" height="100px"></td>
                                                <td><?php echo $output1; ?></td>
                                                <td><?php echo $output2; ?></td>
                                                <td>
                                                    <a class="btn btn-primary btn-sm" name="delete" href="edit.php?title=<?php echo $title; ?>&page=<?php echo $page; ?>&id=<?php echo $id; ?>">编辑</a>
                                                    <a class="btn btn-danger btn-sm" name="delete" href="delete.php?title=<?php echo $title; ?>&page=<?php echo $page; ?>&id=<?php echo $id; ?>">删除</a>
                                                </td>
                                            </tr>
                                        <?php
                                    endwhile;
                                    mysqli_free_result($query);
                                        // 结束将数据库数据读取到页面=============================================

                                    ; ?>


                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <li class="page-item<?php echo ($page-1)<1?' disabled':''; ?>">
                                <a class="page-link" href="index.php?title=<?php echo $title; ?>&page=<?php echo ($page-1)<1?1:($page-1); ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>

                            <?php for ($i = 1; $i <= $pages; $i++) :; ?>
                                <li class="page-item<?php echo ($page==$i)?' active':''; ?>"><a class="page-link" href="index.php?title=<?php echo $title; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                            <?php endfor; ?>


                            <li class="page-item<?php echo ($page+1)>$pages?' disabled':''; ?>">
                                <a class="page-link" href="index.php?title=<?php echo $title; ?>&page=<?php echo ($page+1)>$pages?$pages:($page+1); ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>

                    <!-- <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">...</div> -->
                </div>
            </div>
        </div>
    </div>
</body>

</html>