<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 14-12-24
 * Time: 下午2:01
 */

namespace JasonWL\WeChat\Response;


use JasonWL\WeChat\Response\Producer\ResponseContentProducer;

class Response
{
    /**
     * @var string
     */
    public $content;

    protected $producedContentCache;

    /**
     * @var ResponseContentProducer
     */
    public $responseContentProducer;

    public function getContent()
    {
        if ($this->producedContentCache) {
            return $this->producedContentCache;
        }
        if ($this->responseContentProducer) {
            $this->producedContentCache = $this->responseContentProducer->produce();
            return $this->producedContentCache;
        }
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function setProducer(ResponseContentProducer $responseContentProducer)
    {
        $this->responseContentProducer = $responseContentProducer;
    }
} 