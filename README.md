# 钉钉自定义机器人

## 安装

使用 `composer` 安装

```bash
composer require --prefer-dist "ipaya/yii2-dingtalk-robot:*"
```

## 使用方法

```php
<?php

use iPaya\DingTalk\Robot\Robot;

$robot = new Robot([
    'accessToken' => '<你的聊天机器人 Access Token>'
]);

$robot->sendText('机器人消息');
```
