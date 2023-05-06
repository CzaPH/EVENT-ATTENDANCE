<?php
    function semester($is_active, $conn)
    {
        if($is_active){
            $query = $conn->prepare("SELECT * FROM tblsemester WHERE is_active = true AND is_deleted = false");
            $query->execute();
            $result = $query->get_result();
            $data = mysqli_fetch_array($result);
            return $data;
        } else {
            $query = $conn->prepare("SELECT * FROM tblsemester WHERE is_deleted = false");
            $query->execute();
            $result = $query->get_result();
            $html = "";
            $html .= '<select name="semester_id" id="semester_id" class="w-100" required>
                        <option value="">SELECT</option>';
                        foreach($result as $row) {
                            $html .= '<option value="'.$row['id'].'">'.strtoupper($row['semester_code'].' - '.$row['semester_description']).'</option>';
                        }
            $html .= '<select>';

            return $html;
        }
    }

    function group()
    {
        $html = "";

        $html .= '<b>Filter by</b><br />
                <select name="group_by" id="group_by" class="w-100">
                    <option value="daily" selected>Daily</option>
                    <option value="monthly">Monthly</option>
                </select>';

        return $html;
    }
?>