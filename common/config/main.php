<?php
use common\models\UrlParam;

return [
    'name' => 'catdaily.vn',
    'language' => 'vi-VN',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@frontendUrl' => 'http://hotteen.vn',
        '@frontendHost' => 'http://hotteen.vn',
        '@backendUrl' => 'http://hotteen.vn/backend',
        '@backendHost' => 'http://hotteen.vn',
        '@imagesUrl' => 'http://hotteen.vn/images',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@common/runtime/cache',
        ],
        'frontendUrlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'sitemap.xml' => 'sitemap/index',
                'sitemap-static-page.xml' => 'sitemap/static-page',
                'sitemap-article-category.xml' => 'sitemap/article-category',
                'sitemap-article-<' . UrlParam::PAGE . ':\d+>.xml' => 'sitemap/article',
                'sitemap-tag-<' . UrlParam::PAGE . ':\d+>.xml' => 'sitemap/tag',

                '' => 'site/index',
                '/' => 'site/index',
                '<' . UrlParam::SLUG . '>.html' => 'article/view',
                '<' . UrlParam::SLUG . '>' => 'article/category',
                '<' . UrlParam::SLUG . '>/' => 'article/category',
                'tag/<' . UrlParam::SLUG . '>' => 'tag/view',
                'tag/<' . UrlParam::SLUG . '>/' => 'tag/view',
            ],
        ],
        'backendUrlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                '/' => 'site/index',
            ],
        ],
    ],
];
