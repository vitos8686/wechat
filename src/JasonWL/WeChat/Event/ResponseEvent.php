<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 14-12-24
 * Time: 下午2:38
 */

namespace JasonWL\WeChat\Event;


use JasonWL\WeChat\Request\Request;
use JasonWL\WeChat\Response\Response;
use Symfony\Component\EventDispatcher\Event;

class ResponseEvent extends Event
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var Response
     */
    private $response;

    public function __construct(Response $response, Request $request)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }
} 