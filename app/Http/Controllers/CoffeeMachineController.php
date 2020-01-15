<?php

namespace App\Http\Controllers;

use App\Models\Coffee;
use Illuminate\Http\Request;
use App\Models\CoffeeMachine;
use App\Models\CoffeeMachineCoffee;

class CoffeeMachineController extends Controller
{
    public function index()
    {
        $machines = CoffeeMachine::all();
        return view('admin/coffee-machines/index', compact('machines'));
    }

    public function add()
    {
        $coffees = Coffee::all();
        return view('admin/coffee-machines/add', compact('coffees'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'url' => 'required',
        ]);

        $data = $request->all();

        $machine = new CoffeeMachine;
        $machine->name = $data['name'];
        $machine->description = $data['description'];
        $machine->url = $data['url'];
        $access_code = uniqid();
        $machine->access_code = substr($access_code, -4);
        $machine->json = '';
        $machine->save();

        if (count($data['coffees']) > 0) {
            foreach ($data['coffees'] as $coffee) {
                $coffeesMachineCoffees = new CoffeeMachineCoffee;
                $coffeesMachineCoffees->coffee_machine_id = $machine->id;
                $coffeesMachineCoffees->coffee_id = $coffee;
                $coffeesMachineCoffees->save();
            }
        }

        return redirect()->route('admin.coffee-machine')->with('status', 'Cafeteira adicionada!');
    }

    public function edit($id)
    {
        $edit = CoffeeMachine::find($id);
        if (!$edit) abort(404);
        $coffees = Coffee::all();
        $coffeesMachineCoffees = $edit->where('coffee_machine_id', $id)->coffees()->get();
        $cmc = [];
        foreach ($coffeesMachineCoffees as $key => $value) {
            $cmc[] = $value['id'];
        }
        $coffeesMachineCoffees = $cmc;
        return view('admin/coffee-machines/edit', compact('edit', 'coffeesMachineCoffees', 'coffees'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'url' => 'required',
            'id' => 'required',
        ]);

        $data = $request->all();

        $machine = CoffeeMachine::find($data['id']);
        if (!$machine) abort(404);
        $machine->name = $data['name'];
        $machine->description = $data['description'];
        $machine->url = $data['url'];
        $machine->save();

        if (count($data['coffees']) > 0) {
            $coffeesMachineCoffees = CoffeeMachineCoffee::where('coffee_machine_id', $data['id'])->get();
            if (count($coffeesMachineCoffees) > 0) {
                foreach ($coffeesMachineCoffees as $forceDelete) {
                    $forceDelete->delete();
                }
            }

            foreach ($data['coffees'] as $coffee) {
                $coffeesMachineCoffees = new CoffeeMachineCoffee;
                $coffeesMachineCoffees->coffee_machine_id = $data['id'];
                $coffeesMachineCoffees->coffee_id = $coffee;
                $coffeesMachineCoffees->save();
            }
        }
        return redirect()->route('admin.coffee-machine')->with('status', 'Cafeteira alterada!');
    }

    public function delete($id)
    {
        $machine = CoffeeMachine::find($id);
        if (!$machine) abort(404);
        $coffeesMachineCoffees = CoffeeMachineCoffee::where('coffee_machine_id', $id)->get();
        if (count($coffeesMachineCoffees) > 0) {
            foreach ($coffeesMachineCoffees as $forceDelete) {
                $forceDelete->delete();
            }
        }

        $machine->delete();

        return redirect()->route('admin.coffee-machine')->with('status', 'Cafeteira excluída!');
    }
}
