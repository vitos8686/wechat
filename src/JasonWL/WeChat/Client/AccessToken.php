<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 14-12-26
 * Time: 上午9:17
 */

namespace JasonWL\WeChat\Client;


class AccessToken
{
    private $token;

    private $tokenExpire;

    private $tokenCreateTime;

    /**
     * @return bool
     */
    public function checkExpire()
    {
        $calcTime = $this->getTokenCreateTime() + $this->getTokenExpire();
        return $calcTime > time();
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        if ($this->checkExpire()) {
            return $this->token;
        }
        return false;
    }

    /**
     * @param array $token
     */
    public function setToken($token)
    {
        $this->token = $token['access_token'];
        $this->setTokenExpire($token['expires_in']);
        $this->setTokenCreateTime($token['create_time']);
    }

    /**
     * @return mixed
     */
    public function getTokenCreateTime()
    {
        return $this->tokenCreateTime;
    }

    /**
     * @param mixed $tokenCreateTime
     */
    public function setTokenCreateTime($tokenCreateTime)
    {
        $this->tokenCreateTime = $tokenCreateTime;
    }

    /**
     * @return mixed
     */
    public function getTokenExpire()
    {
        return $this->tokenExpire;
    }

    /**
     * @param mixed $tokenExpire
     */
    public function setTokenExpire($tokenExpire)
    {
        $this->tokenExpire = $tokenExpire;
    }


} 