<?php
echo $this->Form->create(false,['controller'=>'CMN2000','action'=>'action']);
echo $this->Html->script('CMN2000.js',['inline'=>false]);
?>
<div class="page-content">

  <div class="container">
    <input type="button" id="btnAdd"   name="btnAdd"   value="追加">mi
    <input type="button" id="btnEdit"   name="btnEdit"   value="編集">
    <input type="button" id="btnDelete"   name="btnDelete"   value="削除">
    <?php 
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
          <?php foreach ($wfRoutes as $wfRoute): ?>
            <tr>
              <td class="col-select">
                <input type="checkbox" id="selected[0]" name="selected[0]" value=0>
              </td>
              <td class="col-wf-route-id">
                <?php echo h($wfRoute['WfRoute']['WF_ROUTE_ID']);?>
              </td>
              <td class="col-wf-route-name">
                <?php echo h($wfRoute['WfRoute']['WF_ROUTE_NAME']);?>
              </td>
              <td class="col-route">
                <?php echo h($wfRouteTable[$wfRoute['WfRoute']['WF_ROUTE_ID']]);?>
              </td>
            </tr>
           <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </td></tr></table>
  </div>
</div>