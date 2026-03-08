<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>SHULE NET| @yield('title', 'Admin')</title>
        <meta name="description" content="Official Usongwe Secondary School website: learn about our history, academic programs, achievements, and admissions information.">
<meta name="keywords" content="Usongwe Secondary, Usongwe School, Secondary School Tanzania, Mbeya Schools">
<meta name="author" content="Usongwe Secondary School">
        <link rel="icon" type="image/png" href="/assets/img/favicon.png">

                <!-- Bootstrap CSS -->
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

          <!-- Font Awesome 4 -->
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

          <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

          <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />

          <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

          <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

          <!-- Scripts -->
          @vite(['resources/css/app.css', 'resources/js/app.js'])
          <style>
            body, html {
              margin: 0; 
              padding: 0; 
              height: 100%;
              font-size: 0.9rem;
              background: white;
              overflow-x: hidden;
              font-family: 'Poppins', sans-serif;
            }


            .wrapper {
              display: flex;
              height: 100vh;
            }

            /* Sidebar */
            .sidebar {
              width: 240px;
              background-color: whitesmoke;
              color: black;
              flex-shrink: 0;
              display: flex;
              flex-direction: column;
              padding-top: 1rem;
              position: fixed;
              height: 100vh;
              overflow-y: auto;
              transition: left 0.3s ease;
              left: 0;
              z-index: 1050;
            }

            .sidebar a {
              color: black;
              padding: 10px 15px;
              display: block;
              text-decoration: none;
              border: 2px solid white;
              cursor: pointer;
            }
            

            /* Submenu */
            .submenu a {
              padding-left: 40px;
              background-color: floralwhite;
              border-bottom: none;
            }
            .submenu a:hover {
              background-color: #4e5d6c;
            }

            /* Main content */
            .main {
              margin-left: 240px;
              flex-grow: 1;
              display: flex;
              flex-direction: column;
              height: 100vh;
              overflow: hidden;
            }

            .topbar {
              background-color: #05738E;
              padding: 20px 30px;
              box-shadow: 0 2px 5px rgba(0,0,0,0.1);
              display: flex;
              justify-content: space-between;
              align-items: center;
              flex-shrink: 0;
              color: white;
            }

            .dashboard-content {
              padding: 20px;
              overflow-y: auto;
              flex-grow: 1;
            }

            .dashboard-card {
              border-radius: 10px;
              padding: 20px;
              background: white;
              box-shadow: 0 2px 5px rgba(0,0,0,0.05);
              height: 100%;
              text-align: center;
            }

            /* Sidebar toggle button (mobile) */
            .sidebar-toggler {
              display: none;
              cursor: pointer;
              border: none;
              background: none;
              font-size: 1.5rem;
            }

            /* Overlay for mobile sidebar */
            .overlay {
              display: none;
              position: fixed;
              top: 0; left: 0;
              width: 100vw;
              height: 100vh;
              background: rgba(0,0,0,0.5);
              z-index: 1040;
            }


            /* Make table text smaller */
        table#example {
          font-size: 0.75rem;  /* smaller text */
          border-collapse: collapse;
        }

        /* Thin borders for all cells */
        table#example th,
        table#example td {
          border: 1px solid #555; /* dark gray border */
          padding: 2px 4px;       /* tighter padding */
          vertical-align: middle;
        }

        /* Header background */
        table#example thead th {
          background-color: #ddd; /* light gray header */
          font-weight: 600;
          color: #000;
        }

        /* Alternate row shading for clarity */
        table#example tbody tr:nth-child(even) {
          background-color: #f9f9f9;
        }

        /* Remove extra Bootstrap spacing */
        table#example.dataTable.no-footer {
          border-bottom: 1px solid #555;
        }

        /* Optional: reduce pagination font size */
        .dataTables_wrapper .dataTables_paginate {
          font-size: 0.85rem;
        }

        /* Optional: compact table */
        .table-sm {
          font-size: 0.75rem;
          padding: 0.25rem;
        }


        /* Apply to all basic form controls */
        input[type="text"],
        input[type="number"],
        input[type="email"],
        input[type="password"],
        input[type="date"],
        input[type="time"],
        input[type="url"],
        select,
        .form-control {
            height: 30px !important;
            padding: 2px 6px !important;
            font-size: 0.85rem !important;
            border-radius: 4px !important;
            border: 1px solid #05738E !important;
            outline: none !important;
        }

        /* Remove Bootstrap's focus shadow */
        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="date"]:focus,
        input[type="time"]:focus,
        input[type="url"]:focus,
        select:focus,
        .form-control:focus {
            box-shadow: none !important;
            border-color: #05738E !important;
        }

        /* For Bootstrap checkboxes & radios */
        .form-check-input {
            width: 14px;
            height: 14px;
            margin-top: 0.25rem;
            border: 1px solid #05738E !important;
            outline: none !important;
            box-shadow: none !important;
        }

        /* Select2 single select small */
        .select2-container .select2-selection--single {
            height: 30px !important;
            padding: 2px 6px !important;
            font-size: 0.85rem !important;
            border-radius: 4px !important;
            border: 1px solid #05738E !important;
            outline: none !important;
        }

        /* Select2 single text alignment */
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 26px !important;
            font-size: 0.85rem !important;
        }

        /* Select2 dropdown items */
        .select2-container--default .select2-results__option {
            font-size: 0.85rem !important;
            padding: 4px 6px !important;
        }

        /* Select2 multiple select small */
        .select2-container--default .select2-selection--multiple {
            min-height: 30px !important;
            padding: 2px 4px !important;
            font-size: 0.85rem !important;
            border: 1px solid #05738E !important;
            outline: none !important;
        }


            /* Responsive */
            @media (max-width: 768px) {
              .sidebar {
                position: fixed;
                left: -240px;
                height: 100%;
              }

              .sidebar.active {
                left: 0;
              }

              .main {
                margin-left: 0;
                height: 100vh;
              }

              .sidebar-toggler {
                display: inline-block;
              }

              .overlay.active {
                display: block;
              }
            }

            .dt-button {
        padding: 4px 8px !important;
        font-size: 0.8rem !important;
          }
          </style>

    </head>
    <body>
