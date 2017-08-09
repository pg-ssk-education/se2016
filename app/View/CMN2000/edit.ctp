<div class="page-content">
  <div class="container">
    <input type="button" id="btnAdd" name="btnAdd" value="追加">
    <input type="button" id="btnEdit" name="btnEdit" value="編集">
    <input type="button" id="btnDelete" name="btnDelete" value="削除">
  </div>
  <div class="container">
    <table>
      <tr>
        <td>
          <div class="table-simple-header table-simple-header-design">
            <table>
              <thead>
                <tr>
                  <th class="col-select">
                    &nbsp;
                  </th>
                  <th class="col-user-id">
                    ユーザID
                  </th>
                  <th class="col-name">
                    氏名
                  </th>
                  <th class="col-mail-address">
                    メールアドレス
                  </th>
                </tr>
              </thead>
            </table>
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="table-simple-body table-simple-body-design">
            <table>
              <tbody>
                <?php foreach($users as $user): ?>
                  <tr>
                    <td class="col-select">
                      <input type="checkbox" id="<?php echo h($user['User']['USER_ID']); ?>" />
                    </td>
                    <td class="col-user-id">
                      <?php echo h($user['User']['USER_ID']); ?>
                    </td>
                    <td class="col-name">
                      <?php echo h($user['User']['NAME']); ?>
                    </td>
                    <td class="col-mail-address">
                      <?php echo h($user['User']['MAIL_ADDRESS']); ?>
                    </td>
                  </tr>
                <? endforeach; ?>
              </tbody>
            </table>
          </div>
        </td>
      </tr>
    </table>
  </div>
</div>
