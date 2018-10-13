<?php
//<project>\app\Http\Controllers\Controller.php
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Traits\ApiResponser;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ApiResponser;

    public function transformAndValidateRequest($sResClass,$request,$rules)
    {
        $transformedRules = $this->transformData($sResClass,$rules);
        $data = $request->validate($transformedRules);
        $originalData = $this->transformData($sResClass,$data,TRUE);
        return $originalData;
    }//transformAndValidateRequest
    
    public function transformData($sResClass,$data,$invert = FALSE)
    {
        $transformedData = [];
        foreach($data as $attribute => $value)
            $transformedData[$sResClass::mapAttribute($attribute,$invert)] = $value;
        return $transformedData;
    }//transformData
    
}//Controller
