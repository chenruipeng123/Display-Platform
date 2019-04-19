<?php
    error_reporting(0);
/**
  +----------------------------------
 * MySQL操作类库
  +----------------------------------
 */
// error_reporting(E_ALL ^ E_DEPRECATED);
// error_reporting(0);
@session_start();
// include("config.php");
define('CLIENT_MULTI_RESULTS', 131072);  
	//通知服务器客户端可以处理由多语句或者存储过程执行生成的多结果集
ini_set("magic_quotes_gpc","Off");  //配置php.ini设置，关闭自动转义
ini_set("date.timezone","PRC");  //配置php.ini设置，关闭自动转义
class mysql {
    /* 主机地址 */
    private $Host = '127.0.0.1';
	
     /* 数据库名称 */
    private $dbName = 'et_show';
    /* 用户名 */
    private $UserName = 'root';

    /* 连接密码 */
    private $Password = 'root';

    /* 数据库编码 */
    private $dbCharSet = 'utf8';

    /* 错误信息 */
    private $errorMsg;

    /* 最后一次执行的SQL */
    private $lastSql;

    /* 字段信息 */
    private $fields = array();

    /* 最后一次插入的ID */
    public $lastInsID = null;

    /* 数据库连接ID */
    private $linkID = 0;

    /* 当前查询ID */
    private $queryID = null;

	/* 构造函数，设置当前数据库，并连接数据库服务器 */
    public function __construct($DBName = '',$UserName = '',$Password = '',$Host= '') {
        if ($DBName != '') $this->dbName = $DBName;
		if ($UserName != '') $this->UserName = $UserName;
		if ($Password != '') $this->Password = $Password;
		if ($Host != '') $this->Host = $Host;
			
        $this->connect();
    }
	/* 获得当前数据库的名称 */
	// public function get_db_name(){
	// 	return $this->dbName;
	// }
    /**
      +----------------------------------------------------------
     * 连接数据库方法
      +----------------------------------------------------------
     * @access public
      +----------------------------------------------------------
     */
    public function connect() {
        if ($this->linkID == 0){
            $this->linkID = @mysql_connect($this->Host, $this->UserName, $this->Password, true, CLIENT_MULTI_RESULTS);
            if (!$this->linkID) {
                $this->errorMsg = '数据库连接错误\r\n' . mysql_error();
                $this->halt();
            }
        }
        if (!mysql_select_db($this->dbName, $this->linkID)) {
            $this->errorMsg = '打开数据库失败' . mysql_error($this->linkID);
            $this->halt('打开数据库失败');
        }
        $dbVersion = mysql_get_server_info($this->linkID);
        if ($dbVersion >= "4.1") {
            //使用UTF8存取数据库 需要mysql 4.1.0以上支持
            mysql_query("SET NAMES '" . $this->dbCharSet . "'", $this->linkID);
        }
        //设置CharSet
        mysql_query('set character set \'' . $this->dbCharSet . '\'', $this->linkID);
        //设置 sql_model
        if ($dbVersion > '5.0.1') {
            mysql_query("SET sql_mode=''", $this->linkID);
        }
    }

    /**
      +----------------------------------------------------------
     * 释放查询结果
      +----------------------------------------------------------
     * @access public
      +----------------------------------------------------------
     */
    public function free() {
		if($this->queryID != null)
        	mysql_free_result($this->queryID);
        $this->queryID = null;
    }

