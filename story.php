<?php
include 'baglanti.php';

// Veritabanından verileri ve resimleri çek
$sql = "SELECT id, baslik, hikaye, resim FROM story ORDER BY id ASC";
$result = $conn->query($sql);
$hikayeler = [];

if ($result->rowCount() > 0) {
    $i = 1; // Ardışık id
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $hikayeler[$i] = array(
            "id" => $row["id"],
            "baslik" => $row["baslik"],
            "hikaye" => $row["hikaye"],
            "resim" => base64_encode($row['resim']) // Resimleri Base64 formatına çevir
        );
        $i++;
    }
} else {
    echo "0 sonuç";
}

// Son ID'yi al
$last_id = count($hikayeler);
$conn = null; // Bağlantıyı kapat
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Story Teller</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        body {
            background-color: rgb(45, 149, 150);
            display: flex;
            height: 100vh;
            margin: 0;
            flex-direction: column;
            align-items: center;
        }

        .kutu-container {
            width: calc(100% - 70px);
            height: calc(100% - 70px);
            margin: 35px auto;
            background-color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .kutu {
            width: 300px;
            height: 300px;
            margin: 20px;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgb(255, 235, 178);
            position: relative;
            padding: 20px;
        }

        .kutu img {
            max-width: 100%;
            max-height: 100%;
            border-radius: 10px;
            box-sizing: border-box;
        }

        .kutu1 {
            background-color: rgb(255, 235, 178);
            width: 800px;
            height: 400px;
            padding: 20px;
            overflow: auto;
            margin-bottom: 20px;
            border-radius: 10px;
            text-align: left;
        }

        #arrow-right,
        #arrow-left {
            font-size: 150px;
            position: absolute;
            bottom: 30px;
            cursor: pointer;
            color: #555;
        }

        #arrow-right:hover,
        #arrow-left:hover {
            color: #333;
        }

        #arrow-right {
            right: 70px;
        }

        #arrow-left {
            left: 70px;
        }

        #volume-high {
            font-size: 100px;
            position: absolute;
            top: 50px;
            left: 50px;
        }
    </style>
</head>

<body>
    <div class="kutu-container">
        <i class="fa fa-volume-high" id="volume-high"></i>
        <div class="kutu">
            <img id="image-display" src="data:image/jpeg;base64,<?php echo $hikayeler[1]['resim'] ?? ''; ?>" alt="Story Image">
        </div>
        <div class="kutu1" id="story-display">
            <h2><?php echo $hikayeler[1]["baslik"] ?? ''; ?></h2>
            <p><?php echo $hikayeler[1]["hikaye"] ?? ''; ?></p>
        </div>
    </div>
    <i class="fas fa-arrow-right" id="arrow-right"></i>
    <i class="fas fa-arrow-left" id="arrow-left"></i>

    <script>
        let currentIndex = 1;
        let hikayeler = <?php echo json_encode($hikayeler); ?>;
        let last_id = <?php echo $last_id; ?>;

        $('#arrow-right').click(function() {
            currentIndex++;
            if (currentIndex > last_id) {
                currentIndex = 1;
            }
            updateDisplay();
        });

        $('#arrow-left').click(function() {
            currentIndex--;
            if (currentIndex < 1) {
                currentIndex = last_id;
            }
            updateDisplay();
        });

        function updateDisplay() {
            $('#story-display').html('<h2>' + hikayeler[currentIndex]["baslik"] + '</h2><p>' + hikayeler[currentIndex]["hikaye"] + '</p>');
            $('#image-display').attr('src', 'data:image/jpeg;base64,' + hikayeler[currentIndex]['resim']);
        }
    </script>
</body>
</html>