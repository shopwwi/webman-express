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

use  Illuminate\Database\Eloquent\Model;
use Shopwwi\B2b2c\Libraries\StatusCode;

class ResultBackVo extends Model
{
    protected $attributes = [
        'exp_logo' => '', //快递公司logo
        'exp_name' => '', //快递公司名称
        'exp_ship_sn' => '', //快递编码
        'exp_ship_code' => '', //快递单号
        'exp_tel' => '', //快递公司电话
        'exp_status' => 0, // 当前快递状态
        'status' => 200, //结果编码
        'message' => '', //信息
        'exp_list' => [], // 快递记录
        'route_info' => [], //快递途径
    ];

    /**
     * 实物订单
     * @param $ordersInfo
     * @return $this
     */
    public function KuaiDi100($result)
    {
        $this->status = intval($result->status ?? $result->returnCode);
        $this->message = $result->message;
        if($this->status == '200'){
            $this->exp_ship_code = $result->nu;
            $this->exp_ship_sn = $result->com;
            $this->exp_status = intval($result->state);
            $this->route_info = $result->routeInfo;
            $expList = collect([]);
            foreach ($result->data as $item){
                $expList->push([
                    'time' => $item->time, //
                    'context' => $item->context,
                    'area_code' => $item->areaCode,
                    'area_name' => $item->areaName,
                    'status' => $item->status,
                    'location' =>  $item->areaCenter,
                    'area_pinyin' => $item->areaPinYin,
                    'status_code' => intval($item->statusCode),
                ]);
            }
            $this->exp_list = $expList;
        }

        return $this;
    }

    public function ShowApi($res)
    {
        $result = $res->showapi_res_body;
        $this->status = intval($res->showapi_res_code);
        $this->message = $result->msg;
        if($this->status == 0){
            $this->exp_ship_code = $result->nu;
            $this->exp_ship_sn = $result->com;
            $this->exp_name = $result->com_name;
            $this->exp_logo = $result->logo;
            $this->exp_status = $this->getShowApiExpStatus(intval($result->ret_code));
            $this->exp_tel = $result->tel;
            $expList = collect([]);
            foreach ($result->data as $item){
                $expList->push([
                    'time' => $item->time, //
                    'context' => $item->context,
                    'area_code' => '',
                    'area_name' => $item->address,
                    'status' => '',
                    'location' =>  $item->location,
                    'area_pinyin' => '',
                    'status_code' => intval($item->status),
                ]);
            }
            $this->exp_list = $expList;
        }
        return $this;
    }

    public function kdniao($result)
    {
        $this->status = $this->Success ? 200:400;
        $this->message = $result->Remark;
        if($this->Success){
            $this->exp_ship_code = $result->LogisticCode;
            $this->exp_ship_sn = $result->ShipperCode;
            $this->exp_status = intval($result->State);
            $expList = collect([]);
            foreach ($result->Traces as $item){
                $expList->push([
                    'time' => $item->AcceptTime, //
                    'context' => $item->AcceptStation,
                    'area_code' => '',
                    'area_name' => $item->Location,
                    'status' => '',
                    'location' =>  '',
                    'area_pinyin' => '',
                    'status_code' => intval($item->Action),
                ]);
            }
            $this->exp_list = $expList;
        }
        return $this;
    }

    protected function getShowApiExpStatus($num){
        switch ($num){
            case 102: //在途中
            case 103: //派送中
            case 104: //已签收
            case 105: //用户拒签
            case 106: //疑难件
            case 107: //无效单
            case 108: //超时单
            case 109: //签收失败
            case 110: //退回

        }
    }
}