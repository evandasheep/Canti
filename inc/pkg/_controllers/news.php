<?php
	
class News extends Controller
{
	protected $articleModel;
	protected $article;
	protected $articles = [];
	
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
		$this->article = $this->articleModel->get_article($id);
		if($this->article == false)
		{
			include 'web/404.view';
		}
		else
		{
			$this->pageTitle = $this->article->get_title();
			include 'web/news/article.view';
		}
		exit;
	}
	
	protected function manage()
	{
		$this->pageTitle = 'Manage Articles';
		if($this->user->get_isLoggedIn() && $this->user->get_isAdmin())
		{
			$this->articles = $this->articleModel->get_all();
			include 'web/news/manage.view';
		}
		else
		{
			// User is not logged in or user is not admin, turn away.
			header('Location: '.$this->site->get_siteUrl());
		}
	}
	
	protected function create()
	{
		$this->pageTitle = 'Manage Articles';
		if($this->user->get_isLoggedIn() && $this->user->get_isAdmin())
		{
			include 'web/news/create.view';
		}
		else
		{
			// User is not logged in or user is not admin, turn away.
			header('Location: '.$this->site->get_siteUrl());
		}
	}
	
	protected function edit($id)
	{
		$this->pageTitle = 'Manage Articles';
		if($this->user->get_isLoggedIn() && $this->user->get_isAdmin())
		{
			$this->article = $this->articleModel->get_article($id);
			if($this->article == false)
			{
				include 'web/404.view';
			}
			else
			{
				include 'web/news/create.view';
			}
		}
		else
		{
			// User is not logged in or user is not admin, turn away.
			header('Location: '.$this->site->get_siteUrl());
		}
	}
}