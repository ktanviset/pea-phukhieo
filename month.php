<?php
require_once 'system/import.php';
require_once 'system/islogin.php';

if ($_GET['district'] == '' || $_GET['district'] == null){
    Util::redirect('begin.php');
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
<body>
    <header class="header">
        <a href="begin.php" class="header__logo"><img src="images/logo.png" alt=""></a>
    </header>
    <div class="container">
        <h2>ระบบงานบริการใบแจ้งค่าไฟฟ้าหน่วยงานราชการ</h2> 
        <h1>Fast Invoice service (FIS)</h1> 
        <div class="toolbar">
            <?php
            $district = DB::get('district', '*', array('id' => $_GET['district']));
            $organization = DB::get('organization', '*', array('id' => $_GET['organization']));
            ?>
            <div class="toolbar__title">อำเภอ : <?php echo $district['name']; ?> >> หน่วยงาน : <?php echo $organization['name']; ?></div>
            <div class="toolbar__nav">
                <div class="toolbar__exit"><a href="organization.php<?php echo '?district='.$_GET['district']; ?>">กลับ</a></div>
            </div>
        </div>
        <form action="doc.php">
            <div class="form__row">
                <div class="form__col">
                    <label class="select" for="">กรุณาระบุบิลเดือน</label> 
                </div>
                <div class="form__col">
                    <input type="hidden" name="district" value="<?php echo $_GET['district']; ?>" >
                    <input type="hidden" name="organization" value="<?php echo $_GET['organization']; ?>" >
                    <select name="monthyear" id="monthyear" required>
                        <option value="" disabled selected>กรุณาเลือกเดือนที่ต้องการ</option>

                        <?php
                        $month_year_list = DB::select('vw_file_upload_month_year', '*');
                        foreach ($month_year_list as $month_year) { ?>
                        <option value="<?php echo $month_year['monthval'].'.'.$month_year['year']; ?>"><?php echo Util::formatMonthNameTH($month_year['monthval']).' ปี '.($month_year['year'] + 543); ?></option>
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
            <div class="action__row"><a href="docaction.php<?php echo '?district='.$_GET['district'].'&organization='.$_GET['organization']; ?>">จัดการเอกสาร</a></div>
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