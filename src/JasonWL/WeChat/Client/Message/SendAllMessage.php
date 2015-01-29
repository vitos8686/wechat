<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 14-12-30
 * Time: 下午12:32
 */

namespace JasonWL\WeChat\Client\Message;


class SendAllMessage extends Message
{
    public function __construct($mediaId)
    {
        $this->post('msgtype', 'mpnews')
            ->post('mpnews', ['media_id' => $mediaId])
            ->post('filter', array(
                'is_to_all' => true
            ))
            ->url('https://api.weixin.qq.com/cgi-bin/message/mass/sendall');
    }
} 