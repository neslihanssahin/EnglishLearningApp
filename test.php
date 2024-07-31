<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
include 'baglanti.php'; // Veritabanı bağlantı dosyanız

// Puan kutusu için mevcut puanı al
if (!isset($_SESSION['puan'])) {
    $_SESSION['puan'] = 0;
}
$puan = $_SESSION['puan'];

// Üst kutu için resmi çek
$sql_resim = "SELECT resim FROM test WHERE id=1";
$result_resim = $conn->query($sql_resim);
$resim_verisi = "";
if ($result_resim->rowCount() > 0) {
    $row = $result_resim->fetch(PDO::FETCH_ASSOC);
    $resim_verisi = $row['resim'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id'])) {
        $id = intval($_POST['id']);
        $sql = "SELECT id, kelime1, kelime2, kelime3, kelime4, resim, cevap FROM test WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $data = array();
        if ($row) {
            $data = array(
                'kelime1' => $row['kelime1'],
                'kelime2' => $row['kelime2'],
                'kelime3' => $row['kelime3'],
                'kelime4' => $row['kelime4'],
                'resim' => base64_encode($row['resim']),
                'cevap' => $row['cevap']
            );
        } else {
            echo json_encode(new stdClass); // Veri bulunamadıysa boş bir JSON nesnesi gönder
            exit();
        }
        echo json_encode($data);
        exit();
    } elseif (isset($_POST['increase_puan'])) {
        $_SESSION['puan'] += intval($_POST['increase_puan']);
        echo $_SESSION['puan'];
        exit();
    } elseif (isset($_POST['decrease_puan'])) {
        $_SESSION['puan'] -= intval($_POST['decrease_puan']);
        echo $_SESSION['puan'];
        exit();
    }
}

// Silinen veriden sonraki tüm verilerin ID'lerini güncelle
$sql_update_ids = "SET @num := 0; UPDATE test SET id = @num := (@num+1); ALTER TABLE test AUTO_INCREMENT = 1;";
$conn->exec($sql_update_ids);

// Son ID'yi al
$sql_last_id = "SELECT MAX(id) AS max_id FROM test";
$result_last_id = $conn->query($sql_last_id);
$last_id_row = $result_last_id->fetch(PDO::FETCH_ASSOC);
$last_id = $last_id_row['max_id'];

