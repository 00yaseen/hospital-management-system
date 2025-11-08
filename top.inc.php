<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>HMS Admin Panel</title>

  <!-- Boxicons & Bulma -->
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">

  <style>
    /* Sidebar */
    .sidebar {
      width: 260px;
      height: 100vh;
      background-color: #004c91;
      color: white;
      position: fixed;
      overflow-y: auto;
      padding-top: 10px;
    }

    .menu-list { padding: 0 8px; }

    /* anchor style */
    .menu-list > li > a {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 0.6rem;
      padding: 10px 14px;
      color: #232425ff;
      text-decoration: none;
      border-radius: 8px;
      transition: background .18s, color .18s;
      font-weight: 500;
    }
    .menu-list > li > a:hover,
    .menu-list > li > a.active {
      background: #007bff;
      color: #fff;
    }

    /* icon sizing */
    .menu-list i.bx { font-size: 1.15rem; margin-right: 10px; }

    /* submenu */
    .submenu {
      display: none;           
      margin-top: 6px;
      margin-left: 18px;
    }
    .submenu a {
      display: block;
      padding: 8px 12px;
      border-radius: 6px;
      color: #232425ff;
      text-decoration: none;
      transition: background .15s;
      font-size: 0.95rem;
    }
    .submenu a:hover { background: #006edc; color: #fff; }

    /* arrow */
    .dropdown-arrow {
      transition: transform .25s ease;
      font-size: 1.05rem;
      color: inherit;
    }
  
    .has-dropdown.active .dropdown-arrow {
      transform: rotate(90deg);
    }

    .mb-4 { margin-bottom: .75rem; }

    .sidebar::-webkit-scrollbar { width: 6px; }
    .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.18); border-radius: 3px; }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <aside class="sidebar menu p-2">
    <p class="menu-label pt-1" style="color:#cfd8ee; padding-left:14px;">General</p>

    <ul class="menu-list">
      <li class="mb-4">
        <a href="dashboard.php"><span><i class='bx bx-home'></i> Dashboard</span></a>
      </li>

       <li class="mb-4"><a href="../register.php"><span><i class='bx bx-group'></i> registeration</span></a></li>
      
      <!-- Doctors Dropdown -->
      <li class="mb-4">
        <!-- NOTE: put the arrow INSIDE the clickable .has-dropdown element -->
        <a href="#" class="has-dropdown"><span><i class='bx bx-user-voice'></i> Doctors</span> <i class='bx bx-chevron-right dropdown-arrow'></i></a>
        <ul class="submenu">
          <li class="mb-4"><a href="all_doctors.php"><i class='bx bx-user'></i> All Doctors</a></li>
          <li class="mb-4"><a href="appointments_list.php"><i class='bx bx-calendar-check'></i> Appointment List</a></li>
        </ul>
      </li>

      <!-- Patients Dropdown -->
      <li class="mb-4">
        <a href="#" class="has-dropdown"><span><i class='bx bx-user'></i> Patients</span> <i class='bx bx-chevron-right dropdown-arrow'></i></a>
        <ul class="submenu">
          <li class="mb-4"><a href="all_patients.php"><i class='bx bx-list-ul'></i> All Patients</a></li>
          <li class="mb-4"><a href="patients_report.php"><i class='bx bx-file'></i> Patients Report</a></li>
          <li class="mb-4"><a href="patients_bills.php"><i class='bx bx-credit-card'></i> Patients Bills</a></li>
        </ul>
      </li>

      <li class="mb-4"><a href="staff.php"><span><i class='bx bx-group'></i> Staff</span></a></li>
      <li class="mb-4"><a href="pharmacy.php"><span><i class='bx bx-store'></i> Pharmacy</span></a></li>
      <li class="mb-4"><a href="accountant.php"><span><i class='bx bx-calculator'></i> Accountant</span></a></li>
      <li class="mb-4"><a href="departments.php"><span><i class='bx bx-building-house'></i> Department</span></a></li>
      <li class="mb-4"><a href="wards.php"><span><i class='bx bx-bed'></i> Ward</span></a></li>
      <li class="mb-4"><a href="beds.php"><span><i class='bx bx-bed'></i> Bed</span></a></li>
      <li class="mb-4"><a href="../logout.php"><span><i class='bx bx-log-out'></i> Logout</span></a></li>
    </ul>
  </aside>

  
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script>
    $(function () {
      // When a .has-dropdown is clicked:
      $('.has-dropdown').on('click', function (e) {
        e.preventDefault();                       
        const $btn = $(this);
        const $submenu = $btn.next('.submenu');

        // If submenu does not exist, just exit
        if (!$submenu.length) return;

        const isVisible = $submenu.is(':visible');

        // close all submenus and remove active class from all parents
        $('.submenu').not($submenu).slideUp(180);
        $('.has-dropdown').not($btn).removeClass('active');

        // toggle clicked submenu
        if (isVisible) {
          $submenu.slideUp(180);
          $btn.removeClass('active');
        } else {
          $submenu.slideDown(180);
          $btn.addClass('active');
        }
      });

      $('.menu-list a[href="' + location.pathname.split("/").pop() + '"]').addClass('active');
    });
  </script>
</body>
</html>
