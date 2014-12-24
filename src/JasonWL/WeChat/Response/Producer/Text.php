<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 14-12-24
 * Time: 下午5:33
 */

namespace JasonWL\WeChat\Response\Producer;


class Text extends ResponseContentProducer
{
    public function __construct($fromUser, $toUser, $content)
    {
        parent::__construct($fromUser, $toUser);
        $this->replaceParamsPool['content'] = $content;
    }

    protected function template()
    {
        $template = <<<XML
<xml>
<ToUserName><![CDATA[@{toUser}]]></ToUserName>
<FromUserName><![CDATA[@{fromUser}]]></FromUserName>
<CreateTime>@{createTime}</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[@{content}]]></Content>
</xml>
XML;
        return $template;
    }

} 