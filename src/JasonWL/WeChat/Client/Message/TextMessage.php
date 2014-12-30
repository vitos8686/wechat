<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 14-12-25
 * Time: 下午8:26
 */

namespace JasonWL\WeChat\Client\Message;

class TextMessage extends Message
{
    public function __construct($toUser, $content)
    {
        parent::__construct($toUser);
        $this->post('msgtype', 'text')
            ->post('text', ['content' => $content]);
    }
}