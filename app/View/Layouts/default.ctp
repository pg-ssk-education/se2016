<!DOCTYPE html>
<html>
	<head>
		<?php
		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('jquery.dataTables.min');
		echo $this->Html->css('cmn');
		echo $this->Html->script('jquery-3.1.1.min.js');
		echo $this->Html->script('bootstrap.min.js');
		echo $this->Html->script('jquery.dataTables.min.js');
		?>
	</head>
	<body>
		<?php echo $this->Session->flash(); ?>
		<?php echo $this->fetch('content'); ?>
			
		<div class="page-footer">
			<table>
				<tr>
					<td>
						&copy;CSC-Osaka Education Team.
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>
