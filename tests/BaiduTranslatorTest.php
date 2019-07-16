<?php

/*
 * This file is part of the her-cat/baidu-translator.
 *
 * (c) her-cat <i@her-cat.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace HerCat\BaiduTranslator\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use HerCat\BaiduTranslator\BaiduTranslator;
use PHPUnit\Framework\TestCase;

class BaiduTranslatorTest extends TestCase
{
    public function testGetHttpClient()
    {
        $translator = new BaiduTranslator('mock-app-id', 'mock-key');

        $this->assertInstanceOf(ClientInterface::class, $translator->getHttpClient());
    }

    public function testSetGuzzleOptions()
    {
        $translator = new BaiduTranslator('mock-app-id', 'mock-key');

        $this->assertNull($translator->getHttpClient()->getConfig('timeout'));

        $translator->setGuzzleOptions(['timeout' => 5000]);

        $this->assertSame(5000, $translator->getHttpClient()->getConfig('timeout'));
    }

    public function testTranslate()
    {
        $response = new Response(200, [], '{"success": true}');

        $client = \Mockery::mock(Client::class);

        $client->expects()->get(BaiduTranslator::API, [
            'query' => 'mock-params',
        ])->andReturn($response);

        $translator = \Mockery::mock(BaiduTranslator::class, ['mock-app-id', 'mock-key'])->makePartial();
        $translator->allows()->getHttpClient()->andReturn($client);
        $translator->expects()->buildRequestParams('mock-text', 'zh', 'auto')->andReturn('mock-params');

        $this->assertSame(['success' => true], $translator->translate('mock-text'));
    }
}
