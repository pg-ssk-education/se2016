
<div class="page-content" style="font-size:14pt; padding-left:10px">$loginUserName
	<br><br>
	承認待ち申請書一覧
	<div class="container table-border table-border-design">
		<table>
			<tr>
				<th style="width:130px">
					申請書ID
				</th>
				<th style="width:200px">
					申請書名
				</th>
				<th style="width:500px">
					コメント
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

