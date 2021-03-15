<?php
require_once 'system/import.php';
require_once 'system/islogin.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // fetch file to download from database
    $file = DB::get('file_upload', '*', array('id' => $id));
    $filepath = $file['location'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . $file['name'].'.'.$file['filetype']);
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        readfile($filepath);
        exit;
    }
}
?>