<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anasayfa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        /* Navbar stilini ayarlayalım */
        nav {
            background-color: rgb(16, 44, 87);
            width: 100%;
            padding: 10px 0;
            position: fixed;
            top: 0;
            z-index: 1000;
            /* Navbar'ın diğer içeriklerin üstünde kalmasını sağlar */
        }

        .navbar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 90%;
            margin: 0 auto;
            color: white;
            font-size: 20px;
        }

        .logo {
            font-weight: bold;
            font-size: 24px;
            display: flex;
            align-items: center;
        }

        .logo img {
            max-height: 40px; /* İstenen küçük boyut */
            margin-right: 10px; /* LOGO ile ikon arasındaki boşluk */
        }

        .navbar-links {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .navbar-links li {
            margin-right: 20px;
        }

        .navbar-links li a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
        }

        .navbar-links li a:hover {
            color: gray;
        }

        /* İçerik container */
        .main-content {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            padding-top: 100px; /* Navbar yüksekliği kadar içeriği aşağı kaydırdık */
            padding-bottom: 50px; /* Footer yüksekliği kadar içeriği aşağı kaydırdık */
        }

        .kutu-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            color: white;
            font-weight: bold;
            font-size: 25px;
            font-family: Arial, sans-serif;
        }

        .kutu {
            width: 400px;
            height: 250px;
            margin: 10px;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: transform 0.3s, opacity 0.3s, font-size 0.3s;
            /* Animasyon süresi */
        }

        .kutu:hover {
            transform: scale(1.1);
            opacity: 0.7;
            font-size: 30px;
        }

        .kutu a {
            color: white;
            /* Yazı rengi beyaz */
            text-decoration: none;
            /* Altı çizgili olmasın */
        }

        .kutu1 {
            background-color: rgb(255, 137, 17);
            transform-origin: right center;
        }

        .kutu2 {
            background-color: rgb(45, 149, 150);
            transform-origin: left center;
        }

        .kutu3 {
            background-color: rgb(216, 0, 50);
            transform-origin: right center;
        }

        .kutu4 {
            background-color: rgb(134, 70, 156);
            transform-origin: left center;
        }

        /* Footer stilini ayarlayalım */
        footer {
            background-color: rgb(16, 44, 87);
            color: white;
            text-align: center;
            padding: 10px 0;
            width: 100%;
            position: relative;
            /* Sayfanın sonuna yapışık olacak şekilde ayarlandı */
            margin-top: auto; /* Footer'ı sayfanın en altına yapıştırır */
        }

        .user-icon {
            margin-left: 20px;
            color: white;
            font-size: 24px;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav>
        <div class="navbar-container">
            <div class="logo">
                <a href="ana.php"><img src="foto/logo.png" alt="LOGO"></a>
            </div>
            <div class="user-icon">
                <i class="fas fa-user"></i>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">

        <div class="kutu-container">
            <div class="kutu kutu1">
                <a href="learnWords.php">LEARN WORDS</a>
            </div>
            <div class="kutu kutu2">
                <a href="story.php">STORY</a>
            </div>
        </div>
        <div class="kutu-container">
            <div class="kutu kutu3">
                <a href="test.php">TEST</a>
            </div>
            <div class="kutu kutu4">
                <a href="list.php">LIST</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        Designed by <span style="color: #FFA500;">PrimeCoders</span>
    </footer>

    <!-- FontAwesome 6.x -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"
        integrity="sha512-MWbU+19krr75oT8fDn9tFmWq34j3NSj8ib4S7fb3fB5xDZJxhD6jBheJfTGwN3Hkvg7ZxH3n+Y9TfNyUdLOZRA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    

</body>

</html>
