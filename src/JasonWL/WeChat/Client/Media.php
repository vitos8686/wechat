<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 14-12-30
 * Time: 上午11:44
 */

namespace JasonWL\WeChat\Client;


use Curl\Curl;
use JasonWL\WeChat\Exception\WeChatException;

class Media extends Client
{

    const IMAGE = 'image';
    const VIDEO = 'video';
    const VOICE = 'voice';
    const THUMB = 'thumb';

    public function __construct()
    {
        parent::__construct();

    }

    public function upload($type = self::IMAGE, $filePath)
    {
        if (!file_exists($filePath) || !is_readable($filePath)) {
            throw new WeChatException('待上传的文件不可读或不存在:' . $filePath);
        }
        $this->upFile($filePath)
            ->get('type', $type)
            ->url(ApiList::MEDIA_UPLOAD);
        return $this->request();
    }

    public function uploadNews($articles)
    {
        $this->post('articles', $articles)
            ->url('https://api.weixin.qq.com/cgi-bin/media/uploadnews');
        return $this->request();
    }

    /**
     * @param $mediaId
     * @param $localFile
     */
    public function download($mediaId, $localFile)
    {
        $this->get('media_id', $mediaId);
        $accessToken = $this->getAccessToken();
        $this->get('access_token', $accessToken);
        $getQueryString = http_build_query($this->getParams);
        $url = ApiList::MEDIA_DOWNLOAD . '?' . $getQueryString;
        self::curlGetFile($url, $localFile);
    }

    /**
     * 上传媒体文件接口地址前缀与其他接口不同
     * @return null|string
     */
    protected function getApiPrefix()
    {
        return null;
    }

    public static function curlGetFile($url, $localFile)
    {
        $ch = curl_init($url);
        $fp = fopen($localFile, 'w');
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
    }


}