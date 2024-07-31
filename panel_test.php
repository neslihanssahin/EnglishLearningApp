<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Test</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .content {
            width: 100%;
            max-width: 900px;
            margin-top: 150px;
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
            width: calc(100% - 22px); /* Adjusted width */
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .checkmark::before {
            content: '\2713';
            color: green;
        }

        .crossmark::before {
            content: '\2717';
            color: red;
        }

        .delete-icon, .edit-icon {
            cursor: pointer;
            margin-right: 5px;
        }

        .delete-icon::before {
            content: '\f2ed';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            color: red;
        }

        .edit-icon::before {
            content: '\f044';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            color: blue;
        }
    </style>
</head>
<body>
    <div class="content">
        <?php
        // Veritabanı bağlantısı
        include 'baglanti.php';
        include 'panel_sidebar.php';


        // Form verilerini işleme
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $word1 = $_POST["word1"];
            $word2 = $_POST["word2"];
            $word3 = $_POST["word3"];
            $word4 = $_POST["word4"];
            $image = $_FILES["image"]["tmp_name"];
            $cevap = $_POST["cevap"]; // Yeni eklenen cevap sütunu için değeri al
            
            if (!empty($image)) {
                $imageContent = file_get_contents($image);

                $sql = "INSERT INTO test (kelime1, kelime2, kelime3, kelime4, resim, cevap) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(1, $word1);
                $stmt->bindParam(2, $word2);
                $stmt->bindParam(3, $word3);
                $stmt->bindParam(4, $word4);
                $stmt->bindParam(5, $imageContent, PDO::PARAM_LOB);
                $stmt->bindParam(6, $cevap); // Cevap sütunu için bağlayıcıyı ekleyin

                if ($stmt->execute()) {
                    echo "Veri başarıyla eklendi.";
                } else {
                   
                    echo "Hata: " . $sql . "<br>" . $stmt->errorInfo()[2];
                }
                $stmt->closeCursor();
            } else {
                echo "Dosya yüklenmedi.";
            }
        }
        ?>

        <form action="panel_test.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="word1">Kelime 1:</label>
                <input type="text" id="word1" name="word1" placeholder="Kelime 1 i giriniz" required>
            </div>
            <div class="form-group">
                <label for="word2">Kelime 2:</label>
                <input type="text" id="word2" name="word2" placeholder="Kelime 2 yi giriniz" required>
            </div>
            <div class="form-group">
                <label for="word3">Kelime 3:</label>
                <input type="text" id="word3" name="word3" placeholder="Kelime 3 ü giriniz" required>
            </div>
            <div class="form-group">
                <label for="word4">Kelime 4:</label>
                <input type="text" id="word4" name="word4" placeholder="Kelime 4 ü giriniz" required>
            </div>
            <div class="form-group">
                <label for="image">Fotoğraf:</label>
                <input type="file" id="image" name="image" accept="image/*" required>
            </div>
            <!-- Yeni cevap alanı ekleyin -->
            <div class="form-group">
                <label for="cevap">Cevap:</label>
                <input type="text" id="cevap" name="cevap" placeholder="Cevap giriniz" required>
            </div>
            <!-- Yeni cevap alanı eklendi -->

            <button type="submit">Gönder</button>
        </form>

        <table>
            <tr>
                <th>ID</th>
                <th>Kelime 1</th>
                <th>Kelime 2</th>
                <th>Kelime 3</th>
                <th>Kelime 4</th>
                <th>Resim</th>
                <th>Cevap</th> <!-- Tabloya cevap sütununu ekleyin -->
                <th>Düzenle</th>
                <th>Sil</th>
            </tr>
            <?php
            // Veritabanından verileri çekme sorgusu
            $sql = "SELECT id, kelime1, kelime2, kelime3, kelime4, resim, cevap FROM test"; // Cevap sütununu al
            $stmt = $conn->query($sql);

            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["kelime1"] . "</td>";
                    echo "<td>" . $row["kelime2"] . "</td>";
                    echo "<td>" . $row["kelime3"] . "</td>";
                    echo "<td>" . $row["kelime4"] . "</td>";
                    echo "<td>";
                    if (!empty($row["resim"])) {
                        echo "<div class='checkmark'></div>";
                    } else {
                        echo "<div class='crossmark'></div>";
                    }
                    echo "</td>";
                    echo "<td>" . $row["cevap"] . "</td>"; // Cevap sütununu tabloya ekle
                    echo "<td><span class='edit-icon' onclick='editFunction(" . $row["id"] . ")'></span></td>";
                    echo "<td><span class='delete-icon' onclick='deleteFunction(" . $row["id"] . ")'></span></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>Veri bulunamadı.</td></tr>";
            }
            ?>
        </table>
    </div>

    <!-- JavaScript ile düzenleme ve silme işlemleri yapılacak -->
    <script>
        // Düzenleme işlevi
        function editFunction(id) {
            if (id) { // ID var mı kontrol et
                window.location.href = 'edit_test.php?id=' + id;
            } else {
                console.error("Test ID'si alınamadı.");
            }
        }

        // Silme işlevi
        function deleteFunction(id) {
            if (id) { // ID var mı kontrol et
                if (confirm("Bu kelimeyi silmek istediğinizden emin misiniz?")) {
                    // Silme işlemini gerçekleştir
                    window.location.href = 'delete_test.php?id=' + id;
                }
            } else {
                console.error("Test ID'si alınamadı.");
            }
        }
    </script>
</body>
</html>
