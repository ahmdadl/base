<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$this->e($title)?></title>
    <link href="assets/css/app.css" rel="stylesheet" type="text/css">
    <link rel="icon" href="">
</head>
<body>
    <?=$this->section('list')?>
    <?=$this->section('content')?>
    <?=$this->insert('partials/footer')?>
    <script src="assets/js/app.js"></script>
</body>
</html>