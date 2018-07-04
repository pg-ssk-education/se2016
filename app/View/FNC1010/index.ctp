<?php
echo $this->Html->css(['datatables.min'], ['inline' => false]);
echo $this->Html->script(['datatables.min', 'FNC1010'], ['inline' => false]);
echo $this->Form->create(false, ['url' => ['controller' => 'FNC1010', 'action' => 'login']]);
?>
<?php if (!empty($notifications)): ?>
	<div class="mb-2 mb-md-4">
		<table id="notifications" class="table table-striped">
			<thead>
				<tr>
					<th>インフォメーション</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($notifications as $notification): ?>
					<tr>
						<td><?php echo h($notification['Notification']['COMMENT']); ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
<?php endif; ?>

<?php echo $this->Form->end(); ?>
