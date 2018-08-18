<?php
echo $this->Html->script('datatables.min', ['inline' => false]);
echo $this->Html->script('jquery.qrcode.min', ['inline' => false]);
echo $this->Form->create(false, ['url' => ['controller' => 'FNC1020', 'action' => 'qr']]);
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-2 mb-md-4 text-center text-truncate">
            <?php echo $this->Html->url(['action' => 'index', '?' =>['id' => $id], 'full_base' => true]);  ?>
        </div>
    </div>
    <div class="row">
        <div class="col-10 offset-1 mb-2 mb-md-4 text-center">
            <div class="img-fluid" id="qrcode"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mb-2 mb-md-4 text-center">
            <?php echo $this->Html->link('投票ページに戻る', ['controller' => 'FNC1020', 'action' => 'index', '?' => ['id' => $id]], ['class' => 'btn btn-primary px-3 px-sm-5', 'role' => 'button']); ?>
        </div>
    </div>
</div>
<script>
//<![CDATA[
$(document).ready(function(){
    $('#qrcode').qrcode({
        background:'#ffffff',
        foreground:'#000080',
        text      :<?php echo "'" . $this->Html->url(['action' => 'index', '?' =>['id' => $id], 'full_base' => true]) . "'"; ?>,
    });
});
//]]>
</script>