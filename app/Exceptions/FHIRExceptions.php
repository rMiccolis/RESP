<?php 

namespace App\Exceptions;

use Mockery\Exception;

class FHIRExceptions extends Exception{
    
    /*
    public function render($request, Exception $exception)
    {
        if ($exception instanceof IdNotFoundInDatabaseException) {
            return response()->view('errors.custom', [], 500);
        }
        
        return parent::render($request, $exception);
    }
    */
    
}

?>