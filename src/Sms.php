<?php

namespace Siaoynli\AliCloud\Sms;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use Illuminate\Config\Repository;
use mysql_xdevapi\Exception;


class Sms
{

    protected $config;
    protected $client;
    protected $request;
    protected $phone;
    protected $template;
    protected $sign_name;

    protected $error_code=[
        "SMS_TEMPLATE_ILLEGAL"=>"模板不合法(不存在或被拉黑)",
        "SMS_SIGNATURE_ILLEGAL"=>"签名不合法(不存在或被拉黑)",
        "MOBILE_NUMBER_ILLEGAL"=>"无效号码",
        "TEMPLATE_MISSING_PARAMETERS"=>"模板变量缺少对应参数值",
        "EXTEND_CODE_ERROR"=>"扩展码使用错误",
        "DOMESTIC_NUMBER_NOT_SUPPORTED"=>"港澳台消息模板不支持发送境内号码",
        "DAY_LIMIT_CONTROL"=>"触发日发送限额",
        "SMS_CONTENT_ILLEGAL"=>"短信内容包含禁止发送内容",
        "SMS_SIGN_ILLEGAL"=>"签名禁止使用",
        "PRODUCT_UNSUBSCRIBE"=>"产品未开通",
        "ACCOUNT_NOT_EXISTS"=>"账户不存在",
        "BUSINESS_LIMIT_CONTROL"=>"业务限流",
    ];


    public function __construct(Repository $config)
    {
        $this->config = $config->get("alicloud-sms");
        try {
            $this->client = AlibabaCloud::accessKeyClient($this->config["key"], $this->config["secret"])
                ->regionId($this->config["region"])
                ->asDefaultClient();
        } catch (ClientException $e) {
            throw  new ClientException("ClientException :" . $e->getMessage());
        }
    }


    public function to($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    public function signName($sign_name = "注册验证")
    {
        $this->sign_name = $sign_name;
        return $this;
    }


    public function template($template)
    {
        $this->template = $template;
        return $this;
    }

    /**
     * @Author: hzwlxy
     * @Email: 120235331@qq.com
     * @Date: 2019/11/20 12:40
     * @Description:
     * @param null $template_param
     * @return array
     * @throws ClientException
     * @throws ServerException
     */
    public function send($template_param = null)
    {
        if (!$template_param) {
            throw  new \Exception("请传入正确的TemplateParam参数");
        }

        $this->sign_name = $this->sign_name ?: $this->config["sign_name"];
        $this->template = $this->template ?: $this->config["template_code"];

        if (is_array($template_param)) {
            $template_param = json_encode($template_param);
        }
        $client_type = $this->config["client_type"] ?? "http";
        try {
            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                ->scheme($client_type) // https | http
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->host('dysmsapi.aliyuncs.com')
                ->options([
                    'query' => [
                        'RegionId' => $this->config["region"],
                        'PhoneNumbers' => $this->phone,
                        'SignName' => $this->sign_name,
                        'TemplateCode' => $this->template,
                        'TemplateParam' => $template_param,
                    ],
                ])
                ->request();
            $result = $result->toArray();
            if ($result["Code"] == "OK") {
                return ["state" => 1, "info" => $result];
            } else {
                return ["state" => 0, "info" => $result];
            }
        } catch (ClientException $e) {
            throw  new ClientException("ClientException :" . $e->getErrorMessage());
        } catch (ServerException $e) {
            throw  new ServerException("ServerException :" . $e->getErrorMessage());
        }
    }


}
