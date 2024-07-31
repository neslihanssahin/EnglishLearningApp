<?php
include 'baglanti.php';

// Veritabanından verileri ve resimleri çek
$sql = "SELECT id, kelime, resim FROM words ORDER BY id ASC";
$result = $conn->query($sql);

$kelimeler = array();
$resimler = array();
$rowCount = 0;
if ($result) {
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $kelimeler[] = $row["kelime"];
        $resimler[] = base64_encode($row['resim']);
        $rowCount++;
    }
} else {
    echo "0 sonuç";
}

// Son ID'yi al
$last_id = !empty($kelimeler) ? $rowCount - 1 : 0;

// Bağlantıyı kapat
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learn Words</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        body {
            background-color: rgb(255, 137, 17);
            display: flex;
            height: 100vh;
            margin: 0;
            flex-direction: column;
            align-items: center;
        }
        .kutu-container{
            width: calc(100% - 70px);
            height: calc(100% - 70px);
            margin: 35px;
            background-color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .kutu {
            width: 400px;
            height: 300px;
            margin: 40px auto 0;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgb(255, 235, 178);
            position: relative;
            padding: 20px;
        }
        .kutu img {
            width: 100%;
            height: 100%;
            border-radius: 10px;
            box-sizing: border-box;
        }
        .kutu1 {
            width: 200px;
            height: 70px;
            margin-top: 10px;
            background-color: rgb(255, 137, 17);
            border-radius: 10px;
            text-align: center;
            line-height: 70px;
            color: white;
            font-weight: bold;
            font-size: 30px;
        }
        #arrow-right {
            font-size: 150px;
            position: absolute;
            bottom: 30px;
            right: 70px;
        }
        #arrow-left {
            font-size: 150px;
            position: absolute;
            bottom: 30px;
            left: 70px;
        }
        #volume-high{
            margin-top: 50px;
            font-size: 120px;
            position: left;
        }
    </style>
</head>
<body>
<div class="kutu-container">
    <div class="kutu">
        <img id="image-display" src="data:image/jpeg;base64,<?php echo $resimler[0]; ?>" alt="Kelime Resmi">
    </div>
    <div class="kutu1" id="word-display"><?php echo $kelimeler[0]; ?></div>
    <i class="fa-solid fa-volume-high" id="volume-high"></i>
</div>

<i class="fas fa-arrow-right" id="arrow-right"></i>
<i class="fas fa-arrow-left" id="arrow-left"></i>


<script>
    let currentIndex = 0;
    let kelimeler = <?php echo json_encode($kelimeler); ?>;
    let resimler = <?php echo json_encode($resimler); ?>;

    $('#arrow-right').click(function () {
        currentIndex++;
        if (currentIndex > <?php echo $last_id; ?>) {
            currentIndex = 0;
        }
        $('#word-display').text(kelimeler[currentIndex]);
        $('#image-display').attr('src', 'data:image/jpeg;base64,' + resimler[currentIndex]);
    });

    $('#arrow-left').click(function () {
        currentIndex--;
        if (currentIndex < 0) {
            currentIndex = <?php echo $last_id; ?>;
        }
        $('#word-display').text(kelimeler[currentIndex]);
        $('#image-display').attr('src', 'data:image/jpeg;base64,' + resimler[currentIndex]);
    });
</script>

</body>
</html>
