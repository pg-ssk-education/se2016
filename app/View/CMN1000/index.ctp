<?php
	echo $this->Html->css('CMN1000');
	echo $this->Html->script('CMN1000.js');

	echo $this->Form->create(false, array('controller'=>'CMN1000', 'action'=>'login'));
?>
<div class="CMN1000-page-content">
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