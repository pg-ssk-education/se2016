<?php
	echo $this->Html->script('CMN2000',['inline'=>false]);
	echo $this->Form->create(false,['controller'=>'CMN2000','action'=>'action']);
?>
<div class="page-content">
	<div class="page-block">
		<?php echo $this->Form->input('ユーザID', ['type'=>'text', 'value'=>$user['User']['USER_ID']]); ?>
		<?php echo $this->Form->input('ユーザ名', ['type'=>'text', 'value'=>$user['User']['NAME']]); ?>
	</div>
</div>
