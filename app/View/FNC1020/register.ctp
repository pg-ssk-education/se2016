<?php
echo $this->Form->create(false, ['url' => ['controller' => 'FNC1020', 'action' => 'register']]);
?>
        <div class="container-fluid">
            <div class="row">
                
                <?php
                echo $this->Form->input(
                 'txtTitle','type' => 'text', 'class' => 'form-control',
                 'label' =>['text' => 'タイトル'],
                 'div' => ['class' => 'form-group col-12 col-sm-6 col-md-4 mb-2 mb-md-4']); ?>
                <?php
                echo $this->Form->input(
                 'txtContent','type' => 'text', 'class' => 'form-control',
                 'label' =>['text' => '本文'],
                 'div' => ['class' => 'form-group col-12 mb-2 mb-md-4']); ?>
                <?php
                echo $this->Form->input(
                 'txtChoices','type' => 'text', 'class' => 'form-control',
                 'label' =>['text' => '※カンマ区切りで入力してください。'],
                 'div' => ['class' => 'form-group col-12 mb-2 mb-md-4']); ?>
            </div>
            <div class="row">
                <div class="form-group col-12 col-sm-6 col-md-4 mb-2 mb-md-4">
                <?php
                echo $this->Form->input(
                 'txtFrom','type' => 'text', 'class' => 'form-control','placeholder' => 'yyyy/mm/dd',
                 'label' =>['for' => 'txtFrom', 'class' => 'cmn-required', 'text' => '有効期限&nbsp;From'],
                 'div' => ['class' => 'input-group date'], 'id' => 'datepicker1'); ?>
                 <span class="input-group-addon">
                 <span class="glyphicon glypicon-calendar"></span>
                 </span>
                </div>
                
                <div class="form-group col-12 col-sm-6 col-md-4 mb-2 mb-md-4">
                    <?php
                    echo $this->Form->input(
                     'txtFrom','type' => 'text', 'class' => 'form-control','placeholder' => 'yyyy/mm/dd',
                     'label' =>['for' => 'txtTo', 'class' => 'cmn-required', 'text' => 'To'],
                     'div' => ['class' => 'input-group date'], 'id' => 'datepicker2'); ?>
                     <span class="input-group-addon">
                     <span class="glyphicon glypicon-calendar"></span>
                     </span>
                </div>
                
            </div>
            
            <div class="row">
                
                <?php
                echo $this->Form->input(
                 'txtPassword','type' => 'text', 'class' => 'form-control',
                 'label' =>['text' => '管理用パスワード'],
                 'div' => ['class' => 'form-group col-12 col-sm-6 col-md-4 mb-2 mb-md-4']); ?>
                
                <?php
                echo $this->Form->input(
                 'txtRetype','type' => 'text', 'class' => 'form-control',
                 'label' =>['text' => '確認'],
                 'div' => ['class' => 'form-group col-12 col-sm-6 col-md-4 mb-2 mb-md-4']); ?>
                
            </div>
            <div class="row">
                 <div class="col-12 mb-2 mb-md-4">
                 <?php
                 echo $this->Html->link('登録', '#', ['class' => 'btn btn-primary px-3 px-sm-5', 'role' => 'button', 'data-action' => 'save']);
                 ?>
                 </div>
            </div>
        </div>
<?php echo $this->Form->end(); ?>