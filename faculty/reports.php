<?php
    include('../config/config.php');


function num($conn, $class_id){
    $query  = $conn->prepare("SELECT * FROM tblattendance WHERE fk_subject_id = ? GROUP BY fk_subject_id");
    $query->bind_param('i', $class_id);
    $query->execute();
    $result = $query->get_result();

    return mysqli_num_rows($result);
}

function attended($conn, $class_id, $student_id){
    $query  = $conn->prepare("SELECT * FROM tblattendance WHERE fk_subject_id = ? AND fk_student_id = ?");
    $query->bind_param('ii', $class_id, $student_id);
    $query->execute();
    $result = $query->get_result();

    return mysqli_num_rows($result);
}

// function attended2($conn, $class_id, $student_id){
//     $query  = $conn->prepare("SELECT * FROM tblattendance WHERE fk_subject_id = ? AND fk_student_id = ?");
//     $query->bind_param('ii', $class_id, $student_id);
//     $query->execute();
//     $result = $query->get_result();

//     return mysqli_num_rows($result);
// }

function lates($conn, $class_id, $student_id) {
    $query  = $conn->prepare("SELECT * FROM tblattendance WHERE fk_subject_id = ? AND fk_student_id = ? AND is_late = true");
    $query->bind_param('ii', $class_id, $student_id);
    $query->execute();
    $result = $query->get_result();

    return mysqli_num_rows($result);

}

session_start();
if($_SESSION['user_id'] == "")
{
    $_SESSION['user_id'];
    header('location:../index.php');
    exit;
}

    if(isset($_GET['id']) && isset($_SESSION['user_id'])) {
        $class_id   = filter($_GET['id']);

        $query = $conn->prepare("SELECT *
                                FROM
                                    classes
                                    INNER JOIN tblsubject 
                                        ON (classes.subject_id = tblsubject.id) 
                                            WHERE class_id = ? AND instructor_id = ?");
        $query->bind_param('ii', $class_id,$_SESSION['user_id']);
        $query->execute();
        $result = $query->get_result();

        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);

            $query2 = $conn->prepare("SELECT *
                                        FROM
                                            class_list
                                            INNER JOIN tblstudentinfo 
                                                ON (class_list.student_id = tblstudentinfo.id)
                                                WHERE class_id = ? ORDER BY fname ASC");
            $query2->bind_param('i', $class_id);
            $query2->execute();

            $result2 = $query2->get_result();
        } else {
            header('Location: subjects.php');    
            exit;
        }
    } else {
        header('Location: subjects.php');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Manage Student Profile</title>
    <link rel="stylesheet" href="../css/dashboard.css" />
    <link rel="stylesheet" href="../css/sidebar.css" />
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <style>
    .btn {
        padding: 4px !important;
        font-size: 13px !important;
        width: 100%;
        height: 30px;
        background: #081D45 !important;
        text-transform: uppercase !important;
        font-weight: bold;
    }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="logo-details">
            <span class="logo_name"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Faculty</span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="subjects.php">
                    <i class='bx bx-arrow-back'></i>
                    <span class="links_name">Back</span>
                </a>
            </li>
        </ul>
    </div>
    <section class="home-section">
        <!-- <div class="header">
      <h5>COLLEGE OF COMPUTING STUDIES, INFORMATION AND COMMUNICATION TECHNLOGY</h5>
    </div> -->
        <nav>
            <div class="sidebar-button">
                <i class="bx bx-menu sidebarBtn"></i>
                <span class="dashboard"></span><?php echo $_SESSION['USER_NAME'] ?>
            </div>
            <div class="search-box">
                <input type="text" placeholder="Search..." />
                <i class="bx bx-search"></i>
            </div>
        </nav>
        <!-- END OF THE SIDE BAR -->

        <div class="home-content">
            <center>
                <h5 class="bg-white mx-3 p-3 border rounded shadow">
                    <b><?=strtoupper($row['subject_code'])?> - <?=strtoupper($row['subject_description'])?></b>
                </h5>
                <br />
                <p>Total # of Classes : <?=num($conn, $class_id)?></p>
            </center>
            <section class="attendance">
                <div class="attendance-list p-3">
                    <table class="table" id="dt">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NAME</th>
                                <th># OF LATES</th>
                                <th># OF PRESENT</th>
                                <th># OF ABSENTS</th>
                                <th>LOGS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($result2 as $r):?>
                            <tr>
                                <td><?=$r['stud_id']?></td>
                                <td><?=strtoupper($r['lname'].', '.$r['fname'].' '.$r['mname'])?></td>
                                <td><?=lates($conn, $class_id, $r['id'])?></td>
                                <td><?=attended($conn, $class_id, $r['id'])?></td>
                                <td>
                                    <?php
                                        $no_of_absents = (num($conn, $class_id) - attended($conn, $class_id, $r['id']));
                                        if($no_of_absents >= 0){
                                            echo $no_of_absents;
                                        }else{
                                            echo '0';
                                        }
                                        
                                    ?>
                                </td>
                                <td>
                                    <a class="btn" href="logs.php?id=<?=$r['id']?>&&class=<?=$class_id?>">
                                        LOGS
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
                <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                let sidebar = document.querySelector(".sidebar");
                let sidebarBtn = document.querySelector(".sidebarBtn");
                sidebarBtn.onclick = function() {
                    sidebar.classList.toggle("active");
                    if (sidebar.classList.contains("active")) {
                        sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
                    } else sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
                };

                $(function() {
                    $('#dt').DataTable({
                        ordering: false
                    });
                });
                </script>
</body>

</html>