<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 14-12-30
 * Time: 下午12:32
 */

namespace JasonWL\WeChat\Client\Message;


class NewsMessage extends Message
{
    public function __construct($toUser, $articles)
    {
        parent::__construct($toUser);
        $this->post('msgtype', 'news')
            ->post('news', ['articles' => $articles]);
    }
} 