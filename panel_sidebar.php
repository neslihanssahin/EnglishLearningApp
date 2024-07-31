<?php
$active_page = basename($_SERVER['PHP_SELF']); // Aktif sayfanın dosya adını alır

function isActive($page) {
    global $active_page;
    if ($active_page === $page) {
        return 'active'; // Eğer sayfa aktifse 'active' sınıfını döndürür
    } else {
        return ''; // Aktif değilse boş bir string döndürür
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learn Words</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .sidebar {
            height: 100%;
            width: 200px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: rgb(32, 22, 88); /* Yan menü arka plan rengi */
            padding-top: 20px;
            border-radius: 10px; /* Köşe yuvarlaklığı */
        }

        .sidebar a {
            padding: 12px 15px; /* Üst ve alt için 12px, sol ve sağ için 15px */
            text-decoration: none;
            font-size: 18px;
            color: #fff; /* Bağlantı rengi */
            display: flex;
            align-items: center;
            transition: background-color 0.3s ease;
            font-weight: bold;
            font-style: italic;
        }

        .sidebar a.active {
            background-color: #555; /* Aktif bağlantının arka plan rengi */
        }

        .sidebar a:hover {
            background-color: #444; /* Bağlantı üzerine gelindiğinde arka plan rengi */
        }

        .sidebar a i {
            margin-right: 10px;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="file"],
        button {
            width: 100%;
            padding: 12px;
            box-sizing: border-box;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 18px;
        }

        button {
            background-color: #28a745; /* Yeşil arka plan rengi */
            color: #fff;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838; /* Koyu yeşil arka plan rengi */
        }
    

    
    </style>
</head>
<body>
    <div class="sidebar">
        <a href="panel_words.php" class="<?= isActive('panel_sidebar.php') ?>"><i class="fas fa-book"></i> Learn Words</a>
        <a href="panel_story.php" class="<?= isActive('panel_story.php') ?>"><i class="fas fa-book-reader"></i> Story</a>
        <a href="panel_test.php" class="<?= isActive('panel_test.php') ?>"><i class="fas fa-pencil-alt"></i> Test</a>
        <a href="panel_list.php" class="<?= isActive('panel_list.php') ?>"><i class="fas fa-list"></i> List</a>
        <a href="panel_logout.php" class="<?= isActive('panel_logout.php') ?>"><i class="fas fa-sign-out-alt"></i> Çıkış Yap</a>
       
    </div>
    
    
    

   
</body>
</html>