    /**
      +----------------------------------------------------------
     * 执行语句
      +----------------------------------------------------------
     * @access public
      +----------------------------------------------------------
     * @param string $sql  sql指令
      +----------------------------------------------------------
     * @return bool or resource
      +----------------------------------------------------------
     */
    public function deletehtml($str) { 
        $str = trim($str);  
        $str = preg_replace("</P>","1234a3211",$str); 
        $str = preg_replace("</p>","1234a3211",$str); 
        $str = preg_replace("<br/>","1234a3211",$str); 
        $str = preg_replace("/<(.[^>]*)>/","",$str);
        $str = preg_replace("/([\r\n])[\s]+/","",$str);
        $str = preg_replace("/-->/","",$str);
        $str = preg_replace("/<!--.*/","",$str);
        $str = preg_replace("/&(quot|#34);/","",$str);
        $str = preg_replace("/&(amp|#38);/", "/&/",$str);
        $str = preg_replace("/&(lt|#60);/", "/</",$str);
        $str = preg_replace("/&(gt|#62);/", ">",$str);
        $str = preg_replace("/&(nbsp|#160);/", "",$str);
        $str = preg_replace("/&(iexcl|#161);/", "/\xa1/",$str);
        $str = preg_replace("/&(cent|#162);/", "/\xa2/",$str);
        $str = preg_replace("/&(pound|#163);/", "/\xa3/",$str);
        $str = preg_replace("/&(copy|#169);/", "/\xa9/",$str);
        $str = preg_replace("/&#(\d+);/", "",$str);
        $str = preg_replace("/</", "",$str);
        $str = preg_replace("/>/", "",$str);
        $str = preg_replace("/\r\n/", "",$str);
        $str = preg_replace("/\'/", "",$str);
        // $str = preg_replace("/1234a3211/", "/<br/>/",$str);
        return $str;
    }

    public function execute($sql) {
        if ($this->linkID == 0)
            $this->connect();
        
        $this->lastSql = $this->deletehtml($sql);
        $this->queryID = mysql_query($sql); 
        $bool  = strstr("$sql","update");
        $bool2 = strstr("$sql","UPDATE");
        if($bool or $bool2){
            if (!mysql_affected_rows()) {
                 return false;
            }
        }
        if (false == $this->queryID){ 
            $this->errorMsg = 'SQL语句执行失败\r\n'. mysql_error($this->linkID);
            return false;
        }else{
			$this->lastInsID = mysql_insert_id($this->linkID);//
			//$r_str = $this->queryID;
			//return $this->queryID;
			//数据备份操作，如果是insert或update，同步操作数据库
			///*
			$str1 = array("insert into ","INSERT INTO ","update ","UPDATE ");
			$str2 = array("insert into z_","INSERT INTO z_","update z_","UPDATE z_");
			if (stristr($sql,'insert') or stristr($sql,'update')){
				$sql2 = str_replace($str1,$str2,$sql);
				mysql_query($sql2);
			}
			
			//更新super_user_info中的最后操作时间
			$sql2 = 'update super_user set last_time='.time().' where id='.$_SESSION['s_id'];	
			mysql_query($sql2); 
			//*/
			return $this->queryID;        
        }		
    }

    /**
      +----------------------------------------------------------
     * 获取记录集的行数
      +----------------------------------------------------------
     * @access public
      +----------------------------------------------------------
     * @param string $sql  sql指令 可为空
     * 如为空：返回上一结果集记录数
     * 如不为空：返回当前sql语句的记录数 
      +----------------------------------------------------------
     * @return integer
      +----------------------------------------------------------
     */
    public function getRowsNum($sql = '') {

        if ($this->linkID == 0) {
            $this->connect();
        }
        if ($sql != '') {
            $this->execute($sql);
        }
        return mysql_num_rows($this->queryID);
    }

    /**
      +----------------------------------------------------------
     * 表单数据直接插入到数据表中
      +----------------------------------------------------------
     * @access public
      +----------------------------------------------------------
     * @param string $tableName 数据表名
      +----------------------------------------------------------
     * @return 执行成功返回插入记录的索引记录，失败返回false
      +----------------------------------------------------------
     */
    public function form2db($tableName) {

        $_POST["add_time"] = date('Y-m-d H:i:s');
		$data = $_POST;
        $this->fields = $this->getFields($tableName);
        $data = $this->_facade($data);
        if ($this->insert($tableName, $data)) {
            return $this->lastInsID;
        } else {
            return false;
        }
    }

