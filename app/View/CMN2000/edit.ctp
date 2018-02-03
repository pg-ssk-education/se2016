<?php
echo $this->Html->script('CMN2000', ['inline' => false]);
echo $this->Form->create(false, ['url' => ['controller' => 'CMN2000', 'action' => $action, 'id' => $token]]);
?>
<div class="page-content">
	<div class="page-block">
		<?php
		echo 'ユーザＩＤ';
		if ($action == 'insert') {
			echo $this->Form->input('txtUserId', ['type' => 'text', 'value' => $user['User']['USER_ID'], 'label' => false]);
		} else {
			echo $this->Form->input('txtUserId', ['type' => 'text', 'value' => $user['User']['USER_ID'], 'label' => false, 'disabled' => 'disabled']);
		}
		echo '氏名'           . $this->Form->input('txtName'       , ['type' => 'text', 'value' => $user['User']['NAME']        , 'label' => false]);
		echo '氏名(カナ)'     . $this->Form->input('txtNameKana'   , ['type' => 'text', 'value' => $user['User']['NAME_KANA']   , 'label' => false]);
		echo 'コメント'       . $this->Form->input('txtComment'    , ['type' => 'text', 'value' => $user['User']['COMMENT']     , 'label' => false]);
		echo '社員番号'       . $this->Form->input('txtEmployeeNum', ['type' => 'text', 'value' => $user['User']['EMPLOYEE_NUM'], 'label' => false]);
		echo 'メールアドレス' . $this->Form->input('txtMailAddress', ['type' => 'text', 'value' => $user['User']['MAIL_ADDRESS'], 'label' => false]);
		?>
		<div class="btn-group">
			<?php
			if ($action == 'insert') {
				echo $this->Form->button('登録', ['type' => 'submit', 'class' => 'btn']);
			} else {
				echo $this->Form->button('更新', ['type' => 'submit', 'class' => 'btn']);
			}
			?>
		</div>
		<div class="btn-group">
			<?php echo $this->Html->link('キャンセル', ['controller' => 'CMN2000', 'action' => 'index'], ['class' => 'btn'], 'キャンセルします。よろしいですか？'); ?>
		</div>
	</div>
</div>
<?php echo $this->Form->end(); ?>
