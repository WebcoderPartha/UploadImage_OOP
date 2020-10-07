<?php
class Database{

    public $host    = DB_HOST;
    public $user    = DB_USER;
    public $passord = DB_PASSWORD;
    public $dbname  = DB_NAME;

    public $link;
    public $error;

    public function __construct(){
        $this->connectDB();
    }

    private function connectDB(){

        $this->link = new mysqli($this->host, $this->user, $this->passord, $this->dbname);
        if (!$this->link){
            $this->error = "Connection fail". $this->link->connect_error;
            return false;
        }
    }

    // Select Or Read Data;
    public function select($query){
        $result = $this->link->query($query) or die($this->link->error.__LINE__);

        if ($result->num_rows > 0){
            return $result;
        }else{
            return false;
        }
    }

    public function create($query){
        $create = $this->link->query($query) or die($this->link->error.__LINE__);

        if ($create){
            return $create;
        }else{
            die("Error: (".$this->errno.")".$this->link->error);
        }
    }

    public function update($query){

        $update = $this->link->query($query) or die($this->link->error.__LINE__);

        if ($update){
            header("Location: index.php?msg=".urldecode('Updated successfully.'));
            exit();
        }else{
            die("Error: (".$this->errno.")".$this->link->error);
        }

    }

    public function delete($query){

        $delete = $this->link->query($query) or die($this->link->error.__LINE__);
        if ($delete){
            header("Location: index.php?msg=".urldecode('Data deleted successfully.'));
            exit();
        }else{
            die("Error: (".$this->errno.")".$this->link->error);
        }

    }


}
