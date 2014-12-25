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

interface ResponseListenerInterface extends EventSubscriberInterface
{
    public function onResponse(ResponseEvent $event);
}