<nav class="navbar fixed-top navbar-expand-sm navbar-dark bg-primary">
  <a class="navbar-brand" href="/fc/public/">
    <b class="shadow-lg rounded px-1 mx-0" style="font-size: larger">N</b>aruto
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto my-1">
    <li class="nav-item active">
        <a class="nav-link" href="/fc/public/">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/">profile</a>
      </li>
      <li 
      class="nav-item <?=$session->has('logIn') ? 'd-none' : ''?>">
        <a class="nav-link" href="logIn">LogIn</a>
      </li>
    </ul>
  </div>
</nav>