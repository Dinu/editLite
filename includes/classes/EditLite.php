<?php
class EditLite {
    
    public $table;
    public $rows;
    public $columns;
    public $pk;
    
    
    /**
     * Default Constructor
     *
     * @param  string $table            String Table Name
     * @return None
     * @throws None
     */
    public function __construct($table)
    {
        $this->table = $table;
        $this->loadColumns();
        $this->loadPK();
    }
    
    /**
     * Get Tables
     *
     * Static function to return list of all tables in the
     * current DB
     *
     * @param  none
     * @return Mysql Object Array
     * @throws None
     */
    public static function getTables()
    {
        global $db;
        
        $sql = "SHOW TABLE STATUS FROM " . EL_DATABASE;
        return $db->get_results($sql);
    }
    
    
    /**
     * Load columns
     *
     * Assign all column names of current table to $columns
     * 
     * @param  None
     * @return None
     * @throws None
     */
    protected function loadColumns()
    {
        global $db;
        
        $sql = "SHOW COLUMNS FROM $this->table";
        $this->columns = $db->get_results($sql);
    }
    
    /**
     * Load Primary Key
     *
     * Get primary key column name and assign to $pk
     * 
     * @param  None
     * @return None
     * @throws None
     */
    protected function loadPK()
    {
        global $db;
        
        $sql = "SHOW KEYS FROM $this->table "
             . 'WHERE Key_name = "PRIMARY"';
        
        $result = $db->get_row($sql);
        if ($result) $this->pk = $result->Column_name;
        else $this->pk = '';
        
    }
    
    /**
     * Load Rows
     *
     * Loads rows from current table into $rows
     * 
     * TODO: Add filtering and pagination
     *
     * @param  a
     * @return None
     * @throws None
     */
    public function loadRows()
    {
        global $db;
        
        $sql = "SELECT * FROM $this->table";
        $this->rows = $db->get_results($sql);
    }
    
    /**
     * Get Row by PK
     *
     * Select single row by PK
     *
     * @param  string $key      Primary Key Value (if table has PK) or row index
     * @return Mixed            Mysql object if row found / False if nothing
     * @throws None
     */
    public function getRow($key)
    {
        global $db;
        
		if ($key == '') return false; // Don't come to play if you don't have a key kiddo
		
        $sql = "SELECT * FROM $this->table";
        
        if ($this->pk != '') {
            $sql .= " WHERE $this->pk = '$key'";
            return $db->get_row($sql);
        } else {
            $rows = $db->get_results($sql);
            if ($rows)
                return $rows[$key];
            else
                return false;
        }
        
    }
    
    /**
     * Save Edits
     *
     */
    public function saveEdits($key = '')
    {
        global $db;
        
        $sql = '';
        
        foreach ($this->columns as $c) {
            $val = $this::safeText($_POST[$c->Field]);
            if ($sql != '') $sql .= ', ';
            $sql .= "$c->Field = '$val'";
        }
        
        if ($key == '') $sql = "INSERT INTO $this->table SET $sql";
        else {
			$where = $this->getWhereClause($key);
            $sql = "UPDATE $this->table SET $sql $where";
        }
        
        $db->query($sql);
        return $db->rows_affected;
    }
    
	/**
	 * Delete Row
	 * 
	 * Delete row based on Primary Key or Row Index
	 * 
	 * @param mixed $key	PK or Row Index
	 * @return boolean		true or false on success/failure
	 * @throws none
	 */
	public function delete($key)
	{
		global $db;

		$where = $this->getWhereClause($key);
		if ($where != '') {
			$sql = "DELETE FROM $this->table $where";
			$db->query($sql);
			if ($db->rows_affected > 0) return true;
		}
		
		return false;
	}
	
	/**
	 * Get WHERE clause based on row index
	 * 
	 * To be used in CRUD Operations
	 * 
	 * @param mixed $key	PK or Row Index
	 * @return string		MySQL WHERE Clause
	 * @throws none
	 */
	protected function getWhereClause($key)
	{
		$where = '';
		
        if ($this->pk != '') $where = "WHERE $this->pk = '$key'";
        else {
            $row = $this->getRow($key);
            if ($row) {
                foreach ($this->columns as $c) {
                    $field = $c->Field;
                    $val = $row->$field;
                    if ($where != '') $where .= ' AND ';
                    $where .= "$c->Field = '$val'";
                }
            }
			$where = "WHERE $where";
		}

		return $where;
	} 

    /**
     * Get Prettified Name
     *
     * Convert "_" | "-" to splaces
     * Capitalize first char of words
     *
     * @param  string $name     String to be formatted
     * @return string           Formatted String
     * @throws None
     */
    public static function getNiceName($name)
    {
        $name = str_replace('_', ' ', $name);
        $name = str_replace('-', ' ', $name);
        $name = ucwords($name);
        
        return $name;
    }
    
    /**
     * Sanitize User Input for DB Consumption
     *
     * $param string $str       String to be sanitized
     * $param string $charset   String defining Char Set of input
     * $param boolean $nl2br    If true converts new line to break
     * $return string       Sanitized String
     * $throws None
     */ 
    public static function safeText($str, $charset = 'utf-8', $nl2br = false){

		//$str = mysql_real_escape_string($str);

		if ($nl2br) $str = nl2br($str);
		if (get_magic_quotes_gpc()) $str = stripslashes($str);
		$str = htmlentities($str, ENT_QUOTES, $charset, false);
        
        return $str;
	}
    
    /**
     * Get HTML Control
     *
     * Convert "_" | "-" to splaces
     * Capitalize first char of words
     *
     * @param  object $colInfo      Mysql Object with Column Info
     * @return string               HTML String for input/select/checkbox control
     * @throws None
     */
    public static function getControl($colInfo, $row, $return = false)
    {
        $field = $colInfo->Field;
        
		if ($row) $val = $row->$field;
        else $val = '';
		
        switch ($colInfo->Type) {
            case 'mediumtext':
            case 'longtext':
                $html = "<textarea class='form-control' id='$colInfo->Field' name='$colInfo->Field'>$val</textarea>";
                break;
            
            default:
                $html = "<input type='text' class='form-control' id='$colInfo->Field' name='$colInfo->Field' value='$val'>";
        }
        
        
        if ($return) return $html;
        else echo $html;
    }
    
    /**
     * Get CSV For Table Data
     *
     * @param none
     * @return string   CSV String Data
     */
    public function getCSV()
    {
        global $db;
        
        $csv = '';
        
        $newLine = true;
        foreach ($this->columns as $c) {
            if ($newLine) $newLine = false;
            else $csv .= ',';
            $csv .= '"' . $c->Field . '"';
        }

        $sql = "SELECT * FROM $this->table";
        $results = $db->get_results($sql);
        if ($results) {
            foreach ($results as $r) {
                
				$newLine = true;
				$csv .= "\n";
				
				foreach ($this->columns as $c) {
		            if ($newLine) $newLine = false;
		            else $csv .= ',';
					$field = $c->Field;
		            $csv .= '"' . $r->$field . '"';
				}
            }
        }
		
		return $csv;
    }
}
