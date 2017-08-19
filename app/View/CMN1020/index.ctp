<?php
$this->Html->css('CMN1020', null, ['inline'=>false]);
$this->Html->script('CMN1020.js', ['inline'=>false]);
?>
<?php echo $this->Form->create(null, ['url'=>['controller'=>'CMN1020', 'action'=>'send']]); ?>
<div class="page-content">
	<div class="page-block table-border">
		<table>
			<tr>
				<th class="require">
				  ログインID
				</th>
				<td>
					<?php echo $this->Form->input('txtUserId', ['type'=>'text', 'maxlength'=>32, 'label'=>'']); ?>
				</td>
			</tr>
		</table>
	</div>
	<div class="page-block">
		<?php echo $this->Form->submit('送信'); ?>
	</div>
</div>
<?php echo $this->Form->end(); ?>
