<?php
    $productModel = new ProductModel();
    $dssp_new = $productModel->get_dssp_new(4);
    $dssp_best = $productModel->get_dssp_best(4);
    $dssp_view = $productModel->get_dssp_view(4);
    $html_dssp_new = $productModel->showsp($dssp_new);
    $html_dssp_best = $productModel->showsp($dssp_best);
    $html_dssp_view = $productModel->showsp($dssp_view);
?>

<style>
        body {
        margin: 0;
        font-family: 'Montserrat', sans-serif;
        }

        .slider-container {
        background: #1A1A1A;
        display: flex;
        height:700px;
        }

        .text-container {
        flex: 0.8;
        margin-top:200px;
        padding: 50px;
        }
        .text-container h2,h5,p{
            color:white;
        }
        .text-container h4{
            color:black;
        }
        .image-slider {
        flex: 1.2;
        overflow: hidden;
        }

        .image-slider img {
        width: 850px;
        display: none;
        }
        .text-container button {
        background-color: #523713;
        color: white;
        border-radius: 10px;
        padding: 10px 20px;
        font-size: 18px;
        font-weight: bold;
        }

        .text-container button:hover {
        background-color: black;
        }
    </style>
<section id="hero">
        <h4>Chào mừng đến với DAME</h4>
        <h2>Ưu Đãi Siêu Giá Trị</h2>
        <h1>Trên tất cả sản phẩm</h1>
        <p>Tiết kiệm nhiều hơn với phiếu giảm giá và giảm giá tới 70% </p>
        <button>Mua ngay</button>
    </section>

    <section id="feature" class="section-p1">
        <div class="fe-box">
            <img src="layout/img/features/f1.png" alt="">
            <h6>Miễn Phí Giao Hàng</h6>
        </div>
        <div class="fe-box">
            <img src="layout/img/features/f2.png" alt="">
            <h6>Đặt Hàng Online</h6>
        </div>
        <div class="fe-box">
            <img src="layout/img/features/f3.png" alt="">
            <h6>Tiết Kiệm Tiền</h6>
        </div>
        <div class="fe-box">
            <img src="layout/img/features/f4.png" alt="">
            <h6>Khuyến Mãi</h6>
        </div>
        <div class="fe-box">
            <img src="layout/img/features/f5.png" alt="">
            <h6>Thân Thiện</h6>
        </div>
        <div class="fe-box">
            <img src="layout/img/features/f6.png" alt="">
            <h6>Hợ trợ 24/7</h6>
        </div>
    </section>

    <section id="product1" class="section-p1">
        <h2>SẢN PHẨM BÁN CHẠY</h2>
        <div class="pro-container">
            <?=$html_dssp_view;?>
        </div>
    </section>

    <section id="product1" class="section-p1">
        <h2>SẢN PHẨM MỚI</h2>
        <div class="pro-container">
            <?=$html_dssp_new;?>
        </div>
    </section>

    <section id="banner" class="section-m1">
        <h4>Mua Sản Phẩm Tại DAME</h4>
        <h2>Giảm Giá <span>30%</span>Cho Sản Phẩm Mới</h2>
        <button class="normal">Xem Ngay</button>
    </section>

    <section id="product1" class="section-p1">
        <h2>SẢN PHẨM HOT</h2>
        <div class="pro-container">
            <?=$html_dssp_best;?>
        </div>
    </section>