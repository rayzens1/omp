<?php 

    define("ROOT", dirname(__FILE__) );// 
    require_once (ROOT."/utils/functions.php");
    require_once (ROOT."/exceptions/HttpStatusException.php");
    serverBootstrap();
    $FORM = extractForm();
    $ROUTE = extractRoute($FORM);
    try {
        $CONTROLLER = createController($FORM,$ROUTE);
        $CONTROLLER->execute();
    } catch (Exception $exception){
        raiseHttpStatus($exception);
    } catch (Throwable $exception){
        throw $exception;
    }
    
    
     
?>