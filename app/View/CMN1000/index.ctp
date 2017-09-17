<?php
	echo $this->Html->css('CMN1000');
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
	<hr>
	<div class="page-block">
		<div class="table-simple" name="lstInfo">
			<table>
				<thead>
					<tr>
						<th>
							<div class="CMN1000-col-info">
								インフォメーション
							</div>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($notifications as $notification) { ?>
					<tr>
						<td>
							<div class="CMN1000-col-info col-text">
								<?php echo h($notification['Notification']['COMMENT']); ?>
							</div>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php echo $this->Form->end(); ?>
