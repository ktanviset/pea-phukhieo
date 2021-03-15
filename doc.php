<?php
require_once 'system/import.php';
require_once 'system/islogin.php';

if ($_GET['district'] == '' || $_GET['district'] == null){
    Util::redirect('begin.php');
}
if ($_GET['organization'] == '' || $_GET['organization'] == null){
    Util::redirect('begin.php');
}
if ($_GET['monthyear'] == '' || $_GET['monthyear'] == null){
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
<body style="overflow: auto;">
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
            $monthyear = explode(".", $_GET['monthyear']);
            $month = Util::formatMonthNameTH($monthyear[0]);
            $year = $monthyear[1] + 543;
            ?>
            <div class="toolbar__title">อำเภอ : <?php echo $district['name']; ?> >> หน่วยงาน : <?php echo $organization['name']; ?> >> เดือน :  <?php echo $month.' ปี '.$year; ?></div>
            <div class="toolbar__nav">
                <div class="toolbar__exit"><a href="month.php<?php echo '?district='.$_GET['district'].'&organization='.$_GET['organization']; ?>">กลับ</a></div>
            </div>
        </div>
        <h3>บิลเดือนที่ท่านเลือก <?php echo $month.' ปี '.$year; ?></h3>
        <ul class="list">
            <li><div class="list__name"><strong>ชื่อเอกสาร</strong></div><div class="list__action"></div></li>

            <?php
            $where = array(
                'AND' => array(
                    'organization_id' => $_GET['organization'],
                    'monthval' => $monthyear[0],
                    'year' => $monthyear[1]
                ),
                'ORDER' => array('id')
            );
            $file_list = DB::select('vw_file_upload_detail', '*', $where);
            foreach ($file_list as $file) { ?>
            <li>
                <div class="list__name"><?php echo $file['name'] . '.' . $file['filetype']; ?></div>
                <div class="list__action">
                    <a href="download.php?id=<?php echo $file['id'] ?>" target="_blank">ดาวน์โหลด</a>

                </div>
            </li>
            <?php } ?>
        </ul>
        <div class="action">
            
        </div>
        <footer class="footer">
            <div class="footer__detail">การไฟฟ้าส่วนภูมิภาคอำเภอภูเขียว</div>
            <div class="footer__detail">แผนกบัญชีและประมวลผล</div>
            <div class="footer__detail">เบอร์ติดต่อ 044-861-033</div>
        </footer>
    </div>
</body>
</html>