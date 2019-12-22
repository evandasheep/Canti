<?php

class Article extends DataObject
{
	protected $articleId;
	protected $articleTitle;
	protected $articleContent;
	protected $articleDesc;
	protected $articleDate;
	protected $articleAuthor;
	protected $articleStatus;
	
	public function __construct()
	{
		$this->articleId = 0;
		$this->articleTitle = 'Article Not Found!';
		$this->articleContent = "Something went wrong and we couldn't find the article that's ".
								"supposed to be here. If this persists, contact an administrator.";
		$this->articleDesc = 'Invalid Article';
		$this->articleDate = date('Y-m-d H:i:s', time());
		$this->articleStatus = true;
	}
	
	public function constructObject($id, $title, $content, $desc, $date, $author, $status)
	{
		$this->articleId = $id;
		$this->articleTitle = $title;
		$this->articleContent = $content;
		$this->articleDesc = $desc;
		$this->articleDate = $date;
		$this->articleAuthor = $author;
		$this->articleStatus = $status;
	}
	
	// GET
	public function get_id()
	{
		return $this->articleId;
	}
	
	public function get_title()
	{
		return $this->articleTitle;
	}
	
	public function get_content()
	{
		return $this->articleContent;
	}
	
	public function get_desc()
	{
		return $this->articleDesc;
	}
	
	public function get_date()
	{
		return $this->articleDate;
	}
	
	public function get_author()
	{
		return $this->articleAuthor;
	}
	
	public function get_status()
	{
		return $this->articleStatus;
	}
	
	// SET
	
	public function set_title($title)
	{
		$this->articleTitle = $title;
	}
	
	public function set_content($content)
	{
		$this->articleContent = $content;
	}
	
	public function set_desc($desc)
	{
		$this->articleDesc = $desc;
	}
	
	public function set_date($timestamp)
	{
		$this->articleDate = date("Y-m-d H:i:s", $timestamp);
	}
	
	public function set_author($author)
	{
		$this->articleAuthor = $author;
	}
	
	public function set_status($status)
	{
		$this->articleStatus = $status;
	}
}