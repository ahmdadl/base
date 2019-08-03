<nav class="home-menu pure-menu pure-menu-horizontal">
    <a class="pure-menu-heading pure-menu-link <?= $this->uri('/', 'active')?>" href='/ft/public/'>Home</a>
    <ul class="pure-menu-list">
        <li class="pure-menu-item <?=$this->uri('/about', 'class="active"')?>">
            <a class="pure-menu-link" href='about'>About</a>
        </li>
        <li class="pure-menu-item">
        <?php if (!$hasSession) : ?>
                <a class="pure-menu-link pure-button button-success" href='logIn'>SignIn</a>
        <?php else : ?>
                <a class="pure-menu-link pure-button button-danger" href='/ft/public/logOut'>SignOut</a>
        <?php endif?>
        </li>
    </ul>
</nav>