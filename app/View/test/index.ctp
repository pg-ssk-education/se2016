<?php

/**
	CMN0101
*/

?>
	<head>
		
		
		<title>トップページ</title>
	</head>

	<body>
		<div class="page-header page-header-design">
			<div class="menu">
				<table>
					<tr>
						<td>
							<select id="sltMenu" name="sltMenu" onchange="location.href=this.options[selectedIndex].value">
								<option value="">ページを選択
								<option value="CMN2000.htm">マスタメンテナンス
								<option value="DOC2000.htm">申請承認・申請
								<option value="DOC3000.htm">申請承認・確認
								<option value="CMN3000.htm">パスワード変更
							</select>
						</td>
					</tr>
				</table>
			</div>
			
			<div class="logout">
				<table>
					<tr>
						<td>
							<input type="button" onclick="location.href='CMN1000.htm'" id="btnLogout" name="btnLogout" value="ログアウト">
						</td>
					</tr>
				</table>
			</div>
		</div>
		
		<br>
		<div class="page-content" style="font-size:14pt; padding-left:10px">大阪　太郎　さん
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
					<tr>
						<td style="text-align:center">
							20160001
						</td>
						<td style="text-align:center">
							2016年5月 出張費
						</td>
						<td>
							申請理由：東京出張が発生したため
						</td>
					</tr>
					<tr>
						<td style="text-align:center">
							20160013
						</td>
						<td style="text-align:center">
							2016年7月 交通費費
						</td>
						<td>
							申請理由：システムの受け入れでユーザー様を訪問したため
						</td>
					</tr>
					<tr>
						<td style="text-align:center">
							20160020
						</td>
						<td style="text-align:center">
							帰省費
						</td>
						<td>
							
						</td>
					</tr>
				</table>
			</div>
		</div>
		
		<div class="page-footer page-footer-design">
			<table class="copyright">
				<tr>
					<td>
						&copy;CSC-Osaka Education Team.
					</td>
				</tr>
			</table>
		</div>
	</body>
