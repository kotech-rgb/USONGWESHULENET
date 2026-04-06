@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

@php
    $now = \Carbon\Carbon::now('Africa/Dar_es_Salaam');
    $hour = $now->hour;
    $greeting = ($hour < 12) ? 'Good Morning' : (($hour < 17) ? 'Good Afternoon' : 'Good Evening');
@endphp

<div class="container-fluid py-3">

    <!-- Greeting -->
    <div class="mb-4">
        <div class="d-inline-flex align-items-center gap-2 px-3 py-2 bg-white border rounded-pill shadow-sm">
            <i class="bi bi-sun-fill text-warning"></i>
            <strong>{{ $greeting }}, {{ auth()->user()->fname }}</strong>
        </div>
    </div>

    <!-- STATS -->
    @if(Auth::user()->role == "Academic" || Auth::user()->role == "Headmaster")
    <div class="row g-3 mb-4">

        @foreach([
            ['label'=>'Total Students','val'=>$students->count(),'icon'=>'bi-people','color'=>'#3B82F6'],
            ['label'=>'Total Teachers','val'=>$teachers->count(),'icon'=>'bi-person-badge','color'=>'#10B981'],
            ['label'=>'Subjects','val'=>$subjects->count(),'icon'=>'bi-book','color'=>'#8B5CF6'],
            ['label'=>'Classes','val'=>$classes->count(),'icon'=>'bi-door-open','color'=>'#F59E0B']
        ] as $stat)

        <div class="col-md-3 col-6">
            <div class="p-3 rounded-4 text-white position-relative shadow-sm"
                 style="background: linear-gradient(135deg, {{ $stat['color'] }}, #ffffff33); transition:0.3s;">

                <i class="bi {{ $stat['icon'] }} position-absolute top-0 end-0 m-3 opacity-25 fs-4"></i>

                <div class="text-uppercase small opacity-75">{{ $stat['label'] }}</div>
                <div class="fs-3 fw-bold">{{ $stat['val'] }}</div>
            </div>
        </div>

        @endforeach

    </div>
    @endif

    <!-- TEACHER VIEW -->
    @if(Auth::user()->role == "Teacher")
    <div class="row g-3 mb-4">

        <div class="col-md-6">
            <div class="bg-white border rounded-4 p-4 shadow-sm h-100">
                <div class="fw-semibold mb-3">My Classes</div>

                @foreach($Myclasses as $row)
                    <span class="badge rounded-pill bg-light text-dark me-1 mb-1 px-3 py-2">
                        {{ $row }}
                    </span>
                @endforeach
            </div>
        </div>

        <div class="col-md-6">
            <div class="bg-white border rounded-4 p-4 shadow-sm h-100">
                <div class="fw-semibold mb-3">My Subjects</div>

                @foreach($MySubjects as $row)
                    <span class="badge rounded-pill bg-light text-dark me-1 mb-1 px-3 py-2">
                        {{ $row }}
                    </span>
                @endforeach
            </div>
        </div>

    </div>
    @endif

    <!-- LEVELS -->
    @if(Auth::user()->role == "Academic" || Auth::user()->role == "Headmaster")
     <div class="card mb-3 rounded-4">
        <div class="card-body">
            <div class="fw-semibold mb-3">Enrollment Overview</div>
            <div class="row g-3">
                 @foreach($formSummary as $level => $data)
            <div class="col-xl-2 col-lg-3 col-md-4 col-6">

                <div class="bg-white border rounded shadow-sm text-center overflow-hidden p-2">

                    <div class="p-3">
                        <h3 class="text-dark mb-2">{{ $level }}</h3>
                        <h1 style="color:darkblue; font-size: 1.5rem; font-weight: bold;">{{ $data['total'] }}</h1>
                    </div>

                    <div class="d-flex justify-content-around border-top small py-2">
                        <span class="text-primary fw-semibold">Male ({{ $data['M'] }}) </span>
                        <span class="text-danger fw-semibold">Female ({{ $data['F'] }})</span>
                    </div>
                   <!--  <div class="bg-dark p-2">
                       <a href="" class="text-white">VIEW</a> | <a href="" class="text-info">DOWNLOAD</a>
                    </div> -->
                </div>

            </div>
            @endforeach
            </div>
        </div>
    </div>

    @endif

    <!-- CHART + SIDE -->
    <div class="row g-4">

        <div class="col-lg-8">
            <div class="bg-white border rounded-4 p-4 shadow-sm h-100">
                <div class="fw-semibold mb-3">Student Distribution</div>
                <canvas id="mainChart"></canvas>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="bg-white border rounded-4 p-4 shadow-sm h-100">

                <div class="fw-semibold mb-3">Academic Year</div>

                <ul class="list-unstyled small mb-0">
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span>Current Running</span>
                        <span class="badge bg-success">2026</span>
                    </li>
                    <li class="d-flex justify-content-between py-2">
                        <span>Current Term</span>
                        <span class="badge bg-dark">FIRST MID-TERM</span>
                    </li>
                </ul>

            </div>
        </div>

    </div>

</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

const ctx = document.getElementById('mainChart').getContext('2d');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode(array_keys($formSummary->toArray())) !!},
        datasets: [
            {
                label: 'Male',
                data: {!! json_encode(array_values($formSummary->pluck('M')->toArray())) !!},
                backgroundColor: '#3B82F6',
                borderRadius: 6
            },
            {
                label: 'Female',
                data: {!! json_encode(array_values($formSummary->pluck('F')->toArray())) !!},
                backgroundColor: '#EC4899',
                borderRadius: 6
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top'
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

});
</script>

@endsection