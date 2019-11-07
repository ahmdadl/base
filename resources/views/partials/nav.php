<nav
    class="navbar navbar-expand-sm navbar-dark bg-primary shadow-sm text-light">
    <div class="container">
        <a class="navbar-brand" href="/">
            MyBlog
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse"
            data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse navbar-sm-"
            id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li>
                    <a class="nav-link {{request()->is('posts') ? 'active' : ''}}"
                        href="/posts">Posts</a>
                </li>
                <li>
                    <a class="nav-link {{request()->is('posts/create') ? 'active' : ''}}"
                        href="/posts/create">Create</a>
                </li>
                <li>
                    <a class="nav-link {{request()->is('category/create') ? 'active' : ''}}"
                        href="/category/create">Ccategory</a>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                <?php if($session->has('userName')) : ?>
                <li class="nav-item">
                    <a class="nav-link"
                        href="/login">Login</a>
                </li>
                <?php if (true) : ?>
                <li class="nav-item">
                    <a class="nav-link"
                        href="/register">Register</a>
                </li>
                <?php endif ?>
                <?php else : ?>
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle"
                        href="#" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false" v-pre>
                            <?=$session->get('userName')?>
                        </span>
                        <img class="img d-inline rounded-circle pr-1"
                            src='http://ft.test/img/user.png' width="35"
                            height="35">
                            <?=$session->get('userName')?> <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right"
                        aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/logout"
                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="/logout"
                            method="POST" style="display: none;">
                            <?=$this->csrf()?>
                        </form>
                    </div>
                </li>
                <?php endif ?>
            </ul>
        </div>
    </div>
</nav>