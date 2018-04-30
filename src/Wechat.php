<?php

namespace thanatos\wechat;


use EasyWeChat\Factory;
use Yii;
use yii\base\Component;
use yii\base\Exception;

/**
 * Class Wechat
 * @property \EasyWeChat\Payment\Application|\EasyWeChat\OfficialAccount\Application|\EasyWeChat\MiniProgram\Application|\EasyWeChat\OpenPlatform\Application|\EasyWeChat\Work\Application $app
 * @package thanatos\wechat
 */
class Wechat extends Component
{

    /**
     * Application type
     * official 公众号
     * miniProgram 小程序
     * open 开放平台
     * weWork 企业微信
     * payment 微信支付
     * @var string
     */
    public $app_type = 'official';

    /**
     * AppID
     * @var string
     */
    public $app_id = '';

    /**
     * AppSecret
     * @var string
     */
    public $secret = '';

    /**
     * Token
     * @var string
     */
    public $token = '';

    /**
     * EncodingAESKey 兼容与安全模式下请一定要填写
     * @var string
     */
    public $aes_key = '';

    /**
     * API 调用返回结果的类型
     * array(default)/collection/object/raw
     * @var string
     */
    public $response_type = 'object';

    /**
     *
     * 日志配置
     *
     * level: 日志级别, 可选为：
     *         debug/info/notice/warning/error/critical/alert/emergency
     * permission：日志文件权限(可选)，默认为null（若为null值,monolog会取0644）
     * file：日志文件位置(绝对路径!!!)，要求可写权限
     * @var array
     */
    public $log = [];

    /**
     * 接口请求相关配置，超时时间等，具体可用参数请参考：
     * http://docs.guzzlephp.org/en/stable/request-config.html
     *
     * - retries: 重试次数，默认 1，指定当 http 请求失败时重试的次数。
     * - retry_delay: 重试延迟间隔（单位：ms），默认 500
     * - log_template: 指定 HTTP 日志模板，请参考：https://github.com/guzzle/guzzle/blob/master/src/MessageFormatter.php
     * @var array
     */
    public $http = [];

    /**
     * OAuth 配置
     *
     * scopes：公众平台（snsapi_userinfo / snsapi_base），开放平台：snsapi_login
     * callback：OAuth授权完成后的回调页地址
     * @var array
     */
    public $oauth = [];

    /**
     * @var \EasyWeChat\Payment\Application|\EasyWeChat\OfficialAccount\Application|\EasyWeChat\MiniProgram\Application|\EasyWeChat\OpenPlatform\Application|\EasyWeChat\Work\Application
     */
    private $_app;

    /**
     * get App
     * @return \EasyWeChat\MiniProgram\Application|\EasyWeChat\OfficialAccount\Application|\EasyWeChat\OpenPlatform\Application|\EasyWeChat\Payment\Application|\EasyWeChat\Work\Application|null
     */
    public function getApp()
    {
        if ($this->_app === null) {
            $this->setApp();
        }

        return $this->_app;
    }

    /**
     * set App
     */
    public function setApp()
    {
        $app = null;
        $config = $this->combineConfig();
        switch ($this->app_type) {
            case 'official':
                $app = Factory::officialAccount($config);
                break;
            case 'miniProgram':
                $app = Factory::miniProgram($config);
                break;
            case 'open':
                $app = Factory::openPlatform($config);
                break;
            case 'weWork':
                $app = Factory::work($config);
                break;
            case 'payment':
                $app = Factory::payment($config);
                break;
        }

        $this->_app = $app;
        unset($app);
    }

    /**
     *
     * check if client is wechat
     * @return bool
     */
    public function getIsWechat()
    {
        return strpos(Yii::$app->request->userAgent, "MicroMessenger") !== false;
    }

    /**
     * validate wechat config
     * @throws Exception
     */
    public function validateConfig()
    {
        if (empty($this->app_id))
            throw new Exception('AppID is required');

        if (empty($this->secret))
            throw new Exception('AppSecret is required');

    }

    /**
     * combine config
     * @return array
     * @throws Exception
     */
    protected function combineConfig()
    {
        $this->validateConfig();
        $config = [
            'app_id' => $this->app_id,
            'secret' => $this->secret,
            'token' => $this->token,
            'aes_key' => $this->aes_key,
        ];
        if ($this->response_type)
            $config['response_type'] = $this->response_type;

        if (is_array($this->log) && $this->log != null) {
            $config['log'] = $this->log;
            $config['log']['file'] = Yii::getAlias($config['log']['file']);

        } else {
            $config['log'] = [
                'level' => 'debug',
                'permission' => '0777',
                'file' => Yii::getAlias('@runtime') . '/logs/wechat.log'
            ];
        }


        if (is_array($this->http) && $this->http != null)
            $config['http'] = $this->http;

        if (is_array($this->oauth) && $this->oauth != null)
            $config['oauth'] = $this->oauth;

        return $config;
    }

}