<?php

namespace  Siaoynli\AliCloud\Sms;

use Illuminate\Notifications\Notification;

/**
 * Class AliSmsChannel
 * @package Siaoynli\NotificationChannels\AliSms
 */
class AliSmsChannel
{

    /**
     * AliSmsChannel constructor.
     */
    public function __construct()
    {
    }


    public function send($notifiable, Notification $notification)
    {

        $message = $notification->toAlisms($notifiable);
        try {
            return \Siaoynli\AliCloud\Sms\Facades\Sms::to($notifiable->phone)->signName($message->signName)->template($message->template)->send($message->body);
        } catch (\Exception $e) {
            throw \Siaoynli\AliCloud\Sms\Exceptions\CouldNotSendNotification::serviceRespondedWithAnError($e->getMessage());
        }
    }
}
