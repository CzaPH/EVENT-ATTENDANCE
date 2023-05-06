<?php
    @require("../config/config.php");
    if(isset($_POST['assign_automatically'])){
        $class_id     = $_POST['class_id'];
        $order_by     = $_POST['order_by'];

        $delete = $conn->prepare("DELETE FROM tblseatplan WHERE fk_subject_id = ?");
        $delete->bind_param('i', $class_id);
        $delete->execute();

        $select = $conn->prepare("SELECT class_list.student_id AS student_id, tblstudentinfo.*
                                    FROM
                                        class_list
                                        INNER JOIN tblstudentinfo 
                                            ON (class_list.student_id = tblstudentinfo.id)
                                        WHERE class_list.class_id = ?
                                        ORDER BY fname $order_by");
        $select->bind_param('i', $class_id);
        $select->execute();
        $result = $select->get_result();

        foreach($result as $key => $row){
            $seat_number = ($key + 1);
            $insert = $conn->prepare("INSERT INTO tblseatplan(fk_subject_id, fk_student_id, seat_number) VALUES(?,?,?)");
            $insert->bind_param('iis', $class_id, $row['student_id'], $seat_number);
            $insert->execute();
        }
        
        exit(json_encode('success'));
    }elseif(isset($_POST['update_status'])){

        $student_id     = $_POST['student_id'];
        $class_id     = $_POST['class_id'];
        $today = date('Y-m-d');
        $update     = $conn->prepare("UPDATE tblattendance SET is_late = false WHERE fk_student_id = ? AND fk_subject_id = ? AND logdate = ?");
        $update->bind_param('iis', $student_id, $class_id, $today);

        if($update->execute()) {
            $message = 'success';
        } else {
            $message = "Unexpected server error occured. Please reload page.";
        }

        exit(json_encode($message));

    }elseif(isset($_POST['class_id']) && !isset($_POST['student_id'])) {
        $class_id = filter($_POST['class_id']);

        $stmt = $conn->prepare("SELECT tblstudentinfo.*
                                FROM
                                    class_list
                                    INNER JOIN tblstudentinfo 
                                        ON (class_list.student_id = tblstudentinfo.id)
                                        WHERE tblstudentinfo.is_deleted = false AND class_list.class_id = ? 
                                        AND class_list.student_id 
                                    NOT IN (SELECT fk_student_id FROM tblseatplan WHERE fk_subject_id = ?)
                                    ORDER BY fname ASC");
        $stmt->bind_param('ii', $class_id,$class_id);
        $stmt->execute();

        $result     = $stmt->get_result();

        $html = "";

        $html .= '<table class="table table-sm table-condensed table-borderless table-hover" id="dt">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>';
                    foreach($result as $row) {
                        $html .= '<tr style="cursor:pointer;"
                                class="assign-student"
                                data-student_id="'.$row['id'].'">';
                        $html .= '<td>'.$row['stud_id'].'</td>';
                        $html .= '<td>'.strtoupper($row['fname']).'</td>';
                        $html .= '</tr>';
                    }
        $html .= '</tbody>
                </table>
        <script>
            $("#dt").DataTable({
                paging: false,
                ordering:  false,
                info:false
            });
        </script>';

        exit(json_encode($html));
    } elseif(isset($_POST['seat_id'])){

        $id     = $_POST['seat_id'];
        $delete     = $conn->prepare("DELETE FROM tblseatplan WHERE id = ?");
        $delete->bind_param('i', $id);

        if($delete->execute()) {
            $message = 'success';
        } else {
            $message = "Unexpected server error occured. Please reload page.";
        }

        exit(json_encode($message));

    } else {
        $subject_id = $_POST['class_id'];
        $student_id = $_POST['student_id'];
        $seat_number = $_POST['seat_number'];

        $message = "";

        $select = $conn->prepare("SELECT * FROM tblseatplan WHERE seat_number = ? AND fk_subject_id = ?");
        $select->bind_param('ii', $seat_number, $subject_id);
        $select->execute();

        $result = $select->get_result();

        $select2 = $conn->prepare("SELECT * FROM tblseatplan WHERE fk_student_id = ? AND fk_subject_id = ?");
        $select2->bind_param('ii', $student_id, $subject_id);
        $select2->execute();

        $result2 = $select2->get_result();
        
        if(mysqli_num_rows($result) > 0) {
            $message = "Seat was already taken. Vacate seat first.";
            exit(json_encode($message));
        } else if(mysqli_num_rows($result2) > 0) {
            $message = "Selected student already have assigned seat. Delete record first.";
            exit(json_encode($message));
        }

        $query = $conn->prepare("INSERT INTO tblseatplan(fk_subject_id, fk_student_id, seat_number) VALUES(?,?,?)");
        $query->bind_param('iii', $subject_id, $student_id, $seat_number);
        
        if($query->execute()) {
            exit(json_encode('success'));
        } else {
            exit(json_encode('error'));
        }
    }
?>