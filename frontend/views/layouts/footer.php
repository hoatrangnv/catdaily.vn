<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/19/2018
 * Time: 12:51 PM
 */
use common\models\SiteParam;
use yii\helpers\Url;


?>
<footer>
    <div class="container">
        <div class="ft-row">
            <div class="ft-col">
                <a class="logo" href="<?= Url::home() ?>" title="<?= Yii::$app->name ?>">
                    <img src="<?= Yii::getAlias('@web/img/logo_v2.png') ?>" alt="logo">
                </a>
            </div>
            <div class="ft-col">
                <?php
                foreach (SiteParam::findAllByNames([SiteParam::MEMBER]) as $member) {
                    $title_name = explode(':', $member->value, 2);
                    if (count($title_name) === 2) {
                        list($title, $name) = $title_name;
                        ?>
                        <h3 class="title"><?= trim($title) ?></h3>
                        <div class="info"><?= trim($name) ?></div>
                        <?php
                    }
                }
                ?>
            </div>
            <div class="ft-col">
                <?php
                if ($parentCompany = SiteParam::findOneByName(SiteParam::PARENT_COMPANY)) {
                    ?>
                    <h3 class="title">Cơ quan chủ quản</h3>
                    <div class="info"><?= $parentCompany->value ?></div>
                    <?php
                }
                if ($headquarter = SiteParam::findOneByName(SiteParam::HEADQUARTER)) {
                    ?>
                    <h3 class="title">Trụ sở</h3>
                    <div class="info"><?= $headquarter->value ?></div>
                    <?php
                }
                ?>
                <?php
                $phone = SiteParam::findOneByName(SiteParam::PHONE);
                $email = SiteParam::findOneByName(SiteParam::EMAIL);
                if ($phone || $email) {
                ?>
                <h3 class="title">Liên hệ quảng cáo</h3>
                <div class="info">
                    <?php
                    if ($phone) {
                        ?>
                        Hotline: <a href="tel:<?= $phone->value ?>" title="Gọi hotline"><?= $phone->value ?></a>
                        <?php
                        if ($email) {
                            ?> &minus; <?php
                        }
                    }
                    if ($email) {
                        ?>
                        Email: <a href="mailto:<?= $email->value ?>" title="Gửi email"><?= $email->value ?></a>
                        <?php
                    }
                    ?>
                </div>
                <?php
                }
                ?>
            </div>
            <div class="ft-col">
                <h3 class="title">Về chúng tôi</h3>
                <?php
                if ($aboutUs = SiteParam::findOneByName(SiteParam::ABOUT_US)) {
                    ?>
                    <div class="info">
                        <a href="<?= $aboutUs->value ?>" title="Giới thiệu">Giới thiệu</a>
                    </div>
                    <?php
                }
                if ($fb = SiteParam::findOneByName(SiteParam::FACEBOOK_PAGE)) {
                    ?>
                    <div class="info">
                        <a href="<?= $fb->value ?>" title="Facebook">Facebook</a>
                    </div>
                    <?php
                }
                if ($yt = SiteParam::findOneByName(SiteParam::YOUTUBE_CHANNEL)) {
                    ?>
                    <div class="info">
                        <a href="<?= $yt->value ?>" title="Youtube">Youtube</a>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="copyright">
            &copy; Copyright <?= date('Y') ?> <?= Yii::$app->name ?>
            <br>Mọi hình thức sao chép phải có sự đồng ý bằng văn bản.
        </div>
    </div>
</footer>
