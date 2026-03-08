@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<style>
    .dashboard-card {
        color: white;
    }

</style>
@if(Auth()->user()->role=="Teacher")
<div class="row g-4 mb-4">
    <div class="col-6 col-sm-3">
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

    <div class="col-6 col-sm-3">
        <div class="dashboard-card text-center" style="background: linear-gradient(135deg, #36b9cc, #0e8388);">
            <div class="dashboard-icon-wrapper"><i class="fa fa-book"></i></div>
            <a href="" class="dashboard-link">MY SUBJECTS</a><br>
            @if(Auth()->user()->role=="Teacher" || Auth()->user()->role=="Academic")
                     @foreach($MySubjects as $row)
                     <li>{{ $row }}</li>
                     @endforeach
            @endif
        </div>
    </div>
</div>
@endif

@if(Auth()->user()->role=="Academic" || Auth()->user()->role=="Headmaster") 
<div class="row g-4 mb-4">
    <div class="col-6 col-sm-3">
        <div class="dashboard-card text-center" style="background: linear-gradient(135deg, #4e73df, #224abe);">
            <div class="dashboard-icon-wrapper"><i class="fa fa-graduation-cap"></i></div>
            <h2><strong>{{ $students->count() ?? 0 }}</strong></h2>
            <a href="/Student" class="dashboard-link">Students</a>
        </div>
    </div>

    <div class="col-6 col-sm-3">
        <div class="dashboard-card text-center" style="background: linear-gradient(135deg, #36b9cc, #0e8388);">
            <div class="dashboard-icon-wrapper"><i class="fa fa-users"></i></div>
            <h2><strong>{{ $teachers->count()?? 0 }}</strong></h2>
            <a href="/teachers" class="dashboard-link">Teachers</a>
        </div>
    </div>

    <div class="col-6 col-sm-3">
        <div class="dashboard-card text-center" style="background: linear-gradient(135deg, #1cc88a, #157347);">
            <div class="dashboard-icon-wrapper"><i class="fa fa-book"></i></div>
            <h2><strong>{{ $subjects->count() ?? 0 }}</strong></h2>
            <a href="/subjects" class="dashboard-link">Subjects</a>
        </div>
    </div>

    <div class="col-6 col-sm-3">
        <div class="dashboard-card text-center" style="background: linear-gradient(135deg, #f6c23e, #d39e00);">
            <div class="dashboard-icon-wrapper"><i class="fa fa-home"></i></div>
            <h2><strong>{{ $classes->count() ?? 0 }}</strong></h2>
            <a href="/classes" class="dashboard-link">Classes</a>
        </div>
    </div>
</div>

@endif

 @if(Auth()->user()->role=="Mhasibu")
<div class="row g-4 mb-4">
    <div class="col-6 col-sm-3">
        <div class="dashboard-card text-center" style="background: linear-gradient(135deg, #4e73df, #224abe);">
            <div class="dashboard-icon-wrapper"><i class="fa fa-user-circle"></i></div>
            <h2><strong>{{ $debtors->count() ?? 0 }}</strong></h2>
            <a href="" class="dashboard-link">Debitors</a>
        </div>
    </div>

    <div class="col-6 col-sm-3">
        <div class="dashboard-card text-center" style="background: linear-gradient(135deg, #f6c23e, #d39e00);">
            <div class="dashboard-icon-wrapper"><i class="fa fa-home"></i></div>
            <h2><strong>{{ $notifiedTodayCount ?? 0 }}</strong></h2>
            <a href="" class="dashboard-link">Notified today</a>
        </div>
    </div>
</div>
 @endif


<!-- Chart Section -->
@if(Auth()->user()->role=="Academic" || Auth()->user()->role=="Headmaster") 
<div class="chart-container">
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
<div class="chart-container shadow-sm" style="max-width: 500px;">
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
