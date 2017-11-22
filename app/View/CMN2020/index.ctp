<?php
echo $this->Form->create(false,['controller'=>'CMN2020','action'=>'action']);
echo $this->Html->script('CMN2020.js',['inline'=>false]);
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
  <hr>
  <div class="container">
    <table><tr><td>
      <div class="table-simple-header table-simple-header-design">
        <table>
          <thead>
            <tr>
              <th class="col-select">
                &nbsp;
              </th>
              <th class="col-wf-route-id">
                ワークフロールートID
              </th>
              <th class="col-wf-route-name">
                ワークフロールート名
              </th>
              <th class="col-route">
                ルート
              </th>
            </tr>
          </thead>
        </table>
      </div>
      <div class="table-simple-body table-simple-body-design">
        <table>
          <tbody>
          <?php foreach($wfRouteTable as $wfRouteRow): ?>
            <tr>
              <td class="col-select">
                <?php echo $this->Form->input("selected[$i]", ['type' => 'checkbox', 'label' => '']);?>
              </td>
              <td class="col-wf-route-id">
                <?php echo h($wfRouteRow['Route'][['WfRoute']['WF_ROUTE_ID']]);?>
              </td>
              <td class="col-wf-route-name">
                <?php echo h($wfRouteRow['Route'][['WfRoute']['WF_ROUTE_NAME']);?>
              </td>
              <td class="col-route">
                <?php echo h($wfRouteRow['ApprovalUserNames']);?>
              </td>
            </tr>
           <?php endfor; ?>
          </tbody>
        </table>
      </div>
    </td></tr></table>
  </div>
</div>
<?php echo $this->Form->end(); ?>