<?php
	
class News extends Controller
{
	protected $articleModel;
	protected $article;
	
	public function __construct($dbc)
	{
		parent::__construct($dbc);
		
		$this->articleModel = new ArticleModel($this->dbc);
	}
	
	protected function default()
	{
		$this->pageTitle = "Articles";
		include 'web/news.view';
		exit;
	}
	
	protected function article($id)
	{
		$articleModel = new ArticleModel();
		$this->article = $this->articleModel->getById('articles', $id);
		if($this->article == false)
		{
			include 'web/404.view';
		}
		else
		{
			include 'web/news/article.view';
		}
		exit;
	}
}