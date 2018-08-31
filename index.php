<html>
<head>
  <title>王家场帝国</title>
  <meta http-equiv="content-type" content="text/html" charset="UTF-8">
  <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="js/layui/layui.js"></script>
  <script type="text/javascript" src="js/common.js"></script>
  
  <link rel="stylesheet" type="text/css" href="js//layui/css/layui.css">
  <link rel="stylesheet" type="text/css" href="css/index.css" />
  <link rel="shortcut icon" href="img/favicon.png" type="image/png" />
  
</head>

<body>
  <!--导航-->
  <nav class="nav">
    <ul class="layui-nav" lay-filter="">
      <div class="wrap">
        <li class="topbar-logo">
          <img src="../images/favicon.png"/>
          王家场世界
        </li>
        <li class="layui-nav-item viewBtn" view="main"><a>首页</a></li>
        <li class="layui-nav-item viewBtn" view="wow"><a>魔兽世界</a></li>
        <li class="layui-nav-item viewBtn" view="buy"><a>充值</a></li>
        <li class="layui-nav-item bing-right">
          <a href="javascript:;">
            <span class="bing-username">未登录</span>
            <i class="layui-icon layui-icon-triangle-d"></i> 
          </a>
          <dl class="layui-nav-child"> <!-- 二级菜单 -->
            <dd style="text-align: center"><a>基本资料</a></dd>
            <dd style="text-align: center"><a>修改密码</a></dd>
            <hr>
            <dd style="text-align: center"><a class="bing-logout">退出</a></dd>
          </dl>
        </li>
      </div>
    </ul>
  </nav>
  
  <!--主内容容器-->
  <div class="main-wrap">
    <div class="main wrap clearfix">
      <div class="container" id="view">
        <!-- 视图内容 -->
      </div>
    </div>
  </div>
  
  <div class="layui-row" id="footer">
    <div class="footer-logo"><img src="../images/logo1.jpg"/></div>
    <div class="footer-text">© 2017 王家场帝国 - 技术总局 版权所有</div>
  </div>
  
</body>
</html>

<script type="text/javascript">

//初始化页面
if(!sessionStorage.viewNow){
  sessionStorage.viewNow = 'main';
  $('li[view="main"]').addClass('layui-this');
}else{
  $('li[view="'+sessionStorage.viewNow+'"]').addClass('layui-this');
}
$('#view').load('view/'+sessionStorage.viewNow+'.html');

//导航 - 按钮点击事件
$('.viewBtn').click(function(){
  var view = $(this).attr('view');
  sessionStorage.viewNow = view;
  $('#view').load('view/'+view+'.html');
});


//导航依赖 element 模块，否则无法进行功能性操作
layui.use(['element','layer'], function(){
  var element = layui.element;
});



</script>