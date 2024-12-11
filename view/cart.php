<?php
$id_user = $_SESSION['id_user'];
$ds_cart_user = $cartModel->get_cart_user($id_user);
if ($isUserLoggedIn ) {
    $html_cart_user = $cartModel->displayCart($ds_cart_user);
} else {
    $html_cart_user = $cartModel->displayCart(0);
}
?>

<section id="page-header" class="about-header">
    <h2>GIỎ HÀNG</h2>
</section>

<section id="cart" class="section-p1">
    <?php if (!empty($ds_cart_user)) : ?>
        <table width="100%">
            <thead>
                <tr>
                    <td>Xóa</td>
                    <td>Hình ảnh</td>
                    <td>Sản phẩm</td>
                    <td>Giá</td>
                    <td>Số lượng</td>
                    <td>Tổng cộng</td>
                </tr>
            </thead>
            <tbody>
                <?= $html_cart_user ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>Giỏ hàng của bạn đang trống. Hãy tiếp tục mua sắm để thêm sản phẩm vào giỏ hàng.</p>
    <?php endif; ?>
</section>

<section id="cart-add" class="section-p1">
    <?php if (!empty($ds_cart_user)) : ?>
        <div id="coupon">
            <h3>Áp Dụng Mã Giảm Giá</h3>
            <div>
                <form method="post" action="index.php?pg=cart">
                    <input type="text" name="discount_code" placeholder="Nhập Mã Giảm Giá Của Bạn">
                    <button type="submit" class="normal">Áp Dụng</button>
                </form>
            </div>
        </div>

        <div id="subtotal">
            <h3>Tổng Giỏ Hàng</h3>
            <table>
                <?php
                if ($isUserLoggedIn) {
                    $id_user = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : null;
                    if ($id_user !== null) {
                        foreach ($ds_cart_user as $item) :
                ?>
                            <tr>
                                <td><?= $item['name_pro']; ?></td>
                                <td><?= 'Số Lượng: ' . $item['quantity']; ?></td>
                                <td><?= number_format($item['price'] * $item['quantity']) . ' VNĐ'; ?></td>
                            </tr>
                <?php
                        endforeach;
                        $sum_cart = $cartModel->get_sum_cart($id_user);
                        if ($sum_cart !== false) :
                ?>
                            <tr>
                                <td>Tổng Giá Giỏ Hàng</td>
                                <td><?= number_format($sum_cart['tong_cart']) . ' VNĐ'; ?></td>
                            </tr>
                <?php endif; ?>
                        <tr>
                            <td>Phí Vận Chuyển</td>
                            <td>Miễn phí</td>
                        </tr>
                        <tr>
                            <td><strong>Tổng Cộng</strong></td>
                            <td><strong><?= number_format($sum_cart['tong_cart']) . ' VNĐ'; ?></strong></td>
                        </tr>
                <?php
                    }
                }
                ?>
            </table>
            <a class="normal" href="index.php?pg=checkout">Tiếp Tục Thanh Toán</a>
        </div>
    <?php endif; ?>
</section>
