<?php
class RoomManagement
{
  protected $db = null;
  protected $table = "tblsemester";

  public function __construct(ConnectionHandler $db)
  {
    if (!isset($db->con)) return null;
    $this->db = $db;
  }

  public function getRoomManagement()
  {
    // 
    /*SELECT table1.coulumn_name, table2.column_name
      FROM table1
      INNER JOIN table2
      ON table1.column_name = table2.column_name; */
    $result = $this->db->con->query("SELECT * FROM tblroommanagement AS A
    INNER JOIN tblsemester AS B ON A.fk_semester_id = B.id 
    INNER JOIN tblinstructor AS C ON A.fk_instructor_id = C.id
    INNER JOIN tblsubject AS D ON A.fk_subject_id = D.id
    INNER JOIN tblroom AS E ON A.fk_room_id = E.id");

    $resultArray = array();

    while ($info = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $resultArray[] = $info;
    }
    return $resultArray;
  }

  public function addRoomManagement($fk_semester_id, $fk_instructor_id, $fk_subject_id, $fk_room_id, $to_time, $from_time)
  {
    // collect data from the HTML and pass here for testing and then upload to the database
    $sql_query = "INSERT INTO $this->table
                    SET fk_semester_id=$fk_semester_id, 
                    fk_instructor_id='$fk_instructor_id',
                    fk_subject_id='$fk_subject_id',
                    fk_room_id='$fk_room_id',
                        to_time='$to_time'
                        from_time=$from_time";
    return mysqli_query($this->db->con, $sql_query);
  }
}
