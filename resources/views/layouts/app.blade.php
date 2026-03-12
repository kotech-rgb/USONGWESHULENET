<!DOCTYPE html>
<html lang="en">
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

        /* === ORIGINAL GLOBAL LOADER (unchanged) === */
        #global-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(4px);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 99999;
        }
        #global-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(4px);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 99999;
        }

        #dashboard-spinner {
            text-align: center;
            position: relative;
        }

        .spinner-container {
            position: relative;
            width: 100px;
            height: 100px;
            margin: 0 auto;
        }

        .spinner-outer {
            width: 100%;
            height: 100%;
            border: 4px solid rgba(255, 193, 4, 0.1);
            border-top: 4px solid darkgreen;
            border-radius: 50%;
            animation: spin-cw 1s cubic-bezier(0.68,-0.55,0.265,1.55) infinite;
            position: absolute;
        }

        .spinner-inner {
            width: 70%;
            height: 70%;
            border: 3px solid transparent;
            border-bottom: 3px solid #000;
            border-radius: 50%;
            position: absolute;
            top: 15%;
            left: 15%;
            animation: spin-ccw 1.2s linear infinite;
            opacity: 0.8;
        }

        .spinner-core {
            width: 12px;
            height: 12px;
            background-color: green;
            border-radius: 50%;
            position: absolute;
            top: 44%;
            left: 44%;
            box-shadow: 0 0 15px rgba(255, 193, 4, 0.8);
            animation: pulse 1.5s ease-in-out infinite;
        }

        @keyframes spin-cw {
            100% { transform: rotate(360deg); }
        }

        @keyframes spin-ccw {
            100% { transform: rotate(-360deg); }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.5); opacity: 0.5; }
        }

        #dashboard-spinner p {
            margin-top: 25px;
            font-size: 0.9rem;
            color: #000;
            font-weight: 700;
            animation: fadeInOut 2s infinite;
        }

        @keyframes fadeInOut {
            0%, 100% { opacity: 0.4; }
            50% { opacity: 1; }
        }


        /* Sidebar - redesigned with #FFC104 background and black text */
        .sidebar {
            width: 240px;
            background-color: #FFC104;  /* new color */
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
            border-right: 2px solid rgba(0,0,0,0.12);
            box-shadow: 4px 0 10px rgba(0,0,0,0.05);
        }

        .sidebar a {
            color: black !important;
            padding: 10px 15px;
            display: block;
            text-decoration: none;
            border: none;                /* removed white border */
            cursor: pointer;
            font-weight: 500;
            transition: 0.2s;
            border-left: 4px solid transparent;
        }

        .sidebar a:hover {
            background-color: #e5ae09;   /* darker golden */
            border-left: 4px solid #05738E;
        }

        /* Submenu */
        .submenu a {
            padding-left: 40px;
            background-color: #f5c542;   /* slightly lighter, but harmonized */
            border-bottom: none;
        }
        .submenu a:hover {
            background-color: #d9a906;
            border-left: 4px solid #05738E;
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

        /* Topbar redesigned with professional subheader */
        .topbar {
            background-color: #05738E;
            padding: 12px 30px;          /* slightly adjusted */
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
            color: white;
            flex-wrap: wrap;
        }

        /* left side: toggler + title group */
        .topbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .title-group {
            display: flex;
            flex-direction: column;
        }

        .title-group .main-title {
            font-size: 1.5rem;
            font-weight: 600;
            line-height: 1.2;
            color: white;
            margin: 0;
        }

        .title-group .sub-title {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.9);
            margin: 0;
            font-weight: 300;
            letter-spacing: 0.3px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-badge {
            background: rgba(255,255,255,0.15);
            padding: 5px 14px;
            border-radius: 30px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sidebar-toggler {
            display: none;
            cursor: pointer;
            border: none;
            background: none;
            font-size: 1.8rem;
            color: white;
            line-height: 1;
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

        /* Overlay for mobile */
        .overlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0,0,0,0.5);
            z-index: 1040;
        }

        /* Table styles (kept exactly as original) */
        table#example {
            font-size: 0.75rem;
            border-collapse: collapse;
        }
        table#example th,
        table#example td {
            border: 1px solid #555;
            padding: 2px 4px;
            vertical-align: middle;
        }
        table#example thead th {
            background-color: #ddd;
            font-weight: 600;
            color: #000;
        }
        table#example tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table#example.dataTable.no-footer {
            border-bottom: 1px solid #555;
        }
        .dataTables_wrapper .dataTables_paginate {
            font-size: 0.85rem;
        }

        /* Form controls (exactly as original) */
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
        .form-check-input {
            width: 14px;
            height: 14px;
            margin-top: 0.25rem;
            border: 1px solid #05738E !important;
            outline: none !important;
            box-shadow: none !important;
        }
        .select2-container .select2-selection--single {
            height: 30px !important;
            padding: 2px 6px !important;
            font-size: 0.85rem !important;
            border-radius: 4px !important;
            border: 1px solid #05738E !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 26px !important;
            font-size: 0.85rem !important;
        }
        .select2-container--default .select2-results__option {
            font-size: 0.85rem !important;
            padding: 4px 6px !important;
        }
        .select2-container--default .select2-selection--multiple {
            min-height: 30px !important;
            padding: 2px 4px !important;
            font-size: 0.85rem !important;
            border: 1px solid #05738E !important;
        }

        /* Responsive (unchanged) */
        @media (max-width: 768px) {
            .sidebar {
                left: -240px;
            }
            .sidebar.active {
                left: 0;
            }
            .main {
                margin-left: 0;
            }
            .sidebar-toggler {
                display: inline-block;
            }
            .overlay.active {
                display: block;
            }
            .title-group .main-title {
                font-size: 1.2rem;
            }
        }
        .dt-button {
            padding: 4px 8px !important;
            font-size: 0.8rem !important;
        }
    </style>
