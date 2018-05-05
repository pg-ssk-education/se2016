<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>
            <?php echo $title_for_layout . ':社内事務効率化ツール'; ?>
        </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <?php
        echo $this->Html->css(['cmn', 'bootstrap', 'bootstrap-responsive', 'jquery.dataTables.min']);
        echo $this->fetch('meta');
        echo $this->fetch('css');
        ?>
    </head>

    <body>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <h4>
                    <?php echo $this->Html->link(__('社内事務効率化ツール'), '/CMN1000/index', ['class' => 'brand', 'style' => 'margin:0 5px;']); ?>
                </h4>
                <?php if ($this->Session->check('loginUserId')): ?>
                    <ul class="nav">
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown">メニュー<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><?php echo $this->Html->link('ユーザ管理', '/CMN2000/index', []) ?></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav pull-right">
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown"><?php echo h($this->Session->read('loginUserId')); ?><span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <!--<li><a href="google.co.jp">個別設定</a></li>-->
                                <li><?php echo $this->Html->link('ログアウト', '/CMN1000/logout', []) ?></li>
                            </ul>
                        </li>
                    </ul>
                <?php endif; ?>
            </div>
        </div>

        <div class="container-fluid">
            <?php if ($this->Session->check('Message.alert-notice') || $this->Session->check('Message.alert-success') || $this->Session->check('Message.alert-error')): ?>
                <section id="alerts">
                    <?php
                    echo $this->Session->flash('alert-notice');
                    echo $this->Session->flash('alert-success');
                    echo $this->Session->flash('alert-error');
                    ?>
                </section>
            <?php endif; ?>
            <?php echo $this->fetch('content'); ?>
            <div class="row">
                <div class="page-footer">
                    <div>
                        &copy;CSC-Osaka Education Team
                    </div>
                </div>
            </div>
        </div>

        <?php echo $this->Html->script(['jquery-3.2.1', 'bootstrap', 'jquery.dataTables.min']); ?>
        <script>
            $(".dropdown-toggle").dropdown();
        </script>

        <?php
        echo $this->Html->script(['cmn']);
        echo $this->fetch('script');
        ?>

    </body>
</html>
