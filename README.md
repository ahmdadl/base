# PHP Simple Framework
#### Learning PHP OOP

### Features:
* [Fast Route](https://github.com/nikic/fast-route)
* [Symfony Dependency Injection](https://github.com/symfony/dependency-injection)
* [Plates - Template System](https://github.com/league/plates)
* [Validation](https://github.com/respect/validation)
* [Testing- PhpUnit](https://github.com/phpunit/phpunit)
  
### Examples:
File: routes/web.php
```php
$r->get('/', ['HomeController@index']);
$r->post(
    '/',
    [
        'PostController@store',
        'middlewares' => ['CsrfVerify']
    ]
);
```
File: src/Controllers/HomeController.php
```php
<?php declare (strict_types=1);

namespace App\Controllers;

use App\View\FrontRenderInterface;
use App\Util\AppSession;

class HomeController
{
    private $view;
    private $session;

    public function __construct(
        FrontRenderInterface $view,
        AppSession $session
    )
    {
        $this->view = $view;
        $this->session = $session;
        $this->session->sessStart();
    }
}

public function index(array $param = [])
{
    return $this->view->render('[view_name]', [
        'data' => ModelData::all()
    ]);
}
```
File: resources/views/home.php
```html
<?php $this->layout('layout', ['title' => 'Home Page']);?>

<ul>
    <?php foreach($data as $row): ?>
    <li><?=$this->e($row->name)?></li>
    <form action='' method='post'>
        <?=$this->_method('put')?>
        <?=$this->csrf()?>
        <input type='text' name='name'/>
        <input type='submit' value='submit' />
    </form>
    <?php endforeach; ?>
</ul>
```


