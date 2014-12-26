<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 14-12-24
 * Time: 下午3:19
 */

namespace JasonWL\WeChat\Event;


class Event
{
    /**
     * 服务器被动响应时(微信端发来消息时)所触发的日志驱动事件
     */
    CONST SERVICE_LOGGER = 'service_logger';
    CONST CLIENT_ACCESS_CACHE_SET = 'set_client_access_cache';
    CONST CLIENT_ACCESS_CACHE_GET = 'get_client_access_cache';

    CONST MESSAGE_TEXT = 'text';
    CONST MESSAGE_IMAGE = 'image';
    CONST MESSAGE_VOICE = 'voice';
    CONST MESSAGE_VIDEO = 'video';
    CONST MESSAGE_LOCATION = 'location';
    CONST MESSAGE_LINK = 'link';
    CONST MESSAGE_UNKNOW = 'unknow_message';

    CONST EVENT_SUBSCRIBE = 'subscribe';
    CONST EVENT_UNSUBSCRIBE = 'unsubscribe';
    /**
     * 扫描二维码并关注
     */
    CONST EVENT_QRCODE_SUBSCRIBE = 'qrcode_subscribe';
    /**
     * 已关注过之后扫描二维码
     */
    CONST EVENT_QRCODE_SCAN = 'scan';
    /**
     * 上报地理位置的事件
     */
    CONST EVENT_LOCATION = 'location';
    /**
     * 点击菜单拉取消息时的事件推送
     */
    CONST EVENT_CLICK = 'click';
    /**
     * 点击菜单跳转链接时的事件推送
     */
    CONST EVENT_VIEW = 'view';
    CONST EVENT_UNKNOW = 'unknow_event';

} 