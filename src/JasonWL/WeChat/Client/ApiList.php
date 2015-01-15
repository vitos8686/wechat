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
    CONST MEDIA_UPLOAD = 'http://file.api.weixin.qq.com/cgi-bin/media/upload';
    CONST MEDIA_DOWNLOAD = 'http://file.api.weixin.qq.com/cgi-bin/media/get';
    CONST MENU_CREATE = '/menu/create';
    CONST MENU_GET = '/menu/get';

    CONST USER_INFO = '/user/info';
} 