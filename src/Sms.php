<?php

namespace gzdata;


/**
 * 短信SDK
 */
class Sms {

    protected $app_id = null;
    protected $app_secret = null;
    // 调试模式
    protected $debug = false;


    /**
     * client
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;


    public function __construct($app_id='', $app_secret='', $debug=false)
    {
        $this->app_id = $app_id;
        $this->app_secret = $app_secret;
        $this->debug = $debug;


        $this->client = new \GuzzleHttp\Client([
            'base_uri'  => 'http://sendsms.gzdata.com.cn',
            'verify'    => false, // 忽略 ssl
            'timeout'   => 0
        ]);
    }


    /**
     * 发送短信通知
     *
     * @param string $mobile 手机号
     * @param string $template_id 短信模板id
     * @param array $tag 参数，用做替代模板中的@1@变量
     * @return array [bool:success, array:responseArray]
     * @throws \GuzzleHttp\Exception\*
     */
    public function send(string $mobile, string $template_id, array $tag=[]):array {
        $content = sprintf('验证码为： % s，若非本人操作，请勿泄露。', $tag[0]??'0000'); // 兼容jumdata的短信sdk做法,  实际只用来发验证码
        return $this->sendRawContent($mobile, $content);
    }




    
    /**
     * 发送原始文本短信
     *
     * @param string $mobile
     * @param string $content
     * @return array [bool:success, array:responseArr]
     * @throws \GuzzleHttp\Exception\*
     */
    public function sendRawContent(string $mobile, string $content):array 
    {
        // 请求ID
        $reqId = md5(microtime(true) . uniqid('sms'));

        // 参数
        $postData = [
            'account'    => $_ENV['ACCOUNT'],
            'password'   => $_ENV['PASSWORD'],
            'mobile'     => $mobile,
            'content'    => $content,
            'requestId'  => $reqId,
        ];

        $response = $this->client->post('/smsapi/smsapi/send.json', array(
            'json'      => $postData,
        ));

        $respText = $response->getBody()->getContents();
        $respArr = json_decode($respText, true);
        $success = ($respArr['status'] == 10 && $respArr['errorCode'] == 'ALLSuccess');

        return [$success, $respArr];
    }

}