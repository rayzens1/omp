<?php

	require_once(ROOT . "/exceptions/ConstraintUniqueException.php");
	// ...23000: Integrity violation...: 1062 ............... 'Compte.email_UNIQUE'....
	function wrapPDOException(PDOException $ex) {
                if (intval($ex->getCode()) == 23000) {
                        $code = trim( explode(":", $ex->getMessage())[2] );
                        $split = explode(" ", $code);
                        switch ( intval($split[0]) ) {
                        case 1062 : return new ConstraintUniqueException( trim(end($split), "'"), 1062 );
                        }
                }
                return $ex;
        }

?>