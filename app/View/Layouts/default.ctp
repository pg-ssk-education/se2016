<!DOCTYPE html>
<html>
	<head>
		<?php
			echo $this->Html->css(['bootstrap.min', 'jquery.dataTables.min', 'cmn']);
			echo $this->fetch('css');
			echo $this->Html->script(['jquery-3.2.1.min.js', 'bootstrap.min.js', 'jquery.dataTables.min.js', 'cmn.js']);
			echo $this->fetch('script');
		?>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div>
					<?php //echo $this->Navbar->output(); ?>
				</div>
			</div>
			<div class="row">
				<div class="message-alert">
					<?php echo $this->Session->flash('alert'); ?>
				</div>
			</div>
			<div class="row">
				<div class="message-caution">
					<?php echo $this->Session->flash('caution'); ?>
				</div>
			</div>
			<div class="row">
				<div class="message-information">
					<?php echo $this->Session->flash('information'); ?>
				</div>
			</div>
			<?php echo $this->fetch('content'); ?>
			<div class="row">
				<div class="page-footer">
					<div>
						&copy;CSC-Osaka Education Team
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
