<?php
require_once 'system/import.php';
require_once 'system/islogin.php';
require_once 'system/requiredadmin.php';

if ($_GET['district'] == '' || $_GET['district'] == null){
    Util::redirect('begin.php');
}

if (isset($_POST['doc_post'])){
    $currentUserName = User::getCurrentUsername();

    if (!file_exists('uploads')) {
        mkdir('uploads', 0777, true);
    }

    $err_message = '';
    $err = false;
    //update
    if ($_POST['doc_id'] != '' && $_POST['doc_id'] != null) {
        $curr_doc = DB::get('file_upload', '*', array('id' => $_POST['doc_id']));

        $updatefile = false;
        $destination = '';
        $extension = '';
        $filename = $_FILES['doc_file']['name'];
        if ($filename != null && $filename != ''){
            //delete file
            unlink($curr_doc['location']);

            // get the file extension
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            $stored_filename = uniqid() . '.' . $extension;
            // destination of the file on the server
            $destination = 'uploads/' . $stored_filename;
            // the physical file on a temporary uploads directory on the server
            $file = $_FILES['doc_file']['tmp_name'];
            $size = $_FILES['doc_file']['size'];

            if (!in_array($extension, ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx' ])) {
                $err = true;
                $err_message = "You file extension must be .pdf .doc .docx .xls .xlsx .ppt or .pptx";
            } 
            else {
                // move the uploaded (temporary) file to the specified destination
                if (move_uploaded_file($file, $destination)) {
                    $updatefile = true;
                } else {
                    $err = true;
                    $err_message = "Failed to upload file.";
                }
            }
        }

        if (!$err) {
            $data = [];
            $data['name'] = $_POST['doc_name'];
            $data['organization_id'] = $_POST['organization_id'];
            $data['modifiedby'] = $currentUserName;
            $data['bill_date'] = $_POST['bill_date'];
            if ($updatefile){
                $data['location'] = $destination;
                $data['filetype'] = $extension;
            }
            DB::update('file_upload', $data, array('id' => $_POST['doc_id']));
        }
    }
    else{ //create
        $filename = $_FILES['doc_file']['name'];
        if ($filename == null || $filename == ''){
            $err = true;
            $err_message = "None upload file.";
        }

        if (!$err){
            // get the file extension
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            $stored_filename = uniqid() . '.' . $extension;
            // destination of the file on the server
            $destination = 'uploads/' . $stored_filename;
            // the physical file on a temporary uploads directory on the server
            $file = $_FILES['doc_file']['tmp_name'];
            $size = $_FILES['doc_file']['size'];

            if (!in_array($extension, ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx' ])) {
                $err = true;
                $err_message = "You file extension must be .pdf .doc .docx .xls .xlsx .ppt or .pptx";
            } 
            else {
                // move the uploaded (temporary) file to the specified destination
                if (move_uploaded_file($file, $destination)) {
                    $data = [];
                    $data['name'] = $_POST['doc_name'];
                    $data['organization_id'] = $_POST['organization_id'];
                    $data['location'] = $destination;
                    $data['filetype'] = $extension;
                    $data['createdby'] = $currentUserName;
                    $data['modifiedby'] = $currentUserName;
                    $data['bill_date'] = $_POST['bill_date'];
                    $record_id = DB::insert('file_upload', $data);
                } else {
                    $err = true;
                    $err_message = "Failed to upload file.";
                }
            }
        }
    }
    if ($err) {
        SC::setSession('file_upload_error', $err);
        SC::setSession('file_upload_message', $err_message);
    }
    Util::redirect('');
  }
  
if (isset($_POST['doc_delete'])){
    $curr_doc = DB::get('file_upload', '*', array('id' => $_POST['doc_id']));
    unlink($curr_doc['location']);
    DB::delete('file_upload', array('id' => $_POST['doc_id']));
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
    <link rel="stylesheet" href="js/jojosati-bootstrap-datepicker-thai/datepicker.css">
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
                <div class="toolbar__exit"><a href="month.php<?php echo '?district='.$_GET['district'].'&organization='.$_GET['organization']; ?>">กลับ</a></div>
            </div>
        </div>
        <h3>จัดการเอกสาร</h3>
        <ul class="list">
            <li><div class="list__name"><strong>ชื่อเอกสาร</strong></div><div class="list__action"></div></li>

            <?php
            $file_list = DB::select('vw_file_upload_detail', '*', array('ORDER' => array('id')));
            foreach ($file_list as $file) { ?>
            <li>
                <div class="list__name"><?php echo $file['name'] . '.' . $file['filetype']; ?></div>
                <div class="list__action">
                    <a href="download.php?id=<?php echo $file['id'] ?>" target="_blank">ดาวน์โหลด</a>
                    <a href="#editDataModal" class="toggle-modal" data-toggle="modal" data-target="#editDataModal">
                        แก้ไข
                        <input type="hidden" class="modal-param" name="doc_id" value="<?php echo $file['id']; ?>">
                        <input type="hidden" class="modal-param" name="doc_name" value="<?php echo $file['name']; ?>">
                        <input type="hidden" class="modal-param" name="organization_id" value="<?php echo $file['organization_id']; ?>">
                        <input type="hidden" class="modal-param" name="bill_date" value="<?php echo $file['bill_date']; ?>">
                    </a>
                    <a href="#deleteDataModal" class="toggle-modal" data-toggle="modal" data-target="#deleteDataModal">
                        ลบ
                        <input type="hidden" class="modal-param" name="doc_id" value="<?php echo $file['id']; ?>">
                        <input type="hidden" class="modal-param" name="doc_name" value="<?php echo $file['name']; ?>">
                        <input type="hidden" class="modal-param" name="organization_name" value="<?php echo $file['organization_name']; ?>">
                        <input type="hidden" class="modal-param" name="bill_date" value="<?php echo $file['bill_date']; ?>">
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
                        <input type="hidden" class="modal-param" name="doc_id">
                        <input type="hidden" class="modal-param" name="doc_name">
                        <input type="hidden" class="modal-param" name="organization_id">
                        <input type="hidden" class="modal-param" name="doc_file">
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
    <script src="js/jojosati-bootstrap-datepicker-thai/bootstrap-datepicker.js"></script>
    <script src="js/jojosati-bootstrap-datepicker-thai/locales/bootstrap-datepicker.th.js"></script>
    <?php if (SC::get('file_upload_error')) { ?>
    <script>
    $(function() {
        alert('<?php echo SC::get('file_upload_message') ?>');
    });
    </script>
    <?php } 
    SC::remove('file_upload_error');
    SC::remove('file_upload_message');
    ?>
</body>
</html>

<!-- Modal -->
<div class="modal fade" id="editDataModal" tabindex="-1" role="dialog" aria-labelledby="editDataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="doc_post">
                <input type="hidden" name="doc_id">
                <div class="modal-header">
                    <h3 class="modal-title" id="editDataModalLabel">บันทึกข้อมูล</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body d-flex justify-content-center">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-4" style="margin: auto;">
                                <strong>ชื่อไฟล์:</strong>
                            </div>
                            <div class="col-sm-8 d-flex justify-content-center">
                                <input type="text" name="doc_name" required style="margin: auto; width: 25rem;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4" style="margin: auto;">
                                <strong>หน่วยงาน:</strong>
                            </div>
                            <div class="col-sm-8">
                            <select name="organization_id" id="organization_id" required style="width: 25rem;">
                                <option value="" disabled selected>กรุณาเลือกอำเภอ</option>

                                <?php
                                $organization_list = DB::select('vw_organization_detail', '*', array('ORDER' => array('district_id', 'id')));
                                foreach ($organization_list as $organization) { ?>
                                <option value="<?php echo $organization['id']; ?>"><?php echo $organization['district_name'].'>>'.$organization['name']; ?></option>
                                <?php } ?>

                            </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4" style="margin: auto;">
                                <strong>วันที่บิล:</strong>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="bill_date" style="margin: auto; width: 25rem;" data-provide="datepicker" data-date-language="th" data-date-format="yyyy-mm-dd" readonly="readonly" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <input type="file" name="doc_file"  id="doc_file">
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
                <input type="hidden" name="doc_delete">
                <input type="hidden" name="doc_id">
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
                                <strong>ชื่อไฟล์:</strong>
                            </div>
                            <div class="col-sm-8 d-flex justify-content-center">
                                <input type="text" name="doc_name" readonly style="margin: auto; width: 25rem;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4" style="margin: auto;">
                                <strong>หน่วยงาน:</strong>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="organization_name" readonly style="margin: auto; width: 25rem;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4" style="margin: auto;">
                                <strong>วันที่บิล:</strong>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="bill_date" readonly style="margin: auto; width: 25rem;">
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