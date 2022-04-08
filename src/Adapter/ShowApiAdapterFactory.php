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

namespace Shopwwi\WebmanExpress\Adapter;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Shopwwi\WebmanExpress\Contract\AdapterFactoryInterface;
use Shopwwi\WebmanExpress\Contract\ResultBackVo;
use Shopwwi\WebmanExpress\Exception\HttpException;
use Shopwwi\WebmanExpress\Exception\InvalidArgumentException;

class ShowApiAdapterFactory implements AdapterFactoryInterface
{
    protected $api = 'https://route.showapi.com/2650';

    protected $app_id;

    protected $app_key;

    protected $guzzleOptions = [];

    /**
     * Kuaidi100 constructor.
     */
    public function make($options)
    {
        $this->app_id = $options['app_id'];
        $this->app_key = $options['app_key'];
        $this->api = $options['api_url'] ?? $this->api;
        return $this;
    }
    /**
     * 快递查询.
     *
     * @param string $tracking_code 快递单号
     * @param string $shipping_code 物流公司编号
     * @return string
     *
     * @throws InvalidArgumentException
     * @throws HttpException
     */
    public function track($tracking_code = '', $shipping_code = '', $additional = [])
    {
        if (empty($tracking_code)) {
            throw new InvalidArgumentException('TrackingCode is required');
        }

        if (empty($shipping_code)) {
            throw new InvalidArgumentException('ShippingCode is required');
        }

//        $allow_shipping_code = ['SF', 'HTKY', 'ZTO', 'STO', 'YTO', 'YD', 'YZPY', 'EMS', 'HHTT', 'JD', 'UC', 'DBL', 'ZJS', 'TNT', 'UPS', 'DHL', 'FEDEX', 'FEDEX_GJ', 'AJ', 'ALKJWL', 'AX', 'AYUS', 'AMAZON', 'AOMENYZ', 'ANE', 'ADD', 'AYCA', 'AXD', 'ANEKY', 'BDT', 'BETWL', 'BJXKY', 'BNTWL', 'BFDF', 'BHGJ', 'BFAY', 'BTWL', 'CFWL', 'CHTWL', 'CXHY', 'CG', 'CITY100', 'CJKD', 'CNPEX', 'COE', 'CSCY', 'CDSTKY', 'CTG', 'CRAZY', 'CBO', 'CND', 'DSWL', 'DLG', 'DTWL', 'DJKJWL', 'DEKUN', 'DBLKY', 'DML', 'ETK', 'EWE', 'KFW', 'FKD', 'FTD', 'FYKD', 'FASTGO', 'FT', 'GD', 'GTO', 'GDEMS', 'GSD', 'GTONG', 'GAI', 'GKSD', 'GTSD', 'HFWL', 'HGLL', 'HLWL', 'HOAU', 'HOTSCM', 'HPTEX', 'hq568', 'HQSY', 'HXLWL', 'HXWL', 'HFHW', 'HLONGWL', 'HQKD', 'HRWL', 'HTKD', 'HYH', 'HYLSD', 'HJWL', 'JAD', 'JGSD', 'JIUYE', 'JXD', 'JYKD', 'JYM', 'JGWL', 'JYWL', 'JDKY', 'CNEX', 'KYSY', 'KYWL', 'KSDWL', 'KBSY', 'LB', 'LJSKD', 'LHT', 'MB', 'MHKD', 'MK', 'MDM', 'MRDY', 'MLWL', 'NF', 'NEDA', 'PADTF', 'PANEX', 'PJ', 'PCA', 'QCKD', 'QRT', 'QUICK', 'QXT', 'RQ', 'QYZY', 'RFD', 'RRS', 'RFEX', 'SAD', 'SNWL', 'SAWL', 'SBWL', 'SDWL', 'SFWL', 'ST', 'STWL', 'SUBIDA', 'SDEZ', 'SCZPDS', 'SURE', 'SS', 'STKD', 'TAIWANYZ', 'TSSTO', 'TJS', 'TYWL', 'TLWL', 'UAPEX', 'ULUCKEX', 'UEQ', 'WJK', 'WJWL', 'WHTZX', 'WPE', 'WXWL', 'WTP', 'WTWL', 'XCWL', 'XFEX', 'XYT', 'XJ', 'YADEX', 'YCWL', 'YCSY', 'YDH', 'YDT', 'YFHEX', 'YFSD', 'YTKD', 'YXKD', 'YUNDX', 'YMDD', 'YZBK', 'YZTSY', 'YFSUYUN', 'YSDF', 'YF', 'YDKY', 'YL', 'ZENY', 'ZHQKD', 'ZTE', 'ZTKY', 'ZTWL', 'SJ', 'ZTOKY', 'ZYKD', 'WM', 'ZMKM', 'ZHWL', 'AAE', 'ACS', 'ADP', 'ANGUILAYOU', 'APAC', 'ARAMEX', 'AT', 'AUSTRALIA', 'BEL', 'BHT', 'BILUYOUZHE', 'BR', 'BUDANYOUZH', 'CDEK', 'CA', 'DBYWL', 'DDWL', 'DGYKD', 'DLGJ', 'DHL_DE', 'DHL_EN', 'DHL_GLB', 'DHLGM', 'DK', 'DPD', 'DPEX', 'D4PX', 'EMSGJ', 'EKM', 'EPS', 'ESHIPPER', 'FCWL', 'FX', 'FQ', 'FLYZ', 'FZGJ', 'GJEYB', 'GJYZ', 'GE2D', 'GT', 'GLS', 'IOZYZ', 'IADLYYZ', 'IAEBNYYZ', 'IAEJLYYZ', 'IAFHYZ', 'IAGLYZ', 'IAJYZ', 'IALBYZ', 'IALYYZ', 'IASBJYZ', 'IBCWNYZ', 'IBDLGYZ', 'IBDYZ', 'IBELSYZ', 'IBHYZ', 'IBJLYYZ', 'IBJSTYZ', 'IBLNYZ', 'IBOLYZ', 'IBTD', 'IBYB', 'ICKY', 'IDGYZ', 'IWDMLYZ', 'IWGDYZ', 'IWKLEMS', 'IWKLYZ', 'IWLGYZ', 'ILKKD', 'IWLYZ', 'IXGLDNYYZ', 'IE', 'IXPWL', 'IYDYZ', 'IXPSJ', 'IEGDEYZ', 'IELSYZ', 'IFTWL', 'IGDLPDYZ', 'IGSDLJYZ', 'IHGYZ', 'IHHWL', 'IHLY', 'IHSKSTYZ', 'IHSYZ', 'IJBBWYZ', 'IJEJSSTYZ', 'IJKYZ', 'IJNYZ', 'IJPZYZ', 'IKNDYYZ', 'IKNYYZ', 'IKTDWEMS', 'ILMNYYZ', 'IMEDWYZ', 'IMETYZ', 'INRLYYZ', 'ISEWYYZ', 'ISPLSYZ', 'IWZBKSTYZ', 'IXBYYZ', 'IXJPEMS', 'IXLYZ', 'IXXLYZ', 'IYDLYZ', 'IYGYZ', 'IYMNYYZ', 'IYMYZ', 'IZLYZ', 'JP', 'JFGJ', 'JGZY', 'JXYKD', 'JLDT', 'JPKD', 'SYJHE', 'LYT', 'LHKDS', 'SHLDHY', 'NL', 'NSF', 'ONTRAC', 'OCS', 'QQYZ', 'POSTEIBE', 'PAPA', 'QYHY', 'VENUCIA', 'RDSE', 'SKYPOST', 'SWCH', 'SDSY', 'SK', 'STONG', 'STO_INTL', 'JYSD', 'TAILAND138', 'USPS', 'UPU', 'VCTRANS', 'XKGJ', 'XD', 'XGYZ', 'XLKD', 'XSRD', 'XYGJ', 'XYGJSD', 'YAMA', 'YODEL', 'YHXGJSD', 'YUEDANYOUZ', 'YMSY', 'YYSD', 'YJD', 'YBG', 'YJ', 'AOL', 'BCWELT', 'BN', 'UBONEX', 'UEX', 'YDGJ', 'ZY_AG', 'ZY_AOZ', 'ZY_AUSE', 'ZY_AXO', 'ZY_BH', 'ZY_BEE', 'ZY_BL', 'ZY_BM', 'ZY_BT', 'ZY_CM', 'ZY_EFS', 'ZY_ESONG', 'ZY_FD', 'ZY_FG', 'ZY_FX', 'ZY_FXSD', 'ZY_FY', 'ZY_HC', 'ZY_HYSD', 'ZY_JA', 'ZY_JD', 'ZY_JDKD', 'ZY_JDZY', 'ZY_JH', 'ZY_JHT', 'ZY_LBZY', 'ZY_LX', 'ZY_MGZY', 'ZY_MST', 'ZY_MXZY', 'ZY_QQEX', 'ZY_RT', 'ZY_RTSD', 'ZY_SDKD', 'ZY_SFZY', 'ZY_ST', 'ZY_TJ', 'ZY_TM', 'ZY_TN', 'ZY_TPY', 'ZY_TSZ', 'ZY_TWC', 'ZY_RDGJ', 'ZY_TX', 'ZY_TY', 'ZY_DGHT', 'ZY_DYW', 'ZY_WDCS', 'ZY_TZH', 'ZY_UCS', 'ZY_XC', 'ZY_XF', 'ZY_XIYJ', 'ZY_YQ', 'ZY_YSSD', 'ZY_YTUSA', 'ZY_ZCSD', 'ZYZOOM', 'ZH', 'ZO', 'ZSKY', 'ZWSY', 'ZZJH'];
//
//        if (!in_array($shipping_code, $allow_shipping_code)) {
//            throw new InvalidArgumentException('Current ShippingCode is not support');
//        }

        $requestData = [
            'com' => $tracking_code,
            'nu' => $shipping_code
        ];
        if (!empty($additional)) {
            $requestData = array_merge($requestData, $additional);
        }
        $requestData = \json_encode($requestData);

        $post_data = [
            'com' => $shipping_code,
            'nu' => $tracking_code,
            'phone' => '',                // 手机号
        ];
        if (!empty($additional)) {
            $data = array_merge($data, $additional);
        }
        $post_data['showapi_appid'] = $this->app_id;
        $post_data['showapi_sign'] = $this->app_key;

        try {
            $response = $this->getHttpClient()->request('POST', $this->api.'-3', [
                'form_params' => $post_data,
            ])->getBody()->getContents();
        } catch (GuzzleException $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }

        return (new ResultBackVo())->ShowApi(\json_decode($response));
    }

    /**
     * 数据签名.
     *
     * @param $data
     * @param $apikey
     *
     * @return string
     */
    private function encrypt($data, $apikey)
    {
        return urlencode(base64_encode(md5($data.$apikey)));
    }

    /**
     * @return Client
     */
    public function getHttpClient()
    {
        return new Client($this->guzzleOptions);
    }

    /**
     * @return Client
     */
    public function getGuzzleOptions()
    {
        return new Client($this->guzzleOptions);
    }

    /**
     * @param $options
     */
    public function setGuzzleOptions($options)
    {
        $this->guzzleOptions = $options;
    }

}