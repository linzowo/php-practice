<!--
        * @Author: linzwo
        * @Date: 2019-06-14 10:17:15
 * @LastEditors: linzwo
 * @LastEditTime: 2019-06-17 13:08:54
        * @Description: 管理系统主页
 -->

<!-- 引入公共导航栏 -->

<?php include_once 'nav.php'; ?>
<!-- 引入公共导航栏 -->
<!-- 输出：$page = 1、$sheetName、function setIndex()、function getAge($birthday) -->

<?php // 设置页面内容===》输入：setIndex()、$sheetName
setIndex();
?>
<!-- 输出：usersActive||goodsActive、$tableHeader:array -->

<?php // 数据库操作区===》输入：$sheetName=============

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

    // 获取用户选择的页数
    if (!empty($_GET['page']) && intval($_GET['page'])) { // 判断是否有传入页数参数,且传入的参数是有效的
        $page = $_GET['page'];
    };
    // 如果用户刚刚添加了一条新数据回来===>将页面定位到最后一页
    if (isset($_GET['add_success'])) { // 判断是否有添加成功的标识，有就跳转到最后一页
        $page = $pages;
    }

    // 结束页数获取
    mysqli_free_result($query);


    // 开始分页获取
    // 跳过条数
    $passRow = ($page - 1) * 10;
    $query = mysqli_query($conn, "SELECT * FROM {$sheetName} LIMIT {$passRow},10;");

    if (!$query) { // 检测标识获取是否成功
        exit('<h1>从数据库获取数据失败</h1>');
    }
?>
<!-- 输出：$pages、$page、$query -->

<!-- ============================html区域==================================== -->
<!-- 输入：html结构样式、$tableHeader、usersActive||goodsActive、$title、$tableHeader:array、$pages、$page、$query -->

<head>
    
<title>XX管理系统</title>
    <style>
        td {
            vertical-align: middle !important;
        }
    </style>

    <script>

        window.onload = function() {
            
            // 创建一个处理函数用于处理每个复选框被点击
            function ckbClickHandle(){
                checkAll.checked = true;
                for(var i=0;i<checkboxList.length;i++){
                    if(!checkboxList[i].checked){
                        checkAll.checked = false;
                        continue;
                    }
                }

                // 判断当前按钮的状态，如果是被选中就加入数组,如果是取消选中就从数组中删除
                if(this.checked){
                    idArr.push(this.value);
                }else{
                    idArr.splice(idArr.indexOf(this.value),1);
                }

                setDelBtn();
            }

            // 处理函数：处理用户选择了需要删除的内容后，跳转按钮的状态，以及跳转连接中包含的内容
            function setDelBtn(){
                var delId = idArr.join(',');
                // 设置批量删除按钮是否可用
                if(idArr.length == 0){
                    bulkDel.setAttribute('class','nav-link disabled');
                    bulkDel.setAttribute('href',"javascript:void(0);");
                }else{
                    // 将批量删除按钮变为可以使用状态
                    bulkDel.setAttribute('class','nav-link btn-danger');
                    bulkDel.setAttribute('href',"delete.php?sheetName=<?php echo $sheetName; ?>&id="+delId);
                }

            }


            // 声明一个存储数据的数组
            var idArr = [];
            // 设置批量删除按钮的全选和全不选
            // 获取元素
            // 全选按钮
            var checkAll = document.getElementById('checkAll');
            // 每行的复选按钮
            var checkboxList = document.getElementsByTagName('tbody')[0].getElementsByTagName('input');
            // 批量删除按钮
            var bulkDel = document.getElementById('bulkDel');
            // 根据全选按钮的状态确定下面按钮的状态
            checkAll.onclick = function() {
                for (var i = 0; i < checkboxList.length; i++) {
                    checkboxList[i].checked = checkAll.checked;
                    if(checkAll.checked){
                        // 全选了就将本页所有的ID存储在数组中
                        idArr.push(checkboxList[i].value);
                    }else{
                        // 如果没有全选就将数组清空，保证不会多次传入数据
                        idArr.splice(0);
                    }
                }
                setDelBtn();
            };
            // 根据下面按钮的状态确定全选按钮的状态
            for (var i = 0; i < checkboxList.length; i++) {
                checkboxList[i].onclick = ckbClickHandle;
            }
            
            // 运行至此，输出：包含需要删除的id的数组idArr、复选框是否是全选状态

            // 将要删除的id加入到跳转连接中
            
        };
    </script>
