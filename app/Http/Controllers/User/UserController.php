<?php
//<project>/app/Http/Controllers/User/UserController.php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //devuelve una lista completa de usuarios
        //$oCollection: Illuminate\Database\Eloquent\Collection 
        //$oCollection = User::where("name",'%like%',$request->name)->get();
        //return response()->json(["data"=>$oCollection],200);
        $oCollection = User::all();
        $oCollection = UserResource::collection($oCollection);
        return $oCollection;
        //return $this->showAll($oCollection);
        //201: es instancia creada, en metodo store()
        //return response()->json(["data"=>$oCollection],201);
        //var_dump($users);die;
        //return $oCollection->all();
        //return $oCollection;
    
    }//index

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //ruta users
        //var_dump($request);die;
        //hace insert
        $arData = $request->validate([
            "name" => "required|max:255",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:6|confirmed",
        ]);
        
        $arData["password"] = bcrypt($arData["password"]);
        
        /*
        $arData: array(3) {
          ["name"] => string(4) "juan"
          ["email"] => string(17) "prueba@prueba.com"
          ["password"] => string(60) "$2y$10$koMLOC7rr3jb7nb4qwd.M.EnuIFU8kYSLARwBBzH/nCjGGdzos08W"
        }
        */
        
        //var_dump($arData);die;
        $oUser = User::create($arData);
        
        //201 es parte del cod http que indica que se ha creado satisfactoriamente una instancia
        return $this->showOne($oUser,201);  
    }//store

    /**
     * Display the specified resource.
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //ruta users/{id}
        //el modelo $user ya tiene inyectado el recurso por composición
        return $this->showOne($user);   
    }//show

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $arData = $request->validate([
            "name" => "max:255",
            //con user->id se excluye de la validación el email del mismo usuario
            "email" => "email|unique:users,email,{$user->id}",
            "password" => "min:6|confirmed",
        ]);
        
        if($request->has("name")) $user->name = $request->name;
        if($request->has("email")) $user->email = $request->email;
        if($request->has("password")) $user->password = bcrypt($request->password);
            
        //si el usuario no ha cambiado
        if(!$user->isDirty()) 
            return $this->errorResponse("Please specify at least one different value",422);
        
        $user->save();
        
        return $this->showOne($user); 
    }//update

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //delete
        $user->delete();
        return $this->showOne($user); 
    }//destroy
    
}//UserController
