<script>
      let sidebar = document.querySelector(".sidebar");
      let sidebarBtn = document.querySelector(".sidebarBtn");
      sidebarBtn.onclick = function() {
        sidebar.classList.toggle("active");
        if (sidebar.classList.contains("active")) {
          sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
          $('.logo-details').addClass('d-none');
        } else {
            sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
            $('.logo-details').removeClass('d-none');
        }
      };
    </script>
</body>
</html>