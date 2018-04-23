<?php
/**
 * Created by PhpStorm.
 * User: thanatos
 * Date: 2018/4/23
 * Time: 下午2:17
 */

namespace thanatos\wechat;


use Yii;
use yii\base\Component;

class Wechat  extends Component
{

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
    public $token  = '';

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
    public $response_type = '';

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
     *
     * check if client is wechat
     * @return bool
     */
    public function getIsWechat()
    {
        return strpos(Yii::$app->request->userAgent, "MicroMessenger") !== false;
    }
}