<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 14-12-25
 * Time: 上午9:59
 */

namespace JasonWL\WeChat\Event\Listener;


use JasonWL\WeChat\Event\Event;
use JasonWL\WeChat\Event\LoggerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

abstract class LoggerListener implements EventSubscriberInterface
{
    /**
     * @param LoggerEvent $event
     * @return mixed
     */
    abstract public function onLogger(LoggerEvent $event);

    public static function getSubscribedEvents()
    {
        return array(Event::SERVICE_LOGGER => 'onLogger');
    }
} 