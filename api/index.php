<?php

header('Content-Type: application/json');

use App\Models\User;

require_once('../vendor/autoload.php');
require_once('../class/controler.php');
require_once('../class/qrCode.php');
require_once('../class/users.php');
require_once('../class/database.php');


$controller = new ApiController($_GET['endpoint'], $_SERVER['REQUEST_METHOD']);
$db = new Database();
$userDb = new UserDatabase();
$qrCodeDb = new QrCodeDatabase();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"));
}

switch ($controller->getEndpoint()) {
    case 'login':
        $response = array(
            'token' => $userDb->loginUser($data->email, $data->pass)
        );
        break;
    case 'setuser':
        $newUser = new Users($data->name, $data->email, $data->pass);
        if ($userDb->insertUser($newUser)) {
            $response = array(
                'data' => 'Insert OK'
            );
        } else {
            $response = array(
                'data' => 'Error in insert'
            );
        }
        break;
    case 'getusers':
        $response =array(
            'data' => $userDb->selectAllUsers()
        );
        break;
    case 'updateuser':
        if ($userDb->updateUser($data->id, $data->column, $data->value)) {
            $response = array(
                'data' => 'Update OK'
            );
        } else {
            $response = array(
                'data' => 'Error in update'
            );
        }
        break;
    case 'deleteuser':
        if ($userDb->deleteUser($data->id)) {
            $response = array(
                'data' => 'Delete OK'
            );
        } else {
            $response = array(
                'data' => 'Error in delete'
            );
        }
        break;
    case 'getqrcodes':
        $return = $qrCodeDb->selectQrCodeByUserToken($data->token);
        print_r($return[0]);
        $response = [];
        for ($qrCodesIndex=0; $qrCodesIndex < count($return); $qrCodesIndex++) { 
            $qrCodeClass = new QrCode($return[$qrCodesIndex]['title'], $return[$qrCodesIndex]['link'], $return[$qrCodesIndex]['userToken'], $return[$qrCodesIndex]['reference'],  $return[$qrCodesIndex]['description']);
            $qrCode = array(
                "title" => $qrCodeClass->getTitle(),
                "description" => $qrCodeClass->getDescription(),
                "link" => $qrCodeClass->getLink(),
                "ref" => $qrCodeClass->getRef(),
                "render" => $qrCodeClass->getRender(),
            );
            array_push($response, $qrCode);
        }
        break;
    case 'setqrcode':
        $newQrCode = new QrCode($data->title, $data->link, $data->token);
        if ($qrCodeDb->inserQrCode($newQrCode)) {
            $response = array(
                'data' => 'Insert Qr Code OK'
            );
        } else {
            $response = array(
                'data' => 'Error in Insert'
            );
        }
        break;
    case 'updateqrcode':
        if ($qrCodeDb->updateQrCode($data->id, $data->token, $data->column, $data->value)) {
            $response = array(
                'data' => 'Update Qr Code OK'
            );
        } else {
            $response = array(
                'data' => 'Error in update'
            );
        }
        break;
    case 'deleteqrcode':
        if ($qrCodeDb->deleteQrCode($data->id, $data->token)) {
            $response = array(
                'data' => 'Delete Qr Code OK'
            );
        } else {
            $response = array(
                'data' => 'Error in delete'
            );
        }
        break;
    case 'redirect':
        $returnQrCode = $qrCodeDb->refQrCode($_GET['ref']);
        if ($returnQrCode) {
            header("Location: ".$returnQrCode->getLink(), true, 302);
            exit();
        } else {
            $response = array(
                'data' => 'Error in redirect'
            );
        }
        break;
    default:
        $response = 'No Data';
        break;
}
echo json_encode($response);