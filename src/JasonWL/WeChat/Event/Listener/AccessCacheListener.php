<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 14-12-26
 * Time: 上午9:47
 */

namespace JasonWL\WeChat\Event\Listener;


use JasonWL\WeChat\Event\AccessCacheEvent;
use JasonWL\WeChat\Event\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

abstract class AccessCacheListener implements EventSubscriberInterface
{
    /**
     * 存储缓存的实现
     * @param AccessCacheEvent $accessCacheEvent
     * @return mixed
     */
    abstract public function onSetCache(AccessCacheEvent $accessCacheEvent);

    /**
     * 读取缓存的实现
     * @param AccessCacheEvent $accessCacheEvent
     * @return mixed
     */
    abstract public function onGetCache(AccessCacheEvent $accessCacheEvent);

    /**
     * 你可以重写此方法，设置事件优先级等等..
     * 注册事件名称与触发方法的映射关系
     * 在此事件中我们必须得设置以下两个事件：
     * return array(
     *      Event::CLIENT_ACCESS_CACHE_SET => 'onSetCache',
     *      Event::CLIENT_ACCESS_CACHE_GET => 'onGetCache'
     * );
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            Event::CLIENT_ACCESS_CACHE_GET => 'onGetCache',
            Event::CLIENT_ACCESS_CACHE_SET => 'onSetCache'
        );
    }
} 