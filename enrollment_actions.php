<?php
include('config/config.php');
include('functions.php');
$active = semester(1, $conn);

$html = "";

if(isset($_POST['action'])) {
    $semester_id = filter($_POST['semester_id']);
    $subject_id = filter($_POST['subject_id']);
    $schedules = json_encode($_POST['schedules']);
    $instructor_id = filter($_POST['instructor_id']);
    $course_id = filter($_POST['course_id']);
    $yr_and_section = filter($_POST['yr_and_section']);

    $insert = $conn->prepare("INSERT INTO classes (
                                        semester_id, subject_id, schedules, instructor_id, course_id, yr_and_section
                                        ) VALUES(?,?,?,?,?,?)");
    $insert->bind_param('iisiis',$semester_id, $subject_id, $schedules, $instructor_id, $course_id, $yr_and_section);
    $insert->execute();

    exit(json_encode('success'));
}

if(isset($_POST['delete'])) {
    $class_id = filter($_POST['class_id']);
    
    $update = $conn->prepare("UPDATE classes SET is_deleted = true WHERE class_id = ?");
    $update->bind_param('i', $class_id);
    $update->execute();
    exit(json_encode('success'));
}

if(isset($_POST['load'])) {
    $class_id = filter($_POST['class_id']);

    $query  = $conn->prepare("SELECT * FROM class_list INNER JOIN tblstudentinfo
                            ON (class_list.student_id = tblstudentinfo.id)
                             WHERE class_id = ? AND is_deleted = false AND tblstudentinfo.semester_id = ?");
    $query->bind_param('ii', $class_id, $active['id']);
    $query->execute();
    $result = $query->get_result();
    $html .='<table class="table table-sm table-condensed mt-5" id="students">
          <thead>
            <tr>
              <th>
              <input type="checkbox" id="select-all">
              </th>
              <th>ID</th>
              <th>Name</th>
              <th>Sex</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>';
          if(mysqli_num_rows($result) > 0) {
            foreach($result as $row) {
                $html .= '<tr style="text-transform:uppercase !important;">
                            <td>
                                <input type="checkbox" class="student-record" name="list_id" value="'.$row['list_id'].'">
                            </td>
                            <td>'.$row['stud_id'].'</td>
                            <td>'.$row['fname'].'</td>
                            <td>'.$row['sex'].'</td>
                            <td>
                                <a href="#" class="remove-from-class-list"
                                    data-class_id="'.$class_id.'"
                                    data-list_id="'.$row['list_id'].'">
                                    Remove from Class List
                                </a>
                            </td>
                        </tr>';
            }
          } else {
            $html .= '<tr>
                        <td colspan="5">
                            <center>
                                No record found.
                            </center>
                        </td>
                    </tr>';
          }
    $html .='</tbody>
        </table>
        <script>
        $("#students").DataTable({
            ordering:  false,
            paging:false,
        });
        </script>';

    exit(json_encode($html));
}

if(isset($_POST['load_class'])) {
    $class_id = filter($_POST['class_id']);
    $query  = $conn->prepare("SELECT * FROM tblstudentinfo WHERE id NOT IN (SELECT student_id FROM class_list WHERE class_id = ?)
                            ORDER BY lname ASC");
    $query->bind_param("i", $class_id);
    $query->execute();
    $result = $query->get_result();
    $html .='
    <a href="#" class="btn add-multiple btn-info" data-class_id="'.$class_id.'" style="float:right;"> Add Students</a>
        <table class="table table-sm table-condensed" id="data">
          <thead>
            <tr>
             <th>
                <input type="checkbox" id="select-all2">
              </th>
              <th>ID</th>
              <th>Name</th>
              <th>Sex</th>
              <th>Course, Yr &amp; Section</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>';
          if(mysqli_num_rows($result) > 0) {
            foreach($result as $row) {
                $html .= '<tr style="text-transform:uppercase !important;">
                            <td>
                                <input type="checkbox" class="student-record-id" name="student_id" value="'.$row['id'].'">
                            </td>
                            <td>'.$row['stud_id'].'</td>
                            <td>'.$row['fname'].'</td>
                            <td>'.$row['sex'].'</td>
                            <td>'.strtoupper($row['cys']).'</td>
                            <td>
                                <a href="#" class="add-to-class-list"
                                    data-id="'.$row['id'].'">
                                    Add to Class List
                                </a>
                            </td>
                        </tr>';
            }
          } else {
            $html .= '<tr>
                        <td colspan="5">
                            <center>
                                No record found.
                            </center>
                        </td>
                    </tr>';
          }
    $html .='</tbody>
        </table>
        <script>
        $("#data").DataTable({
            ordering:  false,
            paging:false,
            info:true
        });
        </script>';

    exit(json_encode($html));
}

if(isset($_POST['add_multiple'])) {
    $student_id = $_POST['student_id'];
    $class_id = filter($_POST['class_id']);
    for($i = 0; $i < count($student_id); $i++) {
        $update = $conn->prepare("INSERT INTO class_list(class_id, student_id) VALUES(?,?)");
        $update->bind_param('ii', $class_id, $student_id[$i]);
        $update->execute();
    }
    exit(json_encode('success'));
}

if(isset($_POST['add_to_class_list'])) {
    $class_id = filter($_POST['class_id']);
    $student_id = filter($_POST['id']);
    
    $update = $conn->prepare("INSERT INTO class_list(class_id, student_id) VALUES(?,?)");
    $update->bind_param('ii', $class_id, $student_id);
    $update->execute();
    exit(json_encode('success'));
}

if(isset($_POST['remove_from_class_list'])) {
    $list_id = $_POST['list_id'];
    
    $delete = $conn->prepare("DELETE FROM class_list WHERE list_id = ?");
    $delete->bind_param('i', $list_id);
    $delete->execute();
    exit(json_encode('success'));
}

if(isset($_POST['remove_multiple'])) {
    $list_id = $_POST['list_id'];
    for($i = 0; $i < count($list_id); $i++) {
        $delete = $conn->prepare("DELETE FROM class_list WHERE list_id = ?");
        $delete->bind_param('i', $list_id[$i]);
        $delete->execute();
    }
    exit(json_encode('success'));
}

if(isset($_POST['semester_id'])) {
    $semester_id = filter($_POST['semester_id']);

    $html = "";

    $query  = $conn->prepare("SELECT * FROM schedules INNER JOIN tblsubject 
                                ON (schedules.subject_id = tblsubject.id) WHERE semester_id = ?
                                GROUP BY schedules.subject_id");
    $query->bind_param('i', $semester_id);
    $query->execute();

    $result = $query->get_result();
    $html .= '<label class="mx-3">Subject : </label>';
    $html .= '<select name="subject_id" id="subject_id">';
    $html .= '<option value="">SELECT</option>';
    foreach($result as $row) {
        $html .= '<option value="'.$row['subject_id'].'">'.$row['subject_code'].' - '.$row['subject_description'].'</option>';
    }
    $html .= '</select>';

    exit(json_encode($html));
}

if(isset($_POST['subject_id'])) {
    $subject_id = filter($_POST['subject_id']);
    $semester_id = filter($_POST['sem_id']);

    $html = "";

    $query  = $conn->prepare("SELECT * FROM schedules WHERE subject_id = ? AND semester_id = ?");
    $query->bind_param('ii', $subject_id, $semester_id);
    $query->execute();

    $result = $query->get_result();
    $html .= '<label class="mx-3">Schedules Available : </label> <br />';
    foreach($result as $row) {
        $html .= '<input type="checkbox" name="schedules" class="mr-3 pointer" value="'.$row['schedule_id'].'">'.$row['day_of_the_week'].' > '.date('h:i a', strtotime($row['start_time'])).' to '.date('h:i a', strtotime($row['end_time'])).' | '.strtoupper($row['room_details']).'<br />';
    }

    $html .= '<label>Instructor : </label><input type="text" class="w-50 p-2 mt-2 mx-2" name="instructor" id="instructor" placeholder="Instructor" readonly data-toggle="modal" data-target="#modal">';


    $query2  = $conn->prepare("SELECT * FROM tblcourse WHERE is_deleted = false");
    $query2->execute();
    $result2 = $query2->get_result();
    $html .= ' <section>
                <label>Course : </label>';
    $html .= '<select name="course_id" id="course_id" class="w-50 p-2 mt-2 mx-2">';
    $html .= '<option value="">SELECT</option>';
    foreach($result2 as $row2) {
        $html .= '<option value="'.$row2['id'].'">'.$row2['coursecode'].' - '.$row2['coursedescription'].'</option>';
    }
    $html .= '</select> <br />';
    $html .= '<label>Yr &amp; Section : </label><input type="text" class="w-50 p-2 mt-2 mx-2" name="yr_and_section" id="yr_and_section" placeholder="YR & SECTION" required>';
    $html .= '<button class="btn save" type="button">SAVE</button>';
    $html .= '</section>';

    

    exit(json_encode($html));
}

if(isset($_POST['update_instructor'])) {
    $class_id = filter($_POST['class_id']);
    $instructor_id = filter($_POST['instructor_id']);
    
    $update = $conn->prepare("UPDATE classes SET instructor_id = ? WHERE class_id = ?");
    $update->bind_param('ii', $instructor_id, $class_id);
    $update->execute();
    exit(json_encode('success'));
}

?>