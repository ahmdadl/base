<?php declare(strict_types = 1);

$dir = 'D:\w3shools\bootstrap\getbootstrap.com\docs\4.3\utilities';

chdir($dir);

$arr = glob('*');

$search = '<link href="../../dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">';

$replace = '<link href="../../dist/css/bootstrap.min.css" rel="stylesheet">';

$js = '<script src="../../../../../code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>';
$jrep = '<script src="../../../../../code.jquery.com/jquery-3.3.1.slim.min.js"></script>';

$bs = '<script src="../../dist/js/bootstrap.bundle.min.js" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script>';
$brep = '<script src="../../dist/js/bootstrap.bundle.min.js"></script>';

$ss = '<link rel="icon" href="https://getbootstrap.com/docs/4.3/assets/img/favicons/favicon.ico">
<meta name="msapplication-config" content="https://getbootstrap.com/docs/4.3/assets/img/favicons/browserconfig.xml">';
$sad = '<script async src="../../../../../cdn.carbonads.com/carbon7e4a.js?serve=CKYIKKJL&amp;placement=getbootstrapcom" id="_carbonads_js"></script>';
$sg = '<script async src="../../../../../www.google-analytics.com/analytics.js"></script>';

echo '<pre>';
foreach ($arr as $d) {
    if (is_dir($d)) {
        
        chdir($d);
        $text = file_get_contents('index.html');
        $text = str_replace($search, $replace, $text);
        $text = str_replace($js, $jrep, $text);
        $text = str_replace($bs, $brep, $text);
        $text = str_replace($ss, '', $text);
        $text = str_replace($sad, '', $text);
        $text = str_replace($sg, '', $text);
        
        file_put_contents('index.html', $text);

        echo 'changing <b>'. $d. '</b> done'. "\n";

        // break;
        chdir('../');
    }
    
}