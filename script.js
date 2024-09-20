function connectToServer(serverAddress) {
    // Tạo URL steam để kết nối tới server CS:GO
    const steamUrl = 'steam://connect/' + serverAddress;
    window.location.href = steamUrl;
}
async function checkServerStatus(serverAddress, buttonId) {
    try {
        const response = await fetch(`http://localhost:3000/server-status?host=${serverAddress.split(':')[0]}&port=${serverAddress.split(':')[1]}`);
        const data = await response.json();

        if (data.onlinePlayers !== undefined) {
            document.getElementById(buttonId).classList.remove('offline');
        } else {
            document.getElementById(buttonId).classList.add('offline');
        }
    } catch (error) {
        document.getElementById(buttonId).classList.add('offline');
    }
}

document.addEventListener("DOMContentLoaded", function() {
    checkServerStatus('160.25.85.100:27015', 'connect-button-1');
    checkServerStatus('160.25.85.100:27017', 'connect-button-2');
    checkServerStatus('160.25.85.100:27019', 'connect-button-3');
});
let currentServer = ''; // Biến để lưu tên server hiện tại

  const modal = document.getElementById('modal');
  const closeModal = document.getElementById('closeModal');

  // Hàm mở modal và lưu server hiện tại
  function openModal(serverName) {
    currentServer = serverName; // Lưu lại server hiện tại
    document.getElementById('modalTitle').textContent = `Enter Password for ${serverName}`;
    modal.style.display = 'flex';
  }

  // Đóng modal khi bấm nút "X"
  closeModal.addEventListener('click', () => {
    modal.style.display = 'none';
  });

  // Đóng modal khi bấm ra ngoài
  window.addEventListener('click', (event) => {
    if (event.target === modal) {
      modal.style.display = 'none';
    }
  });

  // Hàm kiểm tra mật khẩu dựa trên server hiện tại
  function validatePassword() {
    const password = document.getElementById('password').value;
    const errorMsg = document.getElementById('error-msg');

    // Mật khẩu cho từng server
    const passwords = {
      'Server 1': '123456',
      'Server 2': '',
      'Server 3': '',
      'Server 4': '123456',
      'Server 5': '123456'
    };
    const serverAddresses = {
        'Server 1': 'steam://connect/160.25.85.100:27015',
        'Server 2': 'steam://connect/160.25.85.100:27017',
        'Server 3': 'steam://connect/160.25.85.100:27019',
        'Server 4': 'steam://connect/160.25.85.100:27021', 
        'Server 5': 'steam://connect/160.25.85.100:27023'
      };

    // Kiểm tra mật khẩu
    if (password === passwords[currentServer]) {
      window.location.href =serverAddresses[currentServer]; // Điều hướng đến server tương ứng
    } else {
      errorMsg.style.display = 'block'; // Hiển thị thông báo lỗi
    }
  }