<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\models\Banner;
use common\models\SiteParam;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;

AppAsset::register($this);

/**
 * @var $seoInfo \frontend\models\SeoInfo
 */
$seoInfo = $this->context->seoInfo;
$seoInfo->registerMetaTags($this);
$seoInfo->registerLinkTags($this);

$this->title = $seoInfo->page_title ? $seoInfo->page_title : Yii::$app->name;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <script src="http://hammerjs.github.io/dist/hammer.min.js" type="text/javascript"></script>
    <script src="https://cdn.rawgit.com/vanquyettran/slider/master/slider.js" type="text/javascript"></script>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<style>
    #header {
        color: #A7243A;
        font-size: 1.5em;
        font-weight: bold;
        margin-top: 1rem;
        margin-bottom: 1rem;
        font-style: italic;
    }
    #header a + * {
        margin-left: 1.5rem;
    }
    @media screen and (max-width: 640px) {
        #header {
            padding-left: calc(35px + 1.5rem);
        }
    }
</style>
    <div id="menu-mobile-backdrop"
         onclick="document.querySelector('html').classList.remove('menu-active')">
    </div>

    <div id="header">
        <div class="container">
            <a>CATDaily</a>
            <br class="sm-only">
            <span>Culture - Art - Technology</span>
        </div>
    </div>

    <?= $this->render('//layouts/topNav', ['menu' => $this->context->menu]) ?>

    <?= $this->render('//layouts/searchToolbar') ?>

    <div class="container clr">
    <?php
    /**
     * @var $headerBanner Banner
     */
    $headerBanner = Banner::find()
        ->where(['active' => 1])
        ->andWhere(['position' => Banner::POSITION_HEADER])
        ->andWhere(['<', 'start_time', date('Y-m-d H:i:s')])
        ->andWhere(['>', 'end_time', date('Y-m-d H:i:s')])
        ->orderBy('sort_order asc')
        ->one();
    if ($headerBanner && $headerBanner->image) {
        ?>
        <?= $headerBanner->image->img(null, [
            'style' => 'display:block;width:100%;margin-top:1rem;margin-bottom:1.5rem'
        ]) ?>
        <?php
    }
    ?>
    </div>

    <div class="container clr" id="main-content">
        <?php echo $content ?>
    </div>

    <div id="bottom-nav">
        <?= $this->render('//layouts/navBar', ['menu' => $this->context->bottomMenu]) ?>
    </div>

    <?= $this->render('//layouts/footer') ?>

    <?= $this->render('//layouts/js') ?>

    <?= $this->render('//layouts/fbSDK') ?>
    <?= $this->render('//layouts/googlePlatform') ?>
    <?= $this->render('//layouts/twitterWidget') ?>
    <?= $this->render('//layouts/tracking') ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
