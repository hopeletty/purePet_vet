<?php
// Define your database credentials
$host = 'localhost';
$db = 'purepet';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// Set up the DSN (Data Source Name)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// Function to open a new connection to the database
function openConnection() {
    global $dsn, $user, $pass, $options;
    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
        return $pdo;
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
}

// Function to close the connection (optional, since PDO automatically closes the connection at the end of the script)
function closeConnection(&$pdo) {
    $pdo = null;
}
?>
