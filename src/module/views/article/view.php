<?php

/* @var $this yii\web\View */

use yii\apidoc\templates\bootstrap\assets\AssetBundle;
use yii2lab\helpers\yii\Html;
use yii2module\guide\module\helpers\MarkdownHelper;
use yii2module\guide\module\helpers\NavigationHelper;
use yii2module\guide\module\helpers\ViewHelper;

AssetBundle::register($this);

$this->title = $entity->title;
?>

<div class="pull-right">

<?php
echo Html::a(Html::fa('code', ['class' => 'text-primary']), NavigationHelper::genUrl(NavigationHelper::URL_ARTICLE_CODE, ['id' => $entity->id]), [
	//'class' => 'btn btn-default',
	'title' => t('action', 'CODE'),
]);
echo NBSP;
if(Yii::$app->user->can('guide.modify', $entity->project)) {
	echo Html::a(Html::fa('pencil', ['class' => 'text-primary']), NavigationHelper::genUrl(NavigationHelper::URL_ARTICLE_UPDATE, ['id' => $entity->id]), [
		//'class' => 'btn btn-default',
		'title' => t('action', 'UPDATE'),
	]);
	echo NBSP;
	echo Html::a(Html::fa('trash', ['class' => 'text-danger']), NavigationHelper::genUrl(NavigationHelper::URL_ARTICLE_DELETE, ['id' => $entity->id]), [
		//'class' => 'btn btn-default',
		'title' => t('action', 'DELETE'),
		'data' => [
			'confirm' => t('yii', 'Are you sure you want to delete this item?'),
			'method' => 'post',
		],
	]);
} ?>

</div>

<?= MarkdownHelper::toHtml($entity->content) ?>

<br/>
