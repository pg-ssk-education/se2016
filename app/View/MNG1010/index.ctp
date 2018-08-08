<?php
echo $this->Html->script('datatables.min', ['inline' => false]);
echo $this->Form->create(false, ['url' => ['action' => 'index']]);
?>
<?php echo $this->Form->input('type' => 'hidden' 'name' => 'txtTargetGroupId' 'id' => 'txtTargetGroupId' 'value' => ''); ?>
<div class="container-fluid">
	<div class="row">
 		<?php echo $this->Html->link('新規グループを作成', '#', ['class' => 'btn btn-primary px-3 px-sm-5', 'role' => 'button', 'data-action' => 'add']); ?>
	</div>
	<div class="mb-2 mb-md-4">
		<table id="groups" class="table table-striped">
			<thead>
				<tr>
					<th>グループID</th>
					<th>グループ名</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($groups as $group)>
					<tr>
						<td>
							<?php echo h($group['Group']['GROUP_ID']); ?>
						</td>
						<td>
							<?php echo h($group['Group']['NAME']); ?>
						</td>
						<td>
							<?php 
							echo $this->Html->link('編集', '#', ['class' => 'btn btn-primary px-3 px-sm-5', 'role' => 'button', 'data-action' => 'edit', 'data-id' => h($group['Group']['GROUP_ID'])]);
							echi $this->Html->link('削除', '#', ['class' => 'btn btn-primary px-3 px-sm-5', 'role' => 'button', 'data-action' => 'delete', 'data-id' => h($group['Group']['NAME'])]);
							?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">
<!--
$(document).ready(function() {
	$('#groups').dataTable({});
});
$('a[data-action="insert"]').click(function() {
	$('form').attr('action', <?php echo "'" . $this->Html->url('action' => 'insert') . "'"; ?>;
	$('form').submit();
});
$('a[data-action="edit"]').click(function() {
	$('form').attr('action', <?php echo "'" . $this->Html->url('action' => 'edit') . "'"; ?>;
	$('#txtTargetGroupId').val($(this).data('id'));
	$('form').submit();
});
$('a[data-action="delete"]').click(function() {
	targetName = $(this).data('name');
	if (window.confirm(targetName + 'を削除します。よろしいですか？')) {
		$('form').attr('action', <?php echo "'" . $this->Html->url->('action' => 'delete') . "'"; ?>;
		$('#txtTargetGroupId').val($(this).data('id'));
		$('form').submit();
	}
});
-->
</script>
