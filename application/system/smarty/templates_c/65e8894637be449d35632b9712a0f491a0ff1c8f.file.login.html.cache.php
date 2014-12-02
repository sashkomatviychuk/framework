<?php /* Smarty version Smarty-3.1.19-dev, created on 2014-08-17 15:35:58
         compiled from "C:/xampp/htdocs/my-admin/application/modules/site/views/login/login.html" */ ?>
<?php /*%%SmartyHeaderCode:2872453f0a18d0ac8b5-11029965%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '65e8894637be449d35632b9712a0f491a0ff1c8f' => 
    array (
      0 => 'C:/xampp/htdocs/my-admin/application/modules/site/views/login/login.html',
      1 => 1408278954,
      2 => 'file',
    ),
    'ba668e6c8eb126a72b44403ef21f00b59718192b' => 
    array (
      0 => 'C:/xampp/htdocs/my-admin/application/modules/site/views/layouts/login.base.html',
      1 => 1408278920,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2872453f0a18d0ac8b5-11029965',
  'function' => 
  array (
  ),
  'cache_lifetime' => 3600,
  'version' => 'Smarty-3.1.19-dev',
  'unifunc' => 'content_53f0a18d5f0472_11258686',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53f0a18d5f0472_11258686')) {function content_53f0a18d5f0472_11258686($_smarty_tpl) {?><!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

		<!-- Add custom CSS here -->
		<link rel="stylesheet" type="text/css" href="/public/css/bootstrap.css">
		<link href="/public/css/sb-admin.css" rel="stylesheet">
		<link rel="stylesheet" href="/public/fonts/font-awesome.min.css">
		
		<!-- end of css block -->
		<!-- Add custom javascript here -->
		<script type="text/javascript" src="/public/js/jquery/jquery.min.js"></script>
		<script type="text/javascript" src="/public/js/app.min.js"></script>
		
		<!-- end of js block -->
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
		</style>
		<meta name="description">
		<meta name="key">
		<title><?php echo _('Вхід в систему');?>
</title>
	</head>
	<body>

	<div class="">
			

	<div class="col-md-4"></div>
	<div class="panel panel-default col-md-4" style="width:30%;">
		<div class="panel-body " >
			<h1><?php echo _('Вхід в систему');?>
</h1>
			<form action="" method="POST">
				<div class="form-group">
					<label for="login"><?php echo _('Логін');?>
</label>
					<input name="login" class="form-control" placeholder="<?php echo _('Введіть логін');?>
" autofocus>
				</div>
				<div class="form-group">
					<label for="pass"><?php echo _('Пароль');?>
</label>
					<input name="pass" class="form-control" type="password"  placeholder="<?php echo _('Введіть пароль');?>
">
				</div>
				<button type="submit" class="btn btn-primary"><?php echo _('Вхід');?>
</button>
			</form>
		</div>
	</div>
	<div class="col-md-4"></div>


	</div>

		<!-- JavaScript -->
		<script src="/public/js/bootstrap/bootstrap.min.js"></script>

	</body>
</html>
<?php }} ?>
