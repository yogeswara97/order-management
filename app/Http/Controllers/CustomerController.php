<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = 30;

        $customers = Customer::search($search)
            ->orderBy('status', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        $customersName = Customer::pluck('name')->toArray();

        $title = "Customer";

        return view('customers.index', compact('customers', 'perPage', 'title', 'customersName'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Customer";

        return view('customers.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|email|unique:customers,email|max:255',
            'phone' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'status' => 'required|string|max:8',
        ]);

        $customer = Customer::create($data);

        // Optionally, redirect to a success page or return a response
        return redirect()->route('customer.index', $customer->id)->with('success', 'Customer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $perPage = 30;
        $customer = Customer::findOrFail($id);
        $orders = Order::where('customer_id', $customer->id)->paginate($perPage);

        $title = "Customer";


        return view('customers.show', compact('customer', 'orders', 'perPage', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = Customer::findOrFail($id);

        $title = "Customer";


        return view('customers.edit', compact('customer', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $customer = Customer::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'nullable',
                'string',
                'email',
                'max:255',
                Rule::unique('customers', 'email')->ignore($customer->id),
            ],
            'phone' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'status' => 'required|string|max:8',
        ]);



        $customer->update($data);

        return redirect()->route('customer.index')->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);

        $customer->delete();

        return redirect()->route('customer.index')->with('success', 'Customer deleted successfully.');
    }
}
