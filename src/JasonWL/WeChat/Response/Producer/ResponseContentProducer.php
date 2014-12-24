<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 14-12-24
 * Time: 下午5:20
 */

namespace JasonWL\WeChat\Response\Producer;


abstract class ResponseContentProducer
{
    /**
     * @var
     */
    protected $replaceParamsPool;

    public function __construct($fromUser, $toUser)
    {
        $this->replaceParamsPool['toUser'] = $toUser;
        $this->replaceParamsPool['fromUser'] = $fromUser;
    }

    abstract protected function template();

    public function produce()
    {
        $this->replaceParamsPool['createTime'] = time();
        $replace = array();
        $search = array();
        foreach ($this->replaceParamsPool as $key => $val) {
            $search[] = '@{' . $key . '}';
            $replace[] = $val ? $val : '';
        }
        return str_replace($search, $replace, $this->template());
    }
}
