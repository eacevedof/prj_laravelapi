<?php
//<project>/app/Http/Controllers/Category/CategoryController.php
namespace App\Http\Controllers\Category;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $oCollection = Category::all();
        return $this->showAll($oCollection);
    }//index

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create(){}//create

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //en la migración estan las restricciones de los campos y estas hay que validarlas
        //<project>/database/migrations/2018_08_18_131136_create_categories_table.php
        $data = $request->validate([
            "name" => "required|max:255",
            "description" => "required|max:1000"
        ]);
        $category = Category::create($data);
        return $this->showOne($category,201);
    }//store

    /**
     * Display the specified resource.
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $this->showOne($category);
    }//show

    /**
     * Show the form for editing the specified resource.
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }//edit

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            "name" => "max:255",
            "description" => "max:1000"
        ]);
        
        //fill nos asegura que solo se trate los valores que llegan por post
        $category->fill($request->only(["name","description"]));

        //si no hay cambios
        if($category->isClean())
            return $this->errorResponse("You need to specify any new value to update the category",422);

        $category->save();
        return $this->showOne($category);
    }//update


    /**
     * Remove the specified resource from storage.
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return $this->showOne($category);
    }//destroy
    
}//CategoryController
