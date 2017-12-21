<?php

namespace yii2module\guide\domain\repositories\file;

use Yii;
use yii\web\NotFoundHttpException;
use yii2lab\domain\BaseEntity;
use yii2lab\domain\data\Query;
use yii2lab\domain\interfaces\repositories\ModifyInterface;
use yii2lab\domain\interfaces\repositories\ReadInterface;
use yii2lab\domain\repositories\BaseRepository;
use yii2lab\helpers\yii\FileHelper;
use yii2module\guide\domain\entities\ArticleEntity;

class ArticleRepository extends BaseRepository implements ReadInterface, ModifyInterface {

	public $project;
	public $main = 'README';

	public function update(BaseEntity $entity) {
		$entity->validate();
		$project = Yii::$app->guide->project->oneById($this->project->id);
		$fileName = $project->dir . '/' . $entity->id . '.md';
		$fileName = ROOT_DIR . '/' . $fileName;
		FileHelper::save($fileName, $entity->content);
	}

	public function oneMainByDir($dir) {
		return $this->oneByDir($dir, $this->main);
	}

	public function oneByDir($dir, $id) {
		$content = FileHelper::load(Yii::getAlias("@{$dir}/{$id}.md"));
		if(empty($content)) {
			throw new NotFoundHttpException();
		}
		return $this->forgeEntity([
			'id' => $id,
			'content' => $content,
		]);
	}

	public function setProject($project_id) {
		$project = Yii::$app->guide->project->oneById($project_id);
		$this->project = $project;
	}

	public function oneMain() {
		return $this->oneById($this->main);
	}

	public function oneById($id, Query $query = null) {
		/** @var Query $query */
		$content = FileHelper::load(Yii::getAlias("@{$this->project->dir}/{$id}.md"));
		//$query = Query::forge($query);
		if(empty($content)) {
			throw new NotFoundHttpException();
		}
		$entity = $this->forgeEntity([
			'id' => $id,
			'content' => $content,
		]);
		$entity->project = $this->project;
		return $entity;
	}

	public function oneByIdWithChapter($id) {
		try {
			/** @var ArticleEntity $entity */
			$entity = $this->oneById($id);
		} catch(NotFoundHttpException $e) {
			$entity = Yii::$app->guide->factory->entity->create('article');
			$entity->id = $id;
		}
		try {
			$entity->chapter = $this->domain->repositories->chapter->oneByArticleId($id);
		} catch(NotFoundHttpException $e) {}
		return $entity;
	}
	
	/**
	 * @param BaseEntity $entity
	 *
	 * @throws \yii2lab\domain\exceptions\UnprocessableEntityHttpException
	 */
	public function insert(BaseEntity $entity) {
		// TODO: Implement insert() method.
	}
	
	/**
	 * @param BaseEntity $entity
	 *
	 */
	public function delete(BaseEntity $entity) {
		// TODO: Implement delete() method.
	}
	
	/**
	 * @param Query|null $query
	 *
	 * @return array|null
	 */
	public function all(Query $query = null) {
		// TODO: Implement all() method.
	}
	
	/**
	 * @param Query|null $query
	 *
	 * @return integer
	 */
	public function count(Query $query = null) {
		// TODO: Implement count() method.
	}
}
