<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "partner".
 *
 * @property int $id
 * @property string $name
 * @property int $logo_image_id
 * @property string $website
 * @property int $sort_order
 *
 * @property Image $logoImage
 */
class Partner extends \common\db\MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'partner';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'logo_image_id', 'sort_order'], 'required'],
            [['logo_image_id', 'sort_order'], 'integer'],
            [['name', 'website'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['logo_image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['logo_image_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'logo_image_id' => 'Logo Image ID',
            'website' => 'Website',
            'sort_order' => 'Sort Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogoImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'logo_image_id']);
    }
}
