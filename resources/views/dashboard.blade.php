@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<style>
    :root {
        --dark-red: #ffc104;
        --pure-black: #000000;
        --pure-white: #FFFFFF;
        --light-gray: #F5F5F5;
        --medium-gray: #E0E0E0;
    }

    /* Compact Dashboard Cards */
    .dashboard-card {
        background: linear-gradient(135deg, var(--dark-red) 0%, #660000 100%);
        color: var(--pure-white);
        border: none;
        border-radius: 12px;
        position: relative;
        overflow: hidden;
        transition: all 0.2s ease;
        min-height: 160px;
        box-shadow: 0 4px 12px rgba(139, 0, 0, 0.15);
    }

    .dashboard-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(139, 0, 0, 0.25);
    }

    .dashboard-card .card-body {
        padding: 1.2rem;
        position: relative;
        z-index: 2;
    }

    /* Decorative elements */
    .dashboard-card::after {
        content: "";
        position: absolute;
        background: rgba(255, 255, 255, 0.08);
        width: 120px;
        height: 120px;
        border-radius: 50%;
        bottom: -30px;
        right: -30px;
        z-index: 1;
    }

    .dashboard-card::before {
        content: "";
        position: absolute;
        background: rgba(255, 255, 255, 0.05);
        width: 70px;
        height: 70px;
        border-radius: 50%;
        bottom: 10px;
        right: 10px;
        z-index: 1;
    }

    .card-icon {
        position: absolute;
        top: 15px;
        right: 15px;
        font-size: 1.4rem;
        opacity: 0.3;
        color: var(--pure-white);
        z-index: 3;
    }

    .card-label {
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        font-weight: 600;
        display: block;
        margin-bottom: 8px;
    }

    .card-value {
        color: var(--pure-white);
        font-weight: 800;
        font-size: 2rem;
        line-height: 1;
        margin-bottom: 8px;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    .card-footer-text {
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.7rem;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .card-footer-text i {
        font-size: 0.8rem;
        color: rgba(255, 255, 255, 0.5);
    }

    /* Compact Progress Bar */
    .compact-progress {
        height: 3px;
        background: rgba(0, 0, 0, 0.2);
        border-radius: 10px;
        margin: 8px 0 4px;
        overflow: hidden;
    }

    .compact-progress-bar {
        height: 100%;
        background: var(--pure-black);
        border-radius: 10px;
    }

    /* Black and White Cards */
    .bw-card {
        background: var(--pure-white);
        border: 1px solid var(--medium-gray);
        border-radius: 10px;
        padding: 1rem;
        height: 100%;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    }

    .bw-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--light-gray);
    }

    .bw-card-header h6 {
        font-weight: 700;
        color: var(--pure-black);
        margin: 0;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Alert Box */
    .alert-box-compact {
        background: #FFF5F5;
        border-left: 4px solid var(--dark-red);
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .alert-box-compact small {
        color: var(--dark-red);
        font-weight: 700;
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .alert-box-compact p {
        color: var(--pure-black);
        font-size: 0.85rem;
        margin: 4px 0 0;
    }

    /* Quick Links Compact */
    .quick-link-item-compact {
        display: flex;
        align-items: center;
        padding: 0.7rem 0;
        color: var(--pure-black);
        text-decoration: none;
        border-bottom: 1px solid var(--light-gray);
        font-size: 0.85rem;
    }

    .quick-link-item-compact:last-child {
        border-bottom: none;
    }

    .quick-link-item-compact:hover {
        color: var(--dark-red);
        padding-left: 5px;
    }

    .quick-link-item-compact i:first-child {
        color: var(--dark-red);
        margin-right: 10px;
        font-size: 1rem;
        width: 20px;
    }

    .quick-link-item-compact i:last-child {
        margin-left: auto;
        color: var(--medium-gray);
        font-size: 0.8rem;
    }

    /* Buttons */
    .btn-dark-red {
        background: var(--dark-red);
        color: var(--pure-white);
        border: none;
        border-radius: 6px;
        padding: 0.4rem 0.8rem;
        font-size: 0.8rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-dark-red:hover {
        background: var(--pure-black);
        color: var(--pure-white);
    }

    .btn-outline-dark-red {
        background: transparent;
        color: var(--dark-red);
        border: 1.5px solid var(--dark-red);
        border-radius: 6px;
        padding: 0.4rem 0.8rem;
        font-size: 0.8rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-outline-dark-red:hover {
        background: var(--dark-red);
        color: var(--pure-white);
    }

    /* Table Compact */
    .table-compact {
        font-size: 0.8rem;
    }

    .table-compact thead th {
        background: var(--pure-black);
        color: var(--pure-white);
        font-weight: 600;
        padding: 0.6rem 0.8rem;
        border: none;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table-compact tbody td {
        padding: 0.6rem 0.8rem;
        vertical-align: middle;
        border-bottom: 1px solid var(--light-gray);
        color: var(--pure-black);
    }

    .table-compact tbody tr:hover {
        background: #FFF5F5;
    }

    /* Greeting Badge */
    .greeting-badge {
        background: var(--pure-white);
        border: 1px solid var(--medium-gray);
        border-radius: 30px;
        padding: 0.4rem 1rem;
        font-size: 0.8rem;
        font-weight: 500;
        color: var(--pure-black);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .greeting-badge i {
        color: var(--dark-red);
    }

    /* Animations */
    .fade-in-up {
        animation: fadeInUp 0.4s ease forwards;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(15px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Layout spacing */
    .compact-row {
        margin: 0 -0.5rem;
    }

    .compact-col {
        padding: 0 0.5rem;
        margin-bottom: 1rem;
    }
</style>

@php
    $now = \Carbon\Carbon::now('Africa/Dar_es_Salaam');
    $hour = $now->hour;

    if ($hour >= 5 && $hour < 12) {
        $greeting = 'Good Morning';
    } elseif ($hour >= 12 && $hour < 17) {
        $greeting = 'Good Afternoon';
    } elseif ($hour >= 17 && $hour < 21) {
        $greeting = 'Good Evening';
    } else {
        $greeting = 'Good Night';
    }
@endphp
<!-- Greeting Row -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="greeting-badge">
                <i class="bi bi-hand-thumbs-up-fill"></i>
                <span><strong>{{ $greeting }}</strong>, {{ auth()->user()->name ?? 'Guest' }}</span>
            </div>
        </div>
    </div>

@if(Auth()->user()->role=="Teacher")
<div class="row g-4 mb-4">
    <!-- <div class="col-6 col-sm-6">
        <div class="dashboard-card text-center" style="background: linear-gradient(135deg, #4e73df, #224abe);">
            <div class="dashboard-icon-wrapper"><i class="fa fa-graduation-cap"></i></div>
            <a href="" class="dashboard-link">MY STUDENTS</a><br>
            @if(Auth()->user()->role=="Teacher" || Auth()->user()->role=="Academic")
                     @foreach($Myclasses as $row)
                     <li>{{ $row }}</li>
                     @endforeach
            @endif
        </div>
    </div>
 -->
    <div class="col-6 col-md-6 compact-col fade-in-up">
        <div class="dashboard-card">
            <div class="card-body">
                <i class="bi bi-files card-icon"></i>
                <span class="card-label">MY STUDENTS</span>
                <div class="card-value"></div>
                 @if(Auth()->user()->role=="Teacher" || Auth()->user()->role=="Academic")
                     @foreach($Myclasses as $row)
                     <li class="border border-white d-inline p-2 rounded">{{ $row }}</li>
                     @endforeach
                @endif
            </div>
        </div>
      </div>

      <div class="col-6 col-md-6 compact-col fade-in-up">
        <div class="dashboard-card">
            <div class="card-body">
                <i class="bi bi-files card-icon"></i>
                <span class="card-label">MY SUBJECTS</span>
                <div class="card-value"></div>
                 @if(Auth()->user()->role=="Teacher" || Auth()->user()->role=="Academic")
                     @foreach($MySubjects as $row)
                     <li class="border border-white d-inline p-2 rounded">{{ $row }}</li>
                     @endforeach
               @endif
            </div>
        </div>
      </div>


   <!--  <div class="col-6 col-sm-6">
        <div class="dashboard-card text-center" style="background: linear-gradient(135deg, #36b9cc, #0e8388);">
            <div class="dashboard-icon-wrapper"><i class="fa fa-book"></i></div>
            <a href="" class="dashboard-link">MY SUBJECTS</a><br>
            @if(Auth()->user()->role=="Teacher" || Auth()->user()->role=="Academic")
                     @foreach($MySubjects as $row)
                     <li>{{ $row }}</li>
                     @endforeach
            @endif
        </div>
    </div> -->
</div>
@endif

@if(Auth()->user()->role=="Academic" || Auth()->user()->role=="Headmaster") 
<div class="row g-4 mb-4">
    <div class="col-6 col-md-3 compact-col fade-in-up">
        <div class="dashboard-card">
            <div class="card-body">
                <i class="bi bi-files card-icon"></i>
                <span class="card-label">Total Students</span>
                <div class="card-value">{{ $students->count() ?? 0 }}</div>
                <span class="card-footer-text">
                    <i class="bi bi-calendar"></i>
                </span>
            </div>
        </div>
      </div>


   <!--  <div class="col-6 col-sm-3">
        <div class="dashboard-card text-center" style="background: linear-gradient(135deg, #4e73df, #224abe);">
            <div class="dashboard-icon-wrapper"><i class="fa fa-graduation-cap"></i></div>
            <h2><strong>{{ $students->count() ?? 0 }}</strong></h2>
            <a href="/Student" class="dashboard-link">Students</a>
        </div>
    </div> -->

    <div class="col-6 col-md-3 compact-col fade-in-up">
        <div class="dashboard-card">
            <div class="card-body">
                <i class="bi bi-files card-icon"></i>
                <span class="card-label">Total Teachers</span>
                <div class="card-value">{{ $teachers->count()?? 0 }}</div>
                <span class="card-footer-text">
                    <i class="bi bi-calendar"></i>
                </span>
            </div>
        </div>
      </div>

    <!-- <div class="col-6 col-sm-3">
        <div class="dashboard-card text-center" style="background: linear-gradient(135deg, #36b9cc, #0e8388);">
            <div class="dashboard-icon-wrapper"><i class="fa fa-users"></i></div>
            <h2><strong>{{ $teachers->count()?? 0 }}</strong></h2>
            <a href="/teachers" class="dashboard-link">Teachers</a>
        </div>
    </div> -->


    <div class="col-6 col-md-3 compact-col fade-in-up">
        <div class="dashboard-card">
            <div class="card-body">
                <i class="bi bi-files card-icon"></i>
                <span class="card-label">Total Subjects</span>
                <div class="card-value">{{ $subjects->count() ?? 0 }}</div>
                <span class="card-footer-text">
                    <i class="bi bi-calendar"></i>
                </span>
            </div>
        </div>
      </div>

    <!-- 
    <div class="col-6 col-sm-3">
        <div class="dashboard-card text-center" style="background: linear-gradient(135deg, #1cc88a, #157347);">
            <div class="dashboard-icon-wrapper"><i class="fa fa-book"></i></div>
            <h2><strong>{{ $subjects->count() ?? 0 }}</strong></h2>
            <a href="/subjects" class="dashboard-link">Subjects</a>
        </div>
    </div> -->



    <div class="col-6 col-md-3 compact-col fade-in-up">
        <div class="dashboard-card">
            <div class="card-body">
                <i class="bi bi-files card-icon"></i>
                <span class="card-label">Total Classes</span>
                <div class="card-value">{{ $classes->count() ?? 0 }}</div>
                <span class="card-footer-text">
                    <i class="bi bi-calendar"></i>
                </span>
            </div>
        </div>
      </div>

    <!-- <div class="col-6 col-sm-3">
        <div class="dashboard-card text-center" style="background: linear-gradient(135deg, #f6c23e, #d39e00);">
            <div class="dashboard-icon-wrapper"><i class="fa fa-home"></i></div>
            <h2><strong>{{ $classes->count() ?? 0 }}</strong></h2>
            <a href="/classes" class="dashboard-link">Classes</a>
        </div>
    </div> -->
</div>

@endif

 @if(Auth()->user()->role=="Mhasibu")
<div class="row g-4 mb-4">
    <!-- <div class="col-6 col-sm-3">
        <div class="dashboard-card text-center" style="background: linear-gradient(135deg, #4e73df, #224abe);">
            <div class="dashboard-icon-wrapper"><i class="fa fa-user-circle"></i></div>
            <h2><strong>{{ $debtors->count() ?? 0 }}</strong></h2>
            <a href="" class="dashboard-link">Debitors</a>
        </div>
    </div> -->

    <div class="col-6 col-md-3 compact-col fade-in-up">
        <div class="dashboard-card">
            <div class="card-body">
                <i class="bi bi-files card-icon"></i>
                <span class="card-label">Total Debitors</span>
                <div class="card-value">{{ $debtors->count() ?? 0 }}</div>
                <span class="card-footer-text">
                    <i class="bi bi-calendar"></i>
                </span>
            </div>
        </div>
      </div>

      <div class="col-6 col-md-3 compact-col fade-in-up">
        <div class="dashboard-card">
            <div class="card-body">
                <i class="bi bi-files card-icon"></i>
                <span class="card-label">Notified today</span>
                <div class="card-value">{{ $notifiedTodayCount ?? 0 }}</div>
                <span class="card-footer-text">
                    <i class="bi bi-calendar"></i>
                </span>
            </div>
        </div>
      </div>

    <!-- <div class="col-6 col-sm-3">
        <div class="dashboard-card text-center" style="background: linear-gradient(135deg, #f6c23e, #d39e00);">
            <div class="dashboard-icon-wrapper"><i class="fa fa-home"></i></div>
            <h2><strong>{{ $notifiedTodayCount ?? 0 }}</strong></h2>
            <a href="" class="dashboard-link">Notified today</a>
        </div>
    </div> -->
</div>
 @endif


<!-- Chart Section -->
@if(Auth()->user()->role=="Academic" || Auth()->user()->role=="Headmaster") 
<div class="chart-container border border-success rounded p-2">
    <h4>Students Overview</h4>
    <canvas id="academicChart"></canvas>
</div>
@endif

@if(Auth()->user()->role=="Mhasibu")
<div class="chart-container shadow-sm" style="max-width: 500px;">
    <h4>Financial Overview</h4>
    <canvas id="mhasibuChart" style="width:100%; height:300px;"></canvas>
</div>
@endif

@if(Auth()->user()->role=="Teacher")
<div class="chart-container shadow-sm border border-success p-2 rounded" style="max-width: 100%;">
    <h4>My Subjects Overview</h4>
    <canvas id="teacherChart"></canvas>
</div>
@endif

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    @if(Auth()->user()->role=="Academic")
    const academicCtx = document.getElementById('academicChart').getContext('2d');
    new Chart(academicCtx, {
        type: 'bar',
        data: {
            labels: ['Students', 'Teachers', 'Subjects', 'Classes'],
            datasets: [{
                label: 'Analysis Chart',
                data: [
                    {{ $students->count() ?? 0 }},
                    {{ $teachers->count() ?? 0 }},
                    {{ $subjects->count() ?? 0 }},
                    {{ $classes->count() ?? 0 }}
                ],
                backgroundColor: ['#4e73df', '#36b9cc', '#1cc88a', '#f6c23e']
            }]
        },
        options: { responsive: true }
    });
    @endif

    @if(Auth()->user()->role=="Mhasibu")
    const mhasibuCtx = document.getElementById('mhasibuChart').getContext('2d');
    new Chart(mhasibuCtx, {
        type: 'doughnut',
        data: {
            labels: ['Debtors', 'Notified Today'],
            datasets: [{
                label: 'Count',
                data: [
                    {{ $debtors->count() ?? 0 }},
                    {{ $notifiedTodayCount ?? 0 }}
                ],
                backgroundColor: ['#4e73df', '#f6c23e']
            }]
        },
        options: { responsive: true }
    });
    @endif

    @if(Auth()->user()->role=="Teacher")
    const teacherCtx = document.getElementById('teacherChart').getContext('2d');
    new Chart(teacherCtx, {
        type: 'bar',
        data: {
            labels: [
                @foreach($MySubjects as $subject)
                    "{{ $subject }}",
                @endforeach
            ],
            datasets: [{
                label: 'Subjects',
                data: [
                    @foreach($MySubjects as $subject)
                        1,
                    @endforeach
                ],
                backgroundColor: [
                    @foreach($MySubjects as $subject)
                        'rgba({{ rand(50,200) }}, {{ rand(50,200) }}, {{ rand(50,200) }}, 0.7)',
                    @endforeach
                ]
            }]
        },
        options: { responsive: true }
    });
    @endif
});
</script>
@endsection
