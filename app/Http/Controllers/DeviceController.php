<?php

namespace App\Http\Controllers;

use App\Events\CoffeesEmployee;
use App\Models\Coffee;
use Illuminate\Http\Request;
use App\Models\CoffeeMachine;
use App\Models\Employee;
use App\Models\Order;
//use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Session\Session;

class DeviceController extends Controller
{
    public function index($id)
    {
        $access_code =  session()->get('access_code');
        $session = new Session();
        if ($access_code == null) {
            $access_code = $session->get('access_code');
        }
        $coffeeMachine = CoffeeMachine::where('id', $id)->where('access_code', $access_code)->first();
        if (!$coffeeMachine) abort(404);
        $idCoffeeMachine = $coffeeMachine->id;
        $session->set('access_code', $access_code);
        return view('devices/index', compact('idCoffeeMachine', 'access_code'));
    }

    public function apiCoffeeMachine(Request $request, $machineId)
    {
        $data = $request->all();
        $coffeeMachine = CoffeeMachine::where('id', $machineId)->where('access_code', $data['accesscode'])->first();
        if (!$coffeeMachine) return response()->json(['error' => 'Device not found'], 404, array(), JSON_PRETTY_PRINT);
        return response()->json(['coffeeMachine' => $coffeeMachine], 200, array(), JSON_PRETTY_PRINT);
    }

    public function apiEmployee($employeeCode, $machineId)
    {
        $coffeeMachine = CoffeeMachine::where('id', $machineId)->first();
        if (!$coffeeMachine) return response()->json(['error' => 'Device not found'], 404, array(), JSON_PRETTY_PRINT);
        $employee = Employee::firstOrCreate(['code' => $employeeCode], ['name' => '', 'code' => $employeeCode]);
        $coffees = $coffeeMachine->where('coffee_machine_id', $machineId)->coffees()->get();
        $dataEvent = new \stdClass;
        $dataEvent->employee = $employee;
        $dataEvent->coffees = $coffees;
        $dataEvent->machine_id = $machineId;
        event(new CoffeesEmployee($dataEvent));
        return response()->json(['employee' => $employee, 'coffees' => $coffees], 200, array(), JSON_PRETTY_PRINT);
    }

    public function apiOrder(Request $request, $employeeId, $machineId, $coffeeId)
    {
        $data = $request->all();
        $coffeeMachine = CoffeeMachine::where('id', $machineId)->where('access_code', $data['accesscode'])->first();
        if (!$coffeeMachine) return response()->json(['error' => 'Device not found'], 404, array(), JSON_PRETTY_PRINT);
        $employee = Employee::find($employeeId);
        if (!$employee) return response()->json(['error' => 'Employee not found'], 404, array(), JSON_PRETTY_PRINT);
        $coffee = Coffee::find($coffeeId);
        if (!$coffee) return response()->json(['error' => 'Coffee not found'], 404, array(), JSON_PRETTY_PRINT);
        $order = new Order;
        $order->employee_id = $employee->id;
        $order->coffee_machine_id = $coffeeMachine->id;
        $order->coffee_id = $coffeeId;
        $order->rating = 0;
        $order->save();
        return response()->json(['order' => $order, 'coffeeCode' => $coffee->code], 200, array(), JSON_PRETTY_PRINT);
    }

    public function apiRate(Request $request, $employeeId, $orderId, $coffeeId, $rate)
    {
        $data = $request->all();
        $coffeeMachine = CoffeeMachine::where('id', $data['machineId'])->where('access_code', $data['accesscode'])->first();
        if (!$coffeeMachine) return response()->json(['error' => 'Device not found'], 404, array(), JSON_PRETTY_PRINT);
        $employee = Employee::find($employeeId);
        if (!$employee) return response()->json(['error' => 'Employee not found'], 404, array(), JSON_PRETTY_PRINT);
        $order = Order::find($orderId);
        if (!$order) return response()->json(['error' => 'Order not found'], 404, array(), JSON_PRETTY_PRINT);
        $coffee = Coffee::find($coffeeId);
        if (!$coffee) return response()->json(['error' => 'Coffee not found'], 404, array(), JSON_PRETTY_PRINT);

        $order->rating = $rate;
        $order->save();
        return response()->json(['success' => true], 200, array(), JSON_PRETTY_PRINT);
    }

    public function apifinishOrder(Request $request, $orderId)
    {
        $data = $request->all();
        $coffeeMachine = CoffeeMachine::where('id', $data['machineId'])->where('access_code', $data['accesscode'])->first();
        if (!$coffeeMachine) return response()->json(['error' => 'Device not found'], 404, array(), JSON_PRETTY_PRINT);
        $order = Order::find($orderId);
        if (!$order) return response()->json(['error' => 'Order not found'], 404, array(), JSON_PRETTY_PRINT);

        $order->expired = 1;
        $order->save();
        return response()->json(['success' => true], 200, array(), JSON_PRETTY_PRINT);
    }

    public function login()
    {
        $coffeeMachines = CoffeeMachine::all();
        return view('devices/login', compact('coffeeMachines'));
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'machine' => 'required',
            'code' => 'required',
        ]);

        $data = $request->all();
        $coffeeMachine = CoffeeMachine::where('id', $data['machine'])->where('access_code', $data['code'])->first();
        if (!$coffeeMachine) return redirect()->route('device.login')->with('status', 'Código de acesso inválido!');
        return redirect("/device/" . $data['machine'])->with('access_code', $data['code']);
    }
}
