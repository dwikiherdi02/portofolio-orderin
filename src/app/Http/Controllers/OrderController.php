<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public const PAGE = 'Order';

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('order.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $customers = Customer::select(['id', 'name'])->orderBy('name', 'asc')->get();
        return view('order.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
