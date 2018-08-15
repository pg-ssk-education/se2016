<?php
echo $this->Form->create(false, ['url' => ['controller' => 'MNG1000', 'action' => 'index']]);
?>
<?php echo $this->Form->input('txtToken', ['type' => 'hidden', 'label' => false, 'div' => false, 'value' => $token]); ?>
<div class="container-fluid">
	<div class="row">
		<?php
		if ($action === 'insert') {
			echo $this->Form->input(
				'txtUserId', [
					'type'      => 'text',
					'value'     => h($user['USER_ID']),
					'required'  => true,
					'maxlength' => 32,
					'class'     => 'form-control',
					'label'     => ['text' => 'ユーザID', 'class' => 'cmn-required'],
					'div'       => ['class' => 'form-group col-12 col-sm-6 col-md-4 mb-2 mb-md-4']
				]);
		} else {
			echo $this->Form->input(
				'txtUserId', [
					'type'     => 'text',
					'value'    => h($user['USER_ID']),
					'disabled' => true,
					'class'    => 'form-control',
					'label'    => ['text' => 'ユーザID'],
					'div'      => ['class' => 'form-group col-12 col-sm-6 col-md-4 mb-2 mb-md-4']]);
		}
		echo $this->Form->input(
			'txtName', [
				'type'     => 'text',
				'value'    => h($user['NAME']),
				'required' => true,
				'class'    => 'form-control',
				'label'    => ['text' => '氏名', 'class' => 'cmn-required'],
				'div'      => ['class' => 'form-group col-12 col-sm-6 col-md-4 mb-2 mb-md-4']]);
		echo $this->Form->input(
			'txtNameKana', [
				'type'     => 'text',
				'value'    => h($user['NAME_KANA']),
				'required' => true,
				'class'    => 'form-control',
				'label'    => ['text' => '氏名(カナ)', 'class' => 'cmn-required'],
				'div'      => ['class' => 'form-group col-12 col-sm-6 col-md-4 mb-2 mb-md-4']]);
		echo $this->Form->input(
			'txtComment', [
				'type'  => 'text',
				'value' => h($user['COMMENT']),
				'class' => 'form-control',
				'label' => ['text' => 'コメント'],
				'div'   => ['class' => 'form-group col-12 col-sm-6 col-md-4 mb-2 mb-md-4']]);
		echo $this->Form->input(
			'txtEmployeeNum', [
				'type'     => 'text',
				'value'    => h($user['EMPLOYEE_NUM']),
				'required' => true,
				'class'    => 'form-control',
				'label'    => ['text' => '社員番号', 'class' => 'cmn-required'],
				'div'      => ['class' => 'form-group col-12 col-sm-6 col-md-4 mb-2 mb-md-4']]);
		echo $this->Form->input(
			'txtMailAddress', [
				'type'     => 'text',
				'value'    => h($user['MAIL_ADDRESS']),
				'required' => true,
				'class'    => 'form-control',
				'label'    => ['text' => 'メールアドレス', 'class' => 'cmn-required'],
				'div'      => ['class' => 'form-group col-12 col-sm-6 col-md-4 mb-2 mb-md-4']]);
		?>
	</div>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-12 mb-2 mb-md-4">
			<?php
			echo $this->Html->link('保存', 'javascript:void(0)', ['class' => 'btn btn-primary px-3 px-sm-5 mx-1', 'role' => 'button', 'data-action' => 'save']);
			echo $this->Html->link('中止', 'javascript:void(0)', ['class' => 'btn btn-secondary px-3 px-sm-5 mx-1', 'role' => 'button', 'data-action' => 'cancel']);
			echo $this->Form->submit('', ['name' => 'submit', 'style' => 'display:none;']);
			?>
		</div>
	</div>
</div>

<?php echo $this->Form->end(); ?>

<script type="text/javascript">
<!--
$('a[data-action="save"]').click(function() {
	$('form').attr('action', <?php echo "'" . $this->Html->url(['action' => $action]) . "'"; ?>);
	$('input[name=submit]').click();
});
$('a[data-action="cancel"]').click(function() {
	$('form').attr('action', <?php echo "'" . $this->Html->url(['action' => 'cancel']) . "'"; ?>);
	$('form').submit();
});
-->
</script>
