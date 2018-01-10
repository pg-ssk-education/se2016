<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>
		<?php //echo $title_for_layout; ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Le styles -->
	<?php
	echo $this->Html->css(['cmn', 'bootstrap.min', 'bootstrap-responsive.min', 'jquery.dataTables.min']);
	echo $this->fetch('meta');
	echo $this->fetch('css');
	?>
</head>

<body>
	<?php /*
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container">
				<?php //if ($this->Session->check('CMN1000')): ?>
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".gnavi">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>
				<?php //endif; ?>
				<h4><?php echo $this->Html->link(__('社内事務効率化ツール'), '/CMN1000/index', ['class' => 'brand']); ?></h4>
				<div class="gnavi">
					<?php //if ($this->Session->check('CMN1000')): ?>
						<ul class="nav navbar-right">
							<li><a href="">Home</a></li>
							<li><a href="">About</a></li>
							<li><a href="">Contact</a></li>
						</ul>
					<?php //endif; ?>
				</div>
			</div>
		</div>
	</div>
	*/?>
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<?php /*
			<a class="btn btn-navbar navbar-toggle collapsed" data-toggle="collapse" data-target="#gnavi">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			*/?>
			<h4><?php echo $this->Html->link(__('社内事務効率化ツール'), '/CMN1000/index', ['class' => 'brand', 'style' => 'margin:0 5px;']); ?></h4>
			<ul class="nav">
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown">メニュー<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><?php echo $this->Html->link('ユーザ管理', '/CMN2000/index', []) ?></li>
					</ul>
				</li>
			</ul>
			<ul class="nav pull-right">
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown">ユーザ名<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<!--<li><a href="google.co.jp">個別設定</a></li>-->
						<li><?php echo $this->Html->link('ログアウト', '/CMN1000/index?logout=1', []) ?></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>

	<div class="container">
		<?php if ($this->Session->check('Message.alert-nortice') || $this->Session->check('Message.alert-success') || $this->Session->check('Message.alert-error')): ?>
			<section id="alerts">
				<?php
				echo $this->Session->flash('alert-nortice');
				echo $this->Session->flash('alert-success');
				echo $this->Session->flash('alert-error');
				?>
			</section>
		<?php endif; ?>
		<?php echo $this->fetch('content'); ?>
		<div class="row">
			<div class="page-footer">
				<div>
					&copy;CSC-Osaka Education Team
				</div>
			</div>
		</div>	</div>

	<!-- Le javascript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<?php echo $this->Html->script(['jquery-3.2.1.min', 'bootstrap', 'jquery.dataTables.min']); ?>
	<script>
		$(".dropdown-toggle").dropdown();
	</script>

	<?php echo $this->fetch('script'); ?>

</body>
</html>
