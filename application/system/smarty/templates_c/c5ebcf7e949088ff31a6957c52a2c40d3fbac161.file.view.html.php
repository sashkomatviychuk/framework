<?php /* Smarty version Smarty-3.1.19-dev, created on 2014-08-17 20:17:16
         compiled from "C:/xampp/htdocs/my-admin/application/modules/site/views/users/view.html" */ ?>
<?php /*%%SmartyHeaderCode:1914053f0e1519cf456-83452707%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c5ebcf7e949088ff31a6957c52a2c40d3fbac161' => 
    array (
      0 => 'C:/xampp/htdocs/my-admin/application/modules/site/views/users/view.html',
      1 => 1408282854,
      2 => 'file',
    ),
    '270aef2359e2808312dcff87434bf2b6c86ae978' => 
    array (
      0 => 'C:/xampp/htdocs/my-admin/application/modules/site/views/base.html',
      1 => 1408295675,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1914053f0e1519cf456-83452707',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19-dev',
  'unifunc' => 'content_53f0e152556e54_64030400',
  'variables' => 
  array (
    'active_item' => 0,
    'js' => 1,
    'key' => 1,
    'value' => 1,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53f0e152556e54_64030400')) {function content_53f0e152556e54_64030400($_smarty_tpl) {?><?php if (!is_callable('smarty_function_router')) include 'C:/xampp/htdocs/my-admin/application/system/smarty/plugins/function.router.php';
?><!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

		<!-- Add custom CSS here -->
		<link rel="stylesheet" type="text/css" href="/public/css/bootstrap.css">
		<link href="/public/css/sb-admin.css" rel="stylesheet">
		<link rel="stylesheet" href="/public/fonts/font-awesome.min.css">
		
		<!-- end of css block -->

		<style>
			ul.nav::-webkit-scrollbar{
				width: 8px;
				background-color: #333333;
			}
			ul.nav::-webkit-scrollbar-thumb{
				width: 8px;
				height: 12px;
				border-radius: 2px;
				background-color: #888;
			}
			ul.nav::-webkit-scrollbar-thumb:hover{
				background-color: #777;
				cursor: pointer;
			}

			div.message {
				width: 100%;
				height: 60px;
				background: #fff;
				opacity: 1;
				vertical-align: middle;
				padding: 14px;
			}
		</style>
		<meta name="description">
		<meta name="key">
		<title><?php echo _('Користувач');?>
 <?php echo $_smarty_tpl->tpl_vars['user']->value->login;?>
</title>
	</head>
	<body>
		<div id="wrapper">
			<!-- Sidebar -->
			
	<?php $_smarty_tpl->tpl_vars['active_item'] = new Smarty_variable('users', null, 0);?>

			<?php echo $_smarty_tpl->getSubTemplate ('layouts/sidebar.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('active_item'=>$_smarty_tpl->tpl_vars['active_item']->value), 0);?>


			<div id="page-wrapper">
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
				              <li><a href="/"><i class="fa fa-dashboard"></i> Головна сторінка</a></li>
				              
	<li><a href="<?php echo smarty_function_router(array('name'=>'users'),$_smarty_tpl);?>
"><i class="fa fa-bar-chart-o"></i> <?php echo _('Користувачі');?>
</a></li>
	<li class="active"><i class="fa fa-view"></i> <?php echo ('Перегляд інформації');?>
</li>

            			</ol>
						
	<h1><?php echo _('Інформація');?>
</h1>
	<div class="panel panel-default" style="width: 60%;">
		<div class="panel-heading">
			<?php echo _('Інформація про користувача');?>

		</div>
		<div class="panel-body">
			<div class="media-body">
				<dl class="dl-horizontal">
					<dt>#</dt>
					<dd><?php echo $_smarty_tpl->tpl_vars['user']->value->id;?>
</dd>
					<dt><?php echo _('Login');?>
</dt>
					<dd><?php echo $_smarty_tpl->tpl_vars['user']->value->login;?>
</dd>
					<dt><?php echo _('Email');?>
</dt>
					<dd><?php if ($_smarty_tpl->tpl_vars['user']->value->email) {?><?php echo $_smarty_tpl->tpl_vars['user']->value->email;?>
<?php } else { ?>-<?php }?></dd>
					<dt><?php echo _('Active');?>
</dt>
					<dd><?php if ($_smarty_tpl->tpl_vars['user']->value->is_active) {?>yes<?php } else { ?>no<?php }?></dd>
				</dl>
			</div>
		</div>
		<div class="panel-footer">
			<a href="<?php echo smarty_function_router(array('name'=>'users'),$_smarty_tpl);?>
" class="btn btn-default btn-sm"><?php echo _('Список');?>
</a>
			<div class="pull-right">
				<a href="<?php echo smarty_function_router(array('name'=>'usersEdit','id'=>$_smarty_tpl->tpl_vars['user']->value->id),$_smarty_tpl);?>
" class="btn btn-primary btn-sm"><?php echo _('Редагувати');?>
</a>
				<a href="<?php echo smarty_function_router(array('name'=>'usersDelete','id'=>$_smarty_tpl->tpl_vars['user']->value->id),$_smarty_tpl);?>
" class="btn btn-danger btn-sm"><?php echo _('Видалити');?>
</a>
			</div>
		</div>
	</div>

					</div>
				</div>
			</div>

			<!-- /#page-wrapper -->

		</div><!-- /#wrapper -->

		<!-- JavaScript -->

		<!-- Add custom javascript here -->
		<script type="text/javascript" src="/public/js/jquery/jquery.min.js"></script>
		<script src="/public/js/bootstrap/bootstrap.min.js"></script>
		<script type="text/javascript" src="/public/js/app.js"></script>
		<script type="text/javascript">
		
			if ( typeof App == 'undefined') {
				App = {};
			}
		
			<?php if ($_smarty_tpl->tpl_vars['js']->value) {?>
				<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['js']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
					App._data['<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
'] = '<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
';
				<?php } ?>
			<?php }?>
		</script>
		
		<!-- end of js block -->
	</body>
</html>
<?php }} ?>
