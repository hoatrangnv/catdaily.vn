<?php
/**
 * Created by PhpStorm.
 * User: Quyet
 * Date: 1/8/2018
 * Time: 9:20 AM
 */
use common\models\SiteParam;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<footer>
    <div class="container">
        <div class="ft-row clr">
            <div class="ft-col">
                <ul>
                    <?php
                    if ($com_name = SiteParam::findOneByName(SiteParam::COMPANY_NAME)) {
                        ?>
                        <li class="com-name">
                            <a href="<?= Url::home(true) ?>" title="<?= $com_name->value ?>"><?= $com_name->value ?></a>
                        </li>
                        <?php
                    }
                    ?>
                    <?php
                    foreach (SiteParam::findAllByNames([
                        SiteParam::ADDRESS,
                        SiteParam::PHONE_NUMBER,
                        SiteParam::HOTLINE,
                        SiteParam::EMAIL,
                    ]) as $item) {
                        $value = Html::encode($item->value);
                        switch ($item->name) {
                            case SiteParam::ADDRESS:
                                ?>
                                <li class="address">
                                    <span>Địa chỉ:</span>
                                    <span><?= $value ?></span>
                                </li>
                                <?php
                                break;
                            case SiteParam::PHONE_NUMBER:
                                ?>
                                <li class="phone-number">
                                    <span>Điện thoại:</span>
                                    <a href="tel:<?= $value ?>" title="Bấm để gọi"><?= $value ?></a>
                                </li>
                                <?php
                                break;
                            case SiteParam::HOTLINE:
                                ?>
                                <li class="hotline">
                                    <span>Hotline:</span>
                                    <a href="tel:<?= $value ?>" title="Bấm để gọi"><?= $value ?></a>
                                </li>
                                <?php
                                break;
                            case SiteParam::EMAIL:
                                ?>
                                <li class="email">
                                    <span>Email:</span>
                                    <a href="mailto:<?= $value ?>" title="Gửi email"><?= $value ?></a>
                                </li>
                                <?php
                                break;

                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="ft-col">
                <ul>
                <?php
                foreach (SiteParam::findAllByNames([SiteParam::FOOTER_INFO_HTML]) as $info_html) {
                    ?>
                    <li>
                        <?= $info_html->value ?>
                    </li>
                    <?php
                }
                ?>
                </ul>
            </div>
        </div>
    </div>
</footer>
