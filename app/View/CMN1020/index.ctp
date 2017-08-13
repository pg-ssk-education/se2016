<?php
	echo $this->Html->css('CMN1020', null, ['inline' => false]);
	echo $this->Html->script('CMN1020.js', ['inline' => false]);

	echo $this->Form->create(false, ['url' => ['action' => 'send']]);
?>
<div class="page-content">
	<div class="page-block table-border">
		<table>
			<tr>
				<th class="require">
					ログインID
				</th>
				<td>
					<?php echo $this->Form->input('User.USER_ID', ['type' => 'text', 'label' => false, 'div' => false, 'maxlength' => 32]); ?>
				</td>
			</tr>
		</table>
	</div>
	<div class="page-block">
		<?php echo $this->Form->submit('送信'); ?>
	</div>
</div>
<?php echo $this->Form->end(); ?>
