<?php
/**
 *-------------------------------------------------------------------------s*
 * 
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

namespace Shopwwi\WebmanExpress;

use Shopwwi\WebmanAuth\Exception\JwtTokenException;
use Shopwwi\WebmanExpress\Adapter\KuaiDi100AdapterFactory;
use Shopwwi\WebmanExpress\Exception\InvalidArgumentException;
use support\Container;

class Express
{
    protected $type = 'kuaidi100';
    protected $express = null;
    protected $config = null;

    /**
     * 构造方法
     * @access public
     */
    public function __construct()
    {
        $_config = \config('plugin.shopwwi.express.app', [
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
        $this->config = $_config;
    }

    /**
     * @param null $adapterName
     * @return Express
     * @throws InvalidArgumentException
     */
    public function make($adapterName = null)
    {
        $options = $this->config;
        if($adapterName != null){
            $this->type = $adapterName;
        }else{
            $this->type = $options['default'];
        }
        if(!$options['holder'][$this->type]){
            throw new InvalidArgumentException('lost config');
        }
        return $this->express = Container::get($options['holder'][$this->type]['driver'])->make($options['holder'][$this->type]);
    }

    /**
     * 配置
     * @param $config
     * @return $this
     */
    public function config($config){
        $this->config = $config;
        return $this;
    }

    /**
     * @return null
     */
    public function adapter($name)
    {
        $options = $this->config;
        $this->type = $name;
        if(!$this->config['holder'][$name]){
            throw new InvalidArgumentException('lost config');
        }
        return $this->express = Container::get($options['holder'][$this->type]['driver'])->make($options['holder'][$this->type]);
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