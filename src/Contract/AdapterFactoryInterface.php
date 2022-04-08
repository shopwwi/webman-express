<?php
/**
 *-------------------------------------------------------------------------p*
 *
 *-------------------------------------------------------------------------h*
 * @copyright  Copyright (c) 2015-2022 Shopwwi Inc. (http://www.shopwwi.com)
 *-------------------------------------------------------------------------c*
 * @license    http://www.shopwwi.com        s h o p w w i . c o m
 *-------------------------------------------------------------------------e*
 * @link       http://www.shopwwi.com by 象讯科技 phcent.com
 *-------------------------------------------------------------------------n*
 * @since      shopwwi象讯·PHP商城系统Pro
 *-------------------------------------------------------------------------t*
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