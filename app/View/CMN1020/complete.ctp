<?php
$this->Html->css('CMN1020', null, ['inline'=>false]);
$this->Html->script('CMN1020.js', ['inline'=>false]);
?>
<?php echo $this->Form->create(null, ['url'=>['controller'=>'CMN1000', 'action'=>'index']]); ?>
<div class="page-content">
	<div class="page-block">
		<?php echo $this->Form->button('ログイン画面に戻る', ['type'=>'submit']); ?>
	</div>
</div>
<?php echo $this->Form->end(); ?>
