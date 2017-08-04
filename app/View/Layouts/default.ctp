<!DOCTYPE html>
<html>
	<head>
		<?php
		echo $this->Html->css('cmn');
		echo $this->Html->css('custom');
		echo $this->Html->script('jquery-3.1.1.min.js');
		echo $this->Html->script('cmn.js');
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
