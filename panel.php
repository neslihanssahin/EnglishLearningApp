<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelime Paneli</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 95%;
            max-width: 1400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .checkmark, .crossmark {
            width: 25px;
            height: 25px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }

        .checkmark::after {
            content: "\2713";
            font-size: 18px;
            color: white;
        }

        .crossmark::after {
            content: "\2717";
            font-size: 18px;
            color: white;
        }

        .checkmark {
            background-color: #28a745;
        }

        .crossmark {
            background-color: #dc3545;
        }

        .edit-icon, .delete-icon {
            display: inline-block;
            margin-left: 10px;
            cursor: pointer;
        }

        .edit-icon i, .delete-icon i {
            color: #007bff;
        }

        .edit-form {
            display: none;
        }

        .edit-form input[type="text"] {
            font-size: 18px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <?php include 'panel_sidebar.php'; 
     include 'baglanti.php'; 

    ?>

    <div class="container">
        <h1>Kelime Girişi</h1>
        <?php
        // Formdan gelen verileri al
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $metin = $_POST["metin"];
            $dosya = $_FILES["dosya"]["tmp_name"];
            
            // Dosya yüklendi mi kontrol et
            if (!empty($dosya)) {
                $dosyaIcerik = file_get_contents($dosya);
                
                // Veritabanına ekle
                $sql = "INSERT INTO words (kelime, resim) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(1, $metin);
                $stmt->bindParam(2, $dosyaIcerik, PDO::PARAM_LOB);
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
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="metin">Metin Giriniz:</label>
                <input type="text" id="metin" required name="metin" placeholder="Metin giriniz..." style="font-size: 18px;">
            </div>
            <div class="form-group">
                <label for="dosya">Dosya Seçiniz:</label>
                <input type="file" id="dosya" name="dosya" style="font-size: 18px;">
            </div>
            <button type="submit" style="font-size: 18px;">Kaydet</button>
        </form>
    </div>
    <div class="container">
        <h1>Liste</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Kelime</th>
                <th>Resim</th>
                <th>Düzenle</th>
                <th>Sil</th>
            </tr>
            <?php
            $sql = "SELECT id, kelime, resim FROM words";
            $stmt = $conn->query($sql);

            if ($stmt->rowCount() > 0) {
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["kelime"] . "</td>";
                    echo "<td>";
                    if (!empty($row["resim"])) {
                        echo "<div class='checkmark'></div>";
                    } else {
                        echo "<div class='crossmark'></div>";
                    }
                    echo "</td>";
                    echo "<td><span class='edit-icon'><i class='fas fa-edit'></i></span></td>";
                    echo "<td><span class='delete-icon'><i class='fas fa-trash-alt'></i></span></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Veri bulunamadı.</td></tr>";
            }
            ?>
        </table>
    </div>

    <script>
    // Düzenle ikonuna tıklandığında
    document.querySelectorAll('.edit-icon').forEach(item => {
        item.addEventListener('click', event => {
            // Düzenleme formunu göster
            document.getElementById('editForm').style.display = 'block';
        });
    });

    // Sil ikonuna tıklandığında
    document.querySelectorAll('.delete-icon').forEach(item => {
        item.addEventListener('click', event => {
            // Silme işlemini gerçekleştir
            // Bu kısım henüz kodlanmadı, eklenebilir.
        });
    });
</script>

</body>
</html>
