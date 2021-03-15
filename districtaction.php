<?php
require_once 'system/import.php';
require_once 'system/islogin.php';
require_once 'system/requiredadmin.php';

if (isset($_POST['district_post'])){
    $currentUserName = User::getCurrentUsername();
    if ($_POST['district_id'] != '' && $_POST['district_id'] != null){
        $data = [];
        $data['name'] = $_POST['district_name'];
        $data['modifiedby'] = $currentUserName;
        DB::update('district', $data, array('id' => $_POST['district_id']));
    }
    else{
        $data = [];
        $data['name'] = $_POST['district_name'];
        $data['createdby'] = $currentUserName;
        $data['modifiedby'] = $currentUserName;
        $record_id = DB::insert('district', $data);
    }
    Util::redirect('');
  }
  
  if (isset($_POST['district_delete'])){
    DB::delete('district', array('id' => $_POST['district_id']));
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
            <div class="toolbar__title">ยินดีต้อนรับ : เข้าสู่ระบบงานบริการใบแจ้งค่าไฟฟ้าหน่วยงานราชการ</div>
            <div class="toolbar__nav">
                <div class="toolbar__exit"><a href="begin.php">กลับสู่หน้าหลัก</a></div>
            </div>
        </div>
        <h3>จัดการอำเภอ</h3>
        <ul class="list">
            <li><div class="list__name"><strong>ชื่ออำเภอ</strong></div><div class="list__action"></div></li>

            <?php
            $district_list = DB::select('district', '*', array('ORDER' => array('id')));
            foreach ($district_list as $district) { ?>
            <li>
                <div class="list__name"><?php echo $district['name']; ?></div>
                <div class="list__action">
                    <a href="#editDataModal" class="toggle-modal" data-toggle="modal" data-target="#editDataModal">
                        แก้ไข
                        <input type="hidden" class="modal-param" name="district_id" value="<?php echo $district['id']; ?>">
                        <input type="hidden" class="modal-param" name="district_name" value="<?php echo $district['name']; ?>">
                    </a>
                    <a href="#deleteDataModal" class="toggle-modal" data-toggle="modal" data-target="#deleteDataModal">
                        ลบ
                        <input type="hidden" class="modal-param" name="district_id" value="<?php echo $district['id']; ?>">
                        <input type="hidden" class="modal-param" name="district_name" value="<?php echo $district['name']; ?>">
                    </a>
                </div>
            </li>
            <?php } ?>
        </ul>
        <div class="action">
            <div class="action__row d-flex justify-content-center">
                <form action="">
                    <button type="button" class="button toggle-modal" data-toggle="modal" data-target="#editDataModal">
                        เพิ่ม
                        <input type="hidden" class="modal-param" name="district_id">
                        <input type="hidden" class="modal-param" name="district_name">
                    </button>
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
<div class="modal fade" id="editDataModal" tabindex="-1" role="dialog" aria-labelledby="editDataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="district_post">
                <input type="hidden" name="district_id">
                <div class="modal-header">
                    <h3 class="modal-title" id="editDataModalLabel">บันทึกข้อมูล</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body d-flex justify-content-center">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-3" style="margin: auto;">
                                <strong>ชื่ออำเภอ:</strong>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="district_name" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="button" >บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteDataModal" tabindex="-1" role="dialog" aria-labelledby="deleteDataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="district_delete">
                <input type="hidden" name="district_id">
                <div class="modal-header">
                    <h3 class="modal-title" id="deleteDataModalLabel">ยืนยันลบข้อมูล</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body d-flex justify-content-center">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-3" style="margin: auto;">
                                <strong>ชื่ออำเภอ:</strong>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="district_name" readonly>
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