<?php

namespace yii2module\guide\module;

use Yii;
use yii\base\Module as YiiModule;

class Module extends YiiModule
{

	const URL_ARTICLE_VIEW = '/guide/default/view';
	const URL_ARTICLE_INDEX = '/guide';
	const URL_CHAPTER_VIEW = '/guide/chapter/view';

	public function init() {
		parent::init();
		Yii::$app->navigation->breadcrumbs->create(['guide/main', 'title'], [self::URL_ARTICLE_INDEX]);
	}
}