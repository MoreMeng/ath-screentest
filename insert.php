<?php
error_reporting(E_ALL ^ E_NOTICE);

if (empty($_POST['section']) || empty($_POST['name'])) {
    http_response_code(400);
    echo "ข้อมูลไม่เพียงพอ";
    print_r($_POST);
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require '../dv-config.php';
    require DEV_PATH . '/classes/db.class.v2.php';
    require DEV_PATH . '/functions/global.php';

    $arr = array(
        'name' => $_POST['name'],
        'monitor' => $_POST['monitor'],
        'section' => $_POST['section'],
        'xray' => $_POST['xray'],
        'ip' => $_SERVER['REMOTE_ADDR'],
        'date' => date('Y-m-d H:i:s'),
        'score' => $_POST['score']
    );
    $sql = "INSERT INTO " . TB_PREFIX . "screentest VALUES ( '', :name, :section, :xray, :monitor, :ip, :date, :score)";
    try {
        CON::updateDB($arr, $sql, true);
        echo 'บันทึกข้อมูลแล้ว';
        http_response_code(200);

    } catch (Exception $e) {
        echo 'ไม่สามารถบันทึกข้อมูลได้' . $e;
        http_response_code(403);
    }
}
?>