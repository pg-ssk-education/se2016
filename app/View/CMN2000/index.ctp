<?php
  echo $this->Html->script('CMN2000.js',['inline'=>true]);
  echo $this->Form->create(false,['controller'=>'CMN2000','action'=>'action']);
?>
<div class="page-content">
  <div class="container">
    <?php
      echo $this->Form->button('追加', ['name'=>'btnAdd']);
      echo $this->Form->button('編集', ['name'=>'btnEdit']);
      echo $this->Form->button('削除', ['name'=>'btnDelete']);
      echo $this->Form->hidden('hidAction');
    ?>
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
                      <input type="checkbox" name="check[]" value="<?php echo h($user['User']['USER_ID']); ?>" />
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
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </td>
      </tr>
    </table>
  </div>
</div>
