<?php
class ProductModel {
    private $db;
    function __construct() {
        $this->db = new Database();
    }

    function get_dssp_new($limit) {
        $sql = "SELECT pro.id, pro.id_cate, cate.name_cate, pro.image, pro.price, pro.price_sale, pro.view, pro.name_pro
                FROM product pro 
                INNER JOIN category cate ON pro.id_cate = cate.id
                WHERE pro.date_of_entry IS NOT NULL
                ORDER BY pro.date_of_entry DESC LIMIT " . $limit;
        return $this->db->getAll($sql);
    }

    function get_dssp_best($limit) {
        $sql = "SELECT pro.*, pro.id as idpro, pro.name_pro as proname, cate.name_cate as namecate
                FROM product pro
                LEFT JOIN category cate ON pro.id_cate = cate.id
                WHERE pro.special = 1
                ORDER BY pro.id DESC LIMIT " . $limit;
        return $this->db->getAll($sql);
    }

    function get_dssp_view($limit) {
        $sql = "SELECT pro.*, cate.name_cate
                FROM product pro
                INNER JOIN category cate ON pro.id_cate = cate.id
                WHERE pro.view IS NOT NULL
                ORDER BY pro.view DESC, pro.id DESC LIMIT " . $limit;
        return $this->db->getAll($sql);
    }

    function get_dssp_luotmua($limit) {
        $sql = "SELECT pro.*, 
                       (SELECT COUNT(*) 
                        FROM bill_detail 
                        WHERE bill_detail.id_pro = pro.id) as luot_mua, 
                       cate.name_cate
                FROM product pro
                INNER JOIN category cate ON pro.id_cate = cate.id
                ORDER BY luot_mua DESC, pro.id DESC LIMIT ?";
        return $this->db->getAll($sql, [$limit]);
    }
    

    function get_dssp_lienquan($categoryId, $id, $limit) {
    
        $sql = "SELECT pro.*, cate.name_cate 
                FROM product pro 
                INNER JOIN category cate ON pro.id_cate = cate.id 
                WHERE pro.id_cate = ? AND pro.id <> ? 
                ORDER BY pro.id DESC LIMIT " .$limit;
    
        return $this->db->getAll($sql, [$categoryId, $id]);
    }  

    function get_iddm($id){
        $sql = "SELECT id_cate FROM product WHERE id=?";
        return $this->db->getOne($sql,[$id]);
    }

    function showsp($dssp) {
        $html_dssp = '';

        if(is_array($dssp) && count($dssp) > 0) {
            foreach ($dssp as $sp) {
                $specialText = '';

                if(isset($sp['special'])) {
                    if ($sp['special'] == 1) {
                        $specialText = 'HOT';
                    } else if($sp['special'] == 2) {
                        $specialText = 'NEW';
                    }
                }

                $html_dssp .= '<div class="pro' . (isset($sp['special']) ? ' special' : '') . '">
                              <a href="index.php?pg=sproduct&id=' . $sp['id'] . '">
                                  <img src="layout/img/products/' . $sp['image'] . '" alt="" height="380px;">
                                  ' . ($specialText ? '<div class="special-text">' . $specialText . '</div>' : '') . '
                              </a>
                              <div class="des">
                                  <span class="category">'.$sp['id_cate'].' - ' .$sp['id_cate'] . '</span>
                                  ' . (isset($sp['view']) ? '<div class="views"><i class="fas fa-eye"></i> ' . $sp['view'] . '</div>' : '') . '
                                  <a href="index.php?pg=sproduct&id=' . $sp['id'] . '">
                                      <h5>' . $sp['name_pro'] . '</h5>
                                  </a>
                                  <div class="star">
                                      <i class="fas fa-star"></i>
                                      <i class="fas fa-star"></i>
                                      <i class="fas fa-star"></i>
                                      <i class="fas fa-star"></i>
                                      <i class="fas fa-star"></i>
                                  </div>
                                  <h4>' . number_format($sp['price']) . ' VNĐ   ' . (isset($sp['price_sale']) ? $sp['price_sale'] : '') . ' </h4>
                              </div>
                              <form method="post" action="index.php?pg=cart">
                                <input type="hidden" name="pg" value="cart">
                                <input type="hidden" name="id" value="' . $sp['id'] . '">
                                <input type="hidden" name="name" value="' . $sp['name_pro'] . '">
                                <input type="hidden" name="img" value="' . $sp['image'] . '">
                                <input type="hidden" name="price" value="' . $sp['price'] . '">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" name="cart" class="cart"><i class="fal fa-shopping-cart"></i></button>
                              </form>
                            </div>';
            }
        }
        return $html_dssp;
    }

    function showProDetail($pro) {
        $html_prodetail = '';
        extract($pro);
        $html_prodetail .= '<div class="single-pro-image">
                            <img src="layout/img/products/'.$image.'" width="100%" height="650px" id="MainImg" alt="" style="border:1px solid black;">
                            <div class="small-img-group" style="margin-top:5px;">
                                <div class="small-img-col">
                                    <img src="layout/img/products/'. $image .'" width="100%" class="small-img" alt="" height="170px" style="border:1px solid black;">
                                </div>
                                <div class="small-img-col">
                                    <img src="layout/img/products/'. $image1 .'" width="100%" class="small-img" alt="" height="170px" style="border:1px solid black;">
                                </div>
                                <div class="small-img-col">
                                    <img src="layout/img/products/'. $image2 .'" width="100%" class="small-img" alt="" height="170px" style="border:1px solid black;">
                                </div>
                                <div class="small-img-col">
                                    <img src="layout/img/products/'. $image3 .'" width="100%" class="small-img" alt="" height="170px" style="border:1px solid black;">
                                </div>
                            </div>
                        </div>

                        <div class="single-pro-details">
                            <h6>Home / ' . $name_cate . '</h6>
                            <h3 style="font-size:40px">'. $name_pro .'</h3>
                            <h2>'. number_format($price) .' VNĐ</h2>
                            
                            <form method="post" action="index.php?pg=cart" onsubmit="return validateQuantity()">
                                <input type="hidden" name="pg" value="cart">
                                <input type="hidden" name="id" value="' . $id . '">
                                <input type="hidden" name="name" value="' . $name_pro . '">
                                <input type="hidden" name="img" value="'. $image .'">
                                <input type="hidden" name="price" value="'. $price .'">
                                <input type="number" name="soluong" id="soluong" value="1" min="1">
                                <button class="normal" type="submit" name="cart">Thêm Vào Giỏ Hàng</button>
                            </form>
                            <h4>THÔNG TIN SẢN PHẨM</h4>
                            <span>'. $mo_ta .'
                            </span>
                        </div>
                        <script>
                            function validateQuantity() {
                                var quantity = document.getElementById("soluong").value;
                                if (quantity < 1) {
                                    alert("Số lượng phải lớn hơn hoặc bằng 1.");
                                    return false;
                                }
                                return true;
                            }
                        </script>';
    return $html_prodetail;
    }

    function getProductById($id) {
        $sql = "SELECT pro.*, cate.name_cate
                FROM product pro
                INNER JOIN category cate ON pro.id_cate = cate.id
                WHERE pro.id = ?";
        return $this->db->getOne($sql, [$id]);
    }
    
    
}   
?>
