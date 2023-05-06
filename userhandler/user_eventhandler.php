<?php
class User
{
  protected $db = null;
  protected $table = "tbluser";

  public function __construct(ConnectionHandler $db)
  {
    if(!isset($db->con)) return null;
    $this->db = $db;
  }

  public function getUser()
  {
    // 
    /*SELECT table1.coulumn_name, table2.column_name
      FROM table1
      INNER JOIN table2
      ON table1.column_name = table2.column_name; */
    $result = $this->db->con->query("SELECT * FROM tblinstructor where is_deleted = 0");

    $resultArray = array();

    while($info = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
      $resultArray[] = $info;
    }
    return $resultArray;
  }

  public function addUser($fname, $mname, $lname, $user_id,$password)
  {
    // collect data from the HTML and pass here for testing and then upload to the database
    $sql_query = "INSERT INTO $this->table
                    SET fname=$fname,mname='$mname',lname='$lname',user_id='$user_id,password='$password''";
    return mysqli_query($this->db->con, $sql_query);
    
  }

}