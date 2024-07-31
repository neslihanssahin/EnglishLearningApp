<?php
include 'baglanti.php'; // Veritabanı bağlantısı

// ID parametresini kontrol et
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Veritabanından hikayeyi seç
    $sql = "SELECT * FROM story WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $id);
    $stmt->execute();
    $story = $stmt->fetch(PDO::FETCH_ASSOC);

    // Hikaye var mı kontrol et
    if (!$story) {
        echo "Hikaye bulunamadı.";
        exit();
    }
} else {
    echo "Hikaye ID'si belirtilmedi.";
    exit();
}

// Form verilerini güncelle
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $story_title = $_POST["story_title"];
    $story_content = $_POST["story_content"];
    $story_image_tmp = $_FILES["story_image"]["tmp_name"];

    // Dosya yüklendi mi kontrol et
    if (!empty($story_image_tmp)) {
        // Dosya içeriğini al
        $image_content = file_get_contents($story_image_tmp);

        // Veritabanına güncelle
        $sql = "UPDATE story SET baslik = ?, hikaye = ?, resim = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $story_title);
        $stmt->bindParam(2, $story_content);
        $stmt->bindParam(3, $image_content, PDO::PARAM_LOB);
        $stmt->bindParam(4, $id);

        if ($stmt->execute()) {
            // Güncelleme başarılı olduğunda yönlendirme
            header("Location: panel_story.php");
            exit();
        } else {
            echo "Hata: " . $sql . "<br>" . $stmt->errorInfo()[2];
        }
    } else {
        // Resim yüklenmediyse sadece metin alanlarını güncelle
        $sql = "UPDATE story SET baslik = ?, hikaye = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $story_title);
        $stmt->bindParam(2, $story_content);
        $stmt->bindParam(3, $id);

        if ($stmt->execute()) {
            // Güncelleme başarılı olduğunda yönlendirme
            header("Location: panel_story.php");
            exit();
        } else {
            echo "Hata: " . $sql . "<br>" . $stmt->errorInfo()[2];
        }
    }

    // İşlem tamamlandıktan sonra bağlantıyı kapat ve ana sayfaya yönlendir
    $stmt->closeCursor();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hikaye Düzenle</title>
    <style>
        /* Stillemeler */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .content {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            margin-top: 5px;
        }

        textarea {
            height: 200px;
        }

        button[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: green;
            color: #fff;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <div class="content">
        <h1>Hikaye Düzenle</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $id); ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="story_title">Hikaye Başlığı:</label>
                <input type="text" id="story_title" name="story_title" value="<?php echo htmlspecialchars($story['baslik']); ?>" placeholder="Hikaye başlığını giriniz" required>
            </div>

            <div class="form-group">
                <label for="story_content">Hikaye:</label>
                <textarea id="story_content" name="story_content" placeholder="Hikayeyi giriniz" required><?php echo htmlspecialchars($story['hikaye']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="story_image">Hikaye Fotoğrafı (mevcut resmi değiştirmek için):</label>
                <input type="file" id="story_image" name="story_image" accept="image/*">
            </div>

            <button type="submit" style="font-size: 18px;">Güncelle</button>
        </form>
    </div>
</body>

</html>
