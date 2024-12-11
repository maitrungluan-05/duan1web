
<section>
    <div id="login">
        <h3 class="login-title">Đăng Nhập Hệ Thống</h3>
        <p>Bạn Chưa Có Tài Khoản? <a href="index.php?pg=dangky" style="color:blue">Đăng Ký</a></p>
        <?php if ($is_user_logged_in): ?>
            <p>Bạn Đã Năng Nhập!</p>
        <?php else: ?>
            <form action="index.php?pg=dangnhap" method="POST" id="form-login">
               
                <div class="form-group-login">
                    <input type="text" name="username" id="username" class="email-ip" placeholder="Tên đăng nhập " required />
                    
                </div>
                <div class="form-group-login">
                    <input type="password" name="password" id="password" placeholder="Mật khẩu " required />
                
                </div>
                    <?php
                        if($checkMK==1){
                            echo $saimatkhau;
                        }
                        if($checkMK==2){
                            echo $saitaikhoan;
                        }
                        if($checkMK==3){
                            echo $saimatkhau;
                        }
                    ?>
                    <a href="index.php?pg=forgot_password" style="margin-left:52px; color:#000">Quên Mật Khẩu?</a>
                <div class="btn-login pt-1">
                    <button type="submit">Đăng Nhập</button>
                </div>
            </form>
        <?php endif; ?>
    </div>
</section>
