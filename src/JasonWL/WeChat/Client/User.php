<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 15-1-12
 * Time: 下午7:53
 */

namespace JasonWL\WeChat\Client;


class User extends Client
{
    public function info($openId, $lang = 'zh_CN')
    {
        $this->url(ApiList::USER_INFO)
            ->get('openid', $openId)
            ->get('lang', $lang);
        return $this->request();
    }
}