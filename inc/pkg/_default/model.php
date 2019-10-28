<?php

class Model
{
    protected $dbc;
    
	public function __construct($dbc)
	{
		$this->dbc = $dbc;
	}
	
    public function getAll($table)
    {
        try
        {
            $sql = 'SELECT * FROM '.$table.' ORDER BY id';
            $stmt = $this->dbc->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (Exception $e)
        {
            return false;
        }
        return $result;
    }
    
    public function getByParam($table, $column, $param)
    {
        try
        {
            $sql = 'SELECT * FROM '.$table.' WHERE '.$column.' = :param';
            $stmt = $this->dbc->prepare($sql);
            $stmt->bindValue(':param', $param);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (Exception $e)
        {
            return false;
        }
        return $result;
    }
    
    public function getById($table, $id)
    {
        try
        {
            $sql = 'SELECT * FROM '.$table.' WHERE id = :id';
            $stmt = $this->dbc->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch (Exception $e)
        {
            return false;
        }
        return $result;
    }
	
	public function customQuery($sql)
	{
		try
		{
			$stmt = $this->dbc->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		catch (Exception $e)
		{
			return false;
		}
		return $result;
	}
	
	public function getColumn($table, $column)
	{
		try
        {
            $sql = 'SELECT '.$column.' FROM '.$table;
            $stmt = $this->dbc->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (Exception $e)
        {
            return false;
        }
        return $result;
	}
	
	public function setColumnById($table, $column, $id, $param)
	{
		try
        {
            $sql = 'UPDATE '.$table.' SET '.$column.' = :param WHERE id = :id';
            $stmt = $this->dbc->prepare($sql);
			$stmt->bindValue(':param', $param);
			$stmt->bindValue(':id', $id);
            $stmt->execute();
        }
        catch (Exception $e)
        {
            return false;
        }
        return true;
	}
}