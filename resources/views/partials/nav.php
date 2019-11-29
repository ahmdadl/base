<nav class="navbar navbar-expand-sm navbar-dark bg-primary shadow-sm text-light fixed-top <?= $navClass ?>">
    <div class="container">
        <a class="navbar-brand" href="/">
            NinjaCoder
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse navbar-sm-" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li>
                    <a class="nav-link <?= $this->uri('/') ? 'active' : '' ?>" href="<?= $this->uri('/') ? '#body' : '/' ?>"><?= $this->__('nav.portfolio') ?></a>
                </li>
                <li>
                    <a class="nav-link <?= $this->uri('/blog/posts') ? 'active' : '' ?>" href="/blog/posts"><?= $this->__('nav.blog') ?></a>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->

                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        </span>
                        <img class="img d-inline rounded-circle pr-1" src='http://ft.test/img/user.png' width="35" height="35">
                        <?= $session->get('userName') ?> <span class="caret"></span>
                    </a>

                    <?php if ($session->has('admin')) : ?>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/logout" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <?= $this->__('user.logout') ?>
                            </a>

                            <form id="logout-form" action="/root/logout" method="POST" style="display: none;">
                                <?= $this->csrf() ?>
                            </form>
                        </div>
                    <?php endif ?>
                </li>

            </ul>
        </div>
    </div>
</nav>