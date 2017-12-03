<?php

namespace yii2module\guide\module\helpers\filters;

use Yii;
use yii\base\Object;
use yii2module\guide\module\helpers\HighlightHelper;

class CodeFilter extends Object {

	public function run($html) {
		$html = $this->replace($html);
		return $html;
	}

	private function replace($html) {
		$pattern = '~<pre>\s*<code class=\"([\w]+)\">([\s\S]+?)</code>\s*</pre>~';
		$html = preg_replace_callback($pattern, function($matches) {
			$language = $matches[1];
			$content = html_entity_decode($matches[2]);
			$html = HighlightHelper::render($content, $language);
			return $html;
		}, $html);
		return $html;
	}
}