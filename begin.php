<?php
require_once 'system/import.php';
require_once 'system/islogin.php';
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
        <a href="begin.php" class="header__logo"><img src="images/logo.png" alt=""></a>
    </header>
    <div class="container">
        <h2>ระบบงานบริการใบแจ้งค่าไฟฟ้าหน่วยงานราชการ</h2> 
        <h1>Fast Invoice service (FIS)</h1> 
        <div class="toolbar">
            <div class="toolbar__title">ยินดีต้อนรับ : เข้าสู่ระบบงานบริการใบแจ้งค่าไฟฟ้าหน่วยงานราชการ</div>
            <div class="toolbar__nav">
                <div class="toolbar__exit"><a href="logout.php">ออกจากระบบ</a></div>
            </div>
        </div>
        <form action="organization.php">
            <div class="form__row">
                <div class="form__col">
                    <label class="select" for="">กรุณาระบุอำเภอ</label> 
                </div>
                <div class="form__col">
                    <select name="district" id="district" required>
                        <option value="" disabled selected>กรุณาเลือกอำเภอ</option>

                        <?php
                        $district_list = DB::select('district', '*', array('ORDER' => array('id')));
                        foreach ($district_list as $district) { ?>
                        <option value="<?php echo $district['id']; ?>"><?php echo $district['name']; ?></option>
                        <?php } ?>

                    </select>
                </div>
                <div class="form__col">
                    <button>ตกลง</button>
                </div>
            </div>
        </form>
        <div class="action">
            <?php if (SC::get('role') == 'admin') { ?>
            <div class="action__row"><a href="districtaction.php">จัดการอำเภอ</a></div>
            <?php } ?>
        </div>
        <footer class="footer">
            <div class="footer__detail">การไฟฟ้าส่วนภูมิภาคอำเภอภูเขียว</div>
            <div class="footer__detail">แผนกบัญชีและประมวลผล</div>
            <div class="footer__detail">เบอร์ติดต่อ 044-861-033</div>
        </footer>
    </div>
</body>
</html>