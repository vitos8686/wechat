<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 14-12-24
 * Time: 下午12:17
 */

namespace JasonWL\WeChat\Request;


class XmlRequest extends \SimpleXMLIterator
{
    /**
     * @param $xmlStr
     * @return array
     */
    public static function parse($xmlStr)
    {
        $obj = simplexml_load_string($xmlStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        return self::objectToArray($obj);
    }

    private static function objectToArray($obj)
    {
        $_arr = is_object($obj) ? get_object_vars($obj) : $obj;
        foreach ($_arr as $key => $val) {
            $val = (is_array($val)) || is_object($val) ? self::objectToArray($val) : $val;
            $arr[$key] = $val;
        }
        return $_arr;
    }
}