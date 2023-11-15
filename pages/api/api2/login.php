<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
function msg($success, $status, $message, $extra = [])
{
    return array_merge([
        'success' => $success,
        'status' => $status,
        'message' => $message
    ], $extra);
}

require __DIR__ . '/Classes/Database.php';
require __DIR__ . '/Classes/JwtHandler.php';

$db_connection = new Database();
$conn = $db_connection->dbConnection();

$data = json_decode(file_get_contents("php://input"));
$returnData = [];

if (!isset($data->phone) || !isset($data->password) || empty(trim($data->phone)) || empty(trim($data->password))) {
    $returnData = $returnData = msg(0, 422, 'Хоосон утга байна!');
}
else {
    $phone = trim($data->phone);
    $password = trim($data->password);
    $userType = trim($data->userType);

    if (strlen($password) < 1) {
        $returnData = msg(0, 422, 'Нууц үг хамгийн багадаа 1-н тэмдэгтийн урттай байна!');}
    else {
            try {
                if($userType == "1")
                    $fetch_user_by_phone = "SELECT id, pass FROM `teacher` WHERE `phone`=:phone";
                else $fetch_user_by_phone = "SELECT id, pass FROM `parent` WHERE `phone`=:phone";
                
                $query_stmt = $conn->prepare($fetch_user_by_phone);
                $query_stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
                $query_stmt->execute();

                if ($query_stmt->rowCount()) :
                    $row = $query_stmt->fetch(PDO::FETCH_ASSOC);
                    //$check_password = password_verify($password, $row['pass']);

                    if ($password == $row['pass']) :

                        $jwt = new JwtHandler();
                        $token = $jwt->_jwt_encode_data(
                            DOMAIN . "/api",
                            array("user_id" => $row['id'], "userType" => $userType)
                        );

                        $returnData = [
                            'success' => 1,
                            'message' => 'Амжилттай нэвтэрлээ.',
                            'token' => $token
                        ];
                    else :
                        $returnData = msg(0, 422, 'Нууц үг буруу байна!');
                    endif;
                else :
                    $returnData = msg(0, 422, 'Утасны дугаар буруу байна!');
                endif;
            } catch (PDOException $e) {
                $returnData = msg(0, 500, $e->getMessage());
            }
    }
}
echo json_encode($returnData);
