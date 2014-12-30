<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 14-12-30
 * Time: 上午11:44
 */

namespace JasonWL\WeChat\Client;


use JasonWL\WeChat\Exception\WeChatException;

class Media extends Client
{

    const IMAGE = 'image';
    const VIDEO = 'video';
    const VOICE = 'voice';
    const THUMB = 'thumb';

    /**
     * @param string $type
     * @param $filePath
     * @throws WeChatException
     */
    public function __construct($type = self::IMAGE, $filePath)
    {
        parent::__construct();
        if (!file_exists($filePath) || !is_readable($filePath)) {
            throw new WeChatException('待上传的文件不可读或不存在:' . $filePath);
        }
        $this->upFile($filePath)
            ->get('type', $type)
            ->url(ApiList::UPLOAD_MEDIA);
    }

    /**
     * 上传媒体文件接口地址前缀与其他接口不同
     * @return null|string
     */
    protected function getApiPrefix()
    {
        return null;
    }


} 