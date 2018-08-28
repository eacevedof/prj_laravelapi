<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //devuelve una lista completa de usuarios
        //Illuminate\Database\Eloquent\Collection 
        $oCollection = User::all()->random(100);
        return response()->json(["data"=>$oCollection],200);
        //201: es instancia creada, en metodo store()
        //return response()->json(["data"=>$oCollection],201);
        //var_dump($users);die;
        //return $oCollection->all();
        //return $oCollection;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //var_dump($request);die;
        //hace insert
        $arData = $request->validate([
            "name" => "required|max:100",
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
        return response()->json(["data"=>$oUser],201);   
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //ruta users/{id}
        return response()->json(["data"=>$user],200);        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
