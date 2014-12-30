<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 14-12-30
 * Time: 下午12:32
 */

namespace JasonWL\WeChat\Client\Message;


class VoiceMessage extends Message
{
    /**
     * @param string $toUser
     * @param string $mediaID 上传的媒体文件ID
     */
    public function __construct($toUser, $mediaID)
    {
        parent::__construct($toUser);
        $this->post('msgtype', 'voice')
            ->post('voice', ['media_id' => $mediaID]);
    }
} 