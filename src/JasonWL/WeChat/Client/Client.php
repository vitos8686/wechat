<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 14-12-25
 * Time: 下午12:18
 */

namespace JasonWL\WeChat\Client;


use JasonWL\WeChat\Exception\WeChatException;
use Kdyby\Curl\CurlException;
use Kdyby\Curl\Request;
use Kdyby\Curl\Response;

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
     * @param string $appID
     * @param string $appSecret
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
     * @param $url
     * @throws WeChatException
     */
    public function request()
    {
        $url = $this->url;
        $accessToken = $this->getAccessToken();
        $this->get('access_token', $accessToken);
        $getQueryString = http_build_query($this->getParams);
        $url = $this->getApiPrefix() . $url . '?' . $getQueryString;
        if ($this->postParams) {
            $response = $this->doPost($url);
        } else {
            $response = $this->doGet($url);
        }
        $this->cleanRequestParams();
        return $this->parseResponse($response);
    }

    /**
     * @todo 别忘了加入缓存机制
     * @return mixed
     * @throws WeChatException
     */
    private function getAccessToken()
    {
        $params = array(
            'grant_type' => 'client_credential',
            'appid' => $this->appID,
            'secret' => $this->appSecret
        );
        $url = $this->getApiPrefix() . ApiList::AUTH_TOKEN;
        $curlRequest = new Request($url);
        $response = $curlRequest->get($params);
        $result = $this->parseResponse($response);
        return $result['access_token'];
    }

    protected function parseResponse(Response $response)
    {
        $content = $response->getResponse();
        $contentArr = json_decode($content, true);
        if (!is_array($contentArr)) {
            throw new WeChatException("微信端数据异常");
        }
        if (isset($contentArr['errcode']) && $contentArr['errcode'] != 0) {
            throw new WeChatException("错误码:{$contentArr['errcode']},原因:{$contentArr['errmsg']}");
        }
        return $contentArr;
    }

    /**
     * @param $url
     * @return \Kdyby\Curl\Response
     * @throws WeChatException
     */
    private function doPost($url)
    {
        $curlRequest = new Request($url);
        $curlRequest->headers['Content-Type'] = 'application/json';
        $postParams = json_encode($this->postParams, JSON_UNESCAPED_UNICODE);
        try {
            $response = $curlRequest->post($postParams);
        } catch (CurlException $e) {
            throw new WeChatException($e->getMessage());
        }
        return $response;
    }

    /**
     * @param $url
     * @return \Kdyby\Curl\Response
     * @throws WeChatException
     */
    private function doGet($url)
    {
        $curlRequest = new Request($url);
        try {
            $response = $curlRequest->get();
        } catch (CurlException $e) {
            throw new WeChatException($e->getMessage());
        }
        return $response;
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
    }

    protected function upFile($file)
    {
        $this->postFile = $file;
        return $this;
    }


}