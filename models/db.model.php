<?php
$host = 'localhost';  
$db = 'EMP_management';
$port = 5432;
$user = 'postgres';  
$pass = '2005DB'; 

$dsn = "pgsql:host={$host};port={$port};dbname={$db};";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    // PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    // echo "Connected successfully!";
} catch ( PDOException $e) {
    echo "ECHO FAILED TO CONNECT TO THE DATABASE " . $e->getMessage();
}
?>
