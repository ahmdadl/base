<?php declare(strict_types = 1);

namespace App;

require_once dirname(__DIR__) . '/vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

$client = new Client();

$res = $client->requestAsync('GET', 'https://laracasts.com/series/laravel-from-scratch-2018/episodes/1');

// echo $res->getStatusCode() . '<br>';

// echo $res->getHeader('content-type')[0] . '<br>';
echo "<pre style='word-wrap: break-word;word-break: break-all'>";

// echo htmlspecialchars($res->getBody()->getContents());
// $res->then(
//     function (ResponseInterface $s) {
//         echo $s->getStatusCode();
//     },
//     function (RequestException $e) {
//         echo $e->getMessage();
//     }
// );

$url = 'https://laracasts.com/series/laravel-from-scratch-2018/episodes/1';

function get_web_page($url)
{
    $user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';

    $options = array(

            CURLOPT_CUSTOMREQUEST  =>"GET",        //set request type post or get
            CURLOPT_POST           =>false,        //set to GET
            CURLOPT_USERAGENT      => $user_agent, //set user agent
            CURLOPT_COOKIEFILE     =>"cookie.txt", //set cookie file
            CURLOPT_COOKIEJAR      =>"cookie.txt", //set cookie jar
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        );

    $ch      = curl_init($url);
    curl_setopt_array($ch, $options);
    $content = curl_exec($ch);
    $err     = curl_errno($ch);
    $errmsg  = curl_error($ch);
    $header  = curl_getinfo($ch);
    curl_close($ch);

    $header['errno']   = $err;
    $header['errmsg']  = $errmsg;
    $header['content'] = $content;
    return $header;
}

    $result = get_web_page($url);

    $page = $result['content'];
    echo $page;
