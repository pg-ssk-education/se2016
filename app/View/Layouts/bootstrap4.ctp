<!doctype html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php
    echo $this->fetch('meta');
    echo $this->Html->css(['bootstrap.min', 'bootstrap-grid.min', 'open-iconic-bootstrap.min', 'datatables.min', 'cmn']);
    echo $this->fetch('css');
    ?>
    <title>
        <?php echo $title_for_layout . ':社内事務効率化ツール'; ?>
    </title>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-light bg-light fixed-top">
        <?php echo $this->Html->link(__('大阪営業所事務効率化ツール'), '/CMN1000/index', ['class' => 'brand', 'style' => 'margin:0 5px;']); ?>
        <?php if (isset($loginUser)): ?>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#Navbar" aria-controls="Navbar" aria-expanded="false" aria-label="レスポンシブ・ナビゲーションバー">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="Navbar">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navDropdownFncMenu" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">メニュー</a>
                        <div class="dropdown-menu" aria-labelledby="navDropdownFncMenu">
                            <a class="dropdown-item" href="#">週報</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">交通費</a>
                            <a class="dropdown-item" href="#">出張費</a>
                        </div>
                    </li>
                    <?php if ($loginUser->belongToGroup('admin')): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navDropdownMngMenu" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">管理機能</a>
                            <div class="dropdown-menu" aria-labelledby="navDropdownMngMenu">
                                <a class="dropdown-item" href="#">ユーザ管理</a>
                                <a class="dropdown-item" href="#">グループ管理</a>
                                <a class="dropdown-item" href="#">ワークフロー管理</a>
                            </div>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navDropdownUsrMenu" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="oi oi-person" title="person" aria-hidden="true"></span>ログインユーザ名
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navDropdownUsrMenu">
                            <a class="dropdown-item" href="#">プロフィール編集</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">ログアウト</a>
                        </div>
                    </li>
                </ul>
            </div>
        <?php endif; ?>
    </nav>

    <?php if ($this->Session->check('Message.alert-notice') || $this->Session->check('Message.alert-success') || $this->Session->check('Message.alert-error')): ?>
        <div class="container-fluid">
            <section id="alerts">
                <?php
                echo $this->Session->flash('alert-notice');
                echo $this->Session->flash('alert-success');
                echo $this->Session->flash('alert-error');
                ?>
            </section>
        </div>
    <?php endif; ?>
    <?php echo $this->fetch('content'); ?>
    <footer class="fixed-bottom">
        <div class="container-fluid comet-footer">
            <div class="row">
                <div class="col-12">
                    <div class="text-center">
                        &copy;CSC Osaka Education Team
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <?php
    echo $this->Html->script(['jquery-3.2.1.min', 'bootstrap.min', 'bootstrap.bundle.min', 'dataTables.min', 'cmn']); ?>
    echo $this->fetch('script');
    ?>
</body>
</html>
