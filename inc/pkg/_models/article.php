<?php
	
class ArticleModel extends Model
{
	public function __construct($dbc)
	{
		$this->dbc = $dbc;
	}
	
	public function get_publishedArticles()
	{
		$articles = [];
		$articleObj;
		
		$result = $this->getByParam('articles', 'status', true);
		if(count($result) > 0 && $result != false)
		{
			//TODO: Finish, after mc
		}
	}
}