<?php
class Subject 
{
  protected $db = null;
  protected $table = "tblsubject";

  public function __construct(ConnectionHandler $db)
  {
    if(!isset($db->con)) return null;
    $this->db = $db;
  }

  public function getSubject()
  {
    // 
    /*SELECT table1.coulumn_name, table2.column_name
      FROM table1
      INNER JOIN table2
      ON table1.column_name = table2.column_name; */
    $result = $this->db->con->query("SELECT * FROM tblsubject where is_deleted = 0 ORDER BY id DESC");

    $resultArray = array();

    while($info = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
      $resultArray[] = $info;
    }
    return $resultArray;
  }

  public function addSubject($subject_code, $subject_description)
  {
    // collect data from the HTML and pass here for testing and then upload to the database
    $sql_query = "INSERT INTO $this->table
                    SET subject_code=$subject_code, 
                    subject_description='$subject_description'";
    return mysqli_query($this->db->con, $sql_query);
    
  }

}