<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
    <meta name="google-translate-customization" content="502d2c1a267d1206-8efe060c714e194c-g94a06c6c571083ae-11">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="twitter:site" content="@drchuck" />
    <meta name="twitter:title" content="Dr. Chuck Online - Free Courses in Technology and Programming" />
    <meta name="twitter:description" content="Completely free online courses in Python, HTML, CSS, JavaScript, JQuery, Django, PostgreSQL, and C." />
    <meta name="twitter:image" content="https://online.dr-chuck.com/Chuck_16x9_PY4E.jpg" />

    <title>Dr. Chuck Online - Free Courses in Technology and Programming</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="static/css/custom.css" rel="stylesheet">

    <style>
        .course-card {
            margin-bottom: 30px;
            max-width: 320px;
            margin-left: auto;
            margin-right: auto;
            transition: transform 0.2s;
            border: 1px solid #dee2e6;
        }
        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        .course-card img {
            width: 100%;
            height: auto;
            display: block;
        }
        .course-card .card-body {
            padding: 15px;
        }
        .course-card .card-title {
            font-size: 1.15rem;
        }
        .course-card .card-text {
            color: #666;
            font-size: 0.9rem;
        }
        .course-card .btn {
            margin-top: 0.5rem;
        }
        .course-modal-img {
            display: block;
            max-width: 100%;
            height: auto;
            margin: 0 auto 1rem;
            border-radius: 0.25rem;
        }
        .course-modal-links {
            margin: 0;
            padding-left: 1.25rem;
        }
        .course-modal-links li {
            margin-bottom: 0.5rem;
        }
        .course-modal-links a {
            font-size: 0.95rem;
        }
        .course-modal-empty {
            color: #777;
            font-style: italic;
            margin: 0;
        }
        .site-nav {
            background: linear-gradient(to bottom, #f8f9fa, #e9ecef);
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 0.5rem 0.75rem;
        }
    </style>

</head>
<body class="px-2">
<div class="container py-2">
<h1 class="h2 mb-3">
<span>
<a href="https://twitter.com/drchuck" target="_blank" rel="noopener noreferrer"><img src="https://en.gravatar.com/avatar/2d0a2f518066c5fd09d757a289b54307?s=80" height="40" width="40" alt="Charles Severance (Dr. Chuck) on Twitter"></a>
<span class="d-none d-md-inline">Dr. Chuck Online</span>
<span class="d-md-none"><small>Dr.C.O</small></span>
<span class="d-none d-xl-inline text-secondary small align-middle ms-1">Open Standards, Open Source and Open Education
</span></span></h1>
<nav class="site-nav mb-3" aria-label="Main">
    <ul class="nav nav-pills flex-column flex-sm-row gap-sm-2 mb-0">
      <li class="nav-item"><a class="nav-link active" href="index.php" aria-current="page"><i class="bi bi-house-fill d-md-none me-1" aria-hidden="true"></i><span class="d-none d-md-inline">Courses</span><span class="d-md-none visually-hidden">Courses</span></a></li>
      <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
      <li class="nav-item"><a class="nav-link" href="https://dr-chuck-master-programming-and-ai.kit.com/f4c9f36d0c" target="_blank" rel="noopener noreferrer">Newsletter</a></li>
      <li class="nav-item"><a class="nav-link" href="https://podcast.dr-chuck.com/" target="_blank" rel="noopener noreferrer">Podcast</a></li>
      <li class="nav-item"><a class="nav-link" href="https://youtube.dr-chuck.com/" target="_blank" rel="noopener noreferrer">YouTube</a></li>
      <li class="nav-item"><a class="nav-link" href="https://www.dr-chuck.com/office" target="_blank" rel="noopener noreferrer">Office Hours</a></li>
      <li class="nav-item"><a class="nav-link" href="https://www.dr-chuck.com/">Dr. Chuck</a></li>
    </ul>
</nav>

<p>
Welcome to the School of Dr. Chuck! 
I have designed a series of courses designed to take students from knowing nothing about programming to the point where they have the
skills for an entry level job or internship in a software development orginization.  These classes are designed to get a student
prepared to be a <a href="about.php">master programmer</a> as efficiently as possible.
</p>

<div class="row g-4 justify-content-center">
  <div class="col-12 col-md-6 col-lg-4">
      <div class="card course-card">
        <img src="static/img/courses/ihts-card.png" class="card-img-top" alt="Internet History, Technology, and Security">
        <div class="card-body">
          <h3 class="card-title">Internet History, Technology, and Security</h3>
          <p class="card-text">Covers history from early computing to the web, its commercialization, and key security concepts like encryption and digital signatures. Available on Coursera and FreeCodeCamp and free online for everyone.</p>
          <button type="button" class="btn btn-primary course-modal-open" data-course="ihts">View Course</button>
        </div>
      </div>
  </div>

  <div class="col-12 col-md-6 col-lg-4">
      <div class="card course-card">
        <img src="static/img/courses/py4e-card.png" class="card-img-top" alt="Python for Everybody">
        <div class="card-body">
          <h3 class="card-title">Python for Everybody (PY4E)</h3>
          <p class="card-text">The world's most successful online Python course. Available on Coursera, edX, FreeCodeCamp, and free online for everyone.</p>
          <button type="button" class="btn btn-primary course-modal-open" data-course="py4e">View Course</button>
        </div>
      </div>
  </div>

  <div class="col-12 col-md-6 col-lg-4">
      <div class="card course-card">
        <img src="static/img/courses/dj4e-card.png" class="card-img-top" alt="Django for Everybody">
        <div class="card-body">
          <h3 class="card-title">Django for Everybody (DJ4E)</h3>
          <p class="card-text">Covers Django, HTML, CSS, SQL, JavaScript, BootStrap, and JQuery. Available on Coursera, edX, FreeCodeCamp and free online for everyone.</p>
          <button type="button" class="btn btn-primary course-modal-open" data-course="dj4e">View Course</button>
        </div>
      </div>
  </div>
</div>

<div class="row g-4 justify-content-center">
  <div class="col-12 col-md-6 col-lg-4">
      <div class="card course-card">
        <img src="static/img/courses/wa4e-card.png" class="card-img-top" alt="Web Applications for Everybody">
        <div class="card-body">
          <h3 class="card-title">Web Applications for Everybody (WA4E)</h3>
          <p class="card-text">Covers HTML, CSS, PHP, SQL, JavaScript, BootStrap, and JQuery. Available on Coursera, FreeCodeCamp, and free online for everyone.</p>
          <button type="button" class="btn btn-primary course-modal-open" data-course="wa4e">View Course</button>
        </div>
      </div>
  </div>

  <div class="col-12 col-md-6 col-lg-4">
      <div class="card course-card">
        <img src="static/img/courses/pg4e-card.png" class="card-img-top" alt="PostgreSQL for Everybody">
        <div class="card-body">
          <h3 class="card-title">PostgreSQL for Everybody (PG4E)</h3>
          <p class="card-text">A series of four courses covering PostgreSQL and the Deno NoSQL system. Available on Coursera, edX, and free online for everyone.</p>
          <button type="button" class="btn btn-primary course-modal-open" data-course="pg4e">View Course</button>
        </div>
      </div>
  </div>

  <div class="col-12 col-md-6 col-lg-4">
      <div class="card course-card">
        <img src="static/img/courses/cc4e-card.png" class="card-img-top" alt="C Programming for Everybody">
        <div class="card-body">
          <h3 class="card-title">C Programming for Everybody (CC4E)</h3>
          <p class="card-text">A course looking at the C language and its profound effect on modern computing and Computer Science. Available on Coursera, FreeCodeCamp, and free online for everyone.</p>
          <button type="button" class="btn btn-primary course-modal-open" data-course="cc4e">View Course</button>
        </div>
      </div>
  </div>
</div>

<div class="row g-4 justify-content-center">
  <div class="col-12 col-md-6 col-lg-4">
      <div class="card course-card">
        <img src="static/img/courses/ca4e-card.png" class="card-img-top" alt="Computer Architecture for Everybody">
        <div class="card-body">
          <h3 class="card-title">Computer Architecture for Everybody (CA4E)</h3>
          <p class="card-text">This course covers digital electronics, how electronics can be used for computation, what machine language is, and what assembly language is, and how compiled languages like C work.</p>
          <button type="button" class="btn btn-primary course-modal-open" data-course="ca4e">View Course</button>
        </div>
      </div>
  </div>
</div>

<div class="modal fade" id="courseModal" tabindex="-1" aria-labelledby="courseModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="courseModalTitle">Course details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="courseModalBody"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<template id="course-modal-ihts" data-title="Internet History, Technology, and Security">
  <img src="static/img/courses/ihts-card.png" class="course-modal-img" alt="Internet History, Technology, and Security">
  <ul class="course-modal-links">
    <li>Paid course sites</li>
    <ul>
      <li><a href="https://www.coursera.org/learn/internet-history" target="_blank">Coursera: Internet History, Technology, and Security</a></li>
    </ul>
    <li>Free course materials </li>
    <ul>
      <li><a href="https://ihts.pr4e.com/">Dr. Chuck Online: ihts.pr4e.com</a></li>
      <li><a href="https://online.umich.edu/courses/internet-history-technology-and-security/" target="_blank">University of Michigan Online (requires UM NetID)</a></li>
      <li><a href="https://www.freecodecamp.org/news/learn-the-history-of-the-internet-in-dr-chucks/" target="_blank">Free Code Camp (video only)</a></li>
      <li><a href="https://www.youtube.com/playlist?list=PLlRFEj9H3Oj6-srSAgLb-ZGVNGlo3v14X" target="_blank">YouTube PlayList</a></li>
    </ul>
  </ul>
</template>
<template id="course-modal-py4e" data-title="Python for Everybody (PY4E)">
  <img src="static/img/courses/py4e-card.png" class="course-modal-img" alt="Python for Everybody">
  <ul class="course-modal-links">
    <li>Paid course sites</li>
    <ul>
      <li><a href="https://www.coursera.org/specializations/python" target="_blank">Coursera: Python for Everybody</a></li>
      <li><a href="https://www.edx.org/learn/python/the-university-of-michigan-programming-for-everybody-getting-started-with-python" target="_blank" rel="noopener noreferrer">edX: Python for Everybody</a></li>
    </ul>
    <li>Free course materials </li>
    <ul>
      <li><a href="https://www.py4e.com/">Dr. Chuck Online: www.py4e.com</a></li>
      <li><a href="https://online.umich.edu/series/python-for-everybody/" target="_blank">University of Michigan Online (requires UM NetID)</a></li>
      <li><a href="https://www.youtube.com/watch?v=8DvywoWv6fI" target="_blank">Free Code Camp (video only)</a></li>
      <li><a href="https://www.youtube.com/watch?v=UjeNA_JtXME&list=PLlRFEj9H3Oj7Bp8-DfGpfAfDBiblRfl5p&index=1" target="_blank">YouTube PlayList</a></li>
    </ul>
  </ul>
</template>
<template id="course-modal-dj4e" data-title="Django for Everybody (DJ4E)">
  <img src="static/img/courses/dj4e-card.png" class="course-modal-img" alt="Django for Everybody">
  <ul class="course-modal-links">
    <li>Paid course sites</li>
    <ul>
      <li><a href="https://www.coursera.org/specializations/django" target="_blank" rel="noopener noreferrer">Coursera: Django for Everybody Specialization</a></li>
      <li><a href="https://www.edx.org/xseries/michiganx-django-for-everybody" target="_blank" rel="noopener noreferrer">edX: Django for Everybody XSeries Program</a></li>
    </ul>
    <li>Free course materials</li>
    <ul>
      <li><a href="https://www.dj4e.com/">Dr. Chuck Online: www.dj4e.com</a></li>
      <li><a href="https://online.umich.edu/series/django/" target="_blank" rel="noopener noreferrer">Free certificates for University of Michigan students and staff</a></li>
      <li><a href="https://www.youtube.com/watch?v=o0XbHvKxw7Y" target="_blank" rel="noopener noreferrer">FreeCodeCamp: Django for Everybody</a></li>
    </ul>
  </ul>
</template>
<template id="course-modal-wa4e" data-title="Web Applications for Everybody (WA4E)">
  <img src="static/img/courses/wa4e-card.png" class="course-modal-img" alt="Web Applications for Everybody">
  <ul class="course-modal-links">
    <li>Paid course sites</li>
    <ul>
      <li><a href="https://www.coursera.org/specializations/web-applications" target="_blank" rel="noopener noreferrer">Coursera: Web Applications for Everybody Specialization</a></li>
    </ul>
    <li>Free course materials</li>
    <ul>
      <li><a href="https://www.wa4e.com/">Dr. Chuck Online: www.wa4e.com</a></li>
      <li><a href="https://online.umich.edu/series/web-applications-for-everybody/" target="_blank" rel="noopener noreferrer">Free certificates for University of Michigan students and staff</a></li>
      <li><a href="https://www.freecodecamp.org/news/web-applications-for-everybody-dr-chuck/" target="_blank" rel="noopener noreferrer">Free Code Camp (video course overview)</a></li>
      <li><a href="https://www.youtube.com/playlist?list=PLlRFEj9H3Oj7FHbnXWviqQt0sKEK_hdKX" target="_blank" rel="noopener noreferrer">YouTube PlayList</a></li>
    </ul>
  </ul>
</template>
<template id="course-modal-pg4e" data-title="PostgreSQL for Everybody (PG4E)">
  <img src="static/img/courses/pg4e-card.png" class="course-modal-img" alt="PostgreSQL for Everybody">
  <ul class="course-modal-links">
    <li>Paid course sites</li>
    <ul>
      <li><a href="https://www.coursera.org/specializations/postgresql-for-everybody" target="_blank" rel="noopener noreferrer">Coursera: PostgreSQL for Everybody Specialization</a></li>
      <li><a href="https://www.edx.org/certificates/professional-certificate/michiganx-postgresql-for-everybody" target="_blank" rel="noopener noreferrer">edX: PostgreSQL for Everybody Professional Certificate</a></li>
    </ul>
    <li>Free course materials</li>
    <ul>
      <li><a href="https://www.pg4e.com/">Dr. Chuck Online: www.pg4e.com</a></li>
      <li><a href="https://online.umich.edu/series/postgresql-for-everybody/" target="_blank" rel="noopener noreferrer">Free certificates for University of Michigan students and staff</a></li>
      <li><a href="https://www.youtube.com/playlist?list=PLlRFEj9H3Oj7Oj3ndXmNS1FFOUyQP-gEa" target="_blank" rel="noopener noreferrer">YouTube Playlist</a></li>
    </ul>
  </ul>
</template>
<template id="course-modal-cc4e" data-title="C Programming for Everybody (CC4E)">
  <img src="static/img/courses/cc4e-card.png" class="course-modal-img" alt="C Programming for Everybody">
  <ul class="course-modal-links">
    <li>Paid course sites</li>
    <ul>
      <li><a href="https://www.coursera.org/specializations/c-programming-for-everybody?utm_source=cc4e_com" target="_blank" rel="noopener noreferrer">Coursera: C Programming for Everybody Specialization</a></li>
    </ul>
    <li>Free course materials</li>
    <ul>
      <li><a href="https://www.cc4e.com/">Dr. Chuck Online: www.cc4e.com</a></li>
      <li><a href="https://online.umich.edu/series/c-programming-for-everybody/?utm_source=cc4e_com" target="_blank" rel="noopener noreferrer">Free Certificates for University of Michigan students and staff</a></li>
      <li><a href="https://www.youtube.com/watch?v=PaPN51Mm5qQ" target="_blank" rel="noopener noreferrer">FreeCodeCamp</a></li>
      <li><a href="https://www.youtube.com/playlist?list=PLlRFEj9H3Oj5NbaFb1b2n8lib01uNPWLa" target="_blank" rel="noopener noreferrer">YouTube Playlist</a></li>
    </ul>
  </ul>
</template>
<template id="course-modal-ca4e" data-title="Computer Architecture for Everybody (CA4E)">
  <img src="static/img/courses/ca4e-card.png" class="course-modal-img" alt="Computer Architecture for Everybody">
  <ul class="course-modal-links">
    <li>Paid course sites</li>
    <ul>
      <li><a href="https://www.udemy.com/course/computer-hardware-history/?referralCode=E95943B808A6D0D60EDF" target="_blank" rel="noopener noreferrer">Udemy: Computer Hardware: History from Analog to Digital</a></li>
      <li><a href="https://www.udemy.com/course/how-microprocessors-are-built-and-programmed/?referralCode=76AA3778A203F3AADF5D" target="_blank" rel="noopener noreferrer">Udemy: How Microprocessors are Built and Programmed</a></li>
    </ul>
    <li>Free course materials</li>
    <ul>
      <li><a href="https://www.ca4e.com/">Dr. Chuck Online: www.ca4e.com</a></li>
      <li><a href="https://www.youtube.com/playlist?list=PLlRFEj9H3Oj6_9IsFmVa8llRXHEHkuBS4" target="_blank" rel="noopener noreferrer">YouTube Playlist</a></li>
    </ul>
  </ul>
</template>

<p>
All of the materials are openly licensed and meant to be useful whether you are a student, teacher,
or lifelong learner.
</p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="static/js/course-modal.js"></script>

</body>
</html>
