<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 14-12-24
 * Time: 下午12:39
 */

namespace JasonWL\WeChat\Request;


class Request
{
    protected $raw_content;
    protected $array_content;

    public function __construct($xmlStr)
    {
        $this->raw_content = $xmlStr;
        $this->parseToArray();
    }

    public function parseToArray()
    {
        $array_content = XmlRequest::parse($GLOBALS['HTTP_RAW_POST_DATA']);
        $this->array_content = array_change_key_case($array_content, CASE_LOWER);
    }

    public function getRawContent()
    {
        return $this->raw_content;
    }

    public function getArrayContent($param = false)
    {
        if (false === $param) {
            return $this->array_content;
        }
        $param = strtolower($param);
        if (isset($this->array_content[$param])) {
            return $this->array_content[$param];
        }
        return null;
    }

    public function getFromUserName()
    {
        return $this->getArrayContent('FromUserName');
    }

    public function getToUserName()
    {
        return $this->getArrayContent('ToUserName');
    }

    public function getCreateTime()
    {
        return $this->getArrayContent('CreateTime');
    }

    public function getEvent()
    {
        return $this->getArrayContent('Event');
    }

    public function getMsgType()
    {
        return $this->getArrayContent('MsgType');
    }

    public function getMsgId()
    {
        return $this->getArrayContent('MsgId');
    }

} 