<?php
class NavbarHelper extends Helper {
	var $helpers = array('Html');
	
	public function output() {
		$logined = false;
		$admin = false;
		if (isset($userInfo)) {
			$logined = true;
			
			if ($userInfo['UserLevel'] == 1) {
				$admin = true;
			}
		}
		
		$this->output( ?>
			<nav class="navbar navbar-inverse">
				<div class="navbar-header">
					<?php if($logined): ?>
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#gnavi">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
					<?php endif; ?>
					<?php echo $this->Html->link('事務効率化ツール', ['controller'=>'CMN1000']); ?>
				</div>
				<?php if($logined): ?>
					<div id="gnavi" class="collapse navbar-collapse">
						<ul class="nav navbar-nav">
							<?php if($admin): ?>
								<li><a href="#" class="dropdown-toggle" data-toggle="dropdown">管理メニュー<b class="caret"></b></a>
									<ul class="dropdown-menu">
										<li><?php echo $this->Html->link('ユーザ管理', ['controller'=>'CMN1020', 'action'=>'index']); ?></li>
									</ul>
								</li>
							<?php endif; ?>
							<li><?php echo $this->Html->link('申請', ['controller'=>'DOC2000', 'action'=>'index']); ?></li>
						</ul>
					</div>
				<?php endif; ?>
			</nav>
		<?php
	}
}
