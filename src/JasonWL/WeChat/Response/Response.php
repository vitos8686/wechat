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

    /**
     * @var ResponseContentProducer
     */
    public $responseContentProducer;

    public function getContent()
    {
        if ($this->responseContentProducer) {
            return $this->responseContentProducer->produce();
        } else {
            return $this->content;
        }
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