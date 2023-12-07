<?php
/**
 *-------------------------------------------------------------------------s*
 * 定义
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

namespace Shopwwi\WebmanExpress\Contract;

interface AdapterFactoryInterface
{
    /**
     * @param array $options
     * @return mixed
     */
    public function make(array $options);

    public function track($tracking_code = '', $shipping_code = '', $additional = []);
    public function getHttpClient();
    public function getGuzzleOptions();
    public function setGuzzleOptions($options);

}