    /**
      +----------------------------------------------------------
     * 数据直接插入到数据表中
      +----------------------------------------------------------
     * @access public
      +----------------------------------------------------------
     * @param string $tableName 数据表名
      +----------------------------------------------------------
     * @param array $data 插入的数据 数据键名对应字段名，键值对应值
      +----------------------------------------------------------
     * @return boolean
      +----------------------------------------------------------
     */
    public function insert($tableName, $data) {

        $values = $fields = array();
        foreach ($data as $key => $val) {
            $value = '"' . $val . '"';
            if (is_scalar($value)) { // 过滤非标量数据
                $values[] = $value;
                $fields[] = $key;
            }
        }
        $sql = 'INSERT INTO ' . trim($tableName) . '(' . implode(',', $fields) . ') VALUES(' . implode(',', $values) . ')';
        // echo $sql;
        // exit;
        if ($this->execute($sql)) {
           
            //
			//echo "<br>=I1=".$this->lastInsID;
            return true;
        } else {
             $this->errorMsg = '插入失败\r\n' . mysql_error($this->linkID);
            return false;
        }
    }

    public function insert2($table,$array){
        $keys = join(",",array_keys($array));
        $vals = "'".join("','",array_values($array))."'";
        $sql = "insert into {$table}({$keys}) values({$vals})";
        // echo $sql;
        mysql_query($sql);
        return mysql_insert_id();
    }

    /**
      +----------------------------------------------------------
     * 更新操作
      +----------------------------------------------------------
     * @access public
      +----------------------------------------------------------
     * @param string $tableName 数据表名
      +----------------------------------------------------------
     * @param array $data 插入的数据 数据键名对应字段名，键值对应值
      +----------------------------------------------------------
     * @param array $condition 更新条件，为安全起见，不能为空
      +----------------------------------------------------------
     * @param array $isForm 可为空，缺省为true
     * 如果为true，会当成表单更新数据表来处理，自动映射字段
     * 如果为false，会当成普通的更新来处理，不会自动映射字段
      +----------------------------------------------------------
     * @return boolean
      +----------------------------------------------------------
     */
    public function update($tableName, $data, $condition, $isForm = true) {

        if (empty($condition)) {
            $this->errorMsg = '没有设置更新条件';
            return false;
		}
		//处理分解condition
		if(is_array($condition)){
			$condition = self::_parseCondition($condition);
		}
        if ($isForm) {
            $this->fields = $this->getFields($tableName);
            $data = $this->_facade($data);
        }
        $sql = 'UPDATE ' . trim($tableName) . ' SET ';
        foreach ($data as $key => $val) {
            $sql .= $key . '=\'' . $val . '\',';
        }
        $sql = substr($sql, 0, strlen($sql) - 1);
        $sql .= ' WHERE ' . $condition;
        if ($this->execute($sql)) {
            return true;
        } else {
            $this->errorMsg = '更新失败\r\n' . mysql_error($this->linkID);
            return false;
        }
    }

    /**
      +----------------------------------------------------------
     *  删除操作
      +----------------------------------------------------------
     * @access public
      +----------------------------------------------------------
     * @param string $tableName 数据表名
      +----------------------------------------------------------
     * @param array $condition 更新条件，为安全起见，不能为空
      +----------------------------------------------------------
     * @return boolean
      +----------------------------------------------------------
     */
    public function delete($tableName, $condition) {
		//处理分解condition
		if(is_array($condition)){
			$condition = self::_parseCondition($condition);
		}
        $sql = 'delete from ' . $tableName . ' where 1=1 and ' . $condition;
		
        if (!$this->execute($sql))
            return false;
        return true;
    }
    
    /**
     +----------------------------------------------------------
     * 利用__call魔术方法实现一些特殊的Model方法
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param string $method 方法名称
     * @param array $args 调用参数
     +----------------------------------------------------------
     * @return mixed
     +----------------------------------------------------------
     */
    public function __call($method,$args){
        
        /*根据某个字段获取记录字段的值
         * 例1：getFieldByid(student_info,100,name)---获取学生表中id为100的学生姓名
         * 例2：getFieldByxh(student_info,201215030223,address)---获取学生表中学号为201015030223的地址
         * 注："getFieldBy"不区分大小写，后面的字段名区分大小写
		 * 返回值：string
         */
        if(strtolower(substr($method,0,10)) == 'getfieldby'){
            $name = substr($method,10);
            $sql = 'select `'.$args[2].'` from '.$args[0].' where '.$name.'=\''.$args[1].'\'';
			if($this->execute($sql)){
            	$row = mysql_fetch_array($this->queryID);
            	return $row[0];
			}else{
				return false;
			}
        }
		 /*根据某个字段和值获取某条记录
         * 例1：getByid(student_info,100)---获取学生表中id为100的学生信息
         * 例2：getByxh(student_info,201215030223)---获取学生表中学号为201015030223的学生信息
         * 注："getBy"不区分大小写，后面的字段名区分大小写
		 * 返回值：array
         */
		elseif(strtolower(substr($method,0,5)) == 'getby'){
			$ret = array();
			$name = substr($method,5);
			$sql = 'select * from '.$args[0].' where '.$name.'=\''.$args[1].'\'';
			if($this->execute($sql)){
				$row = mysql_fetch_array($this->queryID);
				return $row;
			}else{
				return false;
			}
		}
    }

