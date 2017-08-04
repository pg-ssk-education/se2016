
<div class="page-content" style="font-size:14pt; padding-left:10px">$loginUserName
	<br><br>
	承認待ち申請書一覧
	<div class="page-block">
		<div class="table-simple" name="lstInfo">
			<table>
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

