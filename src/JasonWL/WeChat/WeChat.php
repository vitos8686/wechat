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
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
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
        $this->request = new Request(isset($GLOBALS['HTTP_RAW_POST_DATA']) ?
                $GLOBALS['HTTP_RAW_POST_DATA'] : ''
        );
        if (!$this->checkSignature()) {
            throw new WeChatException('来源验证失败');
        }

        if ($this->isUrlValidate()) {
            $this->response->setContent($_GET['echostr']);
            return $this->response;
        }

        if (!isset($GLOBALS['HTTP_RAW_POST_DATA']) && !$this->debug) {
            throw new WechatException('未接收到HTTP_RAW_POST_DATA');
        }
        $this->eventDistributer($this->request);
        $this->logger();
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
            if ($event === Event::EVENT_CLICK) {
                if ($this->request->getArrayContent('EventKey')) {
                    $this->dispatcher->dispatch(
                        strtoupper($this->request->getArrayContent('EventKey')),
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
            $this->logger('$_GET is empty');
            return false;
        }
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $tmpArr = array($this->token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if ($tmpStr === $signature) {
            return true;
        } else {
            $this->logger($tmpStr . '!==' . $signature);
            return false;
        }
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

    public function logger($content = false)
    {
        if ($content) {
            $content = $this->response->getContent() . "\n" . $content;
            $this->response->setContent($content);
        }
        $this->dispatcher->dispatch(
            Event::SERVICE_LOGGER,
            new LoggerEvent($this->response, $this->request)
        );
    }

}