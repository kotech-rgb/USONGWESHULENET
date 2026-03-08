<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>USONGWE SECONDARY SCHOOL| HOME</title>
<meta name="description" content="Official Usongwe Secondary School website: learn about our history, academic programs, achievements, and admissions information.">
<meta name="keywords" content="Usongwe Secondary, Usongwe School, Secondary School Tanzania, Mbeya Schools">
<meta name="author" content="Usongwe Secondary School">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family:'Poppins', sans-serif; background:#f4f6fa; color:#333; line-height:1.6; scroll-behavior: smooth;}
a { text-decoration:none; color:inherit; }
img { max-width:100%; display:block; }

header { background:#004aad; color:white; padding:15px 30px; display:flex; justify-content:space-between; align-items:center; position:sticky; top:0; z-index:1000; transition:all 0.3s ease; }
header.shrink { padding:10px 30px; box-shadow:0 4px 10px rgba(0,0,0,0.2); }
header h1 { font-size:1.6rem; font-weight:700; transition:font-size 0.3s ease; }
header.shrink h1 { font-size:1.4rem; }
nav { display:flex; gap:25px; }
nav a { color:white; font-weight:500; position:relative; transition:color 0.3s ease;}
nav a::after { content:''; position:absolute; width:0; height:2px; background:#fff; left:0; bottom:-4px; transition:0.3s; }
nav a:hover::after { width:100%; }
nav a:hover { color:#ffd700; }
.hamburger { display:none; flex-direction:column; gap:5px; cursor:pointer; }
.hamburger span { width:25px; height:3px; background:white; border-radius:2px; }
.mobile-nav { display:none; flex-direction:column; background:#004aad; position:absolute; top:60px; right:0; width:100%; padding:10px 0; }
.mobile-nav a { padding:12px 25px; color:white; }
.mobile-nav a:hover { background: rgba(255,255,255,0.1); }

.hero { background:url('/assets/website/mkuu.jpg') center/cover no-repeat; color:white; padding:120px 20px; text-align:center; position:relative; overflow:hidden; }
.hero::before { content:''; position:absolute; top:0; left:0; width:100%; height:100%; background:rgba(0,74,173,0.7); }
.hero-content { position:relative; z-index:1; max-width:900px; margin:auto; opacity:0; transform:translateY(40px); animation:fadeUp 1s forwards 0.2s; }
.hero-content h2 { font-size:2.8rem; margin-bottom:20px; font-weight:700; transition:transform 0.3s ease;}
.hero-content p { font-size:1.2rem; margin-bottom:25px; transition:transform 0.3s ease;}
.hero-content .cta-buttons { display:flex; justify-content:center; gap:20px; flex-wrap:wrap; }
.hero-content .cta-buttons a { padding:12px 25px; border-radius:8px; font-weight:600; color:white; background:linear-gradient(135deg,#004aad,#0077ff); transition:0.3s; }
.hero-content .cta-buttons a:hover { transform:translateY(-5px) scale(1.05); background:linear-gradient(135deg,#00317a,#005fd9); }

.about, .stats, .news, .events, .testimonials { opacity:0; transform:translateY(40px); transition:all 1s ease; }

.about img, .about-text, .news-card, .event-card, .testimonial, .stat { transition:all 0.5s ease; }
.about img:hover, .news-card:hover, .event-card:hover, .testimonial:hover, .stat:hover { transform:scale(1.03); box-shadow:0 10px 25px rgba(0,0,0,0.15); }

.about { padding:80px 25px; background:#f9fbff; display:flex; flex-wrap:wrap; align-items:center; gap:30px; justify-content:center; }
.about img { flex:1 1 300px; border-radius:12px; box-shadow:0 6px 20px rgba(0,0,0,0.1); }
.about-text { flex:1 1 400px; }
.about-text h3 { font-size:2rem; margin-bottom:15px; color:#004aad; }
.about-text p { font-size:1rem; margin-bottom:15px; }

.stats { display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:20px; padding:60px 25px; text-align:center; background:#fff; }
.stat { background:#004aad; color:white; border-radius:12px; padding:40px 20px; box-shadow:0 6px 20px rgba(0,0,0,0.1); transition:all 0.5s ease; }
.stat h4 { font-size:2.5rem; margin-bottom:10px; }
.stat p { font-size:1rem; }

.news { padding:60px 25px; text-align:center; }
.news h3 { font-size:2rem; margin-bottom:40px; color:#004aad; }
.news-cards { display:grid; grid-template-columns:repeat(auto-fit,minmax(280px,1fr)); gap:25px; }

.news-card { background:white; border-radius:12px; padding:20px; box-shadow:0 4px 12px rgba(0,0,0,0.1); transition:all 0.3s ease; }
.news-card:hover { transform:translateY(-5px) scale(1.02); box-shadow:0 8px 20px rgba(0,0,0,0.15); }
.news-card img { border-radius:8px; margin-bottom:15px; }
.news-card h4 { font-size:1.2rem; margin-bottom:10px; color:#004aad; }
.news-card p { font-size:0.95rem; color:#555; }

.events { padding:60px 25px; background:#f9fbff; }
.events h3 { font-size:2rem; margin-bottom:40px; text-align:center; color:#004aad; }
.events-cards { display:grid; grid-template-columns:repeat(auto-fit,minmax(280px,1fr)); gap:25px; }
.event-card { background:white; border-radius:12px; padding:20px; box-shadow:0 4px 12px rgba(0,0,0,0.1); transition:all 0.3s ease; }
.event-card:hover { transform:translateY(-5px) scale(1.02); box-shadow:0 8px 20px rgba(0,0,0,0.15); }
.event-card h4 { font-size:1.2rem; margin-bottom:10px; color:#004aad; }
.event-card p { font-size:0.95rem; color:#555; }

.testimonials { padding:60px 25px; text-align:center; }
.testimonials h3 { font-size:2rem; margin-bottom:40px; color:#004aad; }
.testimonial { background:white; border-radius:12px; padding:30px; margin:15px auto; max-width:500px; box-shadow:0 4px 12px rgba(0,0,0,0.1); transition:all 0.3s ease; }
.testimonial:hover { transform:scale(1.03); box-shadow:0 8px 20px rgba(0,0,0,0.15); }
.testimonial p { font-style:italic; margin-bottom:10px; }
.testimonial h4 { font-weight:700; color:#004aad; font-size:1rem; }

footer { background:#004aad; color:white; text-align:center; padding:30px 20px; margin-top:auto; }
footer a { color:white; margin:0 8px; font-size:1.2rem; }

@keyframes fadeUp { from { opacity:0; transform:translateY(40px);} to { opacity:1; transform:translateY(0);} }

@media(max-width:768px){
  nav { display:none; }
  .hamburger { display:flex; }
  .about { flex-direction:column; text-align:center; }
}


/*Message of Head master*/
.about {
  background: linear-gradient(135deg, #f9f9f9, #eef7fa);
  padding: 60px 20px;
}

/* Container layout */
.about-container {
  display: flex;
  align-items: center;
  gap: 30px;
  max-width: 1100px;
  margin: 0 auto;
  background: #fff;
  padding: 30px;
  border-radius: 16px;
  box-shadow: 0 8px 20px rgba(0,0,0,0.08);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.about-container:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 25px rgba(0,0,0,0.12);
}

/* Image */
.about-image img {
  width: 160px;
  height: auto;
  border-radius: 50%;  /* circle look */
  object-fit: cover;
  box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

/* Text */
.about-text {
  flex: 1;
}

.about-text h3 {
  font-size: 1.8rem;
  margin-bottom: 15px;
  color: #05738E;   /* brand color */
  font-weight: 700;
}

.about-text p {
  margin-bottom: 12px;
  line-height: 1.7;
  color: #444;
  font-size: 1rem;
}

/* Responsive */
@media (max-width: 768px) {
  .about-container {
    flex-direction: column;
    text-align: center;
    padding: 25px;
  }

  .about-image img {
    width: 120px;
    margin-bottom: 20px;
  }

  .about-text h3 {
    font-size: 1.5rem;
  }
}
</style>
</head>
<body>

<header id="header">
  <h1>USONGWE SECONDARY SCHOOLs</h1>
  <nav>
    <a href="#hero">Home</a>
    <a href="#about">About</a>
    <a href="#events">Events</a>
    <a href="/login">Staff Login</a>
  </nav>
  <div class="hamburger" onclick="toggleMenu()"><span></span><span></span><span></span></div>
  <div class="mobile-nav" id="mobileNav">
    <a href="#hero">Home</a>
    <a href="#about">About</a>
    <a href="#events">Mission & Vission</a>
    <a href="/login">Staff Login</a>
  </div>
</header>

<section class="hero" id="hero">
  <div class="hero-content">
    <h2>Welcome to Usongwe Secondary School</h2>
    <p>Struggle for success</p>
    <div class="cta-buttons">
      <a href="#about">About Us</a>
      <a href="#events">Mission & Vission</a>
      <a href="/login">Staff Login</a>
    </div>
  </div>
</section>

<section class="about" id="about">
  <div class="about-container">
    <div class="about-image">
      <img src="/assets/website/mkuuWelcome.jpg" alt="Headmaster">
    </div>
    <div class="about-text">
      <h3>Welcome message!</h3>
      <p>
        Usongwe Secondary School (registration S0913) is a government secondary school located in Utengule Usongwe, within Mbeya Rural District Tanzania.
      </p>
      <p>The School was officially opened on 04/08/1997 as a divisional school in Utengule Usongwe with initial enrollment of seventy-nine(79) Form One students — 39 girls and 40 boys.
      </p>
      <p>
      In 2008, the school introduced Advanced level studies by enrolling 25 form five students in the HGE combination. Currently, the school is core educational (For both boys and Girls) for form one to form four, While form five and form six are exclusively for girls.</p>
    </div>
  </div>
</section>


<!-- TOP MANAGEMENT TEAM -->
<section class="management" id="management" style="padding:60px 25px; background:#f9fbff; text-align:center;">
  <h3 style="font-size:2rem; margin-bottom:40px; color:#004aad;">Top Management Team</h3>
  <div class="management-cards" style="display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:25px; justify-items:center;">
    
    <!-- Card 1 -->
    <div class="management-card" style="background:white; border-radius:12px; padding:20px; box-shadow:0 4px 12px rgba(0,0,0,0.1); transition:all 0.3s ease;">
        <center>
      <img src="/assets/website/mkuuWelcome.jpg" alt="Headmaster" style="width:120px; height:120px; border-radius:50%; object-fit:cover; margin-bottom:15px;">
      </center>
      <h4 style="color:#004aad; margin-bottom:5px;">Valeria Charles Mtega</h4>
      <p style="font-weight:600; margin-bottom:10px;">Headmistress</p>
      <p style="font-size:0.9rem; color:#555;">The headmaster oversees the entire school and is ultimately responsible for the performance, effectiveness, and success of all school programmes, including peer counselling</p>
    </div>

    <!-- Card 2 -->
    <div class="management-card" style="background:white; border-radius:12px; padding:20px; box-shadow:0 4px 12px rgba(0,0,0,0.1); transition:all 0.3s ease;">
        <center>
      <img src="/assets/website/deputy4.jpg" alt="Deputy Headmaster" style="width:120px; height:120px; border-radius:50%; object-fit:cover; margin-bottom:15px;">
      </center>
      <h4 style="color:#004aad; margin-bottom:5px;">Ms. Enike Obas Ruben</h4>
      <p style="font-weight:600; margin-bottom:10px;">First Deputy Head</p>
      <p style="font-size:0.9rem; color:#555;">Assists the headmistress in leading the school and manages daily academic and administrative operations</p>
    </div>
    
   
    <!-- Card 3 -->
    
     <div class="management-card" style="background:white; border-radius:12px; padding:20px; box-shadow:0 4px 12px rgba(0,0,0,0.1); transition:all 0.3s ease;">
        <center>
      <img src="/assets/website/NGS_9055.jpg" alt="Bursar" style="width:120px; height:120px; border-radius:50%; object-fit:cover; margin-bottom:15px;">
      </center>
      <h4 style="color:#004aad; margin-bottom:5px;">Mr. Leonard Leuteri Chula</h4>
      <p style="font-weight:600; margin-bottom:10px;">Second Deputy Head</p>
      <p style="font-size:0.9rem; color:#555;">Assists the headmistress in leading the school and manages daily academic and administrative operations</p>
    </div>
    
    

    
     <!-- Card 3 -->
    <div class="management-card" style="background:white; border-radius:12px; padding:20px; box-shadow:0 4px 12px rgba(0,0,0,0.1); transition:all 0.3s ease;">
        <center>
      <img src="/assets/website/academic.jpg" alt="Bursar" style="width:120px; height:120px; border-radius:50%; object-fit:cover; margin-bottom:15px;">
      </center>
      <h4 style="color:#004aad; margin-bottom:5px;">Mr. Simon J. Kazimbaya</h4>
      <p style="font-weight:600; margin-bottom:10px;">Academic Master</p>
      <p style="font-size:0.9rem; color:#555;"> Leads the department and ensures faculty, students, and staff receive the support needed for academic, research, and administrative duties</p>
    </div>

  </div>
</section>

<style>
/* Add hover animation for management cards */
.management-card:hover {
  transform:translateY(-5px) scale(1.03);
  box-shadow:0 10px 25px rgba(0,0,0,0.15);
}
</style>


<!-- <section class="stats" id="stats">
  <div class="stat"><h4>1200+</h4><p>Students</p></div>
  <div class="stat"><h4>75</h4><p>Teachers</p></div>
  <div class="stat"><h4>20</h4><p>Years of Excellence</p></div>
  <div class="stat"><h4>15</h4><p>Clubs & Societies</p></div>
</section>  -->

<section class="mission-vision" id="mission-vision" style="padding:60px 25px; background:#f9fbff; text-align:center;">
  <h3 style="font-size:2rem; margin-bottom:40px; color:#004aad;">Our Mission & Vision</h3>
  <div class="mv-cards" style="display:grid; grid-template-columns:repeat(auto-fit,minmax(280px,1fr)); gap:25px; justify-items:center;">

    <!-- Mission -->
    <div class="mv-card" style="background:white; border-radius:12px; padding:30px; box-shadow:0 4px 12px rgba(0,0,0,0.1); transition:all 0.3s ease;">
      <i class="fa fa-bullseye" style="font-size:2rem; color:#004aad; margin-bottom:15px;"></i>
      <h4 style="color:#004aad; margin-bottom:10px;">Mission</h4>
      <p style="font-size:0.95rem; color:#555;">
       Usongwe secondary school aspire to be the best in provision of quality education which will development each child to his/her own capacity.
      </p>
    </div>

    <!-- Vision -->
    <div class="mv-card" style="background:white; border-radius:12px; padding:30px; box-shadow:0 4px 12px rgba(0,0,0,0.1); transition:all 0.3s ease;">
      <i class="fa fa-eye" style="font-size:2rem; color:#004aad; margin-bottom:15px;"></i>
      <h4 style="color:#004aad; margin-bottom:10px;">Vision</h4>
      <p style="font-size:0.95rem; color:#555;">
        To develop each child to his/her own capacity.
      </p>
    </div>

  </div>
</section>


<!-- <section class="events" id="events">
  <h3>Upcoming Events</h3>
  <div class="events-cards">
    <div class="event-card">
      <h4>Annual Sports Day</h4>
      <p>Join us on 10th October for an exciting day of sports and fun competitions for all students.</p>
    </div>
    <div class="event-card">
      <h4>Science Exhibition</h4>
      <p>On 15th November, our students will present innovative science projects and experiments.</p>
    </div>
    <div class="event-card">
      <h4>Parent-Teacher Meeting</h4>
      <p>Scheduled for 5th December, we encourage parents to discuss progress and achievements.</p>
    </div>
  </div>
</section> -->



<footer id="contact">
  <p>Developed by KoTech © 2025 All Rights Reserved</p>
</footer>

<script>
function toggleMenu() {
  const menu = document.getElementById('mobileNav');
  menu.style.display = (menu.style.display === 'flex') ? 'none' : 'flex';
}

window.addEventListener('scroll', () => {
  const header = document.getElementById('header');
  if(window.scrollY > 50) header.classList.add('shrink');
  else header.classList.remove('shrink');
  document.querySelectorAll('.about, .stats, .news, .events, .testimonials').forEach(section => {
    const top = section.getBoundingClientRect().top;
    if(top < window.innerHeight - 100) {
      section.style.opacity = 1;
      section.style.transform = 'translateY(0)';
    }
  });
});
</script>
</body>
</html>
