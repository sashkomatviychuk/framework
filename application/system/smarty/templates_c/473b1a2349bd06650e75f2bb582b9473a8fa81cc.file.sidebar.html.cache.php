<?php /* Smarty version Smarty-3.1.19-dev, created on 2014-08-18 21:06:20
         compiled from "C:/xampp/htdocs/my-admin/application/modules/site/views/layouts/sidebar.html" */ ?>
<?php /*%%SmartyHeaderCode:2217453f0e784eeb0b1-48715140%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '473b1a2349bd06650e75f2bb582b9473a8fa81cc' => 
    array (
      0 => 'C:/xampp/htdocs/my-admin/application/modules/site/views/layouts/sidebar.html',
      1 => 1408385177,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2217453f0e784eeb0b1-48715140',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19-dev',
  'unifunc' => 'content_53f0e7852b22e4_32169034',
  'variables' => 
  array (
    'active_item' => 0,
    'code' => 0,
    'lang' => 1,
    'title' => 0,
    'MSG' => 0,
  ),
  'has_nocache_code' => true,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53f0e7852b22e4_32169034')) {function content_53f0e7852b22e4_32169034($_smarty_tpl) {?><?php if (!is_callable('smarty_function_router')) include 'C:/xampp/htdocs/my-admin/application/system/smarty/plugins/function.router.php';
if (!is_callable('smarty_function_url')) include 'C:/xampp/htdocs/my-admin/application/system/smarty/plugins/function.url.php';
?><nav class="navbar-inverse"  role="navigation">
	<ul class="nav navbar-nav side-nav">
			<li <?php if ($_smarty_tpl->tpl_vars['active_item']->value=='main') {?>class="active"<?php }?>><a href="<?php echo smarty_function_router(array('name'=>'home'),$_smarty_tpl);?>
"><i class="fa fa-dashboard"></i> <?php echo _('Головна сторінка');?>
</a></li>
			<li <?php if ($_smarty_tpl->tpl_vars['active_item']->value=='users') {?>class="active"<?php }?>><a href="<?php echo smarty_function_router(array('name'=>'users'),$_smarty_tpl);?>
"><i class="fa fa-bar-chart-o"></i> <?php echo _('Користувачі');?>
</a></li>
		</ul>
</nav>
<nav class="navbar navbar-inverse navbar-fixed-top" style="opacity:0.9;  -webkit-box-shadow: 0 2px 10 rgba(0, 0, 0, .15);  box-shadow: 0 2px 10 rgba(0, 0, 0, .15);"  role="navigation">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header" >
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="/"><?php echo _('Панель управління');?>
</a>
	</div>

	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="collapse navbar-collapse navbar-ex1-collapse">
		<ul class="nav navbar-nav navbar-right navbar-user">
			<li class="dropdown user-dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-globe"></i> <?php echo _('Мови');?>
 <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<?php  $_smarty_tpl->tpl_vars['title'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['title']->_loop = false;
 $_smarty_tpl->tpl_vars['code'] = new Smarty_Variable;
 $_from = Config::get('langs.translation'); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['title']->key => $_smarty_tpl->tpl_vars['title']->value) {
$_smarty_tpl->tpl_vars['title']->_loop = true;
 $_smarty_tpl->tpl_vars['code']->value = $_smarty_tpl->tpl_vars['title']->key;
?>
						 <li><a href="<?php echo smarty_function_url(array('lang'=>$_smarty_tpl->tpl_vars['code']->value),$_smarty_tpl);?>
"><i class="<?php echo '/*%%SmartyNocache:2217453f0e784eeb0b1-48715140%%*/<?php if ($_smarty_tpl->tpl_vars[\'code\']->value==$_smarty_tpl->tpl_vars[\'lang\']->value) {?>/*/%%SmartyNocache:2217453f0e784eeb0b1-48715140%%*/';?>
fa fa-check<?php echo '/*%%SmartyNocache:2217453f0e784eeb0b1-48715140%%*/<?php }?>/*/%%SmartyNocache:2217453f0e784eeb0b1-48715140%%*/';?>
"></i> <?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</a></li>
					<?php } ?>
				</ul>
			</li>
			<li class="dropdown user-dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Username <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="#"><i class="fa fa-user"></i> <?php echo _('Профіль');?>
</a></li>
					<li><a href="#"><i class="fa fa-gear"></i> <?php echo _('Налаштування');?>
</a></li>
					<li class="divider"></li>
					<li><a href="<?php echo smarty_function_router(array('name'=>'logout'),$_smarty_tpl);?>
/?r=<?php echo smarty_function_url(array(),$_smarty_tpl);?>
"><i class="fa fa-power-off"></i> <?php echo _('Вийти');?>
</a></li>
				</ul>
			</li>
		</ul>
	</div><!-- /.navbar-collapse -->
	
		<?php if (Message::has()) {?>
			<?php $_smarty_tpl->tpl_vars['MSG'] = new Smarty_variable(Message::pop(), null, 0);?>
			<div class=" navbar-collapse navbar-ex1-collapse message  alert-<?php echo $_smarty_tpl->tpl_vars['MSG']->value['type'];?>
 hide js-alert-message" style="">
				<span class="pull-left fa fa-2x fa-<?php if ($_smarty_tpl->tpl_vars['MSG']->value['type']=='danger') {?>warning<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['MSG']->value['type'];?>
<?php }?>"></span>&nbsp;
				<span class="pull-left" style="font-size: 16px;"><?php echo $_smarty_tpl->tpl_vars['MSG']->value['text'];?>
</span>
				<a href="#" class="btn btn-default pull-right message-close">Close</a>
			</div>
		<?php }?>
	
</nav>
<?php }} ?>
