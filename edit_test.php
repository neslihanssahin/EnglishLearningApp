<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
include 'baglanti.php'; // Veritabanı bağlantı dosyanız

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        $id = intval($_POST['id']);
        $word1 = $_POST['word1'];
        $word2 = $_POST['word2'];
        $word3 = $_POST['word3'];
        $word4 = $_POST['word4'];
        $cevap = $_POST['cevap'];

        $image = $_FILES['image']['tmp_name'];
        $imageContent = !empty($image) ? file_get_contents($image) : null;

        $sql = "UPDATE test SET kelime1=?, kelime2=?, kelime3=?, kelime4=?, resim=?, cevap=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        if ($stmt->execute([$word1, $word2, $word3, $word4, $imageContent, $cevap, $id])) {
            echo "<script>alert('Veri başarıyla güncellendi.');</script>";
            echo "<script>window.location.href = 'panel_test.php';</script>";
            exit();
        } else {
            echo "<script>alert('Veri güncellenirken bir hata oluştu.');</script>";
        }
    }
}

// Veritabanından veriyi getirme
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM test WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $test = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Düzenle Test</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .content {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input[type="text"],
        .form-group input[type="file"] {
            width: calc(100% - 22px);
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .form-group input[type="file"] {
            padding: 5px;
        }

        .preview label {
            display: block;
            font-weight: bold;
        }

        .preview img {
            max-width: 200px;
            margin-top: 10px;
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
        <h2>Testi Düzenle</h2>
        <form action="edit_test.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $test['id']; ?>">
            <div class="form-group">
                <label for="word1">Kelime 1:</label>
                <input type="text" id="word1" name="word1" value="<?php echo $test['kelime1']; ?>" required>
            </div>
            <div class="form-group">
                <label for="word2">Kelime 2:</label>
                <input type="text" id="word2" name="word2" value="<?php echo $test['kelime2']; ?>" required>
            </div>
            <div class="form-group">
                <label for="word3">Kelime 3:</label>
                <input type="text" id="word3" name="word3" value="<?php echo $test['kelime3']; ?>" required>
            </div>
            <div class="form-group">
                <label for="word4">Kelime 4:</label>
                <input type="text" id="word4" name="word4" value="<?php echo $test['kelime4']; ?>" required>
            </div>
            <div class="form-group">
                <label for="image">Resim:</label>
                <input type="file" id="image" name="image" accept="image/*">
                <div class="preview">
                    <label>Önceki Resim:</label><br>
                    <?php if (!empty($test['resim'])): ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($test['resim']); ?>" alt="Önceki Resim" width="100">
                    <?php else: ?>
                        <p>Önceki resim yok.</p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-group">
                <label for="cevap">Cevap:</label>
                <input type="text" id="cevap" name="cevap" value="<?php echo $test['cevap']; ?>" required>
            </div>
            <button type="submit" name="submit">Güncelle</button>
        </form>
    </div>
</body>
</html>
