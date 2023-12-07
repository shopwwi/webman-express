# 安装

```
composer require shopwwi/webman-express
```
# 配置文件
```
//路径 config/plugin/shopwwi/express/app.php
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
            'driver' => \Shopwwi\WebmanExpress\Adapter\ShowApiAdapterFactory::class,
            'api_url' => 'https://route.showapi.com/2650',
            'app_id' => '', //showapi_appid
            'app_key' => '' //secret
        ]
    ],
```
## 支持的查询
- 快递100 （kuaidi100）
- 快递鸟（kdniao）
- 万维易源 （showapi）
# 使用方法

1. 选择选定器

```php
use Shopwwi\WebmanExpress\Facade\Express;
$express = Express::make(); //默认选定器
$express = Express::make('kuaidi100');
```
2.快递查询

```php
use Shopwwi\WebmanExpress\Facade\Express;

$express = Express::make(); //默认选定器
// $tracking_code 快递单号
// $shipping_code 物流公司编码
// $additional 扩展参数 详见下面说明
$express = $express->track($tracking_code, $shipping_code,$additional = [])

```
3.请求扩展参数区别（$additional）

- 快递鸟

|参数名称|类型| 说明                                                                                                                                                                                         | 必须要求   |
|------|-----|---------------------------------------------------------------------------------------------------------------------------------------------------------|--------|
|OrderCode|String| 订单编号                                                                                                                                                                                       | 否      |
|CustomerName	|String| ShipperCode 为JD，必填，对应京东的青龙配送编码，也叫商家编码，格式：数字＋字母＋数字，9 位数字加一个字母，共10 位，举例：001K123450；ShipperCode 为SF，且快递单号非快递鸟渠道返回时，必填，对应收件人/寄件人手机号后四位；ShipperCode 为SF，且快递单号为快递鸟渠道返回时，不填；ShipperCode 为其他快递时，不填 | 否      |

- 快递100

|参数名称|类型| 说明                                                                                                                                                                                         | 必须要求  |
|-----|-----|---------------------------------------------------------------------------------------------------------------------------------------------------------|-------|
|phone|String| 收、寄件人的电话号码（手机和固定电话均可，只能填写一个，顺丰速运和丰网速运必填，其他快递公司选填。如座机号码有分机号，分机号无需传入。）| 否     |
|from|String| 出发地城市 | 否 |
|to|String| 目的地城市，到达目的地后会加大监控频率 | 否 |

4.返回结果说明(对各站进行了统一)

| 参数名称            |类型| 说明       |
|-----------------|-----|----------|
| message         | String | 消息体，请忽略  | 
| status          | String | 通讯状态，请忽略 |
| exp_logo        |String| 快递公司logo |
| exp_name        |String| 快递公司名称   |
| exp_ship_sn     |String| 快递公司编码   |
| exp_ship_code   |String| 快递单号     |
| exp_tel         |String| 快递公司电话   |
| exp_status      |String| 当前快递状态   |
| exp_status_text |String| 当前快递状态   |
| route_info      | Array | 快递途径明细   |
| exp_list        | Array | 快递明细列表   |
| └ time          | String | 时间，原始格式  |
| └ context       | String | 内容       |
| └ status        | String | 本数据元对应的物流状态名称或者高级状态名称 |
| └ status_code   | String | 本数据元对应的高级物流状态值 |
| └ area_name     | String | 本数据元对应的行政区域的名称 |
| └ area_code     | String | 本数据元对应的行政区域的编码 |
| └ location      | String | 本数据元对应的行政区域经纬度 |
| └ area_pinyin   | String | 本数据元对应的行政区域拼音 |
