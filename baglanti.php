<?php
$host = "localhost";
$db = "primaryEnglish";
$charset = "utf8mb4";
$user = "neslihan";
$pass = "EUy)1E.w334wv01Y"; // Şifrenizin doğru olduğundan emin olun

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $conn = new PDO($dsn, $user, $pass, $options);
   
} catch (\PDOException $e) {
    die("Veritabanına bağlanırken hata oluştu: " . $e->getMessage());
}
?>
