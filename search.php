<?php
$host = '54.255.188.197';
$dbname = 'leakdata_epu';
$username = 'leakdata_epu';
$password = 'sv_nam_hi';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['q'])) {
        $query = $_GET['q'];
        $stmt = $conn->prepare("SELECT DISTINCT class FROM students WHERE class LIKE :query LIMIT 5");
        $stmt->execute(['query' => '%' . $query . '%']);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $stmt = $conn->prepare("SELECT * FROM students WHERE class LIKE :search");
        $stmt->execute(['search' => '%' . $search . '%']);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
