<?php
/**
 * PRODUCTION entry script — InfinityFree (yoki boshqa shared hosting) uchun.
 * Joylashuvi: htdocs/index.php
 * Ilovaning qolgan qismi: htdocs/app/ (vendor, config, controllers, models, views, ...)
 */
defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_ENV') or define('YII_ENV', 'prod');

require __DIR__ . '/app/vendor/autoload.php';
require __DIR__ . '/app/vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/app/config/web.php';

(new yii\web\Application($config))->run();
