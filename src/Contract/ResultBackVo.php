<?php
/**
 *-------------------------------------------------------------------------s*
 * 返回统一格式
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

use Shopwwi\B2b2c\Libraries\StatusCode;

class ResultBackVo
{
    protected $attributes = [
        'exp_logo' => '', //快递公司logo
        'exp_name' => '', //快递公司名称
        'exp_ship_sn' => '', //快递编码
        'exp_ship_code' => '', //快递单号
        'exp_tel' => '', //快递公司电话
        'exp_status' => 0, // 当前快递状态
        'exp_status_text' => '', // 当前快递状态
        'status' => 200, //结果编码
        'message' => '', //信息
        'exp_list' => [], // 快递记录
        'route_info' => [], //快递途径
    ];
}