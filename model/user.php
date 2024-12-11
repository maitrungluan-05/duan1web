<?php
require_once 'pdo.php'; // Kết nối tới Database class

class UserModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Cập nhật mật khẩu
    public function updatePassword($id, $newpass_hash) {
        $sql = "UPDATE user SET password = ? WHERE id = ?";
        $this->db->update($sql, [$newpass_hash, $id]);
    }

    // Cập nhật thông tin người dùng
    public function updateUser($id, $fullname, $sdt, $diachi, $email) {
        $sql = "UPDATE user SET fullname = ?, phone = ?, diachi = ?, email = ? WHERE id = ?";
        $this->db->update($sql, [$fullname, $sdt, $diachi, $email, $id]);
    }

    // Lấy tất cả người dùng
    public function getAllUsers($new = 0) {
        $sql = "SELECT * FROM user";
        if ($new == 1) {
            $sql .= " ORDER BY id DESC LIMIT 7";
        }
        return $this->db->getAll($sql);
    }

    // Lấy thông tin người dùng theo ID
    public function getUserById($user_id) {
        $sql = "SELECT * FROM user WHERE id = ?";
        return $this->db->getOne($sql, [$user_id]);
    }

    // Kiểm tra xem người dùng đã đăng nhập hay chưa
    public static function isUserLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    // Cập nhật vai trò người dùng
    public function updateUserRole($id, $new_role) {
        $sql = "UPDATE user SET role = ? WHERE id = ?";
        $this->db->update($sql, [$new_role, $id]);
    }

    // Cập nhật trạng thái người dùng
    public function updateUserStatus($id, $new_status) {
        $sql = "UPDATE user SET status = ? WHERE id = ?";
        $this->db->update($sql, [$new_status, $id]);
    }

    // Đăng ký người dùng mới
    public function registerUser($fullname, $email, $phone, $username, $password, $role = 0) {
        // Kiểm tra mật khẩu
        if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%^&*(),.?":{}|<>]{6,}$/', $password)) {
            return "Mật khẩu phải có ít nhất 6 ký tự, bao gồm ít nhất một số, một chữ cái in hoa và một ký tự đặc biệt";
        }

        // Kiểm tra tên đăng nhập
        if (!preg_match('/^[0-9A-Za-z!@#$%^&*(),.?":{}|<>]+$/', $username)) {
            return "Tên đăng nhập không hợp lệ";
        }

        // Kiểm tra tên đăng nhập đã tồn tại chưa
        if ($this->usernameExists($username)) {
            return "Tên đăng nhập đã tồn tại";
        }

        // Kiểm tra email hợp lệ
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Địa chỉ email không hợp lệ";
        }

        // Kiểm tra số điện thoại
        if (!preg_match('/^[0-9]{10,11}$/', $phone)) {
            return "Số điện thoại không hợp lệ";
        }

        // Hash mật khẩu
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Thực hiện đăng ký người dùng
        $sql = "INSERT INTO user (fullname, email, phone, username, password, role) VALUES (?, ?, ?, ?, ?, ?)";
        try {
            $this->db->insert($sql, [$fullname, $email, $phone, $username, $hashed_password, $role]);
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    // Đăng nhập người dùng
    public function loginUser($username, $password) {
        // Lấy thông tin người dùng theo username
        $user = $this->getUserByUsername($username);
    
        // Kiểm tra nếu tìm thấy người dùng
        if ($user) {
            // So sánh mật khẩu đã nhập với mật khẩu đã lưu (hashed) trong cơ sở dữ liệu
            if (password_verify($password, $user['password'])) {
                // Đăng nhập thành công, thiết lập session
                $_SESSION['login_attempts'] = 0;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['is_admin'] = $user['role'] == 1;
                session_regenerate_id(true); // Tăng cường bảo mật session
                return true;
            } else {
                // Mật khẩu sai
                return false;
            }
        }
    }
    
    

    // Lấy thông tin người dùng theo tên đăng nhập
    public function getUserByUsername($username) {
        $sql = "SELECT * FROM user WHERE username = ?";
        return $this->db->getOne($sql, [$username]);
    }    

    // Kiểm tra xem tên đăng nhập có tồn tại không
    public function usernameExists($username) {
        $sql = "SELECT COUNT(*) FROM user WHERE username = ?";
        $count = $this->db->getOne($sql, [$username]);
        return $count['COUNT(*)'] > 0;
    }

    // Kiểm tra xem email có tồn tại không
    public function emailExists($email) {
        $sql = "SELECT COUNT(*) FROM user WHERE email = ?";
        $count = $this->db->getOne($sql, [$email]);
        return $count['COUNT(*)'] > 0;
    }

    // Kiểm tra xem số điện thoại có tồn tại không
    public function phoneExists($phone) {
        $sql = "SELECT COUNT(*) FROM user WHERE phone = ?";
        $count = $this->db->getOne($sql, [$phone]);
        return $count['COUNT(*)'] > 0;
    }

    // Lấy số lượng người dùng
    public function getSoluongUser() {
        $sql = "SELECT COUNT(id) FROM user WHERE 1";
        return $this->db->getOne($sql)['COUNT(id)'];
    }

    // Hiển thị danh sách người dùng
    public function showUser($dsuser) {
        $html_dsuser = '';
        $i = 0;
        foreach ($dsuser as $user) {
            $i++;
            $html_dsuser .= '<tr>
                                <td>' . $i . '</td>
                                <td>' . htmlspecialchars($user['hinh']) . '</td>
                                <td>' . htmlspecialchars($user['fullname']) . '</td>
                                <td>' . $this->getRoleName($user['role']) . '</td>
                                <td>' . htmlspecialchars($user['username']) . '</td>
                                <td>' . $user['phone'] . '</td>
                                <td>' . htmlspecialchars($user['email']) . '</td>
                                <td>' . htmlspecialchars($user['diachi']) . '</td>
                                <td>
                                    <a href="index.php?pg=user_edit&id=' . $user['id'] . '" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i> Sửa</a>
                                </td>
                            </tr>';
        }
        return $html_dsuser;
    }

    // Lấy tên vai trò
    public function getRoleName($role) {
        switch ($role) {
            case 0:
                return 'User';
            case 1:
                return 'Admin';
            case 2:
                return 'Block';
            default:
                return 'Unknown';
        }
    }
}
?>
