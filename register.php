<?php
require_once 'system/import.php';
require_once 'system/islogin.php';
require_once 'system/requiredadmin.php';

$editform = false;
$user = null;
$orgvalue = "";
$rolevalue = "";
if (isset($_GET['id'])){
    if ($_GET['id'] != null && $_GET['id'] != '') {
        $editform = true;
        $user = DB::get('system_user', '*', array('id' => $_GET['id']));
        $orgvalue = $user['organization_id'];
        $rolevalue = $user['role'];
    }
}

if (isset($_POST['save_user'])){
    $err_message = '';
    $err = false;

    $currentUserName = User::getCurrentUsername();
    if ($_POST['id'] != null && $_POST['id'] != '') {
        //update
        $data = [];
        if ($_POST['password'] != null && $_POST['password'] != ''){
            $data['password'] = $_POST['password'];
        }
        $data['firstname'] = $_POST['name'];
        $data['lastname'] = $_POST['lastname'];
        $data['email'] = $_POST['email'];
        $data['mobilephone'] = $_POST['mobilephone'];
        $data['role'] = $_POST['role'];
        $data['organization_id'] = $_POST['organization'];
        $data['createdby'] = $currentUserName;
        $data['modifiedby'] = $currentUserName;
        DB::update('system_user', $data, array('id' => $_POST['id']));
    }
    else {
        //create
        $checkUser = DB::get('system_user', '*', array('username' => $_POST['username']));
        if ($checkUser != null) {
            if (count($checkUser) > 0){
                $err = true;
                $err_message = "username ".$_POST['username']." มีแล้วในระบบ";
            }
        }
        
        if (!$err){
            $data = [];
            $data['username'] = $_POST['username'];
            $data['password'] = $_POST['password'];
            $data['firstname'] = $_POST['name'];
            $data['lastname'] = $_POST['lastname'];
            $data['email'] = $_POST['email'];
            $data['mobilephone'] = $_POST['mobilephone'];
            $data['role'] = $_POST['role'];
            $data['organization_id'] = $_POST['organization'];
            $data['createdby'] = $currentUserName;
            $data['modifiedby'] = $currentUserName;
            $record_id = DB::insert('system_user', $data);
        }
    }
    if ($err) {
        SC::setSession('save_user_error', $err);
        SC::setSession('save_user_message', $err_message);
        Util::redirect('');
    }
    else{
        Util::redirect('user.php');
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <div class="toolbar__title">ยินดีต้อนรับ : หน้าบันทึกผู้ใช้</div>
            <div class="toolbar__nav">
                <div class="toolbar__exit"><a href="user.php">จัดการผู้ใช้</a></div>
            </div>
        </div>
        <h3>บันทึกผู้ใช้</h3>
        <form method="POST" class="register">
            <input type="hidden" name="id" value="<?php if ($editform) echo $user['id']; ?>">
            <div class="form__row">
                <div class="form__col"><label for="username">ชื่อผู้ใช้งาน</label></div>
                <div class="form__col"><input type="text" id="username" name="username" required value="<?php if ($editform) echo $user['username']; ?>" <?php if ($editform) echo 'readonly'; ?>></div>
            </div>
            <div class="form__row">
                <div class="form__col"><label for="name">ชื่อจริง</label></div>
                <div class="form__col"><input type="text" id="name" name="name" value="<?php if ($editform) echo $user['firstname']; ?>"></div>
            </div>
            <div class="form__row">
                <div class="form__col"><label for="lastname">นามสกุล</label></div>
                <div class="form__col"><input type="text" id="lastname" name="lastname" value="<?php if ($editform) echo $user['lastname']; ?>"></div>
            </div>
            <div class="form__row">
                <div class="form__col"><label for="email">อีเมล์</label></div>
                <div class="form__col"><input type="email" id="email" name="email" value="<?php if ($editform) echo $user['email']; ?>"></div>
            </div>
            <div class="form__row">
                <div class="form__col"><label for="mobilephone">เบอร์โทร</label></div>
                <div class="form__col"><input type="text" id="mobilephone" name="mobilephone" value="<?php if ($editform) echo $user['mobilephone']; ?>"></div>
            </div>
            <div class="form__row">
                <div class="form__col"><label for="organization">หน่วยงาน</label></div>
                <div class="form__col">
                    <select name="organization" id="organization" class="register" required>
                        <option value="" disabled <?php if ($orgvalue == "") echo "selected"; ?>>กรุณาเลือกหน่วยงาน</option>
                        
                        <?php
                        $organization_list = DB::select('vw_organization_detail', '*', array('ORDER' => array('district_id', 'id')));
                        foreach ($organization_list as $organization) { ?>
                        <option value="<?php echo $organization['id']; ?>" <?php if ($orgvalue == $organization['id']) echo "selected"; ?>><?php echo $organization['district_name'].'>>'.$organization['name']; ?></option>
                        <?php } ?>

                    </select>
                </div>
            </div>
            <div class="form__row">
                <div class="form__col"><label for="role">สิทธิ์ผู้ใช้งาน</label></div>
                <div class="form__col">
                    <select name="role" id="role" class="register" required>
                        <option value="" disabled <?php if ($rolevalue == "") echo "selected"; ?>>กรุณาเลือกหน่วยงาน</option>
                        <option value="user" <?php if ($rolevalue == "user") echo "selected"; ?>>user</option>
                        <option value="admin" <?php if ($rolevalue == "admin") echo "selected"; ?>>admin</option>
                    </select>
                </div>
            </div>
            <div class="form__row">
                <div class="form__col"><label for="password">รหัสผ่าน</label></div>
                <div class="form__col"><input type="password" id="password" name="password" <?php if (!$editform) echo "required"; ?>></div>
            </div>
            <button type="submit" name="save_user">บันทึก</button>
        </form>
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
    <?php if (SC::get('save_user_error')) { ?>
    <script>
    $(function() {
        alert('<?php echo SC::get('save_user_message') ?>');
    });
    </script>
    <?php } 
    SC::remove('save_user_error');
    SC::remove('save_user_message');
    ?>
</body>
</html>