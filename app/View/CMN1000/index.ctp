<?php
	echo $this->Html->css('CMN1000', ['inline' => false]);
	echo $this->Html->script('CMN1000.js', ['inline' => false]);

	// ログインを3回失敗するとログイン画面を1分間ロックする
	if (isset($invalidAccessCount) && $invalidAccessCount >= 3) {
		return;
	}

	echo $this->Form->create(false, ['url' => ['controller' => 'CMN1000', 'action' => 'login']]);
?>

<div class="page-content">
	<div class="row">
		<table class="table-border">
			<tr>
				<th class="require">
					ログインID
				</th>
				<td>
					<?php echo $this->Form->input('txtLoginId', ['type' => 'text', 'maxlength' => 32, 'label' => false]); ?>
				</td>
			</tr>
			<tr>
				<th class="require">
					パスワード
				</th>
				<td>
					<?php echo $this->Form->input('txtPassword', ['type' => 'password', 'maxlength' => 32, 'label' => false]); ?>
				</td>
			</tr>
		</table>
		<div class="page-block">
			<?php echo $this->Form->button('ログイン', ['type' => 'submit', 'class' => 'btn btn-primary', 'div' => false]); ?>
			<?php echo $this->Html->link('パスワード再設定', ['class' => 'disabled', 'controller' => 'CMN1020', 'action' => 'index']); ?>
		</div>
	</div>
	<?php if(isset($notifications)): ?>
		<div class="row">
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
		</div>
	<?php endif; ?>
</div>
<?php echo $this->Form->end(); ?>
