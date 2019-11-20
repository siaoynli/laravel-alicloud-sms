# laravel-alicloud-sdk-sms

#### 项目介绍

阿里云SDK发送短信包,一个号码1小时限制5条 一天限制10条

## install

this package  for laravel

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
$message=[
  "code"=>"1234",
  "product"=>"xx网",
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

