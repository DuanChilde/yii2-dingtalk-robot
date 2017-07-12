<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\DingTalk\Robot;


use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\Json;
use yii\httpclient\Client;

class Robot extends Component
{
    public $baseUrl = 'https://oapi.dingtalk.com/robot/send';
    public $accessToken;

    public function init()
    {
        parent::init();
        if ($this->accessToken == null) {
            throw new InvalidConfigException('请配置 "iPaya\DingTalk\Robot\Robot::accessToken"');
        }
    }

    /**
     * @param array $data
     * @return bool
     */
    public function send($data)
    {
        $httpClient = new Client();
        $response = $httpClient->createRequest()
            ->setUrl($this->baseUrl)
            ->setMethod('post')
            ->setFormat('application/json')
            ->setContent(Json::encode($data))
            ->send();
        if ($response->isOk) {
            $rs = Json::decode($response->content);
            if (isset($rs['errcode']) && $rs['errcode'] == 0) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param string $text
     * @param array $atMobiles
     * @param bool $isAtAll
     * @return bool
     */
    public function sendText($text, $atMobiles = [], $isAtAll = false)
    {
        $data = [
            'msgtype' => 'text',
            'text' => [
                'content' => $text,
            ],
            'at' => [
                'atMobiles' => $atMobiles,
                'isAtAll' => $isAtAll,
            ]
        ];
        return $this->send($data);
    }

    /**
     * @param string $title
     * @param string $text
     * @param string $url
     * @param string $picUrl
     * @return bool
     */
    public function sendLink($title, $text, $url, $picUrl = null)
    {
        $data = [
            'msgtype' => 'link',
            'link' => [
                'text' => $text,
                'title' => $title,
                'picUrl' => $picUrl,
                'messageUrl' => $url,
            ]
        ];
        return $this->send($data);
    }

    /**
     * @param string $title
     * @param string $markdownContent
     * @param array $atMobiles
     * @param bool $isAtAll
     * @return bool
     */
    public function sendMarkdown($title, $markdownContent, $atMobiles = [], $isAtAll = false)
    {
        $data = [
            'msgtype' => 'markdown',
            'markdown' => [
                'text' => $markdownContent,
                'title' => $title,
            ],
            'at' => [
                'atMobiles' => $atMobiles,
                'isAtAll' => $isAtAll
            ]
        ];
        return $this->send($data);
    }
}
