<?php
class MysqlAdapter{
    protected $_config = array() ;
    protected $_link;
    protected $_result;

    // Constructor 
    public function __construct($config = array()){
        if(count($config) != 4){
            throw new InvalidArgumentException("Invalid number of connection parameters.");

        }
        $this->_config = $config;
     }
     
     // Connect to mysql
     public function connect() {
        if ($this->_link === null){ 
            list($host,$user,$password, $database) = $this->_config;
            if(! $this->_link= mysqli_connect($host, $user, $password, $database)) {
                throw new RuntimeException("Error connecting to the server:".mysqli_connect_error());
            }
            unset($host,$user,$password, $database);

        }
        return $this->_link;
     }

     // Execute the specified query

     public function query($query){
        if(!is_string($query) || empty($query)){
            throw new InvalidArgumentException("The specified query is not valid.");
        }
        // lazy connect to mysql
        $this->connect();
        if (!$this->_result = mysqli_query($this->_link, $query)){
            throw new RuntimeException("Error executing the specified query".$query.mysqli_error($this->_link));
        }
        return $this->_result;

     }

     // perform SELECT statement 
     
     public function select($table,$where='', $fields= '*',$order= '',$limit=null,$offset=null){

        $query = 'SELECT '.$fields.' FROM '.$table
        .(($where ? ' WHERE '.$where:''))
        .(($limit ? ' LIMIT '.$limit:''))
        .(($limit && $offset ? ' OFFSET '.$offset:''))
        .(($order ? ' ORDER BY '.$order:''));

        $this->query( $query );
        return $this->countRows();

     }

     // insert 
     public function insert($table,array $data){ // asso array
        $fileds = implode(',',array_keys($data));
        $values = implode(',',array_map(array($this,'quoteValue'), array_values($data))); // array_map get function and array and loop in each element to performe action
        $query = 'INSERT INTO '.$table. '('.$fileds.')'.' VALUES ('.$values.')';
        $this->query( $query );
        return $this->getInsertID();


     }

     // update
     public function update($table,array $data,$where=''){

        $set=array();
        foreach($data as $filed=>$value){
            $set[] = $filed.'='.$this->quoteValue($value);
        }
        $set = implode(',',$set);
        $query = 'UPDATE '.$table.' SET '.$set
        .(($where ? ' WHERE '.$where:''));
        $this->query( $query );
        return $this->geAffecttedRow();
     }

     // delete

     public function delete($table,$where= ''){
        $query = 'DELETE FROM '.$table
        .(($where ? ' WHERE '.$where:''));
        $this->query( $query );
        return $this->geAffecttedRow();

     }

     //Escape the Specified value 

     public function quoteValue($value){
        $this->connect();
        if($value == null){
            $value = 'NULL';
        }else if(!is_numeric($value)){
            $value = "'" . mysqli_real_escape_string($this->_link, $value) ."'";
        }
        return $value;

     }

     // Fetch a single row from the current result set (as an associative array)

     public function fetch(){
        if($this->_result !== null){
            if(($row = mysqli_fetch_array($this->_result, MYSQLI_ASSOC)) === false){
                 
                $this->freeResult();
            }
            return $row;
         
     }
     return false;

    }

    // fetch all rows from the current result set as (an arrray of associative arrays)

    public function fetchAll(){
        if($this->_result !== null){
            if(($all = mysqli_fetch_all($this->_result, MYSQLI_ASSOC)) === false){
               $this->freeResult();
            }
            return $all;
         
     }
     return false;

    }

    // Get th insertion ID

    public function getInsertID() {
        return $this->_link !== null ? mysqli_insert_id($this->_link) : null;
    }

    // get number of row 
    public function countRows(){
        return $this->_result !== null ? mysqli_num_rows($this->_result) :0;
    }

    // Get number of affected rows 

    public function geAffecttedRow(){
        return $this-> _link !== null ? mysqli_affected_rows($this->_link) : 0;
    }

    // free up the current resul set

    public function freeResult(){
        if($this->_result===null){
            return false;
        }
        mysqli_free_result($this->_result);
        return true;
    }

    // close explicity the database connection 
    public function disconnecte(){ 
        if($this->_link === null){
            return false;
        }
        mysqli_close($this->_link);
        $this->_link = null;   
        return true;
     }

     public function __destruct(){ 
        $this->disconnecte();
     }






    }
?>
