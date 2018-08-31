<?php 
$page='ZhaoHuiMiMaIframe';
$security = rand(10000, 100000);
?>
<script src="<?php $_SERVER ['DOCUMENT_ROOT']?>/js/jquery-1.12.0.min.js"></script>
<script type="text/javascript" src="<?php $_SERVER ['DOCUMENT_ROOT']?>/js/layui/layui.js"></script>
<script src="<?php $_SERVER ['DOCUMENT_ROOT']?>/js/common.js"></script>
<link rel="stylesheet" type="text/css" href="<?php $_SERVER ['DOCUMENT_ROOT']?>/js/layui/css/layui.css"/>
<link rel="stylesheet" href="<?php $_SERVER ['DOCUMENT_ROOT']?>/app/<?php echo $page.'.css';?>">

<div class="wrap">
  <form class="layui-form layui-form-pane" onsubmit="return false">
    <div class="layui-form-item">
      <label class="layui-form-label">账号名称</label>
      <div class="layui-input-inline">
        <input type="text" name="name" required  lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
      </div>
    </div>
    <div class="layui-form-item">
      <label class="layui-form-label">电子邮件</label>
      <div class="layui-input-inline">
        <input type="text" name="email" required lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
      </div>
    </div>
    <div class="layui-form-item">
      <label class="layui-form-label">新密码</label>
      <div class="layui-input-inline">
        <input type="text" name="newpass" required lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
      </div>
    </div>
    <div class="layui-form-item">
      <label class="layui-form-label">确认新密码</label>
      <div class="layui-input-inline">
        <input type="text" name="newpass2" required lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
      </div>
    </div>
    <div class="layui-form-item">
      <label class="layui-form-label">验证码 <font style="color:#00b0f2;"><?php echo $security; ?></font></label>
      <div class="layui-input-inline">
        <input type="text" name="security" required lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
      </div>
    </div>
    <div class="layui-form-item">
      <div class="layui-input-inline">
        <button class="layui-btn" id="reg" disabled>这个功能还不能用</button>
      </div>
    </div>
  </form>
</div>
<script>

layui.use('form', function(){
  var form = layui.form;
});



$('#reg').click(function(){
  action = 'ZhaoHuiMiMa';
  name = $('input[name="name"]').val();
  email = $('input[name="email"]').val();
  newpass = $('input[name="newpass"]').val();
  newpass2 = $('input[name="newpass2"]').val();
  security = $('input[name="security"]').val();
  if(newpass==newpass2){
    if(security==<?php echo $security;?>){
      ajax = $.ajax({
        url:rootpath+"/ajax/register_ajax.php",
        async:true,
        type: 'post',
        data: {action,name,email,newpass},
        success:function(res){
          if(res=='ok'){
            layer.msg('修改成功');
            layer.close(index);
          }else{
            layer.msg('修改失败:'+res);
          }
          //当你在iframe页面关闭自身时
          // var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
          // parent.layer.close(index); //再执行关闭   
          
        }
      });
    }else{
      layer.msg('验证码不正确', {
        offset: '380px',
        anim: 6
      });
    }
  }else{
    layer.msg('2次输入的密码不一致', {
      offset: '380px',
      anim: 6
    });
  }


});

</script>