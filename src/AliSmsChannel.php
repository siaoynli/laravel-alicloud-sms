<?php

namespace Siaoynli\AliCloud\Sms;

use Illuminate\Notifications\Notification;

/**
 * Class AliSmsChannel
 * @package Siaoynli\NotificationChannels\AliSms
 */
class AliSmsChannel
{

    public function send($notifiable, Notification $notification)
    {

        $message = $notification->toAlisms($notifiable);
        try {
            $response = \Siaoynli\AliCloud\Sms\Facades\Sms::to($notifiable->phone)->signName($message->signName)->template($message->template)->send($message->body);
            $this->buildPayload($response, $notifiable, $notification);
        } catch (\Exception $e) {
            throw \Siaoynli\AliCloud\Sms\Exceptions\CouldNotSendNotification::serviceRespondedWithAnError($e->getMessage());
        }
    }

    /**
     * @param $response
     * @param $notifiable
     * @param Notification $notification
     * @return mixed
     * 发送短信之后执行的操作
     */
    protected function buildPayload($response, $notifiable, Notification $notification)
    {
        if (method_exists($notification, 'toPayload')) {
            return $notification->toPayload($response, $notifiable);
        }
    }
}
