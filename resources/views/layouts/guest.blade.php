<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>USONGWE SEC | Auth</title>

<!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    :root {
    --brand-yellow: #FFC104;
    --pure-white: #FFFFFF;
    --medium-gray: #E0E0E0;
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  border-radius: 0 !important;
}

body {
  background: whitesmoke;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 1rem;
  font-family: 'Inter', sans-serif;
}

/* Main Card */
.login-card {
  max-width: 820px;
  width: 100%;
  background: #fff;
  display: flex;
  flex-wrap: wrap;
  box-shadow: 0 12px 28px -8px rgba(0,0,0,0.12);
  border: 1px solid rgba(0,0,0,0.05);
  overflow: hidden;
}

/* Carousel Side */
.carousel-side {
  flex: 1 1 260px;
  background: #FFC014;
  padding: 1rem;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

@media (max-width: 768px) {
  .carousel-side {
    display: none !important;
  }
}

.image-pad-wrapper {
  padding: 0.8rem;
}

.carousel-image {
  width: 100%;
  aspect-ratio: 16 / 11;
  object-fit: cover;
  border: 2px solid #fff;
  box-shadow: 0 8px 16px -6px rgba(0,0,0,0.25);
}

.image-narration {
  font-size: 0.75rem;
  font-weight: 600;
  color: white;
  margin-top: 0.6rem;
  padding-left: 0.4rem;
  border-left: 4px solid rgba(0,0,0,0.3);
}

/* Indicators */
.carousel-indicators {
    justify-content: center;
    margin-bottom: 0;
}

.carousel-indicators [data-bs-target] {
    width: 25px;
    height: 4px;
    border-radius: 4px !important;
    background-color: rgba(255,255,255,0.6);
    opacity: 1;
}

.carousel-indicators .active {
    background-color: #000;
}


/* Login Side */
.login-side {
  flex: 1 1 260px;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 1.5rem 1rem;
}

.login-form-wrapper {
  width: 100%;
  max-width: 260px;
}

.login-header h2 {
  font-size: 1.6rem;
  font-weight: 700;
}

.login-header h2 i {
  color: #B71F25;
  margin-right: 5px;
}

.login-header p {
  font-size: 0.75rem;
  color: #6a6a6a;
}

/* Form */
.form-label {
  font-size: 0.7rem;
  font-weight: 600;
}

.form-control {
  font-size: 0.8rem;
  padding: 0.45rem 0.8rem;
  border: 1.5px solid #e6e6e6;
}

.form-control:focus {
  border-color: black;
  box-shadow: 0 0 0 0.15rem rgba(255,192,20,0.2);
}

.btn-login {
  background: #B71F25;
  border: 1px solid #e0a800;
  font-size: 0.8rem;
  font-weight: 700;
  padding: 0.5rem;
  width: 100%;
}

.btn-login:hover {
  background: #e5aa12;
}

.forgot-link {
  font-size: 0.7rem;
  color: #6a6a6a;
  text-decoration: none;
}

.forgot-link:hover {
  color: #B71F25;
}

.form-check-input:checked {
  background-color: #B71F25;
  border-color: #B71F25;
}

.signup-text {
  font-size: 0.7rem;
  text-align: center;
  margin-top: 1rem;
}

.signup-text a {
  color: #B71F25;
  font-weight: 700;
  text-decoration: none;
}


            /* Container for the dots */
    .dot-loader {
        display: none; /* Hidden by default */
        align-items: center;
        justify-content: center;
        gap: 6px;
        margin-left: 10px;
    }

    /* The actual dots */
    .dot-loader div {
        width: 10px;
        height: 10px;
        background-color: var(--brand-yellow);
        border-radius: 50%;
        animation: dot-pulse 1.2s infinite ease-in-out;
    }

    /* Pulse timing for each dot */
    .dot-loader div:nth-child(2) { animation-delay: 0.2s; }
    .dot-loader div:nth-child(3) { animation-delay: 0.4s; }

    @keyframes dot-pulse {
        0%, 80%, 100% { transform: scale(0); opacity: 0; }
        40% { transform: scale(1); opacity: 1; }
    }

    /* Show loader when button is in loading state */
    .btn.is-loading .dot-loader {
        display: inline-flex;
    }

    .btn.is-loading {
        pointer-events: none;
        opacity: 0.8;
    }

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
</style>
</head>

<body>

<div class="login-card">

<!-- Welcome Section -->
<div class="carousel-side d-flex align-items-center justify-content-center text-white">
    <div class="text-center">
        <h2 class="fw-bold">Welcome Back!</h2>
        
        <!-- Short underline -->
        <div style="width: 70px; height: 3px; background-color: white; margin: 8px auto 10px;"></div>

        <!-- Time Counter -->
        <div id="clock" style="font-size: 14px; font-weight: 500;"></div>

        <!-- <p class="small mt-2">We're happy to see you again.</p> -->
    </div>
</div>

<script>
function updateClock() {
    const now = new Date();
    const timeString = now.toLocaleTimeString();
    document.getElementById("clock").textContent = timeString;
}

setInterval(updateClock, 1000);
updateClock();
</script>

  <!-- Login Section -->
  <div class="login-side">
    <div class="login-form-wrapper">
       @php
    $now = \Carbon\Carbon::now('Africa/Dar_es_Salaam');
    $hour = $now->hour;

    if ($hour >= 5 && $hour < 12) {
        $greeting = 'Hey! Good Morning';
        $color="Green";
    } elseif ($hour >= 12 && $hour < 17) {
        $greeting = 'Hey! Good Afternoon';
         $color="Orange";
    } elseif ($hour >= 17 && $hour < 21) {
        $greeting = 'Hey! Good Evening';
         $color="Black";
    } else {
        $greeting = 'Hey! Good Night';
         $color="Green";
    }
    @endphp
        <center>
        <div class="greeting-badge rounded-pill">
                <i class="bi bi-hand-thumbs-up-fill"></i>
                <span><strong>{{ $greeting }}</strong></span>
            </div>
        </center>
       {{ $slot }}

    </div>
  </div>

</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('submit', function (event) {
    // 1. Identify the button that triggered the submit
    const form = event.target;
    const submitBtn = form.querySelector('.btn');

    if (submitBtn) {
        // 2. Add the loading class
        submitBtn.classList.add('is-loading');
        // 3. Check if loader already exists, if not, add it
        if (!submitBtn.querySelector('.dot-loader')) {
            const loaderHtml = `
                <span class="dot-loader">
                    <div></div>
                    <div></div>
                    <div></div>
                </span>`;
            submitBtn.innerHTML += loaderHtml;
        }
        // 4. Update text to show action
        const currentText = submitBtn.innerText.trim();
    }
  });
</script>
    <script>
    const togglePassword = document.querySelector('#togglePassword');
    const passwordInput = document.querySelector('#password');
    const eyeIcon = document.querySelector('#eyeIcon');
    togglePassword.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
                eyeIcon.classList.toggle('bi-eye');
        eyeIcon.classList.toggle('bi-eye-slash');
    });
    </script>
</body>
</html>
