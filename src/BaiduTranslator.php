<?php

/*
 * This file is part of the her-cat/baidu-translator.
 *
 * (c) her-cat <i@her-cat.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace HerCat\BaiduTranslator;

use GuzzleHttp\Client as HttpClient;
use HerCat\BaiduTranslator\Exceptions\HttpException;

/**
 * Class BaiduTranslator.
 */
class BaiduTranslator
{
    const API = 'https://fanyi-api.baidu.com/api/trans/vip/translate';

    /**
     * @var string
     */
    protected $appId;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var array
     */
    protected $guzzleOptions = [];

    /**
     * BaiduTranslator constructor.
     *
     * @param string $appId
     * @param string $key
     */
    public function __construct($appId, $key)
    {
        $this->appId = $appId;
        $this->key = $key;
    }

    /**
     * @return HttpClient
     */
    public function getHttpClient()
    {
        return new HttpClient($this->guzzleOptions);
    }

    /**
     * @param array $options
     */
    public function setGuzzleOptions(array $options)
    {
        $this->guzzleOptions = $options;
    }

    /**
     * @param $text
     * @param string $to
     * @param string $from
     * @param string $format
     *
     * @return mixed|string
     *
     * @throws HttpException
     */
    public function translate($text, $to = 'zh', $from = 'auto', $format = 'json')
    {
        $query = $this->buildRequestParams($text, $to, $from);

        try {
            $response = $this->getHttpClient()->get(self::API, [
                'query' => $query,
            ])->getBody()->getContents();

            return 'json' === $format ? \json_decode($response, true) : $response;
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param $text
     * @param $to
     * @param $from
     *
     * @return array
     */
    public function buildRequestParams($text, $to, $from)
    {
        $params = \array_filter([
            'q' => $text,
            'from' => $from,
            'to' => $to,
            'appid' => $this->appId,
            'salt' => time(),
        ]);

        $params['sign'] = $this->generateSign($text, $params['salt']);

        return $params;
    }

    /**
     * @param $text
     * @param $salt
     *
     * @return string
     */
    public function generateSign($text, $salt)
    {
        return md5($this->appId.$text.$salt.$this->key);
    }
}
