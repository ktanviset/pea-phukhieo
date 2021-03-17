<?php
require_once 'system/import.php';
require_once 'system/islogin.php';
require_once 'system/requiredadmin.php';

if (isset($_POST['user_delete'])){
    DB::delete('system_user', array('id' => $_POST['user_id']));
    Util::redirect('');
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
<body style="overflow: auto;">
    <header class="header">
        <a href="begin.php" class="header__logo"><img src="images/logo.png" alt=""></a>
    </header>
    <div class="container">
        <h2>ระบบงานบริการใบแจ้งค่าไฟฟ้าหน่วยงานราชการ</h2> 
        <h1>Fast Invoice service (FIS)</h1> 
        <div class="toolbar">
            <div class="toolbar__title">ยินดีต้อนรับ : หน้าจักการผู้ใช้</div>
            <div class="toolbar__nav">
                <div class="toolbar__exit"><a href="begin.php">กลับสู่หน้าหลัก</a></div>
            </div>
        </div>
        <h3>จัดการผู้ใช้</h3>
        <ul class="list">
            <li><div class="list__name"><strong>ชื่อผู้ใช้</strong></div><div class="list__action"></div></li>

            <?php
            $admincount = DB::count('system_user', array('role' => 'admin'));
            $user_list = DB::select('system_user', '*', array('ORDER' => array('id')));
            foreach ($user_list as $user) { ?>
            <li>
                <div class="list__name"><?php echo '['.$user['role'].'] '.$user['username']; ?></div>
                <div class="list__action">
                    <a href="register.php?id=<?php echo $user['id']; ?>">แก้ไข</a>
                    <?php if ($admincount < 1) { ?>
                    <a href="#deleteDataModal" class="toggle-modal" data-toggle="modal" data-target="#deleteDataModal">
                        ลบ
                        <input type="hidden" class="modal-param" name="user_id" value="<?php echo $user['id']; ?>">
                        <input type="hidden" class="modal-param" name="user_name" value="<?php echo $user['username']; ?>">
                    </a>
                    <?php } ?>
                </div>
            </li>
            <?php } ?>
        </ul>
        <div class="action">
            <div class="action__row">
                <form action="">
                    เพิ่มผู้ใช้ : <a class="button" href="register.php">เพิ่ม</a>
                </form>
            </div>
        </div>
        <footer class="footer">
            <div class="footer__detail">การไฟฟ้าส่วนภูมิภาคอำเภอภูเขียว</div>
            <div class="footer__detail">แผนกบัญชีและประมวลผล</div>
            <div class="footer__detail">เบอร์ติดต่อ 044-861-033</div>
        </footer>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="js/modalparam.js"></script>
</body>
</html>

<!-- Modal -->
<div class="modal fade" id="deleteDataModal" tabindex="-1" role="dialog" aria-labelledby="deleteDataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="user_delete">
                <input type="hidden" name="user_id">
                <div class="modal-header">
                    <h3 class="modal-title" id="deleteDataModalLabel">ยืนยันลบข้อมูล</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body d-flex justify-content-center">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-4" style="margin: auto;">
                                <strong>Username:</strong>
                            </div>
                            <div class="col-sm-8 d-flex justify-content-center">
                                <input type="text" name="user_name" readonly style="margin: auto; width: 25rem;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="button" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="button" >ลบ</button>
                </div>
            </form>
        </div>
    </div>
</div>