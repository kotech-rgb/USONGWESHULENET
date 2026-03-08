<div class="topbar d-flex justify-content-between align-items-center px-3 py-2 bg-dark text-white">
    <!-- Sidebar Toggler (small screens) -->
    <button class="sidebar-toggler d-md-none btn btn-sm btn-outline-light me-2" aria-label="Toggle sidebar" onclick="toggleSidebar()">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Title -->
    <h5 class="mb-0">@yield('title', 'Dashboard')</h5>

    <!-- User Profile Dropdown -->
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="/assets/img/user.png" class="rounded-circle border border-light" style="width:32px; height:32px;">
        </a>
        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
            <li>
                <a class="dropdown-item" href="{{ route('Myprofile') }}">
                    <i class="fa fa-user me-2 text-primary"></i> Profile
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">
                        <i class="fa fa-sign-out me-2"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>

<!-- Breadcrumb -->
<div class="shadow-sm mb-3 bg-white" style="font-size:0.6rem;">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb p-2 mb-0">
            <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-dark">@yield('title')</a></li>
            @php
                $year = \App\Models\Year::where('status', 'active')->first();
                $term = \App\Models\Term::where('status', 'active')->first();
            @endphp
            <li class="breadcrumb-item active" aria-current="page">
                <strong class="text-primary">{{ ($year->year_name-1 ?? 'No Year') . '/' . ($year->year_name ?? '0') }}</strong>
                =>
                <strong class="text-danger">{{ $term->term_name ?? 'No Term' }}</strong>
            </li>
        </ol>
    </nav>
</div>


{{-- Include SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            showCloseButton: true,
            timer: 10000,
            timerProgressBar: true,
            width: 500,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
                toast.addEventListener('click', () => Swal.close());
            }
        });

        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}"
            });
        @endif

        @if(session('warning'))
            Toast.fire({
                icon: 'warning',
                title: 'Warning',
                text: "{{ session('warning') }}"
            });
        @endif

        @if(session('info'))
            Toast.fire({
                icon: 'info',
                title: 'info',
                text: "{{ session('info') }}"
            });
        @endif

        @if(session('invalid'))
            Toast.fire({
                icon: 'error',
                title: 'Failed',
                text: "{{ session('invalid') }}"
            });
        @endif

        @if($errors->any())
            @foreach($errors->all() as $error)
                Toast.fire({
                    icon: 'error',
                    title: 'Error',
                    text: "{{ $error }}"
                });
            @endforeach
        @endif

        const form = document.getElementById('confirmDialog');
        if (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to submit your request",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); 
                    }
                });
            });
        }
    });
</script>
