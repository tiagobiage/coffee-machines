<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coffee;
use App\Models\CoffeeMachineCoffee;

class CoffeeController extends Controller
{
    public function index()
    {
        $coffees = Coffee::all();
        return view('admin/coffees/index', compact('coffees'));
    }

    public function add()
    {
        return view('admin/coffees/add');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'code' => 'required',
        ]);

        $data = $request->all();

        $coffee = new Coffee;
        $coffee->name = $data['name'];
        $coffee->description = $data['description'];
        $coffee->code = $data['code'];
        $coffee->save();
        return redirect()->route('admin.coffee')->with('status', 'Café adicionado!');
    }

    public function edit($id)
    {
        $edit = Coffee::find($id);
        if (!$edit) abort(404);
        return view('admin/coffees/edit', compact('edit'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'code' => 'required',
            'id' => 'required',
        ]);

        $data = $request->all();

        $coffee = Coffee::find($data['id']);
        if (!$coffee) abort(404);
        $coffee->name = $data['name'];
        $coffee->description = $data['description'];
        $coffee->code = $data['code'];
        $coffee->save();
        return redirect()->route('admin.coffee')->with('status', 'Café alterado!');
    }

    public function delete($id)
    {
        $coffee = Coffee::find($id);
        if (!$coffee) abort(404);
        $coffee->delete();
        $coffeesMachineCoffees = CoffeeMachineCoffee::where('coffee_id', $id)->get();
        $coffeesMachineCoffees->delete();
        return redirect()->route('admin.coffee')->with('status', 'Café excluído!');
    }
}