    /**
      +----------------------------------------------------------
     *  弹出错误提示，并终止运行
      +----------------------------------------------------------
     * @access public
      +----------------------------------------------------------
     * @param string $msg 错误消息，可为空
      +----------------------------------------------------------
     */
    public static function halt($msg = '') {
        if ($msg != '') {
            $msg .= '\r\n';
        }
		$error = mysql_error();
        die($msg);
    }

    /**
      +----------------------------------------------------------
     *  获取最后一次查询ID
      +----------------------------------------------------------
     * @access public
      +----------------------------------------------------------
     */
	 public function getQueryId(){
		 return $this->queryID;
	 }
	 
	 /**
      +----------------------------------------------------------
     *  获取最后一次数据库操作错误信息
      +----------------------------------------------------------
     * @access public
      +----------------------------------------------------------
     */
    public function getLastError() {

        return $this->errorMsg;
    }

    /**
      +----------------------------------------------------------
     *  获取最后一次执行的SQL语句
      +----------------------------------------------------------
     * @access public
      +----------------------------------------------------------
     */
    public function getLastSql() {

        return $this->lastSql;
    }

    /**
      +----------------------------------------------------------
     *  获取最后一次插入数据库记录的索引ID号
      +----------------------------------------------------------
     * @access public
      +----------------------------------------------------------
     */
    public function getLastInsID() {
        return $this->lastInsID;
    }

    /**
      +----------------------------------------------------------
     *  获取上一次操作影响的行数
      +----------------------------------------------------------
     * @access public
      +----------------------------------------------------------
     */
    public function getAffectedRows() {
        return mysql_affected_rows($this->linkID);
    }

    /**
      +----------------------------------------------------------
     * 取得数据表的字段信息
      +----------------------------------------------------------
     * @access public
      +----------------------------------------------------------
     */
    public function getFields($tableName) {
        $result = array();
        $this->execute('SHOW COLUMNS FROM ' . $this->parseKey($tableName));
        while ($row = mysql_fetch_array($this->queryID)) {
            $result[] = $row;
        }
        $info = array();
        if ($result) {
            foreach ($result as $key => $val) {
                $info[$val['Field']] = array(
                    'name' => $val['Field'],
                    'type' => $val['Type'],
                    'notnull' => (bool) ($val['Null'] === ''), // not null is empty, null is yes
                    'default' => $val['Default'],
                    'primary' => (strtolower($val['Key']) == 'pri'),
                    'autoinc' => (strtolower($val['Extra']) == 'auto_increment'),
                );
            }
        }
        return $info;
    }

    /**
      +----------------------------------------------------------
     * 字段和表名处理添加`
      +----------------------------------------------------------
     * @access protected
      +----------------------------------------------------------
     * @param string $key
      +----------------------------------------------------------
     * @return string
      +----------------------------------------------------------
     */
    protected function parseKey(&$key) {
        $key = trim($key);
        if (false !== strpos($key, ' ') || false !== strpos($key, ',') || false !== strpos($key, '*') || false !== strpos($key, '(') || false !== strpos($key, '.') || false !== strpos($key, '`')) {
            //如果包含* 或者 使用了sql方法 则不作处理
        } else {
            $key = '`' . $key . '`';
        }
        return $key;
    }

