<?php
	echo $this->Html->css('DOC2000');
	echo $this->Html->script('DOC2000.js');

?>
	
	<div class="page-header">
		<div class="menu">
			<table>
				<tr>
					<td>
						<b>文書タイプ</b>
						<select name="hogehoge">
							<option value="commute">交通費清算書</option>
							<option value="businessTrip">出張費（仮払申請書）</option>
							<option value="licenseAllowance">資格手当申請書</option>
							<option value="other">その他</option>
						</select>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="page-content">
		<div class="page-block">
			<input type="checkbox" name="" value="befApplication">
				申請前
			<input type="checkbox" name="" value="approvalIn">
				承認中
			<input type="checkbox" name="" value="approved">
				承認済
			<input type="checkbox" name="" value="rejection">
				却下
		</div>
		<div class="page-block">
			<input type="button" id="btnSearch" name="btnSearch" value="検索">
			<input type="button" id="btnNew" name="btnNew" value="新規">
		</div>
		<hr>
		<div class="page-block">
			<input type="button" id="btnDisplay" name="btnDisplay" value="表示">
			<input type="button" id="btnEdit" name="btnEdit" value="編集">
			<input type="button" id="btnDelete" name="btnDelete" value="削除">
		</div>
		<div class="page-block table-simple">
			<table>
				<thead>
					<tr>
						<th>
							
						</th>
						<th>
							<div style="width:200px">
								文書タイプ
							</div>
						</th>
						<th>
							<div style="width:120px">
								状態
							</div>
						</th>
						<th>
							<div style="width:120px">
								作成日時
							</div>
						</th>
						<th style="width:120px">
							<div style="width:120px">
								申請日時
							</div>
						</th>
						<th>
							<div style="width:250px">
								最終コメント
							</div>
						</th>
					</tr>
				</thead>
				<tbody style="overflow:scroll;">
					<tr>
						<td>
							<input type="checkbox" name="" value="">
						</td>
						<td>
							<div style="width:200px">
								交通費清算書
							</div>
						</td>
						<td>
							<div style="width:120px">
								承認中
							</div>
						</td>
						<td>
							<div style="width:120px">
								2017-07-10 20:50:55
							</div>
						</td>
						<td>
							<div style="width:120px">
								2017-07-10 22:23:00
							</div>
						</td>
						<td>
							<div style="width:250px">
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<input type="checkbox" name="" value="">
						</td>
						<td>
							出張費（仮払申請書）
						</td>
						<td>
							申請前
						</td>
						<td>
							2017-07-12 19:20:30
						</td>
						<td>
							2017-07-13 15:00:50
						</td>
						<td>
							
						</td>
					</tr>
					<tr>
						<td>
							<input type="checkbox" name="" value="">
						</td>
						<td>
							交通費清算書
						</td>
						<td>
							却下
						</td>
						<td>
							2017-07-12 20:50:55
						</td>
						<td>
							2017-07-13 22:23:00
						</td>
						<td>
							申請書類による不備のため差戻しします。
						</td>
					</tr>
					<tr>
						<td>
							<input type="checkbox" name="" value="">
						</td>
						<td>
							資格手当申請書
						</td>
						<td>
							承認済
						</td>
						<td>
							2017-07-15 20:50:55
						</td>
						<td>
							2017-07-15 22:23:00
						</td>
						<td>
							
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
