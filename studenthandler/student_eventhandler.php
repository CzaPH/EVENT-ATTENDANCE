<?php
class Student 
{
  protected $db = null;
  protected $table = "tblstudentinfo";

  public function __construct(ConnectionHandler $db)
  {
    if(!isset($db->con)) return null;
    $this->db = $db;
  }

  public function getStudent()
  {
    // 
    /*SELECT table1.coulumn_name, table2.column_name
      FROM table1
      INNER JOIN table2
      ON table1.column_name = table2.column_name; */
    $result = $this->db->con->query("SELECT * FROM tblstudentinfo AS A
    INNER JOIN tblcourse AS B ON A.fk_course_id = B.id 
    INNER JOIN tblsection AS C ON A.fk_section_id = C.id
    INNER JOIN tblyear AS D ON A.fk_year_id = D.id");


    $resultArray = array();

    while($info = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
      $resultArray[] = $info;
    }
    return $resultArray;
  }

  public function addStudent($id,$stud_id, $fname, $mname, $lname, $sex, $fk_course_id, $fk_section_id, $fk_year_id)
  {
    // collect data from the HTML and pass here for testing and then upload to the database
    $sql_query = "INSERT INTO $this->table
                    SET stud_id=$stud_id, 
                        fname='$fname', mname='$mname', lname='$lname',
                        sex='$sex',
                        fk_course_id='$fk_course_id',
                        fk_course_id='$fk_section_id',
                        fk_course_id='$fk_year_id'";
    return mysqli_query($this->db->con, $sql_query);
    
  }

}