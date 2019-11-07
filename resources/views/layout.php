<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="/ft/public/" />
    <title><?=$this->e($title)?></title>
    <link href="/assets/css/app.css" rel="stylesheet" type="text/css">
    <link rel="icon" href="">
</head>
<body>
    <?=$this->insert('partials/nav')?>
    <main class="container">
        <?=$this->section('list')?>
        <?=$this->section('content')?>
        <?=$this->insert('partials/footer')?>
    </main>
    <script src='/assets/js/bootstrap-native-v4.min.js'></script>
    <script src="/assets/js/app.js"></script>
</body>
</html>