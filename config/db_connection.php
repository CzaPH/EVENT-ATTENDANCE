<?php

class ConnectionHandler
{
      protected $host = 'lfmerukkeiac5y5w.cbetxkdyhwsb.us-east-1.rds.amazonaws.com';
      protected $user = 'z4lalbkhiykyuwaa';
      protected $password = 'qaxa067j1uqvnx8b';
      protected $database = 'gdcmy2nzpcyi4nxw';

      public $con = null;

      public function __construct()
      {
            $this->con = mysqli_connect($this->host, $this->user, $this->password, $this->database);

            if ($this->con->connect_error){
                  echo 'Fail Connection' . $this->con->connect_error;
            }
      }

      public function __destruct()
      {
            $this->closeConnection();
      }
      
      // clossing Connection
      protected function closeConnection()
      {
            if($this->con != null){
                  $this->con->close();
                  $this->con = null;
            }
      }
}