</head>

<body>

    <!-- index主页面开始 -->
    <div class="row mt-5">

        <!-- 侧边导航栏开始 -->
        <div class="col-2">
            <div class="list-group text-center">
                <a href="index.php?sheetName=msd_users" class="list-group-item list-group-item-action<?php echo $usersActive; ?>">
                    users
                </a>
                <a href="index.php?sheetName=msd_goods" class="list-group-item list-group-item-action<?php echo $goodsActive; ?>">
                    goods
                </a>
            </div>
        </div>
        <!-- 侧边导航栏结束 -->

        <!-- 内容展示区开始 -->
        <div class="container">
            <div class="col-9">
                <div class="tab-content" id="v-pills-tabContent">

                    <!-- 内容展示列表开始 -->
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
                                            if ($sheetName === 'msd_goods') {
                                                $output1 = $row[3]; // ==>商品类型
                                                $output2 = '￥' . sprintf("%.2f", $row[4]); // ==>商品价格
                                            } else {
                                                $output1 = (intval($row[3]) == 0) ? "♀" : "♂"; // ==>用户性别
                                                $output2 = getAge($row[4]); // ==>用户年龄
                                            }
                                            ?>


                                            <tr id="<?php echo $id; ?>">
                                                <td><input type="checkbox" name="" value="<?php echo $id; ?>"></td>
                                                <td><?php echo $id ?></td>
                                                <td><?php echo $name ?></td>
                                                <td><img src="<?php echo $picPath ?>" width="100px" height="100px"></td>
                                                <td><?php echo $output1; ?></td>
                                                <td><?php echo $output2; ?></td>
                                                <td>
                                                    <!-- 编辑按钮 -->
                                                    <a class="btn btn-primary btn-sm" name="delete" href="edit.php?sheetName=<?php echo $sheetName; ?>&page=<?php echo $page; ?>&id=<?php echo $id; ?>">编辑</a>
                                                    <!-- 删除按钮 -->
                                                    <a class="btn btn-danger btn-sm" name="delete" href="delete.php?sheetName=<?php echo $sheetName; ?>&id=<?php echo $id; ?>">删除</a>
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
                    <!-- 内容展示列表结束 -->

                    <!-- 分页按钮开始 -->
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <li class="page-item<?php echo ($page - 1) < 1 ? ' disabled' : ''; ?>">
                                <a class="page-link" href="index.php?sheetName=<?php echo $sheetName; ?>&page=<?php echo ($page - 1) < 1 ? 1 : ($page - 1); ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>

                            <?php for ($i = 1; $i <= $pages; $i++) :; ?>
                                <li class="page-item<?php echo ($page == $i) ? ' active' : ''; ?>"><a class="page-link" href="index.php?sheetName=<?php echo $sheetName; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                            <?php endfor; ?>


                            <li class="page-item<?php echo ($page + 1) > $pages ? ' disabled' : ''; ?>">
                                <a class="page-link" href="index.php?sheetName=<?php echo $sheetName; ?>&page=<?php echo ($page + 1) > $pages ? $pages : ($page + 1); ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <!-- 分页按钮结束 -->

                    <!-- <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">...</div> -->
                </div>
            </div>
        </div>
        <!-- 内容展示区结束 -->

    </div>
    <!-- index主页面结束 -->
</body>

</html>
<!-- 输出：
主页样式===》包含：分页按钮、管理按钮、新增按钮、编辑按钮、删除按钮
分页按钮===》输出：$page、对应的分页页面
管理按钮===》输出：$sheetName、对应的页面
新增按钮===》输出：$sheetName、新增页面
编辑按钮===》输出：$id、$sheetName、编辑页面
删除按钮===》输出：$id、$sheetName、删除页面
-->