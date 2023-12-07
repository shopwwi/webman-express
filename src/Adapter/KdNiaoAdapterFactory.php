<?php
/**
 *-------------------------------------------------------------------------s*
 * 快递鸟
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
use Shopwwi\WebmanExpress\Contract\KdNiaoBackVo;
use Shopwwi\WebmanExpress\Exception\HttpException;
use Shopwwi\WebmanExpress\Exception\InvalidArgumentException;

class KdNiaoAdapterFactory implements AdapterFactoryInterface
{
    protected $api = 'https://api.kdniao.com/Ebusiness/EbusinessOrderHandle.aspx';

    protected $app_id;

    protected $app_key;

    protected $guzzleOptions = ['verify'=>false];

    /**
     * Kuaidi100 constructor.
     */
    public function make($options)
    {
        $this->app_id = $options['app_id'];
        $this->app_key = $options['app_key'];
        $this->api = $options['api_url'] ?? 'https://api.kdniao.com/Ebusiness/EbusinessOrderHandle.aspx';
        return $this;
    }


    /**
     * 快递查询.
     *
     * @param string $tracking_code 快递单号
     * @param string $shipping_code 物流公司编号
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

        $requestData = [
            'LogisticCode' => $tracking_code,
            'ShipperCode' => $shipping_code
        ];
        if (!empty($additional)) {
            $requestData = array_merge($requestData, $additional);
        }
        $requestData = \json_encode($requestData);

        $post = array(
            'EBusinessID' => $this->app_id,
            'RequestType' => '1002',
            'RequestData' => urlencode($requestData),
            'DataType' => '2',
            'DataSign' => $this->encrypt($requestData, $this->app_key),
        );

        try {
            $response = $this->getHttpClient()->request('POST', $this->api, [
                'form_params' => $post,
            ])->getBody()->getContents();
            return (new KdNiaoBackVo())->back(\json_decode($response));
        } catch (GuzzleException $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }

        return null;
    }

    /**
     * 数据签名.
     *
     * @param $data
     * @param $apikey
     *
     * @return string
     */
    private function encrypt($data, $apikey)
    {
        return urlencode(base64_encode(md5($data.$apikey)));
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