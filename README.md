
# 云上贵州短信SDK


**安装**

```
composer require yuxiaobo/gzdata_sms_sdk
```

## 单元测试

```
./vendor/bin/phpunit test/SmsTest.php
```

## 短信SDK
> 已完成

- send 发送短信
- sendRawContent 发送自定义短信


#### 发送短信

```php
$sms = new Sms($_ENV['ACCOUNT'], $_ENV['PASSWORD']);
list($success, $response) = $sms->send('183****014', '无需填入, 兼容jumdata语法', ['5678']);

if ($success == false) {
    // 短信发送失败
}
```