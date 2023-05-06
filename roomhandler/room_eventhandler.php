<?php
class Room
{
  protected $db = null;
  protected $table = "tblroom";

  public function __construct(ConnectionHandler $db)
  {
    if (!isset($db->con)) return null;
    $this->db = $db;
  }

  public function getRoom()
  {
    // 
    /*SELECT table1.coulumn_name, table2.column_name
      FROM table1
      INNER JOIN table2
      ON table1.column_name = table2.column_name; */
    $result = $this->db->con->query("SELECT * FROM tblroom");

    $resultArray = array();

    while ($info = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $resultArray[] = $info;
    }
    return $resultArray;
  }

  public function addRoom($room_code, $room_description)
  {
    // collect data from the HTML and pass here for testing and then upload to the database
    $sql_query = "INSERT INTO $this->table
                    SET room_code=$room_code, 
                    room_description='$room_description'";
    return mysqli_query($this->db->con, $sql_query);
  }
}
