<?php
/**
 *-------------------------------------------------------------------------s*
 * 快递100返回格式
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

class KuaiDi100BackVo extends ResultBackVo
{
    /**
     * 实物订单
     * @param $ordersInfo
     * @return $this
     */
    public function back($result)
    {
        $data = json_decode(json_encode($this->attributes));
        $data->status = intval($result->status ?? $result->returnCode);
        $data->message = $result->message;
        if($data->status == '200'){
            $data->exp_ship_code = $result->nu;
            $data->exp_ship_sn = $result->com;
            $data->exp_status = intval($result->state);
            $data->exp_status_text = $this->getExpStatus(intval($result->state));
            $data->route_info = $result->routeInfo;
            $expList = collect([]);
            foreach ($result->data as $item){
                $expList->push([
                    'time' => $item->time, //
                    'context' => $item->context,
                    'area_code' => $item->areaCode??0,
                    'area_name' => $item->areaName??'',
                    'status' => $item->status,
                    'location' =>  $item->areaCenter,
                    'area_pinyin' => $item->areaPinYin,
                    'status_code' => intval($item->statusCode),
                ]);
            }
            $data->exp_list = $expList;
        }

        return $data;
    }
    /**
     * 状态
     * @param $num
     * @return string
     */
    protected function getExpStatus($num){
        $codeList = [
            1 =>'揽收',
            101 =>'已下单',
            102 =>'待揽收',
            103 =>'已揽收',
            0 =>'在途',
            1001 =>'到达派件城市',
            1002 =>'干线',
            1003 =>'转递',
            5 =>'派件',
            501 =>'投柜或驿站',
            3 =>'签收',
            301 =>'本人签收',
            302 =>'派件异常后签收',
            303 =>'代签',
            304 =>'投柜或站签收',
            6 =>'退回',
            4 =>'退签',
            401 =>'已销单',
            7 =>'转投',
            2 =>'疑难',
            201 =>'超时未签收',
            202 =>'超时未更新',
            203 =>'拒收',
            204 =>'派件异常',
            205 =>'柜或驿站超时未取',
            206 =>'无法联系',
            207 =>'超区',
            208 =>'滞留',
            209 =>'破损',
            210 =>'销单',
            8 =>'清关',
            10 =>'待清关',
            11 =>'清关中',
            12 =>'已清关',
            13 =>'清关异常',
            14 =>'拒签',
        ];
        return $codeList[$num] ?? '';
    }
}