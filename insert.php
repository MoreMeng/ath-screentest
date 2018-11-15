<?php
error_reporting(E_ALL ^ E_NOTICE);

if (empty($_POST['section']) || empty($_POST['name'])) {
    http_response_code(400);
    echo "ข้อมูลไม่เพียงพอ";
    print_r($_POST);
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    setcookie('XRAY', 1, time() + (60*60*6), "/");

    require '../dv-config.php';
    require DEV_PATH . '/classes/db.class.v2.php';
    require DEV_PATH . '/functions/global.php';

    $arr = array(
        'name' => $_POST['name'],
        'section' => $_POST['section'],
        'monitor' => $_POST['monitor'],
        'xray' => $_POST['xray'],
        'ip' => $_SERVER['REMOTE_ADDR'],
        'date' => date('Y-m-d H:i:s'),
        'score' => $_POST['score']
    );
    $sql = "INSERT INTO " . TB_PREFIX . "screentest VALUES ( '', :name, :section, :monitor, :xray, :ip, :date, :score)";
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