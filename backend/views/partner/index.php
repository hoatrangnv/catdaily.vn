<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\searchModels\Partner */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Partners';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partner-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Partner', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
//            'logo_image_id',
            'website',
            'sort_order',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
