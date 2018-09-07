<?php
//<project>/app/Http/Controllers/TransactionCategoryController.php
namespace App\Http\Controllers;

use App\Category;
use App\Transaction;
use Illuminate\Http\Request;

class TransactionCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function index(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function create(Transaction $transaction)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction, Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction, Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaction  $transaction
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transaction  $transaction
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction, Category $category)
    {
        //
    }
}
