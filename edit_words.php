<?php
include 'baglanti.php'; // Veritabanı bağlantısı

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $kelime = $_POST['kelime'];
    $dosya = $_FILES["dosya"]["tmp_name"];
    
    if (!empty($dosya)) {
        $dosyaIcerik = file_get_contents($dosya);
        $sql = "UPDATE words SET kelime = ?, resim = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $kelime);
        $stmt->bindParam(2, $dosyaIcerik, PDO::PARAM_LOB);
        $stmt->bindParam(3, $id);
    } else {
        $sql = "UPDATE words SET kelime = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $kelime);
        $stmt->bindParam(2, $id);
    }
    
    if ($stmt->execute()) {
        echo "Kelime başarıyla güncellendi.";
    } else {
        echo "Hata: " . $sql . "<br>" . $stmt->errorInfo()[2];
    }
    $stmt->closeCursor();
    
    // panel_words.php sayfasına yönlendirme
    header("Location: panel_words.php");
    exit();
} elseif (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM words WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $id);
    $stmt->execute();
    $word = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
} else {
    echo "Geçersiz ID.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelime Düzenle</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        .form-group input[type="text"], .form-group input[type="file"] {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Kelime Düzenle</h1>
        <form action="edit_words.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($word['id']); ?>">
            <div class="form-group">
                <label for="kelime">Kelime:</label>
                <input type="text" id="kelime" name="kelime" value="<?php echo htmlspecialchars($word['kelime']); ?>" required>
            </div>
            <div class="form-group">
                <label for="dosya">Dosya Seçiniz (mevcut dosyayı değiştirmek için):</label>
                <input type="file" id="dosya" name="dosya">
            </div>
            <button type="submit">Güncelle</button>
        </form>
    </div>
</body>
</html>
