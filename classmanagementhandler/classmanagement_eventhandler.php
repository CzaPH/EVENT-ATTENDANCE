<?php
class ClassManagement
{
  protected $db = null;
  protected $table = "tblclassmanagement";

  public function __construct(ConnectionHandler $db)
  {
    if (!isset($db->con)) return null;
    $this->db = $db;
  }

  public function getClassManagement()
  {
    // 
    /*SELECT table1.coulumn_name, table2.column_name
      FROM table1
      INNER JOIN table2
      ON table1.column_name = table2.column_name; */
    $result = $this->db->con->query("SELECT * FROM tblclassmanagement AS A
    INNER JOIN tblstudentinfo AS B ON A.fk_student_id = B.id 
    INNER JOIN tblstudentinfo AS C ON A.fk_student_name = C.id");

    $resultArray = array();

    while ($info = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $resultArray[] = $info;
    }
    return $resultArray;
  }

  public function addClassManagement($fk_student_id, $fk_student_name)
  {
    // collect data from the HTML and pass here for testing and then upload to the database
    $sql_query = "INSERT INTO $this->table
                    SET fk_student_id=$fk_student_id, 
                    fk_student_name='$fk_student_name'";
    return mysqli_query($this->db->con, $sql_query);
  }
}
