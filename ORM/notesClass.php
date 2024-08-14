<?php
require "orm.php";
require 'config.php';

class NotesClass extends MysqlAdapter{
    private $table = 'notes';

    public function __construct(){
      global $config;
      parent::__construct($config);
    }

    public function getNotes($user_id){
        $this->select($this->table,'id= '.$user_id );
        return $this->fetchAll();
    }

    public function getNote( $user_id ,$count_id){
        $this->select($this->table,'id= '.$user_id.' AND count_id='.$count_id.'');
        return $this->fetch();
    }

    public function addNote(array $data){
        return $this->insert($this->table, $data);
    }

    public function updateNote(array $data,$user_id,$count_id){
        return $this->update($this->table, $data, 'id= '.$user_id.' AND count_id= '.$count_id.'');
    }
    public function deleteNote($user_id){
        return $this->delete($this->table,$user_id);
  
    }

    public function userInfo($user_id){
        $this->select('users','id= '.$user_id);
        return $this->fetch();
    }

    public function getRowcount($user_id){
        return $this->select($this->table,'id= '.$user_id);
    }

}


?>