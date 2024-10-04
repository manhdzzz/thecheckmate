<?php
$host = '54.255.188.197';
$dbname = 'leakdata_epu';
$username = 'leakdata_epu';
$password = 'sv_nam_hi';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die('Kết nối thất bại: ' . $conn->connect_error);
}

$query = '%' . $_GET['query'] . '%'; // Thêm ký tự wildcard cho LIKE

// Sử dụng Prepared Statements để ngăn chặn SQL Injection
$stmt = $conn->prepare("SELECT DISTINCT class FROM students WHERE class LIKE ? LIMIT 5");
$stmt->bind_param('s', $query);
$stmt->execute();
$result = $stmt->get_result();

$suggestions = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $suggestions .= '<div class="suggestion-item">' . htmlspecialchars($row['class']) . '</div>';
    }
}

echo $suggestions;

$stmt->close();
$conn->close();
?>
