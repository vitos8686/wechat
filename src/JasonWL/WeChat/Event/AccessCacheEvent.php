<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 14-12-26
 * Time: 上午9:11
 */

namespace JasonWL\WeChat\Event;

use JasonWL\WeChat\Client\AccessToken;
use Symfony\Component\EventDispatcher\Event as SymfonyEvent;

class AccessCacheEvent extends SymfonyEvent
{
    /**
     * @var AccessToken
     */
    public $accessToken;

    /**
     * @param AccessToken $accessToken
     * @param bool $isForSave 此次请求是存缓存还是取缓存
     */
    public function __construct(AccessToken $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return AccessToken
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }
} 