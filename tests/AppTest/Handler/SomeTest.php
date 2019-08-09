<?php declare (strict_types=1);

namespace AppTest\Handler;

use PHPUnit\Framework\TestCase;
use App\DIContainer;
use Symfony\Component\HttpFoundation\Request;

final class SomeTest extends TestCase
{
    protected $container;

    protected $request;

    public function setUp() : void
    {
        $this->container = new DIContainer([]);
        $this->request = (new Request())::createFromGlobals();
    }

    public function testInstance() : void
    {
        $this->assertInstanceOf(DIContainer::class, $this->container);
        $this->assertInstanceOf(Request::class, $this->request);
        $this->assertNotEquals('asd', $this->request->server->get('PHP_SELF'));
    }

    /**
     * @dataProvider stringTobeEscaped
     *
     * @param string $exepcted
     * @param string $actual
     * @return void
     */
    public function testEs(string $exepcted, string $actual) : void
    {
        $es = function (string $str = '') {
            return htmlspecialchars(strip_tags(trim($str)), ENT_QUOTES);
        };

        $this->assertEquals($exepcted, $es($actual));
    }

    public function testMethod() : void
    {
        $method = function (string $method = 'post') {
            return '<input type="hidden" name="_method" value="' . strtoupper($method) . '" />';
        };

        $this->assertEquals($method('POST'), $method());
        $this->assertEquals($method('GET'), $method('GET'));
        $this->assertEquals($method('put'), $method('PUT'));
        $this->assertNotEquals($method('put'), $method('delete'));
    }

    /**
     * @dataProvider HtmlText
     *
     * @param string $exepcted
     * @param string $actual
     * @return void
     */
    public function testSpaceless(
        string $exepcted,
        string $actual
    ) : void {
        $sanitize = function (string $str) {
            $search = [
                '/>\s+</',
                '/(\s)+/s',
                '/<!--(.|\s)*?-->/'
            ];
            $replace = [
                '><',
                '\\1',
                ''
            ];
            return trim(preg_replace($search, $replace, $str));
        };

        $this->assertEquals($exepcted, $sanitize($actual));
    }

    public function stringTobeEscaped() : array
    {
        return [
            'empty string' => ['', ''],
            'word' => ['word', 'word'],
            'word with space' => ['word', ' word '],
            'word with before space' => ['word', ' word'],
            'word with after space' => ['word', 'word '],
            'html header' => ['asd', '<h1>asd</h1>'],
            'script tag' => ['alert()', '<script>alert()</script>']
        ];
    }

    public function HtmlText() : array
    {
        return [
            'empty string' => ['', ''],
            'html header' => ['<h1> asd </h1>', '<h1> asd </h1>'],
            'html comment' => [
                '<div></div>',
                '<div><!--asdefg--></div>'
            ],
            'html head' => [
                '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1">',
                '<!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1">'
            ],
            'html paragraph' => ['<p> asd </p><p>www </p>', '<p> asd </p> <p>www </p> ']
        ];
    }
}