<?php 

    require_once(ROOT .  "/exceptions/HttpStatusException.php");
    require_once(ROOT .  "/utils/controller/IController.php");

    define("START_TIME", "startTime" );
    define("COMPTE_ID", "compteId" );


    function serverBootstrap(){
        error_reporting(E_ALL & ~E_DEPRECATED & ~E_WARNING & ~E_STRICT & ~E_NOTICE & ~E_PARSE);
        ini_set('display_errors', 'off');
    }

    function headerAndDie($header){
        header($header);
        die();
    }


    function _400_Bad_Request($msg = ""){
        headerAndDie("HTTP/1.1 400 bad request: ". $msg);
    }

    function _404_Not_Found($msg = ""){
        headerAndDie("HTTP/1.1 404 Not Found: ". $msg);
    }

    function _405_Method_Not_Allowed($msg = "") {
		headerAndDie("HTTP/1.1 405 Method Not Allowed");
	}

    function _499_Authentication_Error($msg = "") {
        headerAndDie("HTTP/1.1 499 Authentication Error : " . $msg);
    }

    function _500_Internal_Server_Error($msg = "") {
        headerAndDie("HTTP/1.1 500 Internal Server Error : ". $msg);
    }

/* Methodes */

function raiseHttpStatus(HttpStatusException $exception):void{
    switch($exception->getCode()) {
        case 404 :_404_Not_Found($exception->getMessage());
            break;
        case 400 :
            _400_Bad_Request($exception->getMessage());
            break;
        case 405 :
            _405_Method_Not_Allowed($exception->getMessage());
            break;
        case 499:
            _499_Authentication_Error($exception->getMessage());
            break;
        case 500:
            _500_Internal_Server_Error($exception->getMessage());
            break;
        default : throw new Exception ("Http Status Exception not manage" );
    }
}

function extractForm(): array {
    switch ($_SERVER['REQUEST_METHOD']){
        case 'GET':return $_GET;
        case 'POST':return $_POST;
        case 'DELETE':return $_GET;
        case 'PUT':
            $raw = file_get_contents('php://input');
            $form = [];
            parse_str($raw,$form);
            return $form;
        default: _405_method_Not_Allowed() ;
        throw new Exception("Unsupported HTTP method: " . $_SERVER['REQUEST_METHOD']);
        

    }
}


    function extractRoute(array $FORM):string {
		if ( ! isset( $FORM['route'] ) ) {
			 _400_Bad_Request("No parameter: route");
             return "";
		}
		$ROUTE = $FORM['route'];
		if ( preg_match("/^[A-Za-z]{1,64}$/", $ROUTE) ) {
			return $ROUTE;
		}
		_400_Bad_Request("Wrong route syntax :route");
        return "";
	} 
    function createController($FORM,$ROUTE):IController {
        $METHOD = createMethod();
        $CLASS_NAME = $ROUTE . $METHOD . "Controller";
        $FILE = ROOT. "/controllers/". $CLASS_NAME . ".php";
        //if the file doesn't existe we throw an exception.
        if(!file_exists($FILE)) {
            throw new HttpStatusException(404, "Unknown Controller :" . $ROUTE . $METHOD);
        }           
        require($FILE);
        $CONTROLLER = new $CLASS_NAME($FORM);
        return $CONTROLLER;
            
    }

    function createMethod() {
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        return ucfirst($method);
    }

    function isNaturalNumber(string $number):bool {
        return ctype_digit($number);
    }

    function isSanitizedString(string $str):bool {
        return true;
    }

    function sanitizeString(string $str):string {
        return $str;
    }

    function manageSession() {
        session_start();
        initSession();

        if( $_SESSION[START_TIME] + getMaxTime() < time()) {
            reinitSession();
        }
    }

    function initSession() {
        if(!isset($_SESSION[START_TIME])) {
            $_SESSION[START_TIME] = time();
        } else if (isLogged()) {
            $_SESSION[START_TIME] = time();
        }
    }

    function reinitSession() {
        session_destroy();
        session_start();
        initSession();
    }

    
    function getMaxTime():int {
        return 60 * 15; // 15 minutes
    }
    
    function isLogged():bool {
        return isset($_SESSION[COMPTE_ID]);
    }

    function getCompteIdFromSession() : ?int {
        return isLogged() ? $_SESSION[COMPTE_ID] : null;
    }

    function login(int $id) {
        $_SESSION[COMPTE_ID] = $id;
    }
?>