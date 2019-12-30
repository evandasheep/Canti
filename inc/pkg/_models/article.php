<?php
	
class ArticleModel extends Model
{
	public function __construct($dbc)
	{
		$this->dbc = $dbc;
	}
	
	public function get_article($id)
	{
		$article = new Article();
		$result = $this->getById('articles',$id);
		if(!result && $id != 0)
		{
			return false;
			exit;
		}
		elseif(is_array($result) && $result != false)
		{
			$article->constructObject($result['id'],$result['title'],$result['content'],
				$result['description'],$result['date'],$result['author'],$result['status']);
		}
		return $article;
	}
	
	public function get_publishedArticles()
	{
		$articles = [];
		$articleObj;
		
		$result = $this->getByParam('articles', 'status', true);
		if(count($result) > 0 && $result != false)
		{
			foreach($result as $row)
			{
			    $articleObj = new Article();
			    $articleObj->constructObject($row['id'],$row['title'],$row['content'],$row['description'],$row['date'],$row['author'],$row['status']);
			    array_push($articles, $articleObj);
			}
		}
		else
		{
		    $articleObj = new Article();
		    array_push($articles, $articleObj);
		}
		
		return array_reverse($articles);
	}
	
	public function insert($article)
	{
		$sql = "INSERT INTO `articles` (`title`, `content`, `description`, `date`, `author`, `status`) VALUES (:title, :content, :description, :date, :author, :status)";
		try
		{
			$stmt = $this->dbc->prepare($sql);
			$stmt->bindValue(":title", $article->get_title());
			$stmt->bindValue(":content", $article->get_content());
			$stmt->bindValue(":description", $article->get_desc());
			$stmt->bindValue(":date", $article->get_date());
			$stmt->bindValue(":author", $article->get_author());
			$stmt->bindValue(":status", $article->get_status());
			$stmt->execute();
		}
		catch (Exception $e)
		{
			echo "Error inserting article.<pre>";
			var_dump($e);
			echo "</pre>";
		}
	}
	
	public function update($article)
	{
		$sql = "UPDATE `articles` SET `title` = :title,
				`content` = :content, `description` = :description,
				`date` = :date, `author` = :author, `status` = :status
				WHERE `id` = :id";
		try
		{
			$stmt = $this->dbc->prepare($sql);
			$stmt->bindValue(":id", $article->get_id());
			$stmt->bindValue(":title", $article->get_title());
			$stmt->bindValue(":content", $article->get_content());
			$stmt->bindValue(":description", $article->get_desc());
			$stmt->bindValue(":date", $article->get_date());
			$stmt->bindValue(":author", $article->get_author());
			$stmt->bindValue(":status", $article->get_status());
			$stmt->execute();
		}
		catch (Exception $e)
		{
			echo "Error updating article.<pre>";
			var_dump($e);
			echo "</pre>";
		}
	}
}