 <!-- Sidebar -->
  <nav class="sidebar shadow-sm" id="sidebar" aria-label="Sidebar Navigation">
    <h4 class="text-center mb-3" style="color: #05738E; letter-spacing: 0.4rem;"><strong>SHULE NET</strong></h4>
    <a href="/dashboard"><i class="fa fa-dashboard me-2"></i> Dashboard</a>
  @if(Auth()->user()->role=="Academic" || Auth()->user()->role=="Headmaster") 

    <!-- <a href="{{ route('teachers_index') }}"><i class="fa fa-users me-2"></i> Staff Members</a> -->
    <a data-bs-toggle="collapse" href="#staffMenu" role="button" aria-expanded="false" aria-controls="ManagemantSubmenu" id="resultsMenuToggle">
    <i class="fa fa-users me-2"></i> Staff Members <i class="fa fa-caret-down float-end"></i>
    </a>
    <div class="collapse submenu" id="staffMenu">
      <a href="{{ route('teachers_index') }}"><i class="fa fa-angle-right"></i> View Staff</a>
      <a href="{{ route('class_teachers') }}"><i class="fa fa-angle-right"></i> Class teachers</a> 
    </div>

    <!-- Student menu with submenu -->
    <a data-bs-toggle="collapse" href="#studentMenu" role="button" aria-expanded="false" aria-controls="ManagemantSubmenu" id="resultsMenuToggle">
      <i class="fa fa-graduation-cap me-2"></i> Students <i class="fa fa-caret-down float-end"></i>
    </a>
    <div class="collapse submenu" id="studentMenu">
      <a href="{{ route('student_index') }}"><i class="fa fa-angle-right"></i> View Students</a>
      <a href="{{ route('student_transfer') }}"><i class="fa fa-angle-right"></i> Transfer</a>
      <a href="{{ route('wafutwe') }}"><i class="fa fa-angle-right"></i> Request delete</a>
    </div>

    <!-- Results menu with submenu -->
    <a data-bs-toggle="collapse" href="#ManagemantSubmenu" role="button" aria-expanded="false" aria-controls="ManagemantSubmenu" id="resultsMenuToggle">
      <i class="fa fa-tasks me-2"></i> Management <i class="fa fa-caret-down float-end"></i>
    </a>
    <div class="collapse submenu" id="ManagemantSubmenu">
      <a href="{{ route('subjects_index') }}"><i class="fa fa-angle-right"></i> Subjects</a>
      <a href="{{ route('class_index') }}"><i class="fa fa-angle-right"></i> Classes</a>
      <a href="{{ route('grade.index') }}"><i class="fa fa-angle-right"></i> Grades</a> 
      <a href="{{ route('divisions.index') }}"><i class="fa fa-angle-right"></i> Division</a>
      <a href="{{ route('teacher_subject_index') }}"><i class="fa fa-angle-right"></i> Teachers Subjects</a>
      <a href="{{ route('student_subject_index') }}"><i class="fa fa-angle-right"></i> Students Subjects</a>
    </div>
    @endif

    @if(Auth()->user()->role=="Teacher" || Auth()->user()->role=="Academic" || Auth()->user()->role=="Headmaster")
    <!-- Results menu with submenu -->
    <a data-bs-toggle="collapse" href="#resultsSubmenu" role="button" aria-expanded="false" aria-controls="resultsSubmenu" id="resultsMenuToggle">
      <i class="fa fa-file-text me-2"></i> Marks <i class="fa fa-caret-down float-end"></i>
    </a>
    <div class="collapse submenu" id="resultsSubmenu">
      <a href="{{ route('tamplate_index') }}"><i class="fa fa-angle-right"></i> Score sheet</a>
      <a href="{{ route('upload_index') }}"><i class="fa fa-angle-right"></i> Upload</a>
      <a href="{{ route('upload_tracking') }}"><i class="fa fa-angle-right"></i> Upload Status</a>
      <a href="{{ route('test_index') }}"><i class="fa fa-angle-right"></i> View Scores</a>
    </div>
    @endif


    @if(Auth()->user()->role=="Teacher" || Auth()->user()->role=="Academic" || Auth()->user()->role=="Headmaster")
    <!-- Results menu with submenu -->
    <a data-bs-toggle="collapse" href="#resultsMenus" role="button" aria-expanded="false" aria-controls="resultsMenus" id="resultsMenuToggle">
      <i class="fa fa-book me-2"></i> Results <i class="fa fa-caret-down float-end"></i>
    </a>
    <div class="collapse submenu" id="resultsMenus">
      <a href="{{ route('result_index') }}"><i class="fa fa-angle-right"></i> Preview</a>
      @if(Auth()->user()->role=="Academic")
      <a href="{{ route('result_post') }}"><i class="fa fa-angle-right"></i> Approve</a>
      <a href="{{ route('sms.index') }}"><i class="fa fa-angle-right"></i> Send SMS</a>
      @endif
 
    </div>
    @endif

    @if(Auth()->user()->role=="Mhasibu")
    <!-- Results menu with submenu -->
     <a data-bs-toggle="collapse" href="#FeeStructureSubmenu" role="button" aria-expanded="false" aria-controls="FeeStructureSubmenu" id="resultsMenuToggle">
      <i class="fa fa-university me-2"></i> Fee Structure <i class="fa fa-caret-down float-end"></i>
    </a>
    <div class="collapse submenu" id="FeeStructureSubmenu">
      <a href="{{ route('fees.index') }}"><i class="fa fa-angle-right"></i> Create Fees</a>
      <a href="{{ route('fees.fee_structure') }}"><i class="fa fa-angle-right"></i> Fee structure</a>
    </div>


    <a data-bs-toggle="collapse" href="#paymentSubmenu" role="button" aria-expanded="false" aria-controls="paymentSubmenu" id="resultsMenuToggle">
      <i class="fa fa-dollar me-2"></i> Payments <i class="fa fa-caret-down float-end"></i>
    </a>
    <div class="collapse submenu" id="paymentSubmenu">
      <a href="{{ route('payments.create') }}"><i class="fa fa-angle-right"></i> Add payment</a>
      <a href="{{ route('payments.view') }}"><i class="fa fa-angle-right"></i> View payments</a>
      <a href="{{ route('generate_receipts') }}"><i class="fa fa-angle-right"></i> Generate receipt</a>
    </div>

    <a data-bs-toggle="collapse" href="#debitorsReport" role="button" aria-expanded="false" aria-controls="debitorsReport" id="resultsMenuToggle">
      <i class="fa fa-user-circle me-2"></i> Debitors<i class="fa fa-caret-down float-end"></i>
    </a>
    <div class="collapse submenu" id="debitorsReport">
      <a href="{{ route('debtors.index') }}"><i class="fa fa-angle-right"></i> Remind via SMS </a>
    </div>

    <a data-bs-toggle="collapse" href="#paymentReport" role="button" aria-expanded="false" aria-controls="paymentReport" id="resultsMenuToggle">
      <i class="fa fa-bar-chart me-2"></i> Reports<i class="fa fa-caret-down float-end"></i>
    </a>
    <div class="collapse submenu" id="paymentReport">
      <a href="{{ route('debitors.all') }}"><i class="fa fa-angle-right"></i> Debtors report </a>
      <a href="{{ route('fees.index') }}"><i class="fa fa-angle-right"></i> General report</a>
    </div>


    @endif

    @if(Auth()->user()->role=="Academic" || Auth()->user()->role=="Headmaster")
    <!-- Results menu with submenu -->
    <a data-bs-toggle="collapse" href="#reportSubmenu" role="button" aria-expanded="false" aria-controls="reportSubmenu" id="resultsMenuToggle">
      <i class="fa fa-bar-chart me-2"></i> Reports <i class="fa fa-caret-down float-end"></i>
    </a>
    <div class="collapse submenu" id="reportSubmenu">
      <a href="{{ route('report.allStudentsReport') }}"><i class="fa fa-angle-right"></i> Academic Report</a>
    </div>

    <a href="{{ route('configuration.index') }}"><i class="fa fa-cogs me-2"></i> Configurations</a> 
    @endif

     <!-- Results menu with submenu -->
    <a data-bs-toggle="collapse" href="#Security" role="button" aria-expanded="false" aria-controls="Security" id="resultsMenuToggle">
      <i class="fa fa-lock me-2"></i> Security <i class="fa fa-caret-down float-end"></i>
    </a>
    <div class="collapse submenu" id="Security">
      <a href="#"><i class="fa fa-angle-right"></i> System Logs</a>
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
    </form>
    <a href="#" 
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
       <i class="fa fa-sign-out me-2"></i> Logout
    </a>
  </nav>
