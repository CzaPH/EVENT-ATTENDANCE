<?php function navItems($active) { ?>
<?php 
        $items = [
            [
                "caption"=> "Dashboard",
                "icon"=> "bx bx-grid-alt",
                "url"=> "dashboard.php"
            ],
            [
                "caption"=> "Student Profile",
                "icon"=> "bx bxs-user-circle",
                "url"=> "student.php"
            ],
            [
              "caption"=> "Class Management",
              "icon"=> "bx bxs-school",
              "url"=> "enroll.php"
          ],
            // [
            //     "caption"=> "QR Generator",
            //     "icon"=> "bx bx-barcode-reader",
            //     "url"=> "qr.php"
            // ],
            [
              "caption"=> "Subject",
              "icon"=> "bx bx-book-content",
              "url"=> "subject.php"
            ],
            [
                "caption"=> "Course",
                "icon"=> "bx bx-list-ul",
                "url"=> "course.php"
            ],
            [
                "caption"=> "Semester",
                "icon"=> "bx bx-pie-chart-alt-2",
                "url"=> "semester.php"
            ],
            [
                "caption"=> "Instructor",
                "icon"=> "bx bxs-user-rectangle",
                "url"=> "instructor.php"
            ],
            [
                "caption"=> "Attendance Report",
                "icon"=> "bx bxs-report",
                "url"=> "report.php"
            ],
            [
                "caption"=> "User",
                "icon"=> "bx bx-user",
                "url"=> "user.php"
            ],
            [
                "caption"=> "Account",
                "icon"=> "bx bx-user",
                "url"=> "faculty/user.php"
            ],
          //   [
          //     "caption"=> "Event Attendance",
          //     "icon"=> "bx bx-user",
          //     "url"=> "faculty/EventAttendance.php"
          // ],
          //   [
          //     "caption"=> "User Logs",
          //     "icon"=> "bx bxs-user-circle",
          //     "url"=> "logs.php"
          // ],
            [
                "caption"=> "Logout",
                "icon"=> "bx bx-log-out",
                "url"=> "logout.php"
            ]
        ];
    ?>
<ul class="nav-links">
    <?php foreach ($items as $item) { ?>
    <li>
        <a href="<?= $item["url"] ?>" style="color: white" class="<?= $item["caption"] == $active ? "active": "" ?>">
            <i class='<?= $item["icon"] ?>'></i>
            <span class="link_name"><?= $item["caption"] ?></span>
        </a>
    </li>
    <?php } ?>
    <!-- <li>
        <a href="dashboard.php">
          <i class="bx bx-grid-alt"></i>
          <span class="links_name">Dashboard</span>
        </a>
      </li>
      <li>
        <a href="student.php">
          <i class='bx bxs-user-circle'></i>
          <span class="links_name">Student Profile</span>
        </a>
      </li>
      <li>
        <a href="qr.php">
          <i class='bx bx-barcode-reader'></i>
          <span class="links_name">Generate Qr Code</span>
        </a>
      </li>
      <li>
        <a href="course.php">
          <i class="bx bx-list-ul"></i>
          <span class="links_name">Course</span>
        </a>
      </li>
      <li>
        <a href="subject.php">
          <i class='bx bx-book-content'></i>
          <span class="links_name">Subject</span>
        </a>
      </li>
      <li>
        <a href="semester.php">
          <i class="bx bx-pie-chart-alt-2"></i>
          <span class="links_name">Semester</span>
        </a>
      </li>
      <li>
        <a href="instructor.php">
          <i class='bx bxs-user-rectangle'></i>
          <span class="links_name">Instructor</span>
        </a>
      <li>
        <a href="report.php">
          <i class='bx bxs-report'></i>
          <span class="links_name">Attendance Report</span>
        </a>
      </li>
      <li>
        <a href="user.php">
          <i class="bx bx-user"></i>
          <span class="links_name">User</span>
        </a>
      </li>
      <li class="log_out">
        <a href="logout.php">
          <i class="bx bx-log-out"></i>
          <span class="links_name">Log out</span>
        </a>
      </li> -->
</ul>
<?php } ?>