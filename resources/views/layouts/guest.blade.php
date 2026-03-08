<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>USONGWE SECONDARY SCHOOL| HOME</title>
   <meta name="description" content="Official Usongwe Secondary School website: learn about our history, academic programs, achievements, and admissions information.">
<meta name="keywords" content="Usongwe Secondary, Usongwe School, Secondary School Tanzania, Mbeya Schools">
<meta name="author" content="Usongwe Secondary School">
  <link rel="icon" type="image/png" href="/assets/img/favicon.png">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
* { margin: 0; padding: 0; box-sizing: border-box; }
html, body { height: 100%; }
body {
  font-family: 'Poppins', sans-serif;
  line-height: 1.6;
  color: #333;
  background: #f4f6fa;
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}
/* Center container */
.login-page {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    flex-direction: column;
}

/* Top system card */
.system-card {
    background: #007bff;
    color: white;
    padding: 15px 30px;
    border-radius: 10px 10px 0 0;
    width: 100%;
    max-width: 380px;
    text-align: center;
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

/* Login form card */
.search-form {
    background: #fff;
    padding: 30px 40px;
    border-radius: 0 0 10px 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    width: 100%;
    max-width: 450px;
    text-align: center;
}

/* Avatar */
.search-form .avatar {
    border-radius: 50%;
    margin-bottom: 20px;
}

/* Form groups */
.search-form .form-group {
    margin-bottom: 15px;
}

.search-form input {
    width: 100%;
    padding: 12px 15px;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 14px;
}

/* Forgot password above input */
.search-form .forgot-password {
    text-align: right;
    font-size: 14px;
    margin-bottom: 5px;
}

.search-form .forgot-password a {
    color: #007bff;
    text-decoration: none;
}

.search-form .forgot-password a:hover {
    text-decoration: underline;
}

/* Button */
.search-form button {
    background: #007bff;
    color: #fff;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    width: 100%;
}

.search-form button:hover {
    background: #0056b3;
}

/* Error messages */
.search-form .error-message {
    color: red;
    font-size: 13px;
    margin-top: 5px;
    text-align: left;
}
  </style>
</head>
<body>
<div class="login-page">
  <div class="system-card">
        RESULTS - SYSTEM
  </div>
        {{ $slot }}

</div>  

  

    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function toggleMenu() {
      const menu = document.getElementById('mobileNav');
      menu.style.display = (menu.style.display === 'flex') ? 'none' : 'flex';
    }
  </script>

  <script>
 document.querySelectorAll("form").forEach(form => {
  form.addEventListener("submit", function() {
    let btn = form.querySelector('button[type="submit"]');
    if (btn && form.checkValidity()) {
      btn.disabled = true;
      btn.innerHTML = `<i class="fa fa-spinner fa-spin me-2"></i> Processing..`;
    }
  });
});
</script>

</body>
</html>
