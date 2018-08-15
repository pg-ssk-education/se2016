<?php
echo $this->Html->css(['datatables.min'], ['inline' => false]);
echo $this->Html->script(['datatables.min'], ['inline' => false]);
echo $this->Form->create(false, ['url' => ['controller' => 'MNG1000', 'action' => 'index']]);
?>
<?php echo $this->Form->input('txtTargetUserId', ['type' => 'hidden', 'label' => false]); ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-12 mb-2 mb-md-4">
			<?php
			echo $this->Html->link('新規ユーザを作成', 'javascript:void(0)', ['class' => 'btn btn-primary px-3 px-sm-5', 'role' => 'button', 'data-action' => 'add']);
			?>
		</div>
	</div>
</div>
<div class="mb-2 mb-md-4">
	<table id="users" class="table table-striped">
		<thead>
			<tr>
				<th>ユーザID</th>
				<th>氏名</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($users as $user): ?>
				<tr>
					<td>
						<?php echo h($user['User']['USER_ID']); ?>
					</td>
					<td>
						<?php echo h($user['User']['NAME']); ?>
					</td>
					<td>
						<?php
						echo $this->Html->link('編集', 'javascript:void(0)', ['class' => 'btn btn-primary px-3 px-sm-5 mx-1', 'role' => 'button', 'data-action' => 'edit', 'data-id' => h($user['User']['USER_ID'])]);
						echo $this->Html->link('削除', 'javascript:void(0)', ['class' => 'btn btn-primary px-3 px-sm-5 mx-1', 'role' => 'button', 'data-action' => 'delete', 'data-id' => h($user['User']['USER_ID']), 'data-name' => h($user['User']['NAME'])]);
						?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<?php echo $this->Form->end(); ?>

<script type="text/javascript">
<!--
$(document).ready(function() {
    $('#users').dataTable({});
});
$('a[data-action="add"]').click(function() {
	$('form').attr('action', <?php echo "'" . $this->Html->url(['action' => 'add']) . "'"; ?>);
	$('form').submit();
});
$('a[data-action="edit"]').click(function() {
	$('#txtTargetUserId').val($(this).data('id'));
	$('form').attr('action', <?php echo "'" . $this->Html->url(['action' => 'edit']) . "'"; ?>);
	$('form').submit();
});
$('a[data-action="delete"]').click(function() {
	targetName = $(this).data('name');
	if (window.confirm(targetName + 'を削除します。よろしいですか？')) {
		$('#txtTargetUserId').val($(this).data('id'));
		$('form').attr('action', <?php echo "'" . $this->Html->url(['action' => 'delete']) . "'"; ?>);
		$('form').submit();
	}
});
-->
</script>
