<?php
class HttpStatusException extends Exception { 
    public function __construct( int $code, string $message, ?Throwable $previous = null){
        parent::__construct($message,$code,$previous);
    }
}