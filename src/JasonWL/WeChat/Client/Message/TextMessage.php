<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 14-12-25
 * Time: 下午8:26
 */

namespace JasonWL\WeChat\Client\Message;


use JasonWL\WeChat\Client\ApiList;
use JasonWL\WeChat\Client\Client;

class TextMessage extends Client
{
    public function __construct($toUser, $content)
    {
        parent::__construct();
        $this->post('touser', $toUser)
            ->post('msgtype', 'text')
            ->post('text', [
                'content' => $content
            ])
            ->url(ApiList::SEND_MESSAGE);
    }
}