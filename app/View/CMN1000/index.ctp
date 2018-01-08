<?php
echo $this->Html->css('CMN1000', ['inline' => false]);
echo $this->Html->script('CMN1000.js', ['inline' => false]);

// ログインを3回失敗するとログイン画面を1分間ロックする
if (isset($invalidAccessCount) && $invalidAccessCount >= 3) {
	return;
}

echo $this->Form->create(false, ['url' => ['controller' => 'CMN1000', 'action' => 'login']]);
?>

<div class="page-block">
	<table class="table-border">
		<tr>
			<th class="require">
				ログインID
			</th>
			<td>
				<?php echo $this->Form->input('txtLoginId', ['type' => 'text', 'class' => 'form-control', 'maxlength' => 32, 'label' => '', 'div' => 'form-group']); ?>

			</td>
		</tr>
		<tr>
			<th class="require">
				パスワード
			</th>
			<td>
				<?php echo $this->Form->input('txtPassword', ['type' => 'password', 'class' => 'form-control', 'maxlength' => 32, 'label' => '', 'div' => 'form-group']); ?>
			</td>
		</tr>
	</table>
</div>
<div class="page-block">
	<?php echo $this->Form->button('ログイン', ['type' => 'submit', 'class' => 'btn btn-primary', 'div' => false]); ?>
	<?php //echo $this->Html->link('パスワード再設定', ['class' => 'disabled', 'controller' => 'CMN1020', 'action' => 'index']); ?>
</div>
<?php if(isset($notifications)): ?>
	<table class="table table-striped" id="notifications">
		<thead>
			<tr>
				<th>
					インフォメーション
				</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($notifications as $notification): ?>
				<tr>
					<td class="col-text">
						<?php echo h($notification['Notification']['COMMENT']); ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>
<?php echo $this->Form->end(); ?>
