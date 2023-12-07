<?php

namespace Shopwwi\WebmanExpress\Contract;

class KdNiaoBackVo extends ResultBackVo
{
    /**
     * 返回格式
     * @param $result
     * @return mixed
     */
    public function back($result){
        $data = json_decode(json_encode($this->attributes));
        $data->status = $result->Success ? 200:400;
        $data->message = $result->Reason ?? '';
        if($result->Success){
            $data->exp_ship_code = $result->LogisticCode;
            $data->exp_ship_sn = $result->ShipperCode;
            $data->exp_status = intval($result->State);
            $data->exp_status_name = $this->getExpStatus(intval($result->State));
            $expList = collect([]);
            foreach ($result->Traces as $item){
                $expList->push([
                    'time' => $item->AcceptTime, //
                    'context' => $item->AcceptStation,
                    'area_code' => '',
                    'area_name' => $item->Location ??'',
                    'status' => $this->getExpStatus(intval($item->Action??0)),
                    'location' =>  '',
                    'area_pinyin' => '',
                    'status_code' => intval($item->Action??0),
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
            1 => '已揽收',
            2 => '在途中',
             201 => '到达派件城市',
             204 => '到达转运中心',
             205 => '到达派件网点',
             206 => '寄件网点发件',
             202 => '派件中',
             211 => '已放入快递柜或驿站',
            3 => '已签收',
             301 => '正常签收',
             302 => '派件异常后最终签收',
             304 => '代收签收',
             311 => '快递柜或驿站签收',
            4 => '问题件',
             401 => '发货无信息',
             402 => '超时未签收',
             403 => '超时未更新',
             404 => '拒收(退件)',
             405 => '派件异常',
             406 => '退货签收',
             407 => '退货未签收',
             412 => '快递柜或驿站超时未取',
             413 => '单号已拦截',
             414 => '破损',
             415 => '客户取消发货',
             416 => '无法联系',
             417 => '配送延迟',
             418 => '快件取出',
             419 => '重新派送',
             420 => '收货地址不详细',
             421 => '收件人电话错误',
             422 => '错分件',
             423 => '超区件',
            5 => '转寄',
            6 => '清关',
             601 => '待清关',
             602 => '清关中',
             603 => '已清关',
             604 => '清关异常',
            10 => '待揽件',
        ];
        return $codeList[$num] ?? '';
    }

}