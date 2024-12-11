<section>
  <div id="login">
    <h3 class="login-title">Đăng Ký Hệ Thống</h3>
    <p>Bạn đã có tài khoản? <a href="index.php?pg=dangnhap" style="color:blue">Đăng Nhập</a></p>
    <form action="index.php?pg=dangky" method="POST" id="form-login">
      <!-- Các trường nhập liệu cho đăng ký -->
      <div class="form-group-login">
        <input type="text" name="fullname" id="hoten" class="email-ip" placeholder=" " required />
        <label for="fullname">Họ Tên</label>
      </div>
      <div class="form-group-login">
        <input type="email" name="email" id="email" class="email-ip" placeholder=" " required />
        <label for="email">Email</label>
      </div>
      <div class="form-group-login">
        <input type="tel" name="phone" id="dienthoai" class="email-ip" placeholder=" " required />
        <label for="phone">Số Điện Thoại</label>
      </div>
      <div class="form-group-login">
        <input type="text" name="username" id="username" class="email-ip" placeholder=" " required />
        <label for="username">Tên Đăng Nhập</label>
      </div>
      <div class="form-group-login">
        <input type="password" name="password" id="password" placeholder=" " required />
        <label for="password">Mật Khẩu</label>
      </div>
      <div class="btn-login pt-1">
        <button type="submit">Đăng Ký</button>
      </div>
    </form>
  </div>
</section>
