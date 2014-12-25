<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 14-12-25
 * Time: 上午9:59
 */

namespace JasonWL\WeChat\Event\Listener;


use JasonWL\WeChat\Event\LoggerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

interface LoggerListenerInterface extends EventSubscriberInterface
{
    public function onLogger(LoggerEvent $event);
} 