<!DOCTYPE html>
<html lang="fa">
<head>
  <meta charset="UTF-8">

  <link href="https://cdn.fontcdn.ir/Font/Persian/Vazir/Vazir.css" rel="stylesheet" type="text/css" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  
  <link rel="icon" type="img/png" href="{{ asset('img/Logo.png') }}">
<link rel="apple-touch-icon" href="{{ asset('img/Logo.png') }}">

  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
  <header>
    <div id="divHeader">
      <div class="menu-toggle" onclick="toggleMenu()">☰</div>
      <nav id="navMenu">
        <button class="headerButton" onclick="headerButton1()">خانه</button>
        <button class="headerButton" onclick="headerButton2()">قوانین</button>
        <button class="headerButton" onclick="headerButton3()">درباره ما</button>
        <button class="headerButton" onclick="headerButton4()">تماس با ما</button>
      </nav>
      </div>
    </div>
  </header>

  <div class="theme-btn-wrapper">
    <button id="themeToggle">🌞</button>
  </div>
  
@yield('connect')

</body>
</html>
