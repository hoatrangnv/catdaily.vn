<?php
use common\models\UrlParam;

return [
    'name' => 'catdaily.vn',
    'language' => 'vi-VN',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@frontendUrl' => 'http://catdaily.vn',
        '@frontendHost' => 'http://catdaily.vn',
        '@backendUrl' => 'http://cp.catdaily.vn',
        '@backendHost' => 'http://cp.catdaily.vn',
        '@imagesUrl' => 'http://catdaily.vn/images',
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
