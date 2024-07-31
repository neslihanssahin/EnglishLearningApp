<?php 
include 'baglanti.php';

// Veri çekme sorgusu (puanı en yüksekten en düşüğe doğru sıralıyoruz)
$sql = "SELECT ogr_adi, ogr_soyadi, puan FROM list ORDER BY puan DESC";
$result = $conn->query($sql);

// Bağlantıyı kapatma işlemini yapmadan önce $result üzerinde işlem yapacağımız için bu satırı yukarıda taşıdık

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Story</title>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5/GL5/Nc4e3NPOzGgFt3BvjLgxMlhfgYmTf6fK5G" crossorigin="anonymous">
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
            max-width: 600px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .kutu-container{
            width: calc(100% - 70px); /* Ekrandan 30px kenar boşluğu sağlamak için */
            height: calc(100% - 70px); /* Ekrandan 30px kenar boşluğu sağlamak için */
            margin: 35px; /* Kenar boşluğu */
            background-color: white;
            display: flex;
            flex-direction: column; /* Sütun şeklinde yerleştirme */
            align-items: center;
        }
     
        table {
            text-align: center;
            width: 100%;
            margin-top: 20px;
            background-color: #f0f0f0;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: rgb(16, 67, 159);
            color: #fff;
        }
        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tbody tr:hover {
            background-color: #ddd;
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
    <?php include 'panel_sidebar.php'; ?>

    <div class="kutu-container">
        <h2>Öğrenci Listesi</h2>
        <div class="table-container"> <!-- Tablo konteynerini ekliyoruz -->
            <table>
                <thead>
                    <tr>
                        <th>Sıra</th>
                        <th>Öğrenci Adı</th>
                        <th>Öğrenci Soyadı</th>
                        <th>Puan</th>
                        <th>Sil</th>
                        <th>Düzenle</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sira = 1;
                    if ($result->rowCount() > 0) {
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            echo '<tr>';
                            echo '<td>' . $sira . '</td>';
                            echo '<td>' . htmlspecialchars($row['ogr_adi']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['ogr_soyadi']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['puan']) . '</td>';
                            echo "<td><span class='edit-icon'><i class='fas fa-edit'></i></span></td>";
                            echo "<td><span class='delete-icon'><i class='fas fa-trash-alt'></i></span></td>";
                            echo '</tr>';
                            $sira++; // Sıra numarasını artır
                        }
                    } else {
                        echo '<tr><td colspan="6">Veri bulunamadı.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
