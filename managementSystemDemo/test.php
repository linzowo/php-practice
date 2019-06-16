<?php if (!empty($_GET['title']) && $_GET['title'] === 'users') :; ?>
        <h1>用户管理界面</h1>
        <div class="container">
            <form action="">
                <table class="table table-striped table-hover text-center">
                    <thead>
                        <tr class="thead-dark">
                            <th>#</th>
                            <th><input type="checkbox" name="" id="checkAll"></th>
                            <th>歌名</th>
                            <th>封面</th>
                            <th>歌手</th>
                            <th>播放</th>
                            <th>删除</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo 你好 ?></td>
                            <td><input type="checkbox" name="" id="ckb<?php echo 你好 ?>"></td>
                            <td><?php echo 你好 ?></td>
                            <td><img src="<?php echo 你好 ?>" alt="" width="100px"></td>
                            <td><?php echo 你好 ?></td>

                            <td><audio src="<?php echo 你好 ?>" controls></audio></td>
                            <td>
                                <a class="btn btn-primary btn-sm" name="delete" href="musicList_update.php?id=<?php echo 你好 ?>">编辑</a>
                                <a class="btn btn-danger btn-sm" name="delete" href="musicList_delete.php?id=<?php echo 你好 ?>&page=<?php echo $page; ?>">删除</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    <?php elseif (!empty($_GET['title']) && $_GET['title'] === 'goods') :; ?>
        <h1>商品管理界面</h1>
        <div class="container"></div>



    <?php
// if(empty($_GET['title']) || $_GET['title'] !== 'users' || $_GET['title'] !== 'goods' ):;
else :

    //如果用户没有传入title值那么就显示以下内容 
    // 如果用户出入的内容不符合规范也显示下列内容
    ?>

        <div class="container">
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

    <?php endif; ?>