<?php
namespace ce_core\Database;
use \PDO;
use \PDOException;
use ce_core\Exceptions\AppException;

class DB
{

	private $column;
	private $from;
	private $distince = false;
	private $join;
	private $wheres;
	private $group;
	private $having;
	private $order;
	private $limit;

	public function __construct($tableName)
	{
		$this->from = $tableName;
	}

   	public static function table($tableName)
   	{
   		return new self($tableName);
   	}

   	
   	public function select($column)
   	{
   		$this->column = is_array($column) ? $column : func_get_args();
   		return $this;
   	}

   	public function pluck($key, $value='')
   	{
   		
   	}

   	public function count()
   	{

   	}

   	public function max()
   	{

   	}

   	public function avg()
   	{

   	}

   	public function $distince()
   	{
   		$this->distince = true;
   		return $this;
   	}

   	public function join($table, $first, $operator, $second, $type="inner")
   	{
   		$this->join[] = [$table, $first, $operator, $second, $type];
   		return $this;
   	}

   	public function leftjoin($table, $first, $operator, $second)
   	{
   		$this->join[] = [$table, $first, $operator, $second, 'left'];
   		return $this;
   	}

   	public function rightjoin($table, $first, $operator, $second)
   	{
   		$this->join[] = [$table, $first, $operator, $second, 'right'];
   		return $this;
   	}

   	public function where($column, $operator, $value, $boolean = 'AND')
   	{
   		$this->wheres[] = [$column, $operator, $value, $boolean];
   		return $this;
   	}

   	public function orWhere($column, $operator, $value)
   	{
   		$this->wheres[] = [$column, $operator, $value, 'or'];
   		return $this;
   	}

   	

   	public function having($column, $operator, $value)
   	{
   		$this->having[] = [$column, $operator, $value, 'AND'];
   		return $this;
   	}

   	public function orHaving($column, $operator, $value)
   	{
   		$this->having[] = [$column, $operator, $value, 'OR'];
   		return $this;
   	}
   	
   	public function orderBy($column, $direction='ASC')
   	{
   		$this->order[]= [$column, $direction];
   		return $this;
   	}

   	public function groupBy()
   	{
   		$this->column = is_array($column) ? $column : func_get_args();
   		return $this;
   	}

   	public function limit($limit)
   	{
   		$this->limit = $limit;
   		return $this;
   	}

   	public function offset($offset)
   	{
   		$this->offset = $offset;
   		return $this;
   	}

   	public function whereBetween()
   	{

   	}

   	public function whereNotBetween()
   	{

   	}

   	public function whereIn()
   	{

   	}

   	public function whereNotIn()
   	{
   		
   	}

   	public function whereNull()
   	{

   	}

   	public function whereNotNull()
   	{

   	}	

   	public function increment()
   	{

   	}

   	public function decrement()
   	{

   	}

   	public function update()
   	{

   	}

   	public function insertGetId()
   	{

   	}

   	public function insert()
   	{

   	}   	


   	public function delete()
   	{

   	}

   	public function first()
   	{

   	}
}
