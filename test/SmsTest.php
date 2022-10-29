<?php
namespace gzdata\test;

// require_once '../src/Sms.php';

use gzdata\Sms;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Dotenv\Dotenv;

$env = new Dotenv();
$env->load(dirname(__DIR__) . '/.env');

class SmsTest extends TestCase  {


    /**
     * 测试发送短信
     * @test
     * @return void
     */
    public function testSend() {
        $sms = new Sms($_ENV['ACCOUNT'], $_ENV['PASSWORD']);
        list($success, $response) = $sms->send('18311548014', 'MB717503B8', ['5678']);
        $this->assertTrue($success);
        $this->assertIsArray($response);
    }


    /**
     * 测试发送自定义短信
     * @test
     * @return void
     */
    public function testSendRaw()
    {
        $sms = new Sms($_ENV['ACCOUNT'], $_ENV['PASSWORD']);
        list($success, $response) = $sms->sendRawContent('18311548014', '测试测试测试单元测试');
        $this->assertTrue($success);
        $this->assertIsArray($response);
    }
  

}