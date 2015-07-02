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
    }
