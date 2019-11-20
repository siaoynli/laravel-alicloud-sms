<?php
/*
* @Author: hzwlxy
* @Email: 120235331@qq.com
* @Github: http：//www.github.com/siaoynli
* @Date: 2019/7/5 11:15
* @Version:
* @Description:
*/

namespace Siaoynli\AliCloud\Sms\Facades;

use Illuminate\Support\Facades\Facade;

class Sms extends Facade
{
    protected static function getFacadeAccessor() {
        return 'sms';
    }
}
