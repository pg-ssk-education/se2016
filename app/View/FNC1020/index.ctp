<?php
echo $this->Html->script('datatables.min', ['inline' => false]);
echo $this->Form->create(false, ['url' => ['action' => 'index']]);
echo $this->Form->create(false, ['url' => ['controller' => 'FNC1020', 'action' => 'index']]);
?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 mb-2 mb-md-4">
                    <span class="h2"><u>最新技術発表</u></span>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-2 mb-md-4">
                    <span>どのグループに投票しますか？</span>
                </div>
            </div>
            <div class="row">
            
            <?php
                  echo $this->Form->input(
                   'txtRadio', array(
                   'legend' => false,
                   'type' => 'radio',
                   'options' => array('Aチーム', 'Bチーム', 'Cチーム', 'Dチーム'),
                   'div' => ['class' => 'form-group col-12 mb-2 mb-md-4'],
                   'before' => '<div class="radio">',
                   'after' => '</div>',
                   'separator' => '</div><div class="radio">'));
                 ?>
            </div>
            <div class="row">
                <div class="form-group col-12 mb-2 mb-md-4">
                    <?php 
                    echo $this->Html->link(
                    '投票', '#', [
                    'class' => 'btn btn-primary px-3 px-sm-5', 
                    'role' => 'button', 
                    'data-action' => 'select']);
                    ?>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12 mb-2 mb-md-4">
                    <span>投票結果を確認する</span>
                </div>
            </div>
            <div class="row">
                 <?php
                  echo $this->Form->input(
                   'txtPassword', [
                   'type' => 'text',
                   'class' => 'form-control',
                   'label' => ['text' => '管理用パスワード'],
                   'div' => ['class' => 'form-group col-12 mb-2 mb-md-4']
                 ]);
                 ?>
            </div>
            <div class="row">
                <div class="form-group col-12 mb-2 mb-md-4">
                    <?php 
                    echo $this->Html->link(
                    '確認', '#', [
                    'class' => 'btn btn-primary px-3 px-sm-5', 
                    'role' => 'button', 
                    'data-action' => 'resule']);
                    ?>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12 mb-2 mb-md-4">
                    <span>QRコードを表示する</span>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-12 mb-2 mb-md-4">
                    <?php 
                    echo $this->Html->link(
                    '表示', '#', [
                    'class' => 'btn btn-primary px-3 px-sm-5', 
                    'role' => 'button', 
                    'data-action' => 'qr']);
                    ?>
                </div>
            </div>
        </div>
    </form>
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/dataTables.min.js"></script>
    <script src="../js/cmn.js"></script>
    <script>
        //<![CDATA[
        $(document).ready(function() {
            $('#notifications').dataTable({
                lengthChange: false,
                searching: false,
                ordering: false,
                info: false,
                paging: false
            });
        });
        //]]>
    </script>
</body>

</html>
