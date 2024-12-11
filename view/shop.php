<section id="page-header">
        <h2>CỬA HÀNG</h2>
    </section>

    <section id="product1" class="section-p1">
        <div class="pro-container">
            <div class="cat_menu_container">
                <div class="cat_menu_title d-flex flex-row align-items-center justify-content-start">
                    <div class="cat_burger"><span></span><span></span><span></span></div>
                    <div class="cat_menu_text">Danh mục sản phẩm</div>
                </div>
    
                <ul class="cat_menu">
                    <?php
                    // Hiển thị danh mục sản phẩm
                    foreach ($dsdm as $dm) {
                        $activeClass = ($dm['id'] == $id_cate) ? 'active' : '';
                        echo '<li class="' . $activeClass . '"><a href="index.php?pg=shop&iddm=' . $dm['id'] . '">' . htmlspecialchars($dm['name_cate']) . '<i class="fas fa-chevron-right ml-auto"></i></a></li>';
                    }
                    ?>
                </ul>
            </div>

            <?= $html_dssp_current_category; ?>       
        </div>
    </section>