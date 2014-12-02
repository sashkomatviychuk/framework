<?php /* Smarty version Smarty-3.1.19-dev, created on 2014-08-17 20:33:56
         compiled from "C:/xampp/htdocs/my-admin/application/modules/site/views/users/list.html" */ ?>
<?php /*%%SmartyHeaderCode:815753f0e78425c044-34332145%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '453614930b7c971c9a80b319dbcbcde3b79d0304' => 
    array (
      0 => 'C:/xampp/htdocs/my-admin/application/modules/site/views/users/list.html',
      1 => 1408282577,
      2 => 'file',
    ),
    '270aef2359e2808312dcff87434bf2b6c86ae978' => 
    array (
      0 => 'C:/xampp/htdocs/my-admin/application/modules/site/views/base.html',
      1 => 1408295675,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '815753f0e78425c044-34332145',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'active_item' => 0,
    'js' => 1,
    'key' => 1,
    'value' => 1,
  ),
  'has_nocache_code' => true,
  'version' => 'Smarty-3.1.19-dev',
  'unifunc' => 'content_53f0e784e3f291_50477500',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53f0e784e3f291_50477500')) {function content_53f0e784e3f291_50477500($_smarty_tpl) {?><?php if (!is_callable('smarty_function_router')) include 'C:/xampp/htdocs/my-admin/application/system/smarty/plugins/function.router.php';
?><?php echo '/*%%SmartyNocache:815753f0e78425c044-34332145%%*/<?php $_smarty = $_smarty_tpl->smarty; if (!is_callable(\'smarty_function_router\')) include \'C:/xampp/htdocs/my-admin/application/system/smarty/plugins/function.router.php\';
?>/*/%%SmartyNocache:815753f0e78425c044-34332145%%*/';?>
<!DOCTYPE html>
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
		<title><?php echo _('Список користувачів');?>
</title>
	</head>
	<body>
		<div id="wrapper">
			<!-- Sidebar -->
			
	<?php $_smarty_tpl->tpl_vars['active_item'] = new Smarty_variable('users', null, 0);?>

			<?php echo $_smarty_tpl->getSubTemplate ('layouts/sidebar.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array('active_item'=>$_smarty_tpl->tpl_vars['active_item']->value), 0);?>


			<div id="page-wrapper">
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
				              <li><a href="/"><i class="fa fa-dashboard"></i> Головна сторінка</a></li>
				              
	<li class="active"><i class="fa fa-bar-chart-o"></i> <?php echo _('Користувачі');?>
</li>

            			</ol>
						
	<h1><?php echo _('Список користувачів');?>
</h1>
	<div class="panel panel-default">
		<div class="panel-heading">
			<a href="<?php echo smarty_function_router(array('name'=>'usersAdd'),$_smarty_tpl);?>
" class="btn btn-default btn-sm"><?php echo _('Додати');?>
</a>
		</div>
		<div class="panel-body">
			<table class="table table-bordered table-hover table-striped tablesorter">
				<thead>
					<tr>
						<th class="header">#</th>
						<th class="header"><?php echo _('Ім`я');?>
</th>
						<th class="header"><?php echo _('Активний');?>
</th>
						<th class="header"><?php echo _('Опції');?>
</th>
					</tr>
				</thead>
				<tbody>
					<?php echo '/*%%SmartyNocache:815753f0e78425c044-34332145%%*/<?php  $_smarty_tpl->tpl_vars[\'user\'] = new Smarty_Variable; $_smarty_tpl->tpl_vars[\'user\']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars[\'users\']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, \'array\');}
foreach ($_from as $_smarty_tpl->tpl_vars[\'user\']->key => $_smarty_tpl->tpl_vars[\'user\']->value) {
$_smarty_tpl->tpl_vars[\'user\']->_loop = true;
?>/*/%%SmartyNocache:815753f0e78425c044-34332145%%*/';?>

						<tr>
							<td><?php echo '/*%%SmartyNocache:815753f0e78425c044-34332145%%*/<?php echo $_smarty_tpl->tpl_vars[\'user\']->value->id;?>
/*/%%SmartyNocache:815753f0e78425c044-34332145%%*/';?>
</td>
							<td>
								<a href="<?php echo '/*%%SmartyNocache:815753f0e78425c044-34332145%%*/<?php echo smarty_function_router(array(\'name\'=>\'usersView\',\'id\'=>$_smarty_tpl->tpl_vars[\'user\']->value->id),$_smarty_tpl);?>
/*/%%SmartyNocache:815753f0e78425c044-34332145%%*/';?>
"><?php echo '/*%%SmartyNocache:815753f0e78425c044-34332145%%*/<?php echo $_smarty_tpl->tpl_vars[\'user\']->value->login;?>
/*/%%SmartyNocache:815753f0e78425c044-34332145%%*/';?>
</a>
							</td>
							<td><span class="label label-<?php echo '/*%%SmartyNocache:815753f0e78425c044-34332145%%*/<?php if ($_smarty_tpl->tpl_vars[\'user\']->value->is_active) {?>/*/%%SmartyNocache:815753f0e78425c044-34332145%%*/';?>
primary<?php echo '/*%%SmartyNocache:815753f0e78425c044-34332145%%*/<?php } else { ?>/*/%%SmartyNocache:815753f0e78425c044-34332145%%*/';?>
default<?php echo '/*%%SmartyNocache:815753f0e78425c044-34332145%%*/<?php }?>/*/%%SmartyNocache:815753f0e78425c044-34332145%%*/';?>
"><?php echo '/*%%SmartyNocache:815753f0e78425c044-34332145%%*/<?php if ($_smarty_tpl->tpl_vars[\'user\']->value->is_active) {?>/*/%%SmartyNocache:815753f0e78425c044-34332145%%*/';?>
<?php echo '/*%%SmartyNocache:815753f0e78425c044-34332145%%*/<?php echo _(\'Так\');?>
/*/%%SmartyNocache:815753f0e78425c044-34332145%%*/';?>
<?php echo '/*%%SmartyNocache:815753f0e78425c044-34332145%%*/<?php } else { ?>/*/%%SmartyNocache:815753f0e78425c044-34332145%%*/';?>
<?php echo '/*%%SmartyNocache:815753f0e78425c044-34332145%%*/<?php echo _(\'Ні\');?>
/*/%%SmartyNocache:815753f0e78425c044-34332145%%*/';?>
<?php echo '/*%%SmartyNocache:815753f0e78425c044-34332145%%*/<?php }?>/*/%%SmartyNocache:815753f0e78425c044-34332145%%*/';?>
</span></td>
							<td><a class="btn btn-default btn-xs" href="<?php echo '/*%%SmartyNocache:815753f0e78425c044-34332145%%*/<?php echo smarty_function_router(array(\'name\'=>\'usersEdit\',\'id\'=>$_smarty_tpl->tpl_vars[\'user\']->value->id),$_smarty_tpl);?>
/*/%%SmartyNocache:815753f0e78425c044-34332145%%*/';?>
"><span class="fa fa-edit"></span> <?php echo '/*%%SmartyNocache:815753f0e78425c044-34332145%%*/<?php echo _(\'Редагувати\');?>
/*/%%SmartyNocache:815753f0e78425c044-34332145%%*/';?>
</a>
								<a class="btn btn-default btn-xs js-remove-url" data-confirm="Видалити?" href="<?php echo '/*%%SmartyNocache:815753f0e78425c044-34332145%%*/<?php echo smarty_function_router(array(\'name\'=>\'usersDelete\',\'id\'=>$_smarty_tpl->tpl_vars[\'user\']->value->id),$_smarty_tpl);?>
/*/%%SmartyNocache:815753f0e78425c044-34332145%%*/';?>
" data-alert="ok?"><span class="fa fa-trash-o"></span> <?php echo '/*%%SmartyNocache:815753f0e78425c044-34332145%%*/<?php echo _(\'Видалити\');?>
/*/%%SmartyNocache:815753f0e78425c044-34332145%%*/';?>
</a>
								<a class="btn btn-default btn-xs" href="<?php echo '/*%%SmartyNocache:815753f0e78425c044-34332145%%*/<?php echo smarty_function_router(array(\'name\'=>\'shadowLogin\',\'id\'=>$_smarty_tpl->tpl_vars[\'user\']->value->id),$_smarty_tpl);?>
/*/%%SmartyNocache:815753f0e78425c044-34332145%%*/';?>
"><span class="fa fa-share"></span> <?php echo '/*%%SmartyNocache:815753f0e78425c044-34332145%%*/<?php echo _(\'Shadow\');?>
/*/%%SmartyNocache:815753f0e78425c044-34332145%%*/';?>
</a>
							</td>
						</tr>
					<?php echo '/*%%SmartyNocache:815753f0e78425c044-34332145%%*/<?php }
if (!$_smarty_tpl->tpl_vars[\'user\']->_loop) {
?>/*/%%SmartyNocache:815753f0e78425c044-34332145%%*/';?>

						<tr>
							<td colspan="4"><?php echo '/*%%SmartyNocache:815753f0e78425c044-34332145%%*/<?php echo _(\'Список порожній\');?>
/*/%%SmartyNocache:815753f0e78425c044-34332145%%*/';?>
</td>
						</tr>
					<?php echo '/*%%SmartyNocache:815753f0e78425c044-34332145%%*/<?php } ?>/*/%%SmartyNocache:815753f0e78425c044-34332145%%*/';?>

				</tbody>
			</table>
			
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
		
			<?php echo '/*%%SmartyNocache:815753f0e78425c044-34332145%%*/<?php if ($_smarty_tpl->tpl_vars[\'js\']->value) {?>/*/%%SmartyNocache:815753f0e78425c044-34332145%%*/';?>

				<?php echo '/*%%SmartyNocache:815753f0e78425c044-34332145%%*/<?php  $_smarty_tpl->tpl_vars[\'value\'] = new Smarty_Variable; $_smarty_tpl->tpl_vars[\'value\']->_loop = false;
 $_smarty_tpl->tpl_vars[\'key\'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars[\'js\']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, \'array\');}
foreach ($_from as $_smarty_tpl->tpl_vars[\'value\']->key => $_smarty_tpl->tpl_vars[\'value\']->value) {
$_smarty_tpl->tpl_vars[\'value\']->_loop = true;
 $_smarty_tpl->tpl_vars[\'key\']->value = $_smarty_tpl->tpl_vars[\'value\']->key;
?>/*/%%SmartyNocache:815753f0e78425c044-34332145%%*/';?>

					App._data['<?php echo '/*%%SmartyNocache:815753f0e78425c044-34332145%%*/<?php echo $_smarty_tpl->tpl_vars[\'key\']->value;?>
/*/%%SmartyNocache:815753f0e78425c044-34332145%%*/';?>
'] = '<?php echo '/*%%SmartyNocache:815753f0e78425c044-34332145%%*/<?php echo $_smarty_tpl->tpl_vars[\'value\']->value;?>
/*/%%SmartyNocache:815753f0e78425c044-34332145%%*/';?>
';
				<?php echo '/*%%SmartyNocache:815753f0e78425c044-34332145%%*/<?php } ?>/*/%%SmartyNocache:815753f0e78425c044-34332145%%*/';?>

			<?php echo '/*%%SmartyNocache:815753f0e78425c044-34332145%%*/<?php }?>/*/%%SmartyNocache:815753f0e78425c044-34332145%%*/';?>

		</script>
		
		<!-- end of js block -->
	</body>
</html>
<?php }} ?>
