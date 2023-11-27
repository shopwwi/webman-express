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

namespace Shopwwi\WebmanExpress;

use Shopwwi\WebmanExpress\Adapter\KuaiDi100AdapterFactory;
use Shopwwi\WebmanExpress\Exception\InvalidArgumentException;
use support\Container;

class Express
{
    protected $type = 'kuaidi100';
    protected $express = null;

    /**
     * @param null $adapterName
     * @return Express
     * @throws InvalidArgumentException
     */
    public function make($adapterName = null,$config = null)
    {
        if($config !=null){
            $options = $config;
        }else{
            $options = \config('plugin.shopwwi.express.app', [
                'default' => 'kuaidi100',
                'holder' => [
                    'kuaidi100' => [
                        'driver' => KuaiDi100AdapterFactory::class,
                        'api_url' => 'https://poll.kuaidi100.com/poll/query.do',
                        'app_id' => '',
                        'app_key' => ''
                    ],
                ],
            ]);
        }

        if($adapterName != null){
            $this->type = $adapterName;
        }else{
            $this->type = $options['default'];
        }
        if(!$options['holder'][$this->type]){
            throw new InvalidArgumentException('lost config');
        }
        $this->express = Container::get($options['holder'][$this->type]['driver'])->make($options['holder'][$this->type]);
        return $this;
    }

    /**
     * 查询快递
     * @param $tracking_code
     * @param $shipping_code
     * @param array $additional
     * @return void
     */
    public function track($tracking_code, $shipping_code, array $additional = [])
    {
        return $this->express->track($tracking_code, $shipping_code, $additional = []);
    }
}