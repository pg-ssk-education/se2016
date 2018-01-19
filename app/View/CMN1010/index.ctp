<?php
echo $this->Html->css('CMN1010', ['inline' => false]);
echo $this->Html->script('CMN1010.js', ['inline' => false]);

echo $this->Form->create(false, ['url' => ['controller' => 'CMN1010', 'action' => 'login']]);
?>

<?php if (!empty($notifications)): ?>
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
