<?php
include 'panel_sidebar.php';
include 'baglanti.php';

// Formdan gelen verileri al
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $story_title = $_POST["story_title"];
    $story_content = $_POST["story_content"];
    $story_image_tmp = $_FILES["story_image"]["tmp_name"];

    // Dosya yüklendi mi kontrol et
    if (!empty($story_image_tmp)) {
        // Dosya içeriğini al
        $image_content = file_get_contents($story_image_tmp);

        // Veritabanına ekle
        $sql = "INSERT INTO story (baslik, hikaye, resim) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $story_title);
        $stmt->bindParam(2, $story_content);
        $stmt->bindParam(3, $image_content, PDO::PARAM_LOB);

        if ($stmt->execute()) {
            echo "Hikaye başarıyla eklendi.";
        } else {
            echo "Hata: " . $sql . "<br>" . $stmt->errorInfo()[2];
        }

        $stmt->closeCursor();
    } else {
        echo "Resim yüklenmedi.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Story</title>
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

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }


        .form-container {
            width: 100%;
            max-width: 600px;
        }


        .image-thumbnail {
            max-width: 100px;
            max-height: 100px;
        }
     

        .content {
            width: 100%;
            /* Form genişliğini ayarla */
            max-width: 900px;

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
            width: 100%;
            /* Genişletilmiş alanlar */
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

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Tik işareti için CSS sınıfı */
        .checkmark::before {
            content: '\2713';
            color: green;
        }

        /* Çarpı işareti için CSS sınıfı */
        .crossmark::before {
            content: '\2717';
            color: red;
        }

        .delete-icon {
            color: #dc3545;
        }

        .edit-icon {
            color: #007bff;
        }
    </style>
</head>

<body>
    <div class="content">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="story_title">Hikaye Başlığı:</label>
                <input type="text" id="story_title" name="story_title" placeholder="Hikaye başlığını giriniz" required>
            </div>

            <div class="form-group">
                <label for="story_content">Hikaye:</label>
                <textarea id="story_content" name="story_content" placeholder="Hikayeyi giriniz" required></textarea>
            </div>

            <div class="form-group">
                <label for="story_image">Hikaye Fotoğrafı:</label>
                <input type="file" id="story_image" name="story_image" accept="image/*" required>
            </div>

            <button type="submit" style="font-size: 18px;">Kaydet</button>
        </form>

        <table>
            <tr>
                <th>ID</th>
                <th>Başlık</th>
                <th>Hikaye</th>
                <th>Resim</th>
                <th>Düzenle</th>
                <th>Sil</th>
            </tr>
            <?php
            $sql = "SELECT id, baslik, hikaye, resim FROM story";
            $stmt = $conn->query($sql);

            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["baslik"] . "</td>";
                    echo "<td>" . ($row["hikaye"] ? "Hikaye Eklenmiştir" : "") . "</td>";
                    echo "<td>";
                    if (!empty($row["resim"])) {
                        echo "<span class='checkmark'></span>";
                    } else {
                        echo "<span class='crossmark'></span>";
                    }
                    echo "</td>";
                    echo "<td><span class='edit-icon' data-id='" . $row["id"] . "'><i class='fas fa-edit'></i></span></td>";
                    echo "<td><span class='delete-icon' data-id='" . $row["id"] . "'><i class='fas fa-trash-alt'></i></span></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Veri bulunamadı.</td></tr>";
            }
            ?>
        </table>
    </div>
    <script>
// Düzenleme işlevi
document.querySelectorAll('.edit-icon').forEach(item => {
    item.addEventListener('click', event => {
        var id = item.getAttribute('data-id');
        if (id) { // ID var mı kontrol et
            window.location.href = 'edit_story.php?id=' + id;
        } else {
            console.error("Kelime ID'si alınamadı.");
        }
        event.stopPropagation();
    });
});

// Silme işlevi
document.querySelectorAll('.delete-icon').forEach(item => {
    item.addEventListener('click', event => {
        var id = item.getAttribute('data-id');
        if (id) { // ID var mı kontrol et
            if(confirm("Bu hikayeyi silmek istediğinizden emin misiniz?")){
                // Silme işlemini gerçekleştir
                window.location.href = 'delete_story.php?id=' + id;
            }
        } else {
            console.error("Kelime ID'si alınamadı.");
        }
        // Olayın daha fazla işlenmemesi için olayın yayılmasını durdur
        event.stopPropagation();
    });
});
</script>
</body>

</html>
