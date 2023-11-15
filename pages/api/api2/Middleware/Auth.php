<?php
include  ROOT . '/pages/api/Classes/JwtHandler.php';
class Auth extends JwtHandler{

    protected $db;
    protected $headers;
    protected $token;
    public function __construct($db,$headers) {
        parent::__construct();
        $this->db = $db;
        $this->headers = $headers;
    }

    public function checkToken(){
        if(array_key_exists('Authorization',$this->headers) && !empty(trim($this->headers['Authorization']))):
            $this->token = explode(" ", trim($this->headers['Authorization']));
            if(isset($this->token[1]) && !empty(trim($this->token[1]))):
                $data = $this->_jwt_decode_data($this->token[1]);
                if($data["auth"] == 1)
                    return TRUE;
                else return FALSE;
            else:
                return null;

            endif;// End of isset($this->token[1]) && !empty(trim($this->token[1]))

        else:
            return null;

        endif;
    }

    public function isAuth(){
        if(array_key_exists('Authorization',$this->headers) && !empty(trim($this->headers['Authorization']))){
            $this->token = explode(" ", trim($this->headers['Authorization']));
            if(isset($this->token[1]) && !empty(trim($this->token[1])))
            {
                $data = $this->_jwt_decode_data($this->token[1]);
                if(isset($data['auth']) && isset($data['data']->user_id) && $data['auth']){
                    $user = $this->fetchUser($data['data']->user_id, $data['data']->userType);
                    return $user;
                }
                else { 
                    return "null"; 
                }
            }
            else { 
                return null; 
            }
        }
        else return null;

    }
    protected function fetchUser($user_id, $userType){
        try{
            if($userType == "1")
                $fetch_user_by_id = "SELECT id, concat(`fname`, ' ', `lname`) as lname,`phone`, at FROM `teacher` WHERE `id`=:id";
            else $fetch_user_by_id = "SELECT id, concat(`fname`, ' ', `lname`) as lname,`phone` FROM `parent` WHERE `id`=:id";
            $query_stmt = $this->db->prepare($fetch_user_by_id);
            $query_stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
            $query_stmt->execute();

            if($query_stmt->rowCount()):
                $row = $query_stmt->fetch(PDO::FETCH_ASSOC);
                return [
                    'success' => 1,
                    'status' => 200,
                    'user' => $row
                ];
            else:
                return "null";
            endif;
        }
        catch(PDOException $e){
            return null;
        }
    }
}