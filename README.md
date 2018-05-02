<p align="center">
    </a>
    <h1 align="center">Aliyun Oss Sdk Extension for Yii 2</h1>
    <br>
</p>

 based on [aliyun/aliyun-oss-php-sdk](https://github.com/aliyun/aliyun-oss-php-sdk)

[![Latest Stable Version](https://poser.pugx.org/thanatosxia/yii2-wechat/v/stable)](https://packagist.org/packages/thanatosxia/yii2-wechat)
[![Total Downloads](https://poser.pugx.org/thanatosxia/yii2-wechat/downloads)](https://packagist.org/packages/thanatosxia/yii2-wechat)
[![Latest Unstable Version](https://poser.pugx.org/thanatosxia/yii2-wechat/v/unstable)](https://packagist.org/packages/thanatosxia/yii2-wechat)

安装
------------------
```bash
composer require thanatosxia/yii2-wechat
```

使用
--------------
添加配置到main.php/config.php
```php

'wechat' => [
    'class' => 'thanatos\wechat\Wechat',
    'log' => [
        'level' => 'debug',
        'permission' => '0777',
        'file' => '@runtime/logs/wechat.log'
    ],
    'app_id' => '',
    'secret' => '',
    'token' => '',
    /**
     * official 公众号
     * miniProgram 小程序
     * open 开放平台
     * weWork 企业微信
     * payment 微信支付
     */
    'app_type' => '',
],
```

对接微信
```php
        $app = Yii::$app->wechat->app;

        $app->server->push(EventMessageHandle::class);

        $response = $app->server->serve();

        $response->send();
```

新建EventMessageHandle类, extends thanatos\wechat\MessageHandler
```php
class EventMessageHandle extends MessageHandler
{
    // 在执行处理之前会被执行，如果返回false则不继续执行
    public function beforeHandle()
    {

        return parent::beforeHandle();
    }
    
    // 默认的消息处理方法
    public function handleDefault()
    {
        $string = 123 . Yii::$app->user->id;
        return $string;
    }

    public function getUnionid()
    {
        return $this->wechatInfo->unionid;
    }
    
    // 处理用户关注事件
     public function eventSubscribe()
     {
     
     }

}
```

对于微信的时间推荐，可以在自定义的消息处理类中添加方法，来处理 如

- `subscribe` 对应的处理方法是 `eventSubscribe`
- `scan`      对应的处理方法是 `eventScan`
