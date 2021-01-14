<?php

namespace  Siaoynli\AliCloud\Sms\Exceptions;

use Exception;

class CouldNotSendNotification extends Exception
{
    public static function serviceRespondedWithAnError(string $error): self
    {
        return new static("AliSms service responded with an error: {$error}'");
    }
}
