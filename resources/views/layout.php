<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <base href="/fc/public/" />
    <title><?=$this->e($title)?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="<?=$this->asset('assets/css/app.css')?>" rel="stylesheet" type="text/css">
    <link rel="icon" href="">
</head>
<body>
    <main class="container-fluid">
        <?=$this->insert('partials/nav', ['name' => $name,
    'hashid' => $hashid])?>
        <?=$this->section('list')?>
        <?=$this->section('content')?>
        <?=$this->insert('partials/footer')?>
    </main>
    <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=es6"></script>
    <script src="<?=$this->asset('assets/js/bootstrap-native-v4.min.js')?>"></script>
    <script src="<?=$this->asset('assets/js/app.js')?>"></script>
</body>
</html>