<?php
$host = '54.255.188.197';
$dbname = 'leakdata_epu';
$username = 'leakdata_epu';
$password = 'sv_nam_hi';

// Kết nối đến cơ sở dữ liệu
$conn = new mysqli($host, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die('Kết nối thất bại: ' . $conn->connect_error);
}

// Lấy giá trị tìm kiếm từ ô input
$search = '%' . $_GET['search'] . '%';

// Sử dụng Prepared Statements để tránh SQL Injection
$stmt = $conn->prepare("SELECT * FROM students WHERE class LIKE ?");
$stmt->bind_param('s', $search);
$stmt->execute();
$result = $stmt->get_result();

// Kiểm tra kết quả tìm kiếm
if ($result->num_rows > 0) {
    // Bắt đầu tạo bảng hiển thị kết quả
    $output = '<table class="table table-bordered">';
    $output .= '<thead class="thead-dark">
                    <tr>
                        <th>Mã sinh viên</th>
                        <th>Họ</th>
                        <th>Tên</th>
                        <th>Lớp</th>
                        <th>Khoa</th>
                    </tr>
                </thead>
                <tbody>';

    // Duyệt qua từng dòng kết quả và tạo hàng trong bảng
    while ($row = $result->fetch_assoc()) {
        $output .= '<tr>
                        <td>' . htmlspecialchars($row['student_id']) . '</td>
                        <td>' . htmlspecialchars($row['last_name']) . '</td>
                        <td>' . htmlspecialchars($row['first_name']) . '</td>
                        <td>' . htmlspecialchars($row['class']) . '</td>
                        <td>' . htmlspecialchars($row['department_name']) . '</td>
                    </tr>';
    }
    
    $output .= '</tbody></table>'; // Kết thúc bảng
} else {
    // Trường hợp không tìm thấy kết quả
    $output = '<p>Không tìm thấy kết quả.</p>';
}

// Trả kết quả về cho AJAX
echo $output;

// Đóng kết nối
$stmt->close();
$conn->close();
?>
