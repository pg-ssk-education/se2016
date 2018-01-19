<?php
	echo $this->Html->script('CMN2000',['inline'=>false]);
	echo $this->Form->create(false,['controller'=>'CMN2000','action'=>'action']);
?>
<div class="page-content">
	<div class="page-block">
		<?php
			echo $this->Form->button('追加', ['id'=>'btnAdd']);
			echo $this->Form->button('編集', ['id'=>'btnEdit']);
			echo $this->Form->button('削除', ['id'=>'btnDelete']);
			echo $this->Form->hidden('hidAction');
		?>
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
								<?php
								echo $this->Html->link('編集', ['controller'=>'CMN2000', 'action'=>'edit?id='.h($user['User']['USER_ID'])], ['class'=>'btn']);
								echo $this->Html->link('削除', ['controller'=>'CMN2000', 'action'=>'delete?id='.h($user['User']['USER_ID'])], ['class'=>'btn']);
								?>
							</div>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
