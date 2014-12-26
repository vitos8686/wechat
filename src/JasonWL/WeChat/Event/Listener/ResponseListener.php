<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 14-12-24
 * Time: 下午3:01
 */

namespace JasonWL\WeChat\Event\Listener;


use JasonWL\WeChat\Event\ResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

abstract class ResponseListener implements EventSubscriberInterface
{
    /**
     * @param ResponseEvent $event
     * @return mixed
     */
    abstract public function onResponse(ResponseEvent $event);
}