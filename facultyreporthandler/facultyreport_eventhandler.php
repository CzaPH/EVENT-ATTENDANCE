<?php
class FacultyReport
{
  protected $db = null;
  protected $table = "tblstudentinfo";

  public function __construct(ConnectionHandler $db)
  {
    if (!isset($db->con)) return null;
    $this->db = $db;
  }

  public function getFacultyReport()
  {
    // 
    /*SELECT table1.coulumn_name, table2.column_name
      FROM table1
      INNER JOIN table2
      ON table1.column_name = table2.column_name; */
    $result = $this->db->con->query("SELECT B.stud_id, B.fname, B.mname, B.lname, C.coursecode, D.section_code, E.year_code
    FROM tbl_student_add_subject AS A
    INNER JOIN tblstudentinfo AS B ON A.fk_student_id = B.id
    INNER JOIN tblcourse AS C ON B.fk_course_id = C.id
    INNER JOIN tblsection AS D ON B.fk_section_id = D.id
    INNER JOIN tblyear AS E ON B.fk_year_id = E.id");

    $resultArray = array();

    while ($info = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $resultArray[] = $info;
    }
    return $resultArray;
  }

  public function addFacultyReport($fk_student_id, $fk_student_name)
  {
    // collect data from the HTML and pass here for testing and then upload to the database
    $sql_query = "INSERT INTO $this->table
                    SET fk_student_id=$fk_student_id, 
                    fk_student_name='$fk_student_name'";
    return mysqli_query($this->db->con, $sql_query);
  }
}