</head>
<body>
 <!-- ORIGINAL GLOBAL LOADER (restored exactly) -->
<div id="global-loader">
  <div id="dashboard-spinner">
    <div class="spinner-container">
      <div class="spinner-outer"></div>
      <div class="spinner-inner"></div>
      <div class="spinner-core"></div>
    </div>
    <p>Please Wait...</p>
  </div>
</div>   

<div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

<div class="wrapper">
    <!-- Sidebar (keep all original links, only design changed) -->
    @include('layouts.side')

    <!-- Main content -->
    <main class="main" role="main">
        <!-- Topbar with subheader (redesigned look, all original blade includes remain) -->
        @include('layouts.top')

        <div class="dashboard-content">
            <div class="container-fluid p-0">
                @yield('content')
            </div>
        </div>
    </main>
</div>

<!-- Scripts (exactly as original, order preserved) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- DataTables Buttons CSS & JS (original) -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<script>
$(document).ready(function () {
    var table = $('#example').DataTable({
        paging: true,
        pagingType: 'simple',
        pageLength: 500,
        lengthChange: false,
        info: false,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Export to Excel',
                title: 'Data Export',
                exportOptions: {
                    columns: ':visible',
                    format: {
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
// document.querySelectorAll("form").forEach(form => {
//     form.addEventListener("submit", function() {
//         let btn = form.querySelector('button[type="submit"]');
//         if (btn && form.checkValidity()) {
//             btn.disabled = true;
//             btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Processing..`;
//         }
//     });
// });

function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('active');
    document.getElementById('overlay').classList.toggle('active');
}
</script>

<script>
    const loader = document.getElementById("global-loader");

    // 🔹 Normal full page navigation
    window.addEventListener("beforeunload", function () {
        loader.style.display = "flex";
        loader.style.opacity = "1";
    });

    window.addEventListener("load", function () {
        loader.style.opacity = "0";
        setTimeout(() => {
            loader.style.display = "none";
        }, 300);
    });

</script>

</body>
</html>