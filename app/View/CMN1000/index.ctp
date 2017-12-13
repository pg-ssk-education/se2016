<?php
	echo $this->Html->script('CMN1000.js');
	
	// ログインを3回失敗するとログイン画面を1分間ロックする
	if (isset($invalidAccessCount) && $invalidAccessCount >= 3) {
		return;
	}

	echo $this->Form->create(false, ['url'=>['controller'=>'CMN1000', 'action'=>'login']]);
?>
<div class="CMN1000-page-content">
	<div class="page-block table-border">
		<table>
			<tr>
				<th class="require">
					ログインID
				</th>
				<td>
					<?php echo $this->Form->input('txtLoginId', ['type'=>'text', 'maxlength'=>32, 'label'=>false]); ?>
					<!--<input type="text" class="text-loginId" name="txtLoginId" id="user_id" maxlength="32">-->
				</td>
			</tr>
			<tr>
				<th class="require">
					パスワード
				</th>
				<td>
					<?php echo $this->Form->input('txtPassword', ['type'=>'password', 'maxlength'=>32, 'label'=>false]); ?>
					<!--<input type="password" class="text-password" name="txtPassword" id="password" maxlength="32">-->
				</td>
			</tr>
		</table>
	</div>
	<?php echo $this->Html->link('パスワード再設定', ['controller'=>'CMN1020', 'action'=>'index']); ?>
	<div class="page-block">
		<?php echo $this->Form->submit('ログイン'); ?>
	</div>
	<?php if(isset($notifications)): ?>
		<hr>
		<table id="notifications" class="table table-bordered">
			<thead>
				<tr>
					<th>
						インフォメーション
					</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($notifications as $notification) { ?>
				<tr>
					<td class="col-text">
						<?php echo h($notification['Notification']['COMMENT']); ?>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		
		<div class="page-block">
			<div class="table-simple" name="lstInfo">
			</div>
		</div>
	<?php endif; ?>
</div>
<?php echo $this->Form->end(); ?>
