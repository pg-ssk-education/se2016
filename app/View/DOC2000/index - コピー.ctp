<?php
	echo $this->Html->css('DOC2000');
	echo $this->Html->script('DOC2000.js');

?>
	<div class="page-content">
		<div class="container">
			<table>
				<tr>
					<td>
						<label>文書タイプ</label>
					</td>
					<td>
						<select name="hogehoge">
						 <option value="commute">交通費清算書</option>
						 <option value="businessTrip">出張費（仮払申請書）</option>
						 <option value="licenseAllowance">資格手当申請書</option>
						 <option value="other">その他</option>
					</td>
				</tr>
				<tr>
					<td class="col-check" colspan="2">
						<input type="checkbox" name="" value="befApplication">
							申請前
						<input type="checkbox" name="" value="approvalIn">
							承認中
						<input type="checkbox" name="" value="approved">
							承認済
						<input type="checkbox" name="" value="rejection">
							却下
					</td>
				</tr>
				<tr>
					<td>
						<input type="button" id="btnSearch" name="btnSearch" value="検索">
					</td>
					<td>
						<input type="button" id="btnNew" name="btnNew" value="新規">
					</td>
				</tr>
			</table>
		</div>
		<hr>
		<div class="container">
		<table>
			<tr>
				<td>
					<input type="button" id="btnDisplay" name="btnDisplay" value="表示">
				</td>
				<td>
					<input type="button" id="btnEdit" name="btnEdit" value="編集">
				</td>
				<td>
					<input type="button" id="btnDelete" name="btnDelete" value="削除">
				</td>
			</tr>
		</table>
		<table>
			<tr>
				<td>
				<div class="table-simple-header table-simple-header-design">
					<table style="border:solid 1px">
						<thead>
							<tr>
								<th style="border:solid 1px">
									&nbsp;
								</th>
								<th style="border:solid 1px">
									作成日時
								</th>
								<th style="border:solid 1px">
									hogehoge
								</th>
								<th style="border:solid 1px">
									hogehoge2
								</th>
								<th style="border:solid 1px">
									hogehoge3
								</th>
								<th style="border:solid 1px">
									hogehoge5
								</th>
							</tr>
							<tr>
								<td style="border:solid 1px">
									<input type="checkbox" name="" value="">
								</td>
								<td style="border:solid 1px">
									hogehoge
								</td>
								<td style="border:solid 1px">
									hogehoge
								</td>
								<td style="border:solid 1px">
									hogehoge
								</td>
								<td style="border:solid 1px">
									hogehoge
								</td>
								<td style="border:solid 1px">
									hogehoge
								</td>
							</tr>
							<tr>
								<td style="border:solid 1px">
									<input type="checkbox" name="" value="">
								</td>
								<td style="border:solid 1px">
									hogehoge
								</td>
								<td style="border:solid 1px">
									hogehoge
								</td>
								<td style="border:solid 1px">
									hogehoge
								</td>
								<td style="border:solid 1px">
									hogehoge
								</td>
								<td style="border:solid 1px">
									hogehoge
								</td>
							</tr>
							<tr>
								<td style="border:solid 1px">
									<input type="checkbox" name="" value="">
								</td>
								<td style="border:solid 1px">
									hogehoge
								</td>
								<td style="border:solid 1px">
									hogehoge
								</td>
								<td style="border:solid 1px">
									hogehoge
								</td>
								<td style="border:solid 1px">
									hogehoge
								</td>
								<td style="border:solid 1px">
									hogehoge
								</td>
							</tr>
							<tr>
								<td style="border:solid 1px">
									<input type="checkbox" name="" value="">
								</td>
								<td style="border:solid 1px">
									hogehoge
								</td>
								<td style="border:solid 1px">
									hogehoge
								</td>
								<td style="border:solid 1px">
									hogehoge
								</td>
								<td style="border:solid 1px">
									hogehoge
								</td>
								<td style="border:solid 1px">
									hogehoge
								</td>
							</tr>
							<tr>
								<td style="border:solid 1px">
									<input type="checkbox" name="" value="">
								</td>
								<td style="border:solid 1px">
									hogehoge
								</td>
								<td style="border:solid 1px">
									hogehoge
								</td>
								<td style="border:solid 1px">
									hogehoge
								</td>
								<td style="border:solid 1px">
									hogehoge
								</td>
								<td style="border:solid 1px">
									hogehoge
								</td>
							</tr>
						</thead>
					</table>
<!--					
					<table>
						<thead>
							<tr>
								<th class="col-check">
									&nbsp;
								</th>
								<th class="col-division">
									区分
								</th>
								<th class="col-comment">
									コメント
								</th>
							</tr>
						</thead>
					</table>
				</div>
				<div class="table-simple-body table-simple-body-design">
					<table>
						<thead>
							<tr>
								<td class="col-check"></td>
								<td class="col-division"></td>
								<td class="col-comment"></td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="col-check">
									<input type="radio" name="doc" value="commute" checked>
								</td>
								<td>
									<label for="radio">交通費清算書</label>
								</td>
								<td>
									<label for="radio">hogehoge</label>
								</td>
							</tr>
							<tr>
								<td class="col-check">
									<input type="radio"  name="doc" value="businessTrip">
								</td>
								<td>
									<label for="radio">出張費（仮払申請書）</label>
								</td>
								<td>
									<label for="radio">hogehoge</label>
								</td>
							</tr>
							<tr>
								<td class="col-check">
									<input type="radio" name="doc" value="businessTrip">
								</td>
								<td>
									<label for="radio">資格手当申請書</label>
								</td>
								<td>
									<label for="radio">hogehoge</label>
								</td>
							</tr>
							<tr>
								<td class="col-check">
									<input type="radio" name="doc" value="other">
								</td>
								<td>
									<label for="radio">その他</label>
								</td>
								<td>
									<label for="radio">hogehoge</label>
								</td>
							</tr>
						</tbody>
					</table>
					-->
				</div>
				</td>
			</tr>
		</table>
	</div>
</div>
<?php echo $this->Form->end(); ?>
