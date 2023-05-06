<?php function navItems($active) { ?>
<?php 
        $items = [
            [
                "caption"=> "Dashboard", // 0
                "icon"=> "bx bx-grid-alt", // 1
                "url"=> "../faculty/faculty_page.php" // 2
            ],
            [
                "caption"=> "Subject",
                "icon"=> "bx bx-list-ul",
                "url"=> "../faculty/subjects.php"
            ],
            // [
            //     "caption"=> "Report",
            //     "icon"=> "bx bx-pie-chart-alt-2",
            //     "url"=> "../faculty/facultyreport.php"
            // ],
            [
                "caption"=> "Attendance",
                "icon"=> "bx bx-calendar",
                "url"=> "attendance_report.php"
            ],
            [
                "caption"=> "Account",
                "icon"=> "bx bx-user",
                "url"=> "../faculty/user.php"
            ],
            // [
            //     "caption"=> "Event Attendance",
            //     "icon"=> "bx bx-user",
            //     "url"=> "../faculty/EventAttendance.php"
            // ],
            [
                "caption"=> "Logout",
                "icon"=> "bx bx-log-out",
                "url"=> "../logout.php"
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

</ul>
<?php } ?>