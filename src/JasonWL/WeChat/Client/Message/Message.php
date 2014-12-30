<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 14-12-30
 * Time: 下午12:28
 */

namespace JasonWL\WeChat\Client\Message;


use JasonWL\WeChat\Client\ApiList;
use JasonWL\WeChat\Client\Client;

class Message extends Client
{
    /**
     * @param string $toUser 发送给谁
     * @throws \JasonWL\WeChat\Exception\WeChatException
     */
    public function __construct($toUser)
    {
        parent::__construct();
        $this->post('touser', $toUser)
            ->url(ApiList::SEND_MESSAGE);
    }
} 