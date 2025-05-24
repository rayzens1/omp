<?php 

    define("ROOT", dirname(__FILE__) );// 
    require_once (ROOT."/utils/functions.php");
    require_once (ROOT."/exceptions/HttpStatusException.php");
    serverBootstrap();
    manageSession();
    $FORM = extractForm();
    $ROUTE = extractRoute($FORM);
    try {
        $CONTROLLER = createController($FORM,$ROUTE);
        $response = $CONTROLLER->execute();
        header('Content-Type: application/json; charset=UTF-8');
        echo $response;
    } catch (HttpStatusException $exception){
        raiseHttpStatus($exception);
    } catch (Throwable $exception){
        throw $exception;
    }
    
    
     
?>