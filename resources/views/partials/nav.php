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
                <?php if (!$session->has('admin')) : ?>
                <li class="nav-item">
                    <span id="navbarDropdown" class="nav-link active">
                        <img class="img d-inline rounded-circle pr-1" src='/assets/img/me.jpeg' width="35" height="35">
                        Ahmed Adel
                    </span>
                </li>
                <?php else : ?>
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <img class="img d-inline rounded-circle pr-1" src='/assets/img/me.jpeg' width="35" height="35">
                        Ahmed Adel
                        <span class="caret <?= $session->has('admin') ? '' : 'd-none' ?>"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/logout" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <?= $this->__('user.logout') ?>
                            </a>

                            <form id="logout-form" action="/root/logout" method="POST" style="display: none;">
                                <?= $this->csrf() ?>
                            </form>
                    </div>
                </li>
                <?php endif ?>
            </ul>
        </div>
    </div>
</nav>