<body>

<div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

<div class="wrapper">
 @include('layouts.side')

  <!-- Main content -->
  <main class="main" role="main">
    @include('layouts.top')

    <div class="dashboard-content">
      <div class="container-fluid p-0">
        @yield('content')
        
      </div>
    </div>
  </main>
</div>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- Include DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<script>
$(document).ready(function () {
    // Initialize the table first
    var table = $('#example').DataTable({
        paging: true,
        pagingType: 'simple',   // only Next/Prev
        pageLength: 500,         // show 500 rows per page
        lengthChange: false,    // hide "Show entries"
        info: false,            // hide table info
        dom: 'Bfrtip',          // add buttons container
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Export to Excel',
                title: 'Data Export',
                exportOptions: {
                    columns: ':visible',
                    format: {
                        // Use only the first header row for Excel
                        header: function (data, columnIdx) {
                            return $('#example thead tr:eq(0) th').eq(columnIdx).text();
                        }
                    }
                }
            }
        ],
        drawCallback: function(settings) {
            var api = this.api();
            var rows = api.rows({ page: 'all' }).count();
            if (rows <= settings._iDisplayLength) {
                $('.dataTables_paginate').hide();
            } else {
                $('.dataTables_paginate').show();
            }
        }
    });

    // Add a filter row below the original header
    $('#example thead tr').clone(true).appendTo('#example thead');
    $('#example thead tr:eq(1) th').each(function(i) {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="Search '+title+'" style="width:100%"/>');
        $('input', this).on('keyup change', function() {
            if (table.column(i).search() !== this.value) {
                table.column(i).search(this.value).draw();
            }
        });
    });
});

</script>


  <script>
  $(document).ready(function() {
  $('.select2').each(function () {
    var $modal = $(this).closest('.modal');
    var select2Options = {
      theme: 'bootstrap-5',
      allowClear: true,
      dropdownParent: $modal.length ? $modal : $(document.body) 
    };
    $(this).select2(select2Options);
  });
});
</script>


  <script>
 document.querySelectorAll("form").forEach(form => {
  form.addEventListener("submit", function() {
    let btn = form.querySelector('button[type="submit"]');
    if (btn && form.checkValidity()) {
      btn.disabled = true;
      btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Processing..`;
    }
  });
  });

 function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('active');
    document.getElementById('overlay').classList.toggle('active');
  }
 </script>
 
</body>
</html>
