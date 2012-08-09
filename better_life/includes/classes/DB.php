<?php
class DB{
	var $DB_HOST = 'localhost';
	var $DB_NAME;
	var $DB_USER;
	var $DB_PASSWORD = '';
	var $connection;
	var $PAGE_SIZE = 10;
	var $PAGE_START = 0;
	var $pagination_string = '';
	
	function __construct(){
		if($_SERVER['HTTP_HOST']=='localhost'){
			$this->DB_NAME = 'better_life';
			$this->DB_USER = 'root';
			$this->DB_PASSWORD = 'admin';
		}else{
			$this->DB_NAME = 'wwwcrick_cricketgali';
			$this->DB_USER = 'wwwcrick_crick';
			$this->DB_PASSWORD = 'pwd!@#$%^&';
		}
		
		$this->connection = mysql_connect($this->DB_HOST, $this->DB_USER, $this->DB_PASSWORD);
		mysql_select_db($this->DB_NAME);
	}
	function save($table_name, $data_array = array()){
		unset($data_array['submit']);
		$data_array['add_date'] = date("Y-m-d H:i:s");
		$data_array['update_date'] = date("Y-m-d H:i:s");
		if(is_array($data_array) && count($data_array)){
			$sql = 'insert into '.$table_name.' set ';
			$cols_array = array();
			foreach($data_array as $col=>$value){
				$cols_array[] = $col."='".addslashes($value)."'";
			}
			$cols = implode(', ',$cols_array);
			$sql .= $cols;
			$this->execute($sql);
			return mysql_insert_id();
		}else{
			return 0;
		}
	}
	function update($table_name, $data_array = array(), $where=array(), $cond='and'){
		unset($data_array['submit']);
		$data_array['update_date'] = date("Y-m-d H:i:s");
		if(is_array($data_array) && count($data_array)){
			$sql = 'update '.$table_name.' set ';
			$cols_array = array();
			foreach($data_array as $col=>$value){
				$cols_array[] = $col."='".addslashes($value)."'";
			}
			$cols = implode(', ',$cols_array);
			$sql .= $cols;
			if(is_array($where) && count($where)){
				$where_array = array();
				foreach($where as $wk=>$w){
					$where_array[] = $wk."='".$w."'";
				}
				$where_str = implode(' '.$cond.' ',$where_array);
			}
			$sql .= ' where '.$where_str;
			return $this->execute($sql);
		}else{
			return 0;
		}
	}
	function delete($table_name, $where=array(), $cond='and'){
		if(is_array($where) && count($where)){
			$sql = 'delete from '.$table_name;
			$where_array = array();
			foreach($where as $wk=>$w){
				$where_array[] = $wk."='".$w."'";
			}
			$where_str = implode(' '.$cond.' ',$where_array);
		}
		$sql .= ' where '.$where_str;
		return $this->execute($sql);
	}
	function check($table_name, $data_array = array(), $condtion=''){
		if(is_array($data_array) && count($data_array)){
			$sql = 'select * from '.$table_name.' where 1 ';
			foreach($data_array as $col=>$value){
				$cols_array[] = $col."='".addslashes($value)."'";
			}
			$cols = implode(' '.$condtion.' ',$cols_array);
			if($cols!=''){
				$sql .= 'and '.$cols;
			}
			$res = $this->execute($sql);
			return $this->count($res);
		}else{
			return 0;
		}
	}
	public function select($table_name, $data_array = array(), $condtion='and', $data = 'one', $start='', $limit='', $orderby='', $orderbytype=''){
		if(is_array($data_array) && count($data_array)){
			$sql = 'select * from '.$table_name.' where 1 ';
			foreach($data_array as $col=>$value){
				$cols_array[] = $col."='".addslashes($value)."'";
			}
			$cols = implode(' '.$condtion.' ',$cols_array);
			if($cols!=''){
				$sql .= ' and '.$cols;
			}
			if($orderby!='' && $orderbytype!=''){
				$sql .= ' order by '.$orderby.' '.$orderbytype;
			}
			if($start!='' && $limit!=''){
				$sql .= ' limit '.$start.', '.$limit;
			}

			
			
			//print $sql;
			$res = $this->execute($sql);
			if($data=='one'){
				return $this->fecthOne($res);
			}else{
				return $this->fecthAll($res);
			}
		}else{
			return 0;
		}
	}

	function execute($sql){
		$res = mysql_query($sql) or die(mysql_error());
		return $res;
	}
	function count($res){
		return mysql_num_rows($res);
	}

	function getNumBySql($sql){
		return mysql_num_rows($this->execute($sql));
	}

	function getRecordsOfTable($table='', $where=array(1=>1), $cond='and'){
		if($table!=''){
			$sql = "select * from ".$table." where 1";
			if(is_array($where) && count($where)){
				foreach ($where as $k=>$w){
					$sql .= " ".$cond." ".$k." = '".$w."'";
				}
				return $this->count($this->execute($sql));
			}
		}else{
			return 'No Table Passed!';
		}
	}
	function fecthOne($res){
		return mysql_fetch_assoc($res);
	}
	function fecthAll($res){
		$data = array();
		while($line = mysql_fetch_assoc($res)){
			$data[] = $line;
		}
		return $data;
	}
	function fetchWithPagination($sql){
		$sql = $this->pagination($sql);
		$res = $this->execute($sql);
		return $this->fecthAll($res);
		
	}
	
	function pagination($sql){
		
		$this->PAGE_START = isset($_GET['page'])?$_GET['page']*$this->PAGE_SIZE:0;
		$total_res = $this->execute($sql);
		$total_records = $this->count($total_res);
		$pages = ceil($total_records/$this->PAGE_SIZE);
		$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$start = ($_GET[page]-5<0?0:$_GET[page]-5);
		$end = ($_GET[page]+5>$pages?$pages:$_GET[page]+5);
		
		if(strpos($url, '?page='))
			$url = substr($url, 0, strpos($url, '?page='));
		
		if($pages>1){
			$this->pagination_string = '<div class="pagination"><ul>';
			$this->pagination_string .= '<li><a href="'.$url.'?page=0">Start</a></li>';
			$this->pagination_string .= '<li><a href="'.$url.'?page='.($_GET['page']-1<0?0:$_GET['page']-1).'">Prev</a></li>';
			if ($start>0)
				$this->pagination_string .= '<li><a href="#">..</a></li>';
			for($i=$start; $i<$end;$i++){
				$this->pagination_string .= '<li><a '.($i==$_GET['page']?'class="active"':'').' href="'.$url.'?page='.$i.'">'.($i+1).'</a></li>';	
			}
			if ($end<$pages)
				$this->pagination_string .= '<li><a href="#">..</a></li>';
			$this->pagination_string .= '<li><a href="'.$url.'?page='.($_GET['page']+1>=($pages-1)?($pages-1):$_GET['page']+1).'">Next</a></li>';
			$this->pagination_string .= '<li><a href="'.$url.'?page='.($pages-1).'">Last</a></li>';
			$this->pagination_string .= '<ul></div>';
		}
		$sql .= ' limit '.$this->PAGE_START.', '.$this->PAGE_SIZE;
		return $sql;
	}
	
	function ___destruct(){
		mysql_close($this->connection);
	}
}
$DB = new DB();
?>
