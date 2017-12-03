<?php

namespace yii2module\guide\module\helpers\filters;

use Yii;
use yii\base\Object;
use yii\helpers\Url;
use yii2module\guide\module\helpers\NavigationHelper;

class LinkFilter extends Object {

	public function run($html) {
		$html = $this->replaceInternalLink($html);
		$html = $this->replaceExternalLink($html);
		return $html;
	}

	private function replaceInternalLink($html) {
		$pattern = '~<a href="(.+).md">([^<]+)?</a>~';
		$callback = function ($matches) {
			$url = NavigationHelper::genUrl(NavigationHelper::URL_ARTICLE_VIEW);
			$url['id'] = $matches[1];
			return '<a href="'.Url::to($url).'">'.$matches[2].'</a>';
		};
		$html = preg_replace_callback($pattern, $callback, $html);
		return $html;
	}

	private function replaceExternalLink($html) {
		$pattern = '~<a href="(http[^\"]+)">([^<]+)?</a>~';
		$replacement = '<a href="$1" target="_blank">$2</a>';
		$html = preg_replace($pattern, $replacement, $html);
		return $html;
	}

}