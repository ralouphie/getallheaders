<?php

class HttpBuildUrlTest extends \PHPUnit_Framework_TestCase
{
    public function testNormalCase()
    {
        $expected = array(
            'Key-One'                 => 'foo',
            'Key-Two'                 => 'bar',
            'Another-Key-For-Testing' => 'baz'
        );

        $_SERVER['HTTP_KEY_ONE']                 = 'foo';
        $_SERVER['HTTP_KEY_TWO']                 = 'bar';
        $_SERVER['HTTP_ANOTHER_KEY_FOR_TESTING'] = 'baz';

        $result = getallheaders();

        $this->assertEquals($expected, $result);
    }

    public function testContentType()
    {
        $expected = array(
            'Content-Type' => 'two'
        );

        $_SERVER['HTTP_CONTENT_TYPE'] = 'one';
        $_SERVER['CONTENT_TYPE']      = 'two';

        $result = getallheaders();

        $this->assertEquals($expected, $result);
    }

    public function testContentLength()
    {
        $expected = array(
            'Content-Length' => '222'
        );

        $_SERVER['HTTP_CONTENT_LENGTH'] = '111';
        $_SERVER['CONTENT_LENGTH']      = '222';

        $result = getallheaders();

        $this->assertEquals($expected, $result);
    }
}