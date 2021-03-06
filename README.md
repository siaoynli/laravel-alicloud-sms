# laravel-alicloud-sdk-sms

#### 项目介绍

阿里云 SDK 发送短信包,一个号码 1 小时限制 5 条 一天限制 10 条

## install

this package for laravel

```
composer require siaoynli/laravel-alicloud-sms
```

add the

```
Siaoynli\AliCloud\Sms\LaravelAliCloudSmsServerProvider::class
```

to the providers array in config/app.php

```
php artisan vendor:publish --provider="Siaoynli\AliCloud\Sms\LaravelAliCloudSmsServerProvider"
```

## alias

```
 "Sms" => \Siaoynli\AliCloud\Sms\Facades\Sms::class,
```

## 使用方法

```php

use Siaoynli\AliCloud\Sms\Facades\Sms;

$message=[
  "code"=>"1234",  //code 对应模板里面的code 变量
  "product"=>"xx网", //product 对应模板里面的product 变量
];

          $result=Sms::to("18906715000")->signName("注册验证")->template("SMS_29010034")->send($message);
```

返回结果

```php
  "state" => 1
  "info" => array:4 [▼
    "Message" => "OK"
    "RequestId" => "A8A513E0-E631-4929-882B-7219D01F0E26"
    "BizId" => "442107374224819990^0"
    "Code" => "OK"
  ]

//或者
array:2 [▼
  "state" => 0
  "info" => array:3 [▼
    "Message" => "触发分钟级流控Permits:1"
    "RequestId" => "89BFE73F-84FC-42D7-90F8-AFFA6C42EB73"
    "Code" => "isv.BUSINESS_LIMIT_CONTROL"
  ]
]

```

# 使用通知

```php
//App\Notifications\TestNotification
use Siaoynli\NotificationChannels\AliSms\AliSmsChannel;
use Siaoynli\NotificationChannels\AliSms\AliSmsMessage;
use Illuminate\Notifications\Notification;

class TestNotification extends Notification implements ShouldQueue
{
    public function via($notifiable)
    {
        return [AliSmsChannel::class];
    }

     public function toAlisms($notifiable)
    {
        return (new AliSmsMessage)
            ->signName("登录验证")
            ->template('SMS_204975xxx')
            ->body([
                "product" => "xxxx"  //需要去阿里云修改实际模板
            ]);
    }

    /**
     * @param $response
     * @param $notifiable
     */
    public function toPayload($response, $notifiable)
    {
        logger($response);
        logger($notifiable->toArray());
    }


    public function failed(\Exception $exception)
    {

    }
}


//发送通知
 $user = User::find(1);
 $user->notify((new \App\Notifications\TestNotification())->delay(10));
//群发
$users = User::all();
Notification::send($users, new \App\Notifications\TestNotification());
```
