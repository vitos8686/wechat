<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 14-12-24
 * Time: 上午11:46
 */

namespace JasonWL\WeChat;


class WeChatConfig
{
    /**
     * @var string 填写的URL需要正确响应微信发送的Token验证
     */
    static $token;
    /**
     * @var string 微信分配的开发者appID
     */
    static $appId;

    /**
     * @var string 微信分配的开发者appsecret
     */
    static $appSecret;
} 