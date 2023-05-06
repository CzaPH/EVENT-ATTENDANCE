<?php
class Instructor
{
  protected $db = null;
  protected $table = "tblinstructor";

  public function __construct(ConnectionHandler $db)
  {
    if(!isset($db->con)) return null;
    $this->db = $db;
  }

  public function getInstructor()
  {
    // 
    /*SELECT table1.coulumn_name, table2.column_name
      FROM table1
      INNER JOIN table2
      ON table1.column_name = table2.column_name; */
    $result = $this->db->con->query("SELECT * FROM tblinstructor WHERE user_type = 'Faculty' AND is_deleted = 0");

    $resultArray = array();

    while($info = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
      $resultArray[] = $info;
    }
    return $resultArray;
  }

  public function addIntructor($employee_number, $fname, $mname, $lname, $password)
  {
    // collect data from the HTML and pass here for testing and then upload to the database
    $sql_query = "INSERT INTO $this->table
                    SET employee_number=$employee_number, 
                    fname='$fname',mname='$mname',lname='$lname',password='$password'";
    return mysqli_query($this->db->con, $sql_query);
    
  }

}