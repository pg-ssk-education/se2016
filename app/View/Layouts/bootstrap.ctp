<!DOCTYPE html>
<html lang="en">
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

	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<?php if ($this->Session->check('CMN1000')): ?>
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>
				<?php endif; ?>
				<h4><?php echo $this->Html->link(__('社内事務効率化ツール'), '/CMN1000/index'); ?></h4>
				<div class="nav-collapse">
					<?php if ($this->Session->check('CMN1000')): ?>
						<ul class="nav">
							<li class="active"><a href="#">Home</a></li>
							<li><a href="#about">About</a></li>
							<li><a href="#contact">Contact</a></li>
						</ul>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<?php echo $this->Session->flash(); ?>
		<?php echo $this->fetch('content'); ?>
		<div class="row">
			<div class="page-footer">
				<div>
					&copy;CSC-Osaka Education Team
				</div>
			</div>
		</div>
	</div>

	<!-- Le javascript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<?php echo $this->Html->script(['jquery-3.2.1.min', 'bootstrap.min', 'jquery.dataTables.min', 'cmn']); ?>
	<?php echo $this->fetch('script'); ?>

</body>
</html>