// Örnek verileri al (Başlangıç olarak ilk ID)
$sql = "SELECT id, kelime1, kelime2, kelime3, kelime4, cevap FROM test WHERE id=1";
$result = $conn->query($sql);
$veriler = array();
if ($result->rowCount() > 0) {
    $veriler[] = $row = $result->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>TEST</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        #arrow-right,
        #arrow-left {
            font-size: 150px;
            position: absolute;
            bottom: 30px;
            cursor: pointer;
            color: white;
            z-index: 999;
        }

        #arrow-right {
            right: 70px;
        }

        #arrow-left {
            left: 70px;
        }

        body {
            background-color: rgb(216, 0, 50);
            display: flex;
            height: 100vh;
            margin: 0;
            flex-direction: column;
            align-items: center;
        }

        .kutu-container {
            width: calc(100% - 70px);
            height: calc(100% - 70px);
            margin: 35px;
            background-color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .kutu-row {
            display: flex;
            justify-content: center;
            width: 100%;
        }

        .kutu {
            width: 300px;
            height: 100px;
            background-color: rgb(255, 137, 17);
            border-radius: 10px;
            text-align: center;
            line-height: 100px;
            color: white;
            font-weight: bold;
            font-size: 30px;
            display: flex;
            justify-content: center;
            margin-right: 30px;
            margin-bottom: 30px;
            cursor: pointer;
        }

        .kutu1 {
            background-color: rgb(255, 137, 17);
        }

        .kutu2 {
            background-color: rgb(45, 149, 150);
        }

        .kutu3 {
            background-color: rgb(216, 0, 50);
        }

        .kutu4 {
            background-color: rgb(134, 70, 156);
        }

        .kutu:nth-child(2n) {
            margin-right: 10px;
        }

        .kutu:nth-last-child(-n+2) {
            margin-bottom: 30px;
        }

        .kutu:hover {
            transform: scale(1.1);
            opacity: 0.7;
            font-size: 30px;
        }

        .ust-kutu {
            width: 400px;
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

        .ust-kutu img {
            width: 100%;
            height: 100%;
            border-radius: 10px;
            box-sizing: border-box;
        }

        .puan-kutu {
            text-align: center;
            color: black;
            font-size: 40px;
            width: 100px;
            height: 50px;
            border-radius: 5px;
            background-color: white;
            position: absolute;
            top: 5px;
            right: 5px;
            border: 5px solid blue;
        }
    </style>
</head>

<body>
    <audio id="alkis-sesi" src="mp3/alkis-sesi.mp3"></audio>
    <audio id="hata-sesi" src="mp3/hata-sesi.mp3"></audio>

    <div class="kutu-container">
        <div class="puan-kutu"><?php echo $puan; ?></div>
        <div class="ust-kutu">
            <?php if (!empty($resim_verisi)) {
                echo '<img src="data:image/jpeg;base64,' . base64_encode($resim_verisi) . '" alt="Resim">';
            } ?>
        </div>
        <div class="kutu-row">
            <div class="kutu kutu1"><?php echo $veriler[0]['kelime1'] ?? ''; ?></div>
            <div class="kutu kutu2"><?php echo $veriler[0]['kelime2'] ?? ''; ?></div>
        </div>
        <div class="kutu-row">
            <div class="kutu kutu3"><?php echo $veriler[0]['kelime3'] ?? ''; ?></div>
            <div class="kutu kutu4"><?php echo $veriler[0]['kelime4'] ?? ''; ?></div>
        </div>
    </div>
    <i class="fas fa-arrow-right" id="arrow-right"></i>
    <i class="fas fa-arrow-left" id="arrow-left"></i>

    <script>
        let id = 1; // Başlangıç ID'si
        let lastId = <?php echo $last_id; ?>; // Son ID
        let currentAnswer = "<?php echo $veriler[0]['cevap'] ?? ''; ?>"; // Mevcut cevabı sakla

        $('#arrow-right').click(function() {
            id++;
            if (id > lastId) {
                id = 1;
            }
            updateData(id);
        });

        $('#arrow-left').click(function() {
            id--;
            if (id < 1) {
                id = lastId;
            }
            updateData(id);
        });

        function updateData(id) {
            $.ajax({
                type: "POST",
                url: "", // POST isteğinin yapıldığı URL
                data: {
                    id: id
                },
                success: function(response) {
                    console.log("Server response:", response);
                    try {
                        var veriler = JSON.parse(response);
                        $('.kutu1').text(veriler.kelime1);
                        $('.kutu2').text(veriler.kelime2);
                        $('.kutu3').text(veriler.kelime3);
                        $('.kutu4').text(veriler.kelime4);
                        currentAnswer = veriler.cevap; // Mevcut cevabı güncelle
                        if (veriler.resim) {
                            $('.ust-kutu img').attr('src', 'data:image/jpeg;base64,' + veriler.resim);
                        }
                    } catch (e) {
                        console.error("Error parsing JSON!", e);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error:", status, error);
                }
            });
        }

        $('.kutu').click(function() {
            let clickedWord = $(this).text().trim().toLowerCase(); // Tıklanan kelimeyi küçük harfe çevir
            let currentAnswerLowerCase = currentAnswer.trim().toLowerCase(); // Mevcut cevabı küçük harfe çevir

            if (clickedWord === currentAnswerLowerCase) {
                document.getElementById('alkis-sesi').play();
                $.ajax({
                    type: "POST",
                    url: "",
                    data: {
                        increase_puan: 10
                    },
                    success: function(newPuan) {
                        $('.puan-kutu').text(newPuan);
                        // Doğru cevap verildi, bir sonraki soruya geç
                        id++;
                        if (id > lastId) {
                            id = 1;
                        }
                        updateData(id);
                    }
                });
            } else {
                document.getElementById('hata-sesi').play();
                $.ajax({
                    type: "POST",
                    url: "",
                    data: {
                        decrease_puan: 5
                    },
                    success: function(newPuan) {
                        $('.puan-kutu').text(newPuan);
                        // Yanlış cevap verildi, bir sonraki soruya geç
                        id++;
                        if (id > lastId) {
                            id = 1;
                        }
                        updateData(id);
                    }
                });
            }
        });
    </script>
</body>
</html>
