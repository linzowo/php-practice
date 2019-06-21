<!--
 * @Author: linzwo
 * @Date: 2019-06-20 16:13:13
 * @LastEditors: linzwo
 * @LastEditTime: 2019-06-21 18:17:43
 * @Description: 使用php和js两种方式实现:一周内不再显示某元素
 -->
<?php 
    // if(!empty(($_GET['msg'])) && $_GET['msg']==="1"){
    //     // var_dump($_GET['msg']);
    //     // setcookie ($name, $value = "", $expire = 0, $path = "", $domain = "", $secure = false, $httponly = false)
    //     setcookie('show',"hidden",time()+7*24*60*60);
    //     // var_dump($_COOKIE['show']);
    // }
    // if(!empty(($_GET['msg'])) && $_GET['msg']==="2"){
    //     // 删除cookie值===>使起强制过期 // setcookie('show'); // } ?>

<!-- <!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>一周内不再显示某元素</title>

    <style>
        #banner{
            position: relative;
            margin-top: 50px;
            left: 50%;
            margin-left: -512px;
        }
        .hidden{
            display: none;
        }
    </style>
</head>
<body>
    <div id="banner" class="<?php //echo empty($_COOKIE['show'])?'':$_COOKIE['show']; ?>">
        <img src="images/thinking.jpg" alt="" width="1024px">
    </div>
    <button><a href="practice：隐藏div.php?msg=1">一周内不再显示该图片</a></button>
    <button><a href="practice：隐藏div.php?msg=2">解除限制</a></button>
</body>
</html> -->

<!-- 使用js的方式实现 -->

<!DOCTYPE html>
<html lang="zh">
  <head>
    <meta charset="UTF-8" />
    <title>一周内不再显示某元素</title>

    <style>
      #banner {
        position: relative;
        margin-top: 50px;
        left: 50%;
        margin-left: -512px;
      }
      .hidden {
        display: none;
      }
    </style>

    <script>
      window.onload = function() {
        // 获取元素
        var btn1 = document.getElementById("btn1");
        var btn2 = document.getElementById("btn2");
        var banner = document.getElementById("banner");
        // 为元素注册事件
        btn1.onclick = function() {
          // 设置cookie
          //   获取当前时间
          var d = new Date();
          //   将当前时间转换为毫秒数方便进行计算===》通过settime得到一个新的时间（毫秒模式的）===》现在d仍然是一个非世界时的时间对象，需要转换为世界时的字符串
          d.setTime(d.getTime() + 7 * 24 * 60 * 60 * 1000);
          // console.log(typeof d);
          // 设置需要的cookie和过期时间
          document.cookie = "show=hidden;expires=" + d.toUTCString();
        };

        // 接收cookie
        // 将document.cookie转换为一个数组或键值对
        function getCookie(num) {
          /**
           * @description: 获取第n个cookie的键和值组成的数组
           * @param {int} num
           * @return: 一个数组，0=>cookie_key,1=>cookie_value|超出范围就返回false
           */  
          var cookieArr = document.cookie.split(";");
          if(num>=cookieArr.length || num<0){
            return false;
          }
          var resultArr = cookieArr[num].split("=");
          return resultArr;
        }
        var show = getCookie(0)[1];
        if(show==='hidden'){
          banner.setAttribute('class',show);
        }else{
          banner.setAttribute('class','');
        }
        // 删除cookie
        btn2.onclick = function(){
          //   获取当前时间
          var d = new Date();
          // 将当前时间转换为毫秒数方便进行计算，并做一个减法，使这个时间过期
          d.setTime(d.getTime() -1);
          // 即将过期时间设置为一个已经过期的时间
          document.cookie = "show=hidden;expires=" + d.toUTCString();
        }
      };
    </script>
  </head>
  <body>
    <div id="banner" class="">
      <img src="images/thinking.jpg" alt="" width="1024px" />
    </div>
    <button id="btn1">
      <a href="practice：隐藏div.php">一周内不再显示该图片</a>
    </button>
    <button id="btn2"><a href="practice：隐藏div.php">解除限制</a></button>
  </body>
</html>
