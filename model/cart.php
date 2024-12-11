<?php
// Xóa 
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = $_GET['id'];
    $cartModel = new CartModel();
    $cartModel->delete_cart_item($id);
    header('Location: index.php?pg=cart');
    exit;
}
// Update
if (isset($_POST['update_cart'])) {
    $id = $_POST['id'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $thanhtien = $price * $quantity;

    $cartModel = new CartModel();
    $cartModel->updates_cart($id, $quantity, $thanhtien);
    header('Location: index.php?pg=cart');
    exit;
}

class CartModel {
    private $db;

    function __construct() {
        $this->db = new Database();
    }
 
    function get_cart_product($id_product,$id_user) {
        $sql = "SELECT * FROM cart WHERE id_pro = $id_product AND id_user = $id_user";
        return $this->db->getOne($sql);
    }

    function get_cart_user($id_user) {
        $sql = "SELECT * FROM cart WHERE id_user=" .$id_user;
        return $this->db->getALL($sql);
    }

    function get_count_cart($id_user){
        $sql = "SELECT SUM(quantity) AS soluong_cart FROM cart WHERE id_user=".$id_user;
        return $this->db->getOne($sql);
    }

    function get_sum_cart($id_user){
        $sql = "SELECT SUM(total) AS tong_cart FROM cart WHERE id_user=".$id_user;
        return $this->db->getOne($sql);
    }

    function addcart($product_id,$id_user,$product_name,$product_img,$product_price,$product_quantity,$thanhtien){
        $sql = "INSERT INTO cart (id_pro,id_user, name_pro, image, price, quantity , total) VALUES (?,?,?,?,?,?,?);";
        return $this->db->insert($sql,[$product_id,$id_user,$product_name,$product_img,$product_price,$product_quantity,$thanhtien]);
    }


    function updates_cart($product_id, $quantity, $thanhtien) {
        $sql = "UPDATE cart 
                SET quantity = ?, total = ? 
                WHERE id_pro = ?";
        return $this->db->query($sql, [$quantity, $thanhtien, $product_id]);
    }

   
    function delete_cart_item($cart_id) {
        $sql = "DELETE FROM cart 
                WHERE id = ?";
        return $this->db->query($sql, [$cart_id]);
    }

    // Hiển thị giỏ hàng
    function displayCart($cart) {
        $html_cart = '';
        if($cart){
            foreach ($cart as $item) {
                $html_cart .= '<tr>
                                <td><a href="index.php?pg=cart&action=delete&id=' . $item['id'] . '" style="color:#000"><i class="far fa-times-circle"></i></a></td>
                                <td><img src="layout/img/products/' . $item['image'] . '" alt=""></td>
                                <td>' . $item['name_pro'] . '</td>
                                <td>' . number_format($item['price']) . ' VNĐ</td>
                                <td>
                                    <form action="" method="post">
                                        <input type="hidden" name="update_cart" value="1">
                                        <input type="hidden" name="id" value="' . $item['id_pro'] . '">
                                        <input type="hidden" name="price" value="' . $item['price'] . '">
                                        <input type="number" name="quantity" value="' . $item['quantity'] . '" min="1" onchange="this.form.submit()">
                                    </form>
                                </td>
                                <td>' . number_format($item['total']) . ' VNĐ</td>
                            </tr>';
            }
        } else {
            $html_cart = '<tr><td colspan="6">Giỏ hàng của bạn trống.</td></tr>';
        }

        return $html_cart;
    }
}
