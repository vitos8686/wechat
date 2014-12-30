<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 14-12-25
 * Time: 下午12:38
 */

namespace JasonWL\WeChat\Client;


class ApiList
{
    CONST API_PREFIX = 'https://api.weixin.qq.com/cgi-bin';
    CONST AUTH_TOKEN = '/token';
    CONST AUTH_CALLBACK_IP = '/getcallbackip';
    CONST SEND_MESSAGE = '/message/custom/send';
    CONST UPLOAD_MEDIA = 'http://file.api.weixin.qq.com/cgi-bin/media/upload';
} 