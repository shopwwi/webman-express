<?php

namespace Shopwwi\WebmanExpress\Contract;

class ShowApiBackVo extends ResultBackVo
{
    public function back($res)
    {
        $data = json_decode(json_encode($this->attributes));
        $result = $res->showapi_res_body;
        $data->status = intval($res->showapi_res_code);
        $data->message = $result->msg;
        if($data->status == 0){
            $data->exp_ship_code = $result->nu;
            $data->exp_ship_sn = $result->com;
            $data->exp_name = $result->com_name;
            $data->exp_logo = $result->logo;
            $data->exp_status = $this->getShowApiExpStatus(intval($result->ret_code));
            $data->exp_tel = $result->tel;
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
            $data->exp_list = $expList;
        }
        return $data;
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