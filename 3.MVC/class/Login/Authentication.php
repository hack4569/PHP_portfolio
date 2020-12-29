<?php
namespace Login;
use \Comm\DatabaseComm;
    class Authentication extends \Comm\DatabaseComm{
        
        private $searchColumn;
        private $searchTable;
        private $inputData;
        
        // $searchColumns = array(
        //     "userid"=>array(
        //         'kor'=>'사용자ID',
        //         'col'=> $_SESSION['userid'] or $_POST['userid']
        //     )
        // )
        public function __construct(\PDO $pdo, String $searchColumn, String $searchTable, $inputData=''){
            parent::__construct($pdo);
            $this->searchColumn = $searchColumn;
            $this->searchTable = $searchTable;
            $this->inputData = $inputData;
        }

        public function isLogin(){
            $searchColumn = $this->searchColumn;
            $searchTable = $this->searchTable;
            $inputData = $this->inputData;

            $query = "select $searchColumns, password, count(*) as cnt from $searchTable where $searchColumn = :$searchColumn";

            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':$searchColumn',$inputData);
            $stmt->execute();
            $row = $stmt -> fetch();

            if($row['cnt']>0){
                if($row[$searchColumn]!=$inputData){
                    \Util::alert_redirect("로그인 후 이용가능합니다.". "/wine/adm/login");
                }
                if($row['password']!=$_SESSION['password']){
                    $this->logOut();
                }
            }
        }

        public function login_process(){
            $searchColumn = $this->searchColumn;
            $searchTable = $this->searchTable;
            $inputData = $this->inputData;

            $query = "select $searchColumn, password, count(*) as cnt from $searchTable where $searchColumn = :$searchColumn";

            $paramArr = [':'.$searchColumn=>$inputData];
            $stmt = $this->query($query,$paramArr);
            $row = $stmt -> fetch();

            if($row['cnt']>0){
                $encpasswd = hash('sha256', $_POST['password'].$searchColumn);
                if($row[$searchColumn]!=$inputData){
                    \Util::alert_redirect("아이디를 잘못입력하셨습니다.","/wine/adm/login");
                }
                if($row['password']!=$encpasswd){
                    \Util::alert_redirect("비밀번호를 잘못 입력하였습니다.", "/wine/adm/login");
                }
                $_SESSION["userid"] = $inputData;
                \Util::gotoUrl("/wine/adm/product_management/list");
            }
        }

        public function logOut(){
            session_unset(); // 모든 세션변수를 언레지스터 시켜줌
            session_destroy(); // 세션해제함
            
            \Util::gotoUrl("/wine/adm/product_management");
        }

        public function login(){
            return [
                'title'=>'로그인',
                'template'=>'login/login.form.php'
            ];
        }
    }
?>