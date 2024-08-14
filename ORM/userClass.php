<?php
require "orm.php";
require 'config.php';

class User extends MysqlAdapter{
    private $table = 'users';
    public function __construct() {
        // Add from the databse configuration file 
        global $config;
        // Call the parent consteructor 
        parent::__construct($config);   
    }

    // return every user row as array of associative

    public function getUsers(){
       $this->select($this->table);
       return $this->fetchAll();
    }

    // show one user
    // @param int $user_id, return a user row as associative array
    public function getUser($user_id){
        $this->select($this->table,'id= '.$user_id);
        return $this->fetch();
    }

    // add user 
    // @ param array $user_data associative array conting column and value
    // return int returns the id of the user inserted
    public function addUser(array $user_data){
       return $this->insert($this->table, $user_data);
    }

    // @ param array $user_data associative array conting column and value
    // @param int $user_id
    // return int number of affectef rows
    public function updateUser($user_id, $user_data){

        return $this->update($this->table, $user_data,'id= '. $user_id);
    }

    // delete
    // @param int $user_id
    // return int number of affectef rows
    public function deleteUser($user_id){
        return $this->delete($this->table,'id= '. $user_id);
    }

    public function searchUsers($keyword){
        $this->select($this->table,"name LINK '%$keyword%' OR email LIKE '%$keyword'");
        return $this->fetchAll(); 
    }

    public function searchEmail($email){
       
        return  $this->select($this->table,"email='".$email."'") ? True : false;
    }

    public function checkUser($email, $password)
    {
         $this->select($this->table,"email='".$email."'");
    
        $user = $this->fetch();  // Fetch a single row
    
    
        if ($user && password_verify($password, $user['password'])) {
            return $user['id'];
        }
    
        return false;
    }
    


}


?>