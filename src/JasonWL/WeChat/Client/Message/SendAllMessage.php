<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 14-12-30
 * Time: 下午12:32
 */

namespace JasonWL\WeChat\Client\Message;


use JasonWL\WeChat\Client\Client;

class SendAllMessage extends Client
{

    public function send($mediaId)
    {
        $this->post('msgtype', 'mpnews')
            ->post('mpnews', ['media_id' => $mediaId])
            ->post('filter', array(
                'is_to_all' => true
            ))
            ->url('https://api.weixin.qq.com/cgi-bin/message/mass/sendall');
    }

    public function preview($openId, $mediaId)
    {
        $this->post('touser', $openId)
            ->post('mpnews', array(
                'media_id' => $mediaId
            ))
            ->post('msgtype', 'mpnews')
            ->url('https://api.weixin.qq.com/cgi-bin/message/mass/preview');
    }

    protected function getApiPrefix()
    {
        return null;
    }
} 