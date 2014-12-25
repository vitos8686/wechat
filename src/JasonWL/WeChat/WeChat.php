<?php
namespace JasonWL\WeChat;


use JasonWL\WeChat\Event\Event;
use JasonWL\WeChat\Event\LoggerEvent;
use JasonWL\WeChat\Event\ResponseEvent;
use JasonWL\WeChat\Exception\WeChatException;
use JasonWL\WeChat\Request\Request;
use JasonWL\WeChat\Response\Response;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class WeChat
{
    protected $token;
    /**
     * 微信发过来的请求内容，并解析成array格式的
     * @var \JasonWL\WeChat\Request\Request
     */
    protected $request;

    /**
     * 返回给微信的内容
     * @var \JasonWL\WeChat\Response\Response
     */
    protected $response;

    protected $dispatcher;

    /**
     * @var bool
     */
    protected $debug = false;

    /**
     *
     * @param string $token 填写的URL需要正确响应微信发送的Token验证
     * @param $appID
     * @param $appSecret
     */
    public function __construct($token)
    {
        $this->$token = $token;
        $this->response = new Response();
        $this->dispatcher = new EventDispatcher();
    }

    /**
     * 响应微信事件、消息的入口
     *
     * @return Response
     * @throws WeChatException
     */
    public function handle()
    {
        if (!$this->checkSignature()) {
            throw new WeChatException('来源验证失败');
        }

        if ($this->isUrlValidate()) {
            $this->response = $_GET['echostr'];
            return $this->response;
        }

        if (!isset($GLOBALS['HTTP_RAW_POST_DATA']) && !$this->debug) {
            throw new WechatException('未接收到HTTP_RAW_POST_DATA');
        }
        $this->request = new Request($GLOBALS['HTTP_RAW_POST_DATA']);
        $this->eventDistributer($this->request);
        $this->dispatcher->dispatch(
            Event::SERVICE_LOGGER,
            new LoggerEvent($this->response, $this->request)
        );
        return $this->response;
    }

    protected function eventDistributer()
    {
        $event = strtolower($this->request->getEvent());
        $msgType = strtolower($this->request->getMsgType());
        if ($msgType === 'event') {
            if ($event === Event::EVENT_SUBSCRIBE) {
                if ($this->request->getArrayContent('EventKey')) {
                    $this->dispatcher->dispatch(
                        Event::EVENT_QRCODE_SUBSCRIBE,
                        new ResponseEvent($this->response, $this->request)
                    );
                    return;
                }
            }
            $this->dispatcher->dispatch(
                $event,
                new ResponseEvent($this->response, $this->request)
            );
        } else {
            $this->dispatcher->dispatch(
                $msgType,
                new ResponseEvent($this->response, $this->request)
            );
        }
    }

    /**
     * 判断此次发来的请求的真实性
     * @return bool
     */
    private function checkSignature()
    {
        if (true === $this->debug) {
            return true;
        }
        if (!(isset($_GET['signature']) && isset($_GET['timestamp']) && isset($_GET['nonce']))) {
            return false;
        }
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = $this->$token;
        $tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        return $tmpStr === $signature;
    }

    /**
     * 判断此次请求是否为验证URL真实性请求
     * @return bool
     */
    public function isUrlValidate()
    {
        return isset($_GET['echostr']);
    }

    public function debug($opt = false)
    {
        $this->debug = $opt;
    }

    /**
     * @return EventDispatcher
     */
    public function getDispatcher()
    {
        return $this->dispatcher;
    }

    public function addSubscriber(EventSubscriberInterface $listener)
    {
        $this->getDispatcher()->addSubscriber($listener);
    }

}