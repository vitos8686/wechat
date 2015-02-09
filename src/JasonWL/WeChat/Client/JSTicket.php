<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 15-2-9
 * Time: 上午9:27
 */

namespace JasonWL\WeChat\Client;


class JSTicket extends Client
{
    /**
     * 注意 这里没有缓存机制，获取到的ticket一定要走缓存
     * ticket的有效期为7200s
     * @return mixed
     */
    public function getTicket()
    {
        return $this->get('type', 'jsapi')
            ->url(ApiList::JSTICKET_GET)
            ->request();
    }
}