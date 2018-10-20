<?php
//<project>/app/Traits/ApiResponser.php
namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponser
{
    function successReponse($data,$code=200)
    {
        return response()->json($data, $code);
    }//successResponse

    /**
     * 
     * @param mixed $message String|Array
     * @param integer $code
     * @return String 
     */
    function errorResponse($message, $code)
    {
        return response()->json(["error"=>["message"=>$message,"code"=>$code]],$code);
    }//errorResponse

    function showAll(Collection $collection,$code=200)
    {
        if($collection->isEmpty())
        {
            $arData = ["data"=>$collection];
            return $this->successReponse($arData,$code);
        }
        $collection = $this->paginateCollection($collection);
        $resource = $collection->first()->resource;
        $transformedCollection = $resource::collection($collection);
        $arData = ["data"=>$transformedCollection];
        
        return $this->successReponse($arData,$code);
    }//showAll

    function showOne(Model $instance, $code=200)
    {
        $resource = $instance->resource;
        $transformedInstance = new $resource($instance);
        $arData = ["data"=>$transformedInstance];
        return $this->successReponse($arData,$code);
    }//showOne

    function showMessage(String $message, $code=200)
    {
        return $this->successReponse($message,$code);
    }//showMessage    

    function paginateCollection(Collection $collection)
    {
        $perPage = $this->determinePageSize();
        $page = LengthAwarePaginator::resolveCurrentPage();
        $results = $collection->slice(($page-1)*$perPage,$perPage)->values();
        $paginated = new LengthAwarePaginator(
                $results,$collection->count()
                ,$perPage
                ,$page
                ,["path"=> LengthAwarePaginator::resolveCurrentPath()]
        );
        $paginated->appends(request()->query());
        return $paginated;
    }//paginateCollection
    
    function determinePageSize()
    {
        $rules = [
            "per_page" => "integer|min:2|max:50",
        ];
        //aqui se puede dar la excepción
        $perpage = request()->validate($rules);
        return isset($perpage["per_page"]) ? (int)$perpage["per_page"] : 5;
    }//determinePageSize
    
    
}//trait ApiResponser