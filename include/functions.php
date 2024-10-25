<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString . time();
}

function generateRandomNumber($length = 10)
{
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// Canonical string generate
function randomString()
{
    $alphabet = md5("abcdefghijklmnopqrstuwxyz0123456789");
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    $array_lengths = array(4, 4, 4, 4);
    foreach ($array_lengths as $v) {
        for ($i = 0; $i < $v; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        $pass[] = '-';
    }
    return rtrim(implode($pass), '-'); //turn the array into a string
}

function send_email($to, $data, $email_template, $subject, $attachments = array())
{
    global $pdo;
    $data["{{APP_URL}}"] = FULLPATH;
    $data["{{APPNAME}}"] = APPNAME;
    $data["{{SUBJECT}}"] = $subject;

    $message = file_get_contents(SYSPATH . "email_templates/{$email_template}");

    $message = str_replace("{{EMAIL_CONTENT}}", $message, $message);
    $message = str_replace(array_keys($data), $data, $message);

    if (MODE == "live") {

        if (!class_exists('PHPMailer\PHPMailer\Exception')) {
            require SYSPATH . 'library/phpmailer/Exception.php';
            require SYSPATH . 'library/phpmailer/PHPMailer.php';
            require SYSPATH . 'library/phpmailer/SMTP.php';
        }
        $mail = new PHPMailer();
        try {
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->Host = MAILER_HOST;  // Specify main and backup SMTP servers
            $mail->Port = MAILER_PORT;
            $mail->SMTPSecure = MAILER_SMTPSecure;
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = MAILER_EMAIL;                // SMTP username
            $mail->Password = MAILER_PASS;                          // SMTP password

            $mail->From = MAILER_EMAIL;
            $mail->FromName = MAILER_NAME;
            $mail->Subject = $subject;
            foreach ($attachments as $attachment) {
                $mail->addAttachment($attachment);
            }
            $mail->MsgHTML($message);
            $mail->AltBody = "To view the message, please use an HTML compatible email viewer!";
            $mail->ClearAddresses();
            $mail->addAddress($to);

            if ($mail->send()) {
                return array("status" => "ok");
            } else {
                return array("status" => "error", "message" => "Email sending fail. - {$to} - " . $mail->ErrorInfo);
            }
        } catch (Exception $e) {
            return array("status" => "error", "message" => "Email sending fail. - {$to} - " . $mail->ErrorInfo);
        }
    } else {
        return array("status" => "ok");
    }
}

function GetLoginUserName()
{
    return ($_SESSION['dailymilk']['user_id']) ? "{$_SESSION['dailymilk']['firstname']} {$_SESSION['dailymilk']['lastname']}" : null;
}
function GetLoginUserId()
{
    return ($_SESSION['dailymilk']['user_id']) ? $_SESSION['dailymilk']['user_id'] : null;
}
function GetLoginUserRole()
{
    return ($_SESSION['dailymilk']['roleid']) ? $_SESSION['dailymilk']['roleid'] : null;
}
function GetLoginAgencyId()
{
    return ($_SESSION['dailymilk']['agency_id']) ? $_SESSION['dailymilk']['agency_id'] : null;
}

// Password validation function
function validatePassword($password)
{
    $minLength = 8;
    $hasUppercase = preg_match('/[A-Z]/', $password);
    $hasNumber = preg_match('/\d/', $password);

    if (strlen($password) < $minLength) {
        return 'Password must be at least 8 characters long.';
    }
    if (!$hasUppercase) {
        return 'Password must contain at least one uppercase letter.';
    }
    if (!$hasNumber) {
        return 'Password must contain at least one number.';
    }
    return null;
}

function agency_owner_update($agency_id, $user_id)
{
    global $db;

    $db->Update('agency', ['owner_id' => 0], ['owner_id' => $user_id]);
    $db->Update('agency', ['owner_id' => $user_id], ['id' => $agency_id]);
}

function LoadJson($SQL, $EXTRA_WHERE = '', $GROUP_BY = '')
{
    global $db;

    if (!empty($EXTRA_WHERE)) {
        $SQL .= " WHERE $EXTRA_WHERE";
    }

    $stmt = $db->query($SQL . $GROUP_BY);
    $stmt->execute();
    $total = $stmt->rowCount();

    if (!empty($_GET['search']['value'])) {
        $qry = array();
        foreach ($_GET['columns'] as $cl) {
            if ($cl['searchable'] == 'true')
                $qry[] = " " . $cl['name'] . " like '%" . $_GET['search']['value'] . "%' ";
        }
        if (!empty($qry)) {
            $SQL .= " AND (" . implode(" OR ", $qry) . ")";
        }
    }

    if (!empty($GROUP_BY)) {
        $SQL .= $GROUP_BY;
    }

    $stmt = $db->query($SQL);
    $stmt->execute();
    $filtered = $stmt->rowCount();

    if (isset($_GET['order'])) {
        $SQL .= " ORDER BY ";
        $SQL .= $_GET['columns'][$_GET['order'][0]['column']]['name'] . " ";
        $SQL .= $_GET['order'][0]['dir'];
    }

    if ($_GET['length'] >= 0) {
        $SQL .= " LIMIT " . $_GET['length'] . " OFFSET " . $_GET['start'];
    }

    $stmt = $db->query($SQL);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response = array(
        "recordsTotal" => $total,
        "recordsFiltered" => $filtered,
        "data" => $data
    );

    return $response;
}

function custom_number_format($number)
{
    return rtrim(rtrim($number, '0'), '.');
}
