
<div class="page-content" style="font-size:14pt; padding-left:10px">$loginUserName
	<br><br>
	���F�҂��\�����ꗗ
	<div class="container table-border table-border-design">
		<table>
			<tr>
				<th style="width:130px">
					�\����ID
				</th>
				<th style="width:200px">
					�\������
				</th>
				<th style="width:500px">
					�R�����g
				</th>
			</tr>
			
			<?php foreach ($informations as $information): ?>
			
				<tr>
					<td style="text-align:center">
						<?php echo h($information['Information']['ID']); ?>
					</td>
					<td style="text-align:center">
						<?php echo h($information['Information']['NAME']); ?>
					</td>
					<td>
						<?php echo h($information['Information']['COMMENT']); ?>
					</td>
				</tr>
			
			<?php endforeach; ?>
			
			
		</table>
	</div>
</div>

