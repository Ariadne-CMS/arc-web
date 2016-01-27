<?php

    /*
     * This file is part of the Ariadne Component Library.
     *
     * (c) Muze <info@muze.nl>
     *
     * For the full copyright and license information, please view the LICENSE
     * file that was distributed with this source code.
     */

    class TestHTTP extends PHPUnit_Framework_TestCase
    {
        function testGet()
        {
            $res = \arc\http::get( 'http://www.ariadne-cms.org/', '?foo=bar' );
            $this->assertNotEmpty($res);
        }

        function testClient()
        {
            $res = \arc\http::client();
            $this->assertInstanceOf('\arc\http\Client',$res);
        }

        function testHeaders()
        {
            $headerString = <<< EOF
HTTP/1.1 200 OK
Cache-Control: no-transform,public,max-age=300,s-maxage=900
Content-Type: text/html; charset=UTF-8
Date: Mon, 29 Apr 2013 16:38:15 GMT
ETag: "bbea5db7e1785119a7f94fdd504c546e"
Last-Modified: Sat, 27 Apr 2013 00:44:54 GMT
Server: AmazonS3
Vary: Accept-Encoding
X-Cache: HIT
EOF;
            $headers = \arc\http\headers::parse($headerString);
            $this->assertEquals('AmazonS3', $headers['Server']);
            $this->assertEquals('HTTP/1.1 200 OK', $headers[0]);

            $cachetime = \arc\http\headers::parseCacheTime($headers);
            $this->assertEquals(300, $cachetime);
        }
    }
