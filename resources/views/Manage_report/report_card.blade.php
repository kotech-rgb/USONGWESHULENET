@foreach($results as $student)
    <div class="report-container printArea">
        @include('Manage_report.students', ['student' => $student])
    </div>
@endforeach
