<?php
function getPDO() {
    static $pdo = null;
    if ($pdo === null) {
        $servername = 'localhost';
        $username = 'root';
        $password = '';
        $dbname = 'tablepetanque';
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    return $pdo;
}
?>
