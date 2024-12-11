<?php
session_start();
ob_start();
include "model/pdo.php";
include "model/product.php";
include "model/category.php";
include "model/user.php";
include "model/cart.php";

$cartModel = new CartModel();
$userModel = new UserModel();
$productModel = new ProductModel();
$categoryModel = new CategoryModel();
$isUserLoggedIn = UserModel::isUserLoggedIn();
include "view/header.php";

if(!isset($_GET['pg'])) {
    include "view/home.php";
} else {
    switch ($_GET['pg']) {

        case 'cart':
            if (isset($_POST['cart'])) {
                $product_id = $_POST['id'];
                $product_name = $_POST['name'];
                $product_img = $_POST['img'];
                $product_price = $_POST['price'];
                $product_quantity = $_POST['quantity'];
                $total = $product_price * $product_quantity;
                
                // Kiểm tra người dùng đã đăng nhập
                $isUserLoggedIn = isset($_SESSION['id_user']);
                if (!$isUserLoggedIn) {
                    echo '<script>alert("Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng.");</script>';
                    echo '<script>window.location.href = "index.php?pg=dangnhap";</script>';
                    exit;
                } else {
                    $id_user = $_SESSION['id_user'];
                }
                
                // Kiểm tra sản phẩm trong giỏ hàng
                $cart = $cartModel->get_cart_product($product_id, $id_user);
                if ($cart) {
                    // Sản phẩm đã có trong giỏ hàng
                    $up_quantity = $cart['quantity'] + $product_quantity;
                    $up_total = $up_quantity * $product_price;
        
                    // Cập nhật giỏ hàng
                    $cartModel->updates_cart($product_id, $up_quantity, $up_total, $id_user);
                } else {
                    // Sản phẩm chưa có, thêm vào giỏ hàng
                    $cartModel->addcart($product_id, $id_user, $product_name, $product_img, $product_price, $product_quantity, $total);
                }
        
                // Chuyển hướng về giỏ hàng
                header('Location: index.php?pg=cart');
                exit;
            }
        
            // Bao gồm view hiển thị giỏ hàng
            include "view/cart.php";
            break;
        

        case 'dangky':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Lấy thông tin từ form
                $hoten = $_POST['fullname'];
                $email = $_POST['email'];
                $dienthoai = $_POST['phone'];
                $username = $_POST['username'];
                $password = $_POST['password'];
        
                // Gọi phương thức registerUser từ UserModel để đăng ký người dùng
                $register_result = $userModel->registerUser($hoten, $email, $dienthoai, $username, $password);
        
                // Kiểm tra kết quả đăng ký
                if ($register_result === true) {
                    echo '<p style="color: green;">Đăng ký thành công! Đăng nhập <a href="index.php?pg=dangnhap">tại đây</a>.</p>';
                } else {
                    echo '<p style="color: red;">Đăng ký thất bại: ' . $register_result . '</p>';
                }
            }
            include "view/dangky.php";
            break;
        
            case 'dangnhap':
                // Kiểm tra xem người dùng đã đăng nhập chưa
                $is_user_logged_in = UserModel::isUserLoggedIn();
                
                if ($is_user_logged_in) {
                    header("Location: index.php");
                    exit();
                }
                
                // Khởi tạo các biến kiểm tra lỗi
                $checkMK = 0;  // Biến để kiểm tra mật khẩu có đúng không
                $saimatkhau = '';  // Thông báo lỗi sai mật khẩu
                $saitaikhoan = '';  // Thông báo lỗi tên tài khoản
                
                // Kiểm tra nếu form đăng nhập được submit
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (isset($_POST['username']) && isset($_POST['password'])) {
                        $username = $_POST['username'];
                        $password = $_POST['password'];
                        
                        // Lấy thông tin người dùng từ tên đăng nhập
                        $user = $userModel->getUserByUsername($username);
                        
                        if ($user) {
                            // Kiểm tra mật khẩu với phương thức loginUser
                            $login_result = $userModel->loginUser($username, $password);
                            
                            if ($login_result) {
                                $_SESSION['id_user'] = $user['id'];
                                $_SESSION['username'] = $user['username'];
                                $_SESSION['is_admin'] = $user['role'] == 1;
                                session_regenerate_id(true);  // Thay đổi ID session để bảo mật hơn
                                
                                // Chuyển hướng người dùng sau khi đăng nhập thành công
                                if ($_SESSION['is_admin']) {
                                    header("Location: admin/index.php");
                                } else {
                                    header("Location: index.php");
                                }
                                exit();
                            } else {
                                // Nếu mật khẩu sai
                                $checkMK = 1; // Mật khẩu sai
                                $saimatkhau = '<p style="color: red;">Sai mật khẩu, vui lòng thử lại!</p>';
                            }
                        } else {
                            // Nếu không tìm thấy tài khoản
                            $checkMK = 2; // Tên tài khoản không tồn tại
                            $saitaikhoan = '<p style="color: red;">Tên đăng nhập không tồn tại!</p>';
                        }
                    } else {
                        // Nếu thiếu thông tin đăng nhập
                        $checkMK = 3; // Thiếu thông tin đăng nhập
                        $saimatkhau = '<p style="color: red;">Thiếu thông tin đăng nhập!</p>';
                    }
                }
                
                // Bao gồm view đăng nhập
                include "view/dangnhap.php";
                break;
        
        case 'dangxuat':
            if ($is_user_logged_in) {
                session_unset();
                session_destroy();
                header("Location: index.php");
                exit();
            }
                    break;
        case 'cart':
            if(isset($_POST['cart'])) {
                $id_pro = $_POST['id'];
                $name_pro = $_POST['name'];
                $img_pro = $_POST['img'];
                $price_pro = $_POST['price'];
                $quantity_pro = $_POST['quantity'];
                $total = $price_pro * $quantity_pro;
            }
            // chưa xong
        case 'sproduct':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                
                $pro = $productModel->getProductById($id);
            
                // Kiểm tra kết quả trả về từ get_iddm
                $id_cate_result = $productModel->get_iddm($id);
                if ($id_cate_result && isset($id_cate_result['id_cate'])) {
                    $id_cate = $id_cate_result['id_cate'];
                    $dssp_splq = $productModel->get_dssp_lienquan($id_cate, $id, 4);
        
                    if ($pro) {
                        $html_chitietsp = $productModel->showProDetail($pro);
                        $html_dssp_splq = $productModel->showsp($dssp_splq);
                        include "view/sproduct.php";
                    } 
                } 
            } 
            break;
        
        case 'shop': 
            
            $dsdm = $categoryModel->all_cate();
            $tukhoa = "";
            $titlepage = "";
            $sethome = "";

            if(!isset($_GET['id_cate'])) {
                $id_cate = 0;
            } else {
                $id_cate = $_GET['id_cate'];
                $titlepage = $categoryModel->get_name_cate($id_cate);
                $sethome = $categoryModel->get_sethome_cate($id_cate);
            }

            if (isset($_POST["timkiem"]) && ($_POST["timkiem"])) {
                $kyw = $_POST["tukhoa"];
                $titlepage = "Kết quả tìm kiếm với từ khóa: <span>" . $tukhoa . "</span>";
            }

            $dssp = $categoryModel->get_dssp_limit(11);
            $html_dssp_current_category = $productModel->showsp($dssp);
            include "view/shop.php";
            break;
        
        default:
            include "view/home.php";
            break;
    }
}

include "view/footer.php";
?>