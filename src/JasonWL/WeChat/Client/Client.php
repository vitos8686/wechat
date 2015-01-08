<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 14-12-25
 * Time: 下午12:18
 */

namespace JasonWL\WeChat\Client;


use Curl\Curl;
use JasonWL\WeChat\Event\AccessCacheEvent;
use JasonWL\WeChat\Event\Event;
use JasonWL\WeChat\Exception\WeChatException;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class Client
{
    CONST DEFINE_APP_ID = 'JASON_WL_WE_CHAT_APP_ID';
    CONST DEFINE_APP_SECRET = 'JASON_WL_WE_CHAT_APP_SECRET';
    protected $appID;
    protected $appSecret;
    protected $getParams;
    protected $postParams;
    protected $postFile;
    protected $url;
    /**
     * @var EventDispatcher
     */
    protected static $dispatcher;

    /**
     * @var AccessToken
     */
    protected $accessToken;

    /**
     * @throws WeChatException
     */
    public function __construct()
    {
        if (defined(self::DEFINE_APP_ID) && defined(self::DEFINE_APP_SECRET)) {
            $this->appID = constant(self::DEFINE_APP_ID);
            $this->appSecret = constant(self::DEFINE_APP_SECRET);
        }
        if (!$this->appID || !$this->appSecret) {
            throw new WeChatException("appid appsecret常量未定义");
        }
        $this->accessToken = new AccessToken();
    }

    /**
     * @return EventDispatcher
     */
    public static function getDispatcher()
    {
        if (!self::$dispatcher) {
            self::$dispatcher = new EventDispatcher();
        }
        return self::$dispatcher;
    }

    /**
     * 设置权限信息
     * @param $appID
     * @param $appSecret
     */
    public static function setWeChatInfo($appID, $appSecret)
    {
        define(self::DEFINE_APP_ID, $appID);
        define(self::DEFINE_APP_SECRET, $appSecret);
    }

    /**
     * 订阅事件驱动
     * @param EventSubscriberInterface $eventSubscriber
     */
    public static function addSubscriber(EventSubscriberInterface $eventSubscriber)
    {
        self::getDispatcher()->addSubscriber($eventSubscriber);
    }


    /**
     * @return mixed
     * @throws WeChatException
     */
    public function request()
    {
        $url = $this->url;
        $accessToken = $this->getAccessToken();
        $this->get('access_token', $accessToken);
        $getQueryString = http_build_query($this->getParams);
        $url = $this->getApiPrefix() . $url . '?' . $getQueryString;
        if ($this->postParams || $this->postFile) {
            $response = $this->doPost($url);
        } else {
            $response = $this->doGet($url);
        }
        $this->cleanRequestParams();
        return $this->parseResponse($response);
    }

    /**
     * @param $url
     * @return string
     * @throws WeChatException
     */
    private function doPost($url)
    {
        try {
            $curl = new Curl();
            if (!$this->postFile) {
                $curl->setHeader('Content-Type', 'application/json');
                $postData = json_encode($this->postParams, JSON_UNESCAPED_UNICODE);
            } else {
                $postData = $this->postFile;
            }
            $curl->post($url, $postData);
            if ($curl->error) {
                throw new WeChatException($curl->error_message, $curl->error_code);
            }
        } catch (\ErrorException $e) {
            throw new WeChatException($e->getMessage());
        }
        return $curl->raw_response;
    }

    /**
     * @param $url
     * @return null
     * @throws WeChatException
     */
    private function doGet($url)
    {
        try {
            $curl = new Curl();
            $curl->get($url);
            if ($curl->error) {
                throw new WeChatException($curl->error_message, $curl->error_code);
            }
        } catch (\ErrorException $e) {
            throw new WeChatException($e->getMessage());
        }
        return $curl->raw_response;
    }

    /**
     * @return mixed
     * @throws WeChatException
     */
    private function getAccessToken()
    {
        self::getDispatcher()->dispatch(
            Event::CLIENT_ACCESS_CACHE_GET,
            new AccessCacheEvent($this->accessToken)
        );
        if ($this->accessToken->getToken()) {
            return $this->accessToken->getToken();
        }
        $params = array(
            'grant_type' => 'client_credential',
            'appid' => $this->appID,
            'secret' => $this->appSecret
        );
        $url = ApiList::API_PREFIX . ApiList::AUTH_TOKEN;
        $curl = new Curl();
        $curl->get($url, $params);
        $result = $this->parseResponse($curl->raw_response);
        $result['create_time'] = time();
        $this->accessToken->setToken($result);
        self::getDispatcher()->dispatch(
            Event::CLIENT_ACCESS_CACHE_SET,
            new AccessCacheEvent($this->accessToken)
        );
        return $this->accessToken->getToken();
    }

    /**
     * @param $response
     * @return mixed
     * @throws WeChatException
     */
    protected function parseResponse($response)
    {
        $responseArr = json_decode($response, true);
        if (!is_array($responseArr)) {
            throw new WeChatException("微信端数据异常");
        }
        if (isset($responseArr['errcode']) && $responseArr['errcode'] != 0) {
            throw new WeChatException('微信端API的错误消息:' . $responseArr['errmsg'], $responseArr['errcode']);
        }
        return $responseArr;
    }

    protected function getApiPrefix()
    {
        return ApiList::API_PREFIX;
    }

    private function cleanRequestParams()
    {
        $this->getParams = null;
        $this->postParams = null;
        $this->postFile = null;
        $this->url = null;
    }

    protected function post($key, $val)
    {
        $this->postParams[$key] = $val;
        return $this;
    }

    protected function get($key, $val)
    {
        $this->getParams[$key] = $val;
        return $this;
    }

    protected function url($url)
    {
        $this->url = $url;
        return $this;
    }

    protected function upFile($file)
    {
        $this->postFile['media'] = '@' . $file;
        return $this;
    }


}