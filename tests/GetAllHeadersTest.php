<?php

namespace getallheaders\Tests;

use PHPUnit\Framework\TestCase;

class GetAllHeadersTest extends TestCase
{
    /**
     * @dataProvider dataWorks
     */
    public function testWorks($test_type, $expected, $server)
    {
        foreach ($server as $key => $val) {
            $_SERVER[$key] = $val;
        }
        $result = getallheaders();
        $this->assertEquals($expected, $result, "Error testing $test_type works.");
        // Clean up.
        foreach ($server as $key => $val) {
            unset($_SERVER[$key]);
        }
    }

    public function dataWorks()
    {
        return [
            [
                'normal case',
                [
                    'Key-One'                 => 'foo',
                    'Key-Two'                 => 'bar',
                    'Another-Key-For-Testing' => 'baz',
                ],
                [
                    'HTTP_KEY_ONE'                 => 'foo',
                    'HTTP_KEY_TWO'                 => 'bar',
                    'HTTP_ANOTHER_KEY_FOR_TESTING' => 'baz',
                ],
            ],
            [
                'Content-Type',
                [
                    'Content-Type' => 'two',
                ],
                [
                    'HTTP_CONTENT_TYPE' => 'one',
                    'CONTENT_TYPE'      => 'two',
                ],
            ],
            [
                'Content-Length',
                [
                    'Content-Length' => '222',
                ],
                [
                    'CONTENT_LENGTH'      => '222',
                    'HTTP_CONTENT_LENGTH' => '111',
                ],
            ],
            [
                'Content-Length (HTTP_CONTENT_LENGTH only)',
                [
                    'Content-Length' => '111',
                ],
                [
                    'HTTP_CONTENT_LENGTH' => '111',
                ],
            ],
            [
                'Content-MD5',
                [
                    'Content-Md5' => 'aef123',
                ],
                [
                    'CONTENT_MD5'      => 'aef123',
                    'HTTP_CONTENT_MD5' => 'fea321',
                ],
            ],
            [
                'Content-MD5 (HTTP_CONTENT_MD5 only)',
                [
                    'Content-Md5' => 'f123',
                ],
                [
                    'HTTP_CONTENT_MD5' => 'f123',
                ],
            ],
            [
                'Authorization (normal)',
                [
                    'Authorization' => 'testing',
                ],
                [
                    'HTTP_AUTHORIZATION' => 'testing',
                ],
            ],
            [
                'Authorization (redirect)',
                [
                    'Authorization' => 'testing redirect',
                ],
                [
                    'REDIRECT_HTTP_AUTHORIZATION' => 'testing redirect',
                ],
            ],
            [
                'Authorization (PHP_AUTH_USER + PHP_AUTH_PW)',
                [
                    'Authorization' => 'Basic ' . base64_encode('foo:bar'),
                ],
                [
                    'PHP_AUTH_USER' => 'foo',
                    'PHP_AUTH_PW'   => 'bar',
                ],
            ],
            [
                'Authorization (PHP_AUTH_DIGEST)',
                [
                    'Authorization' => 'example-digest',
                ],
                [
                    'PHP_AUTH_DIGEST' => 'example-digest',
                ],
            ],
        ];
    }
}
