<?php
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'muallim',
    'name' => 'Muallim',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'uz',
    'sourceLanguage' => 'uz',
    'timeZone' => 'Asia/Tashkent',
    'defaultRoute' => 'site/index',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
        ],
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'muallim-secret-key-2026',
            'baseUrl' => '',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['/kirish'],
            'identityCookie' => ['name' => '_muallimIdentity', 'httpOnly' => true],
        ],
        'session' => [
            'name' => 'muallim_session',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',

                // Auth
                'kirish'  => 'auth/login',
                'chiqish' => 'auth/logout',
                'royxat'  => 'auth/register',

                // Alifbo (Arabic letters)
                'alifbo'          => 'letter/index',
                'alifbo/<id:\d+>' => 'letter/view',

                // Muallimi Soniy darslar
                'darslar'                    => 'lesson/index',
                'darslar/<chapter:\d+>'      => 'lesson/chapter',
                'dars/<id:\d+>'              => 'lesson/view',
                'dars/<id:\d+>/test'         => 'quiz/lesson',

                // Tajvid
                'tajvid'          => 'tajweed/index',
                'tajvid/<id:\d+>' => 'tajweed/view',

                // Tajvidli Mushaf
                'mushaf'               => 'quran/index',
                'mushaf/<surah:\d+>'   => 'quran/surah',

                // Mashq (Practice)
                'mashq'           => 'practice/index',
                'mashq/harflar'   => 'practice/letters',
                'mashq/sozlar'    => 'practice/words',
                'mashq/shakl'     => 'practice/forms',
                'mashq/talaffuz'  => 'practice/pronunciation',
                'mashq/boglash'   => 'practice/connections',
                'mashq/soz-test'  => 'practice/word-quiz',
                'mashq/harakat'   => 'practice/harakat',
                'mashq/tajvid-test' => 'practice/tajvid-test',
                'mashq/lugat'     => 'practice/lugat',
                'mashq/xotira'    => 'practice/memory',
                'mashq/tez-quiz'  => 'practice/speed-quiz',
                'mashq/gapirish'  => 'practice/speaking',
                'mashq/ai-muallim' => 'practice/ai-chat',
                'mashq/ai-chat-api' => 'practice/ai-chat-api',
                'mashq/nutq-tekshir' => 'practice/check-speech',
                'mashq/tts' => 'practice/tts',
                'mashq/yozuv/<id:\d+>' => 'practice/writing',

                // Quiz
                'test'          => 'quiz/index',
                'test/<id:\d+>' => 'quiz/view',

                // Prayer times
                'namoz' => 'prayer/index',

                // Profile
                'profil' => 'profile/index',

                // Search
                'qidiruv' => 'site/search',

                // Admin
                'admin' => 'admin/default/index',
                'admin/<controller:\w+[-\w]*>/<action:\w+[-\w]*>/<id:\d+>' => 'admin/<controller>/<action>',
                'admin/<controller:\w+[-\w]*>/<action:\w+[-\w]*>' => 'admin/<controller>/<action>',
                'admin/<controller:\w+[-\w]*>' => 'admin/<controller>/index',
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
