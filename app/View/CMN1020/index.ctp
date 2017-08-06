<?php
	echo $this->Html->css('CMN1020', null, array('inline' => false));
	echo $this->Html->script('CMN1020.js', array('inline' => false));

	echo $this->Form->create(null, ['url' => ['action' => 'send']]);
?>
<div class="page-content">
	<div class="page-block table-border">
		<table>
			<tr>
				<th class="require">
					ログインID
				</th>
				<td>
					<input type="text" class="text-loginId" name="txtLoginId" id="user_id" maxlength="32">
				</td>
			</tr>
			<tr>
				<th class="require">
					パスワード
				</th>
				<td>
					<input type="password" class="text-password" name="txtPassword" id="password" maxlength="32">
				</td>
			</tr>
		</table>
	</div>
	<?php echo $this->Html->link('パスワード再設定', '../CMN1020/index/'); ?>
	<div class="page-block">
		<?php echo $this->Form->submit('ログイン', array('name' => 'login')); ?>
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
