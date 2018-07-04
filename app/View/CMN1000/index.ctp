<?php
echo $this->Html->css(['datatables.min'], ['inline' => false]);
echo $this->Html->script(['datatables.min'], ['inline' => false]);
echo $this->Form->create(false, ['url' => ['controller' => 'FNC1000', 'action' => 'login']]);
?>
<div class="container-fluid">
	<div class="row">
		<div class="form-group col-12 col-sm-6 col-md-4 mb-2 mb-md-4">
			<?php echo $this->Form->input('txtUserId', ['type' => 'text', 'class' => 'form-control', 'maxlength' => 32, 'label' => 'ログインID']); ?>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-12 col-sm-6 col-md-4 mb-2 mb-md-4">
			<?php echo $this->Form->input('txtPassword', ['type' => 'password', 'class' => 'form-control', 'maxlength' => 32, 'label' => 'パスワード']); ?>
		</div>
		<div class="col-12 mb-2 mb-md-4">
			<a href="#" class="btn btn-primary px-3 px-sm-5" role="button" data-action="add">ログイン</a>
			<?php echo $this->Form->button('ログイン', ['type' => 'submit', 'class' => 'btn btn-primary px-3 px-sm-5']); ?>
		</div>
	</div>
</div>

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
