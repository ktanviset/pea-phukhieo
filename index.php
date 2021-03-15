<?php
require_once 'system/import.php';

if (User::isLogin()) {
    Util::redirect('begin.php');
}
if (isset($_POST['submit_login'])) {
    $result = User::login($_POST['username'], $_POST['password']);
    if (is_array($result)) {
        Util::redirect('begin.php');
    } else {
        SC::setSession('login_error', true);
        Util::redirect('index.php');
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
    <title>Fast Invoice service (FIS)</title>
    <script defer src="js/main.js"></script>
</head>
<body>
    <header class="header">
        <a href="/" class="header__logo"><img src="images/logo.png" alt=""></a>
    </header>
    <div class="container">
        <h2>ระบบงานบริการใบแจ้งค่าไฟฟ้าหน่วยงานราชการ</h2> 
        <h1>Fast Invoice service (FIS)</h1> 
        <div class="login">
            <div class="login__img"><img src="images/img1.png" alt=""></div>
            <h3 class="login__title">LOGIN เข้าระบบงาน</h3>
            <form method="POST">
                <input type="hidden" name="submit_login">
                <div class="form__row">
                    <div class="form__col"><label for="username">ชื่อผู้ใช้งาน</label></div>
                    <div class="form__col"><input type="text" id="username" name="username"></div>
                </div>
                <div class="form__row">
                    <div class="form__col"><label for="username">รหัสผ่าน</label></div>
                    <div class="form__col"><input type="password" id="password" name="password"></div>
                </div>
                <?php
                if (SC::get('login_error')){
                    echo '<p class="d-flex justify-content-center text-danger">username หรือ password ไม่ถูกต้อง</p><br/>';
                    SC::remove('login_error');
                }
                ?>
                <button type="submit">เข้า</button>
            </form>
        </div>
        <footer class="footer">
            <div class="footer__detail">การไฟฟ้าส่วนภูมิภาคอำเภอภูเขียว</div>
            <div class="footer__detail">แผนกบัญชีและประมวลผล</div>
            <div class="footer__detail">เบอร์ติดต่อ 044-861-033</div>
        </footer>
    </div>
</body>
</html>