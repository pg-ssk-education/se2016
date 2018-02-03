<?php
echo $this->Html->script('CMN2000', ['inline' => false]);
?>
<div class="page-content">
	<div class="page-block">
		<div class="btn-group">
			<?php echo $this->Html->link('追加', ['controller' => 'CMN2000', 'action' => 'add'], ['class' => 'btn']); ?>
		</div>
	</div>
	<div class="page-block">
		<table id="users" class="table table-striped">
			<thead>
				<tr>
					<th>
						ユーザID
					</th>
					<th>
						氏名
					</th>
					<th>
						操作
					</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($users as $user): ?>
					<tr>
						<td>
							<?php echo h($user['User']['USER_ID']); ?>
						</td>
						<td>
							<?php echo h($user['User']['NAME']); ?>
						</td>
						<td>
							<div class="btn-group">
								<?php echo $this->Html->link('編集', ['controller' => 'CMN2000', 'action' => 'edit', 'id' => $user['User']['USER_ID']], ['class'=>'btn']); ?>
							</div>
							<div class="btn-group">
								<?php echo $this->Html->link('削除', ['controller' => 'CMN2000', 'action' => 'delete', 'id' => $user['User']['USER_ID']], ['class' => 'btn'], $user['User']['NAME'].'を削除します。よろしいですか？'); ?>
							</div>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
