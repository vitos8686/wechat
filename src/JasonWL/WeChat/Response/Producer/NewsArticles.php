<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 15-1-30
 * Time: 下午5:52
 */

namespace JasonWL\WeChat\Response\Producer;


class NewsArticles extends ResponseContentProducer
{
    public function __construct($title, $description, $picurl, $url)
    {
        $this->replaceParamsPool['title'] = $title;
        $this->replaceParamsPool['description'] = $description;
        $this->replaceParamsPool['picurl'] = $picurl;
        $this->replaceParamsPool['url'] = $url;
    }

    protected function template()
    {
        $template = <<<XML
<item>
<Title><![CDATA[@{title}]]></Title>
<Description><![CDATA[@{description}]]></Description>
<PicUrl><![CDATA[@{picurl}]]></PicUrl>
<Url><![CDATA[@{url}]]></Url>
</item>
XML;
        return $template;
    }
}