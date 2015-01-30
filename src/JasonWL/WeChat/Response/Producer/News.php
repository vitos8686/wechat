<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 15-1-30
 * Time: 下午5:52
 */

namespace JasonWL\WeChat\Response\Producer;


class News extends ResponseContentProducer
{
    /**
     * @param $fromUser
     * @param $toUser
     * @param $articles
     */
    public function __construct($fromUser, $toUser, $articles)
    {
        parent::__construct($fromUser, $toUser);
        $count = 0;
        $articleStr = "";
        foreach ($articles as $article) {
            $count++;
            $articleStr .= $article->produce();
        }
        $this->replaceParamsPool['articleCount'] = $count;
        $this->replaceParamsPool['articles'] = $articleStr;
    }

    protected function template()
    {
        $template = <<<XML
<xml>
<ToUserName><![CDATA[@{toUser}]]></ToUserName>
<FromUserName><![CDATA[@{fromUser}]]></FromUserName>
<CreateTime>@{createTime}</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
<ArticleCount>@{articleCount}</ArticleCount>
<Articles>@{articles}</Articles>
</xml>
XML;
        return $template;
    }
}