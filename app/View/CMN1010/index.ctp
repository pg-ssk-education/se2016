<?php
	
	echo $this->Form->create(false, ['controller'=>'CMN1010', 'action'=>'action']);
	//echo $this->Form->create(false, ['url' => ['controller'=>'CMN1010', 'action'=>'action']]);
	echo $this->Html->script('CMN1010.js', ['inline' => false]);

?>

<div class="page-content" style="font-size:14pt; padding-left:10px"><?php echo $loginUserName ?>
	<br><br>
	申請書一覧
	<br><br>
	<div class="page-block">
		<div class="table-simple" name="lstInfo">
		
			
			<?php 
			
			echo $this->Form->input('class1', array('type' => 'checkbox', 'label' => '情報'));
			echo $this->Form->input('class2', array('type' => 'checkbox', 'label' => '注意'));
			echo $this->Form->input('class3', array('type' => 'checkbox', 'label' => '警告'));
			echo $this->Form->input('class4', array('type' => 'checkbox', 'label' => '確認済み'));
			
			echo $this->Form->submit('再表示', array('name' => 'reload'));
			//echo $this->Form->button('再表示', ['name' => 'reload', 'type' => 'button']);
			echo $this->Form->hidden('hidAction');
			
			
			
			//$options = array('1' => '情報', '2' => '注意', '3' => '警告');
			
			//echo $this->Form->input('', array(
			//	'type' => 'select',
			//	'multiple' => 'checkbox',
			//	'options' => $options
			//));
			 ?>
			<br>
			 
			<?php echo $this->Form->submit('確認', array('name' => 'confirm')); ?>
			<br>
			
			<table border="1" cellpadding="0" cellspacing="0" width="80%">
				<thead>
					<tr>
						<th>
							<div class="CMN1010-col-info">
								
							</div>
						</th>
						<th>
							<div class="CMN1010-col-info">
								レベル
							</div>
						</th>
						<th>
							<div class="CMN1010-col-info">
								コメント
							</div>
						</th>
						<th>
							<div class="CMN1010-col-info">
								確認
							</div>
						</th>
						<th>
							<div class="CMN1010-col-info">
								遷移
							</div>
						</th>
						
					</tr>
				</thead>
				<tbody>
					<?php foreach ($notifications as $notification) { ?>
					<tr>
						<td>
							<div class="CMN1010-col-info col-text">
								<?php echo $this->Form->input('class1', array('type' => 'checkbox', 'label' => '')); ?>
							</div>
						</td>
						<td>
							<div class="CMN1010-col-info col-text">
								<?php echo h($notification['Notification']['LEVEL']); ?>
							</div>
						</td>
						<td>
							<div class="CMN1010-col-info col-text">
								<?php echo h($notification['Notification']['COMMENT']); ?>
							</div>
						</td>
						<td>
							<div class="CMN1010-col-info col-text">
								<?php echo h($notification['Notification']['CONFIRMED']); ?>
							</div>
						</td>
						<td>
							<div class="CMN1010-col-info col-text">
								<?php echo h($notification['Notification']['FUNCTION_ID']); ?>
							</div>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<br>
<hr>	
<?php echo $this->Form->end(); ?>

