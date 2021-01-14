<?php

namespace  Siaoynli\AliCloud\Sms;

/**
 * Class AliSmsMessage
 * @package Siaoynli\NotificationChannels\AliSms
 */
class AliSmsMessage
{

    /**
     * @var
     */
    public $template;
    /**
     * @var null
     */
    public $signName = null;
    /**
     * @var null
     */
    public $body = null;

    /**
     * AliSmsMessage constructor.
     * @param array $message
     * 短信内容变量信息
     */
    public function __construct(array $message = [])
    {
        $this->body($message);
    }

    /**
     * @param string $signName
     * @return $this
     * 短信签名
     */
    public function signName(string $signName)
    {
        $this->signName = $signName;
        return $this;
    }

    /**
     * @param string $template
     * @return $this
     * 短信模板
     */
    public function template(string $template)
    {
        $this->template = $template;
        return $this;
    }

    /**
     * @param array $message
     * @return $this
     */
    public function body(array $message = [])
    {
        $this->body = $message;
        return $this;
    }


}