    /**
      +----------------------------------------------------------
     * 对保存到数据库的数据进行处理
      +----------------------------------------------------------
     * @access protected
      +----------------------------------------------------------
     * @param mixed $data 要操作的数据
      +----------------------------------------------------------
     * @return boolean
      +----------------------------------------------------------
     */
    private function _facade($data) {
        // 检查非数据字段
        if (!empty($this->fields)) {
            foreach ($data as $key => $val) {
                if (!array_key_exists($key, $this->fields)) {
                    unset($data[$key]);
                }
            }
        }
        return $data;
    }
	
	public function close(){
		mysql_close($this->linkID);
	}
	
	public function __destruct(){
		$this->close();
		
	}

    /*
    ** 2013.5.25新增
    */
	
	public function fetch(&$rst = null , $array_type = MYSQL_ASSOC){
		if($rst == null){
			$rst = $this->queryID;
		}
		if($this->queryID)
			return mysql_fetch_array($rst , $array_type);
		else
			return false;
	}

    //分解条件
    private function _parseCondition($condition , $operator='AND'){
        $return = '';
        if (is_array($condition)) {
            $index = 0;
            foreach ($condition as $key => $value) {
                if ($index) {
                    $return .= " ".$operator;
                }
                $return .= "`{$key}`='{$value}'";
                $index++;
            }
            return $return;
        }else{
            return false;
        }
    }

    /*事务处理开始*/
    public function beginTransaction(){
        $this->execute("START TRANSACTION");
    }

    public function commit(){
        $this->execute("COMMIT");  
    }

    public function rollback(){
        $this->execute("ROLLBACK");
    }
	/*事务处理结束*/
	
	//根据条件查找一条记录
	public function find($table,$condition = null,$field = null){
	    if(is_array($condition)){
	        $condition = self::_parseCondition($condition);
	    }
		//处理condition和field
		$condition = $condition == null ? null : (is_array($condition) ? self::_parseCondition($condition) : $condition);
		$field = $field == null ? '*' : (is_array($field) ? implode(",",$field) : $field);
		$sql = 'SELECT ' . $field . ' FROM '.$table;
		if($condition != null){
			$sql .= " WHERE " . $condition;
		}
		return $this->findOneBySql($sql);
	}
	
	//查找所有记录
	public function findAll($table,$condition = null,$field = null){
		if(is_array($condition)){
	        $condition = self::_parseCondition($condition);
	    }
		//处理condition和field
		$condition = $condition == null ? null : (is_array($condition) ? self::_parseCondition($condition) : $condition);
		$field = $field == null ? '*' : (is_array($field) ? implode(",",$field) : $field);
		$sql = 'SELECT ' . $field . ' FROM '.$table;
		if($condition != null){
			$sql .= " WHERE " . $condition;
		}
		return $this->findallBySql($sql);
	}
	//查询单个数据
    public function fetchOne($sql,$result_type=MYSQL_ASSOC){
        $result = mysql_query($sql);
        $rows = mysql_fetch_array($result,$result_type);
        return $rows;
    }

	public function findOneBySql($sql){
		$sql .= " LIMIT 1";
		$this->execute($sql);
		return $this->fetch();
	}
	//查询多个数据
    public function fetchAll($sql,$result_type=MYSQL_ASSOC){
        $result = mysql_query($sql);
        while (@$rows = mysql_fetch_array($result,$result_type)) {
            $row[] = $rows;
        }
        return $row;
    }

	public function findAllBySql($sql){
		$rows = array();
		$this->execute($sql);
		while($row = $this->fetch()){
			$rows[] = $row;
		}
		return $rows;
	}
}

    function js_alert($message,$url){
      echo "<script language=javascript>alert('";
      echo $message;
      echo "');location.href='";
      echo $url;
      echo "';</script>";
    } 

/*
 * 类库更新日志  2013.5.25 
 * 1、update delete操作中的条件可以设置为数组形式$key=>$value
 * 2、增加事务处理功能（只针对innodb引擎）
 * 3、增加根据条件查找一条记录
 * 4、增加根据条件查找所有记录
 *$sql = '';
 *$rst = $aa->execute($sql);
 *while ($info = $aa->fetch($rst,)){}
 */
?>