
<?php 
include 'baglanti.php';

// Veri çekme sorgusu (puanı en yüksekten en düşüğe doğru sıralıyoruz)
$sql = "SELECT ogr_adi, ogr_soyadi, puan FROM list ORDER BY puan DESC";
$result = $conn->query($sql);
$conn = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIST</title>
    <style>
        body {
            background-color: rgb(134, 70, 156);
            display: flex;
            height: 100vh;
            margin: 0;
            flex-direction: column; /* Sütun şeklinde yerleştirme */
            align-items: center;
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
            background-color:rgb(16, 67, 159);
            color: #fff;
        }
        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tbody tr:hover {
            background-color: #ddd;
        }
        

     
        

    </style>
</head>
<body>
    <div class="kutu-container">
    <div class="kutu-container">
        <h2>Öğrenci Listesi</h2>
        <table>
            <thead>
                <tr>
                    <th>Sıra</th>
                    <th>Öğrenci Adı</th>
                    <th>Öğrenci Soyadı</th>
                    <th>Puan</th>
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
                         echo '</tr>';
                         $sira++; // Sıra numarasını artır
                     }
                 } else {
                     echo '<tr><td colspan="4">Veri bulunamadı.</td></tr>';
                 }
                 ?>
            </tbody>
        </table>
    </div>
    </div>
    
</body>
</html>
