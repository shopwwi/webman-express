<?php
/**
 *-------------------------------------------------------------------------p*
 * 配置文件
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

return [
    'enable' => true,
    'default' => 'kuaidi100',
    'holder' => [
        'kuaidi100' => [
            'driver' => \Shopwwi\WebmanExpress\Adapter\KuaiDi100AdapterFactory::class,
            'api_url' => 'https://poll.kuaidi100.com/poll/query.do',
            'app_id' => '', //customer
            'app_key' => '' //授权KEY
        ],
        'kdniao' => [
            'driver' => \Shopwwi\WebmanExpress\Adapter\KdNiaoAdapterFactory::class,
            'api_url' => 'https://api.kdniao.com/Ebusiness/EbusinessOrderHandle.aspx', //测试地址 http://sandboxapi.kdniao.com:8080/kdniaosandbox/gateway/exterfaceInvoke.json
            'app_id' => '',
            'app_key' => ''
        ],
        'showapi' => [
            'driver' => \Shopwwi\WebmanExpress\Adapter\KdNiaoAdapterFactory::class,
            'api_url' => 'https://route.showapi.com/2650-3',
            'app_id' => '', //showapi_appid
            'app_key' => '' //secret
        ]
    ],
];