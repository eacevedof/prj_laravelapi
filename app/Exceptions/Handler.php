<?php
namespace App\Exceptions;

use Exception;
use App\Traits\ApiResponser;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if($exception instanceof ValidationException)
            return $this->convertValidationExceptionToResponse($exception,$request);

        if($exception instanceof ModelNotFoundException)
            return $this->errorResponse($exception->getMessage(),404); 

        if($exception instanceof NotFoundHttpException)
            return $this->errorResponse("No endpoint found",$exception->getStatusCode());  

        if($exception instanceof MethodNotAllowedHttpException)
            return $this->errorResponse("Method not allowed",$exception->getStatusCode());       

        if($exception instanceof HttpException)
            return $this->errorResponse($exception->getMessage(),$exception->getStatusCode());        
            
        //lee .env APP_DEBUG = true - se está en desarrollo
        if(config("app.debug"))
            return parent::render($request, $exception);
        
        return $this->errorResponse("Unexpected error",500);
    }//render

    /**
     * Create a response object from the given validation exception.
     *
     * @param  \Illuminate\Validation\ValidationException  $exeption
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertValidationExceptionToResponse(ValidationException $exception, $request)
    {
        $arErrors = $exception->validator->errors()->getMessages();
        //\dg::p($arErrors,"errors");die;
        return $this->errorResponse($arErrors,422);
        
        /*
        return $request->expectsJson()
            ? $this->invalidJson($request, $exception)
            : $this->invalid($request, $exception);
         * 
         */
    }//convertValidationExceptionToResponse
    
}//Handler
