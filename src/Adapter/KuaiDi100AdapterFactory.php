<?php
/**
 *-------------------------------------------------------------------------s*
 * 快递100
 *-------------------------------------------------------------------------h*
 * @copyright  Copyright (c) 2015-2023 Shopwwi Inc. (http://www.shopwwi.com)
 *-------------------------------------------------------------------------o*
 * @license    http://www.shopwwi.com        s h o p w w i . c o m
 *-------------------------------------------------------------------------p*
 * @link       http://www.shopwwi.com by 无锡豚豹科技
 *-------------------------------------------------------------------------w*
 * @since      ShopWWI智能管理系统
 *-------------------------------------------------------------------------w*
 * @author     8988354@qq.com TycoonSong
 *-------------------------------------------------------------------------i*
 */
namespace Shopwwi\WebmanExpress\Adapter;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Shopwwi\WebmanExpress\Contract\AdapterFactoryInterface;
use Shopwwi\WebmanExpress\Contract\KuaiDi100BackVo;
use Shopwwi\WebmanExpress\Exception\HttpException;
use Shopwwi\WebmanExpress\Exception\InvalidArgumentException;

class KuaiDi100AdapterFactory implements AdapterFactoryInterface
{
    protected $api = 'https://poll.kuaidi100.com/poll/query.do';

    protected $app_id;

    protected $app_key;

    protected $guzzleOptions = [];

    /**
     * Kuaidi100 constructor.
     */
    public function make($options)
    {
        $this->app_id = $options['app_id'];
        $this->app_key = $options['app_key'];
        $this->api = $options['api_url'] ?? $this->api;
        return $this;
    }

    /**
     * 快递查询.
     *
     * @param string $tracking_code 快递单号
     * @param string $shipping_code 物流公司单号
     *
     * @return string
     *
     * @throws InvalidArgumentException
     * @throws HttpException
     */
    public function track($tracking_code = '', $shipping_code = '', $additional = [])
    {
        if (empty($tracking_code)) {
            throw new InvalidArgumentException('TrackingCode is required');
        }

        if (empty($shipping_code)) {
            throw new InvalidArgumentException('ShippingCode is required');
        }

        if ('shunfeng' == $shipping_code && empty($additional['phone'])) {
            throw new InvalidArgumentException('This Order Need PhoneNumber');
        }


        $data = [
            'com' => $shipping_code,
            'num' => $tracking_code,
            'phone' => '',                // 手机号
            'from' => '',                 // 出发地城市
            'to' => '',                   // 目的地城市
            'resultv2' => '4',            // 开启行政区域解析
            'show' => '0',                // 返回格式：0：json格式（默认），1：xml，2：html，3：text
            'order' => 'desc'             // 返回结果排序:desc降序（默认）,asc 升序
        ];
        if (!empty($additional)) {
            $data = array_merge($data, $additional);
        }
        $post_data = array();
        $post_data['customer'] = $this->app_id;
        $post_data['param'] = json_encode($data, JSON_UNESCAPED_UNICODE);
        $sign = md5($post_data['param'].$this->app_key.$post_data['customer']);
        $post_data['sign'] = strtoupper($sign);
        try {
            $response = $this->getHttpClient()->request('POST', $this->api, [
                'form_params' => $post_data,
            ])->getBody()->getContents();
            return (new KuaiDi100BackVo())->back(\json_decode($response));
        } catch (GuzzleException $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
        return null;
    }

    /**
     * @return Client
     */
    public function getHttpClient()
    {
        return new Client($this->guzzleOptions);
    }

    /**
     * @return Client
     */
    public function getGuzzleOptions()
    {
        return new Client($this->guzzleOptions);
    }

    /**
     * @param $options
     */
    public function setGuzzleOptions($options)
    {
        $this->guzzleOptions = $options;
        return $this;
    }
}