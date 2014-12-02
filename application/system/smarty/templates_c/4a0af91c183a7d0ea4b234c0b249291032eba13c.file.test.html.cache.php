<?php /* Smarty version Smarty-3.1.19-dev, created on 2014-08-17 20:10:12
         compiled from "C:/xampp/htdocs/my-admin/application/modules/site/views/test.html" */ ?>
<?php /*%%SmartyHeaderCode:1980553f08db3d11e04-52110483%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4a0af91c183a7d0ea4b234c0b249291032eba13c' => 
    array (
      0 => 'C:/xampp/htdocs/my-admin/application/modules/site/views/test.html',
      1 => 1408278549,
      2 => 'file',
    ),
    '270aef2359e2808312dcff87434bf2b6c86ae978' => 
    array (
      0 => 'C:/xampp/htdocs/my-admin/application/modules/site/views/base.html',
      1 => 1408295387,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1980553f08db3d11e04-52110483',
  'function' => 
  array (
  ),
  'cache_lifetime' => 3600,
  'version' => 'Smarty-3.1.19-dev',
  'unifunc' => 'content_53f08db4365650_43964488',
  'variables' => 
  array (
    'active_item' => 0,
    'js' => 1,
    'key' => 1,
    'value' => 1,
  ),
  'has_nocache_code' => true,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53f08db4365650_43964488')) {function content_53f08db4365650_43964488($_smarty_tpl) {?><!DOCTYPE html>
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
		<title><?php echo _('Головна сторінка');?>
</title>
	</head>
	<body>
		<div id="wrapper">
			<!-- Sidebar -->
			
	<?php $_smarty_tpl->tpl_vars['active_item'] = new Smarty_variable('main', null, 0);?>

			<?php echo $_smarty_tpl->getSubTemplate ('layouts/sidebar.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array('active_item'=>$_smarty_tpl->tpl_vars['active_item']->value), 0);?>


			<div id="page-wrapper">
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
				              <li><a href="/"><i class="fa fa-dashboard"></i> Головна сторінка</a></li>
				              
            			</ol>
            			
						
	<h1><?php echo '/*%%SmartyNocache:1980553f08db3d11e04-52110483%%*/<?php echo _(\'Головна сторінка\');?>
/*/%%SmartyNocache:1980553f08db3d11e04-52110483%%*/';?>
</h1>

						
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
		
			<?php echo '/*%%SmartyNocache:1980553f08db3d11e04-52110483%%*/<?php if ($_smarty_tpl->tpl_vars[\'js\']->value) {?>/*/%%SmartyNocache:1980553f08db3d11e04-52110483%%*/';?>

				<?php echo '/*%%SmartyNocache:1980553f08db3d11e04-52110483%%*/<?php  $_smarty_tpl->tpl_vars[\'value\'] = new Smarty_Variable; $_smarty_tpl->tpl_vars[\'value\']->_loop = false;
 $_smarty_tpl->tpl_vars[\'key\'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars[\'js\']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, \'array\');}
foreach ($_from as $_smarty_tpl->tpl_vars[\'value\']->key => $_smarty_tpl->tpl_vars[\'value\']->value) {
$_smarty_tpl->tpl_vars[\'value\']->_loop = true;
 $_smarty_tpl->tpl_vars[\'key\']->value = $_smarty_tpl->tpl_vars[\'value\']->key;
?>/*/%%SmartyNocache:1980553f08db3d11e04-52110483%%*/';?>

					App._data['<?php echo '/*%%SmartyNocache:1980553f08db3d11e04-52110483%%*/<?php echo $_smarty_tpl->tpl_vars[\'key\']->value;?>
/*/%%SmartyNocache:1980553f08db3d11e04-52110483%%*/';?>
'] = '<?php echo '/*%%SmartyNocache:1980553f08db3d11e04-52110483%%*/<?php echo $_smarty_tpl->tpl_vars[\'value\']->value;?>
/*/%%SmartyNocache:1980553f08db3d11e04-52110483%%*/';?>
';
				<?php echo '/*%%SmartyNocache:1980553f08db3d11e04-52110483%%*/<?php } ?>/*/%%SmartyNocache:1980553f08db3d11e04-52110483%%*/';?>

			<?php echo '/*%%SmartyNocache:1980553f08db3d11e04-52110483%%*/<?php }?>/*/%%SmartyNocache:1980553f08db3d11e04-52110483%%*/';?>

		</script>
		
		<!-- end of js block -->
	</body>
</html>
<?php }} ?>
