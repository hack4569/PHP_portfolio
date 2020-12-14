<?php 

include_once  $_SERVER['DOCUMENT_ROOT'] ."/wine/autoloader.php";
include_once  $_SERVER['DOCUMENT_ROOT'] ."/wine/common.php";
phpinfo();
$route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'),'/');
$method = $_SERVER['REQUEST_METHOD'];

//20201208 loadTemplate를 사용하는 이유 : 사실 중복소스가 발생하지 않기 때문에 loadTemplate라는 함수를 만들지 않아도 된다. 하지만 extract함수를 사용하기 위해서 만들 필요가 있다.
//문제는 전역변수를 어떻게 만들어야 할지 잘 모르겠다. 
function loadTemplate($templateFileName, $searchVO, $variables = []) {
    extract($variables);
    
    //전역변수
    include $_SERVER['DOCUMENT_ROOT']."/wine/comm/global_variables.php"; 

    //리다이렉트 정보
    $sfst_cate = $searchVO -> getSfst_cate();
    $ssnd_cate = $searchVO -> getSsnd_cate();
    $skey      = $searchVO -> getSkey();
    $addUrl    = $searchVO -> getAddUrl();

	ob_start();
	include  './templates/' . $templateFileName;
	return ob_get_clean();
}

if(strpos($route, 'wine/adm')!==false && $route!='wine/adm/login'){
    //로그인 검증 객체생성
    //설명 :
    //1. 찾을 컬럼명 userid
    //2. 테이블
    //3. 입력값
    $userid = isset($_SESSION['userid'])?$_SESSION['userid'] : "";
    if($userid!="admin"){
        header("Location: /wine/adm/login");
    }
    $loginController = new \Login\Authentication($pdo,"userid", 'manager', $userid);
}else if(strpos($route, 'wine/adm')!==false && $route=='wine/adm/login'){
    $userid = isset($_POST['userid'])?$_POST['userid'] : "";
    $loginController = new \Login\Authentication($pdo,"userid", 'manager', $userid);
}

//객체생성
$searchVO = new \Product_management\SearchVO();//카테고리
//리다이렉트 정보
$sfst_cate = $searchVO -> getSfst_cate();
$ssnd_cate = $searchVO -> getSsnd_cate();
$skey      = $searchVO -> getSkey();
$addUrl    = $searchVO -> getAddUrl();

//상품정보
$productDAO = new \Product_management\Product_managementDAO($pdo, $searchVO);
$productController = new \Product_management\Product_managementContoller($productDAO, $searchVO);

$routes = [
    'wine/adm/login' =>[
        'POST'=>[
            'controller'=>$loginController,
            'action'=>'login_process'
        ],
        'GET'=>[
            'controller'=>$loginController,
            'action'=>'login'
        ]
    ],
    'wine/adm/product_management/add'=>[
        'GET'=>[
            'controller'=>$productController,
            'action'=>'product_add'
        ],
        'POST'=>[
            'controller'=>$productController,
            'action'=>'product_insert'
        ]
    ],
    'wine/adm/product_management/update'=>[
        'GET'=>[
            'controller'=>$productController,
            'action'=>'product_update'
        ],
        'POST'=>[
            'controller'=>$productController,
            'action'=>'product_modify'
        ]
    ],
    'wine/adm/product_management/delete'=>[
        'POST'=>[
            'controller'=>$productController,
            'action'=>'product_delete'
        ]
    ],
    'wine/adm/product_management/list'=>[
        'GET'=>[
            'controller'=>$productController,
            'action'=>'product_list'
        ]
    ]
];

$controller = $routes[$route][$method]['controller'];
$action = $routes[$route][$method]['action'];
try{
    $page = $controller->$action();
    $title = $page['title'];
    if(isset($page['variables'])){
        $output = loadTemplate($page['template'], $searchVO, $page['variables']);
    }else{
        $output = loadTemplate($page['template'], $searchVO);
    }
}catch(PDOException $e){
    $title = '오류가 발생했습니다';

	$output = '데이터베이스 오류: ' . $e->getMessage() . ', 위치: ' .
	$e->getFile() . ':' . $e->getLine();
}

if($route=='wine/adm/login'){
    include $_SERVER['DOCUMENT_ROOT']."/wine/templates/login/login.layout.php";
}else if(strpos($route, 'wine/adm')!==false){
    include './templates/admin/admin.layout.php';
}
