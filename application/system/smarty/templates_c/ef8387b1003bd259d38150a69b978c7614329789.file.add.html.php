<?php /* Smarty version Smarty-3.1.19-dev, created on 2014-08-18 21:13:18
         compiled from "C:/xampp/htdocs/my-admin/application/modules/site/views/users/add.html" */ ?>
<?php /*%%SmartyHeaderCode:2879053f0c706d49fb2-31661548%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ef8387b1003bd259d38150a69b978c7614329789' => 
    array (
      0 => 'C:/xampp/htdocs/my-admin/application/modules/site/views/users/add.html',
      1 => 1408283015,
      2 => 'file',
    ),
    'a117fc25332f2b1ac229ac564f913165af5cba49' => 
    array (
      0 => 'C:/xampp/htdocs/my-admin/application/modules/site/views/users/includes/form.html',
      1 => 1408300329,
      2 => 'file',
    ),
    '270aef2359e2808312dcff87434bf2b6c86ae978' => 
    array (
      0 => 'C:/xampp/htdocs/my-admin/application/modules/site/views/base.html',
      1 => 1408295675,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2879053f0c706d49fb2-31661548',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19-dev',
  'unifunc' => 'content_53f0c70746c8b5_45274609',
  'variables' => 
  array (
    'active_item' => 0,
    'js' => 1,
    'key' => 1,
    'value' => 1,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53f0c70746c8b5_45274609')) {function content_53f0c70746c8b5_45274609($_smarty_tpl) {?><?php if (!is_callable('smarty_function_router')) include 'C:/xampp/htdocs/my-admin/application/system/smarty/plugins/function.router.php';
if (!is_callable('smarty_block_persist')) include 'C:/xampp/htdocs/my-admin/application/system/smarty/plugins/block.persist.php';
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
		<title><?php echo _('Додавання користувача');?>
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
	<li class="active"><i class="fa fa-edit"></i> <?php echo _('Додавання користувача');?>
</li>

            			</ol>
						
	<h1><?php echo _('Додавання користувача');?>
</h1>
	<div class="panel panel-default" style="width: 60%;">
		<div class="panel-body">
			<?php $_smarty_tpl->smarty->_tag_stack[] = array('persist', array()); $_block_repeat=true; echo smarty_block_persist(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

				<form action="" method="POST">
					<input type="hidden" name="token" value="<?php echo $_smarty_tpl->tpl_vars['this']->value->token();?>
">
					<div class="form-group">
						<label for="login"><?php echo _('Логін');?>
</label>
						<input type="text" name="login" class="form-control" autofocus>
					</div>
					<div class="form-group">
						<label for="email"><?php echo _('Емейл');?>
</label>
						<input type="email" name="email" class="form-control">
					</div>
					<div class="form-group">
						<label for="about"><?php echo _('Опис');?>
</label>
						<textarea name="about" class="form-control"></textarea>
					</div>
					<div class="form-group">
						<label for="is_active"><?php echo _('Активний');?>
</label>
						<input type="hidden" name="is_active" value="0">
						<div class="checkbox">
							<label for="">
								<input type="checkbox" name="is_active" value="1"> <?php echo _('Так');?>

							</label>
						</div>
					</div>
					<button type="submit" class="btn btn-success btn-sm"><?php echo _('Зберегти');?>
</button>
					<a href="<?php echo smarty_function_router(array('name'=>'users'),$_smarty_tpl);?>
" class="btn btn-danger btn-sm"><?php echo _('Назад');?>
</a>
				</form>
			<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_persist(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

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
