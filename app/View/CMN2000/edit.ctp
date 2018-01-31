<?php
	echo $this->Html->script('CMN2000',['inline'=>false]);
	echo $this->Form->create(false, ['url' => ['controller' => 'CMN2000', 'action' => $action]]);
?>
<div class="page-content">
	<div class="page-block">
		<?php if(isset($user['User'])):?>
			ユーザＩＤ<?php     echo $this->Form->input('txtUserId'     , ['type'=>'text', 'value'=>$user['User']['USER_ID'], 'label'=>false, 'disabled'=>'disabled']);?>
			<?php echo $this->Form->hidden('hidUserId' , ['value'=>$user['User']['USER_ID']]); ?>
			氏名<?php           echo $this->Form->input('txtName'       , ['type'=>'text', 'value'=>$user['User']['NAME'], 'label'=>false]);?>
			氏名(カナ)<?php     echo $this->Form->input('txtNameKana'   , ['type'=>'text', 'value'=>$user['User']['NAME_KANA'], 'label'=>false]);?>
			コメント<?php       echo $this->Form->input('txtComment'    , ['type'=>'text', 'value'=>$user['User']['COMMENT'], 'label'=>false]);?>
			社員番号<?php       echo $this->Form->input('txtEmployeeNum', ['type'=>'text', 'value'=>$user['User']['EMPLOYEE_NUM'], 'label'=>false]);?>
			メールアドレス<?php echo $this->Form->input('txtMailAddress', ['type'=>'text', 'value'=>$user['User']['MAIL_ADDRESS'], 'label'=>false]);?>
		<?php else:?>
			ユーザＩＤ<?php     echo $this->Form->input('txtUserId'     , ['type'=>'text', 'value'=>'', 'label'=>false]);?>
			氏名<?php           echo $this->Form->input('txtName'       , ['type'=>'text', 'value'=>'', 'label'=>false]);?>
			氏名(カナ<?php      echo $this->Form->input('txtNameKana'   , ['type'=>'text', 'value'=>'', 'label'=>false]);?>
			コメント<?php       echo $this->Form->input('txtComment'    , ['type'=>'text', 'value'=>'', 'label'=>false]);?>
			社員番号<?php       echo $this->Form->input('txtEmployeeNum', ['type'=>'text', 'value'=>'', 'label'=>false]);?>
			メールアドレス<?php echo $this->Form->input('txtMailAddress', ['type'=>'text', 'value'=>'', 'label'=>false]);?>
		<?php endif;?>
		<div class="btn-group">
			<?php echo $this->Form->button('登録', ['type'=>'submit', 'class'=>'btn']); ?>
		</div>
		<div class="btn-group">
			<?php echo $this->Html->link('キャンセル', ['controller'=>'CMN2000', 'action'=>'index'], ['class'=>'btn'], 'キャンセルします。よろしいですか？'); ?>
		</div>
	</div>
</div>
<?php echo $this->Form->end(); ?>
