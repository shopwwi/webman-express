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

namespace Shopwwi\WebmanExpress\Facade;
/**
 * @see \Shopwwi\WebmanExpress\Express
 * @mixin \Shopwwi\WebmanExpress\Express
 * @method make($adapterName = null,$config = null) static 设置选定器
 * @method track($tracking_code, $shipping_code, array $additional = []) static 查询快递
 */
class Express
{
    protected static $_instance = null;


    public static function instance()
    {
        if (!static::$_instance) {
            static::$_instance = new \Shopwwi\WebmanExpress\Express();
        }
        return static::$_instance;
    }
    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return static::instance()->{$name}(... $arguments);
    }
}