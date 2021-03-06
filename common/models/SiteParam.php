<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "site_param".
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @property int $sort_order
 */
class SiteParam extends \common\db\MyActiveRecord
{
    const COMPANY = 'company';
    const PARENT_COMPANY = 'parent_company';
    const HEADQUARTER = 'headquarter';
    const PHONE = 'phone';
    const EMAIL = 'email';
    const FACEBOOK_PAGE = 'facebook_page';
    const YOUTUBE_CHANNEL = 'facebook_channel';
    const ABOUT_US = 'about_us';
    const TRACKING_CODE = 'tracking_code';
    const MEMBER = 'member';

    /**
     * @return string[]
     */
    public function getParamLabels()
    {
        return [
            self::COMPANY => 'Company',
            self::PARENT_COMPANY => 'Parent company',
            self::HEADQUARTER => 'Headquarter',
            self::PHONE => 'Phone',
            self::EMAIL => 'Email',
            self::FACEBOOK_PAGE => 'Facebook page',
            self::YOUTUBE_CHANNEL => 'Youtube chanel',
            self::ABOUT_US => 'About us',
            self::TRACKING_CODE => 'Tracking Code',
            self::MEMBER => 'Member',
        ];
    }

    /**
     * @return string
     */
    public function paramLabel()
    {
        $paramLabels = $this->getParamLabels();
        if (isset($paramLabels[$this->name])) {
            return $paramLabels[$this->name];
        } else {
            return $this->name;
        }
    }

    private static $_indexData;

    /**
     * @return self[]
     */
    public static function indexData()
    {
        if (self::$_indexData == null) {
            self::$_indexData = self::find()->orderBy('sort_order asc')->indexBy('id')->all();
        }

        return self::$_indexData;
    }

    /**
     * @param $name
     * @return self|null
     */
    public static function findOneByName($name)
    {
        $data = self::indexData();
        foreach ($data as $item) {
            if ($item->name == $name) {
                return $item;
            }
        }
        return null;
    }

    /**
     * @param $names
     * @param $limit
     * @return self[]
     */
    public static function findAllByNames($names, $limit = INF)
    {
        $result = [];
        $data = self::indexData();
        $i = 0;
        foreach ($data as $item) {
            if (in_array($item->name, $names)) {
                $result[] = $item;
                $i++;
            }
            if ($i >= $limit) {
                break;
            }
        }
        return $result;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site_param';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'value', 'sort_order'], 'required'],
            [['sort_order'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['value'], 'string', 'max' => 2047],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'value' => 'Value',
            'sort_order' => 'Sort Order',
        ];
    }
}
