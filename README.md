<h1 align="center"> baidu-translator </h1>

<p align="center"> 百度翻译 SDK.</p>

[![Build Status](https://travis-ci.org/her-cat/baidu-translator.svg?branch=master)](https://travis-ci.org/her-cat/baidu-translator) 
[![StyleCI build status](https://github.styleci.io/repos/196751395/shield)](https://github.styleci.io/repos/196751395)
[![Latest Stable Version](https://poser.pugx.org/her-cat/baidu-translator/v/stable)](https://packagist.org/packages/her-cat/baidu-translator) 
[![Latest Unstable Version](https://poser.pugx.org/her-cat/baidu-translator/v/unstable)](https://packagist.org/packages/her-cat/baidu-translator) 
[![License](https://poser.pugx.org/her-cat/baidu-translator/license)](https://packagist.org/packages/her-cat/baidu-translator)

## 安装

```shell
$ composer require her-cat/baidu-translator -vvv
```

## 配置

使用本扩展前，你需要去 [百度翻译开放平台](ht://api.fanyi.baidu.com/api/trans/product/index) 注册账号，然后获取应用的 `APP ID` 和 `密钥`。

## 使用

```php
use HerCat\BaiduTranslator\BaiduTranslator;

$appId = 'APP ID';
$key = '密钥';

$translator = new BaiduTranslator($appId, $key);
```

翻译：

```php
$text = 'hello';    // 需要翻译的内容
$to = 'zh';         // 译文语言
$from = 'auto';     // 翻译源语言，`auto` 表示自动获取
$format = 'json';   // 格式化结果

$result = $translator->translate($text, $to, $from, $format);
```

返回示例：

```json
{
    "from":"en",
    "to":"zh",
    "trans_result":[
        {
            "src":"hello",
            "dst":"你好"
        }
    ]
}
```

### 在 Laravel 中使用

在 Laravel 中使用也是同样的安装方式，配置写在 config/translator.php 中：

```php
return [
    'app_id' => env('BAIDU_TRANSLATOR_APP_ID'),
    'key' => env('BAIDU_TRANSLATOR_KEY'),
];
```

然后在 .env 中配置 ：

```dotenv
BAIDU_TRANSLATOR_APP_ID=xxxxxxxxxxxxx
BAIDU_TRANSLATOR_KEY=xxxxxxxxxxxxx
```

可以用两种方式来获取 `HerCat\BaiduTranslator\BaiduTranslator` 实例：

#### 方法参数注入

```php
.
.
.
public function show(BaiduTranslator $translator) 
{
    $response = $translator->translate('hello');
}
.
.
.
```

#### 服务名访问

```php
.
.
.
public function show() 
{
    $response = app('baiduTranslator')->translate('hello');
}
.
.
.
```

## 参考

- [百度翻译开放平台文档](http://api.fanyi.baidu.com/api/trans/product/apidoc)
- [PHP 扩展包实战教程 - 从入门到发布](https://learnku.com/courses/creating-package)

## License

MIT
