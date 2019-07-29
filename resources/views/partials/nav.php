<nav class="home-menu pure-menu pure-menu-horizontal">
    <a class="pure-menu-heading pure-menu-link <?= $this->uri('/', 'active')?>" href='/ft/public/'>Home</a>
    <ul class="pure-menu-list">
        <li class="pure-menu-item <?=$this->uri('/about', 'class="active"')?>">
            <a class="pure-menu-link" href='/ft/public/about'>About</a>
        </li>
    </ul>
</nav>