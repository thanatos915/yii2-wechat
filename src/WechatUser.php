<?php
/**
 * Created by PhpStorm.
 * User: thanatos
 * Date: 2018/4/24
 * Time: 下午6:15
 */

namespace thanatos\wechat;


use yii\base\Model;

class WechatUser extends Model
{
    public $subscribe;
    public $openid;
    public $nickname;
    public $sex;
    public $language;
    public $city;
    public $province;
    public $country;
    public $headimgurl;
    public $subscribe_time;
    public $unionid;
    public $remark;
    public $groupid;
    public $subscribe_scene;

}