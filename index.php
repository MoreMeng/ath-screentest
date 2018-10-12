<?php
session_start();
error_reporting(0);
// error_reporting(E_ERROR | E_WARNING | E_PARSE);

require realpath('../dv-config.php');
require DEV_PATH . '/classes/db.class.v2.php';
require DEV_PATH . '/functions/global.php';

$GET_DEV = (empty($_GET['dev'])) ? null : $_GET['dev'];

define('Q_VERSION', '1.0.0');

?>

<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Monitor Calibration Graphic</title>
    <!-- CORE CSS -->
    <link rel="stylesheet" href="<?php echo ASSET_PATH; ?>/bootswatch/flatly/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo ASSET_PATH; ?>/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo ASSET_PATH; ?>/fonts/maledpan/maledpan.css">
    <link rel="stylesheet" href="<?php echo ASSET_PATH; ?>/fonts/chatthai/chatthai.css">
    <link rel="stylesheet" href="<?php echo ASSET_PATH; ?>/sweetalert-lastest/dist/sweetalert.css">
    <link rel="stylesheet" href="<?php echo ASSET_PATH; ?>/select2/dist/css/select2.css">
    <link rel="stylesheet" href="<?php echo ASSET_PATH; ?>/select2-bootstrap-theme/dist/select2-bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/css/screentest.css?v=<?php echo filemtime('css/screentest.css'); ?>">
    <?php if (!in_array($GET_DEV, array('','view','report'))) : ?>
    <link rel="stylesheet" href="<?php echo ASSET_PATH; ?>/datatables/media/css/dataTables.bootstrap.min.css">
    <?php elseif ($GET_DEV == 'report') : ?>
    <!-- <link rel="stylesheet" href="<?php echo ASSET_PATH; ?>/morris.js/morris.css"> -->
    <?php endif; ?>
</head>

<body>
<div id="bg"></div>
    <div id="wrapper">
        <div id='quiz'></div>

        <nav>
            <ul class="pager">
                <li> <a id="prev" href='#'>ก่อนหน้า</a> </li>
                <li> <a id="next" href='#'>ถัดไป</a> </li>
            </ul>
        </nav>

        <div id="send" class="container-fluid">
            <div class="col-xs-4 col-xs-offset-4 well well-lg">

                <form action="" method="POST" class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input class="form-control" type="text" id="name" name="name" placeholder="ชื่อ-นามสกุล ผู้ทำการทดสอบ">
                    </div>
                    <div class="form-group">
                        <label for="monitor">Monitor:</label>
                        <input class="form-control" type="text" id="monitor" name="monitor" placeholder="ยี่ห้อ รุ่น ของหน้าจอ ตัวอย่าง: Acer X193HQ A">
                    </div>
                    <div class="form-group">
                        <label for="section">Section:</label>
                        <select data-placeholder="เลือกหน่วยงาน" class="form-control select2" name="section" id="section">
                        <option></option>
                                <?php
                            // foreach ($da_section as $row) {
                            //  $select = ($row['sec_id'] == $com[0]['ser_section']) ? 'selected' : '';
                            //  echo '<option value="'.$row['sec_id'].'" '.$select .'>'.pad($row['sec_code']).$row['sec_name'].'</option>'.PHP_EOL;
                            // }
                            $sql_section = "SELECT
                            " . TB_PREFIX . "department_section.sec_id,
                            " . TB_PREFIX . "department_section.sec_name,
                            " . TB_PREFIX . "department_section.sec_code,
                            " . TB_PREFIX . "department.dep_id,
                            " . TB_PREFIX . "department.dep_name
                            FROM
                            " . TB_PREFIX . "department_section
                            INNER JOIN " . TB_PREFIX . "department ON " . TB_PREFIX . "department_section.dept_id = " . TB_PREFIX . "department.dep_id
                            ORDER BY
                            " . TB_PREFIX . "department_section.dept_id ASC,
                            " . TB_PREFIX . "department_section.sec_name ASC";

                            $section = CON::selectArrayDB(array(), $sql_section);
                            $selected = $def = '';
                            foreach ($section as $row) {
                                // $select = ($selected==$row['sec_id']) ? ' selected' : null;
                                // $select = ($row['sec_id'] == $com[0]['ser_section']) ? 'selected' : '';
                                $select = ($row['sec_id'] == $_SESSION['ses_sec_id']) ? 'selected' : '';

                                if ($row['dep_id'] != $def) {
                                    echo ($def != '') ? '</optgroup>' : '';
                                    echo '<optgroup label="' . $row['dep_name'] . '">';
                                    $def = $row['dep_id'];
                                    echo '<option value="' . $row['sec_id'] . '" ' . $select . '>' . $row['sec_code'] . ' - ' . $row['sec_name'] . '</option>';
                                } else {
                                    echo '<option value="' . $row['sec_id'] . '" ' . $select . '>' . $row['sec_code'] . ' - ' . $row['sec_name'] . '</option>';
                                }
                            }
                            echo '</optgroup>';
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="monitor">ใช้หน้าจอนี้สำหรับดูผล xray หรือไม่?</label>
                        <div class="btn-group btn-block" data-toggle="buttons">
                        <label class="btn btn-success">
                            <input type="radio" name="xray" id="y" autocomplete="off"> ใช้
                        </label>
                        <label class="btn btn-danger">
                            <input type="radio" name="xray" id="n" autocomplete="off"> ไม่ใช้
                        </label>
                    </div>
                    </div>
                    <div class="form-group">
                        <div class="text-center">
                            <button id="submit" type="button" class="btn btn-primary">บันทึกผลการทดสอบ</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <?php require 'footer.php'; ?>

    <script src="<?php echo SITE_URL; ?>/js/loadbg.js" async></script>
    <script src="<?php echo ASSET_PATH; ?>/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo ASSET_PATH; ?>/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo ASSET_PATH; ?>/select2/dist/js/select2.min.js"></script>
    <script src="<?php echo ASSET_PATH; ?>/sweetalert2/dist/sweetalert.min.js"></script>
    <script src="<?php echo SITE_URL; ?>/js/app.js"></script>

</body>

</html>