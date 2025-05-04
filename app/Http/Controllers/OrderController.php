<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = 50;

        $orders = Order::with('customer')
            ->orderByRaw("FIELD(status, 'new', 'quotation', 'invoice')")
            ->orderByDesc('created_at')
            ->filter($request->only(['start', 'end', 'search']))
            ->paginate($perPage);

        $customersName = Customer::pluck('name')->toArray();
        $title = "Order";

        return view('orders.index', compact('orders', 'perPage', 'title','customersName'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Order";

        $customers = Customer::all();

        $currentYear = Carbon::now()->year;
        $orderCount = Order::whereYear('order_date', $currentYear)->count();

        $orderId = str_pad($orderCount + 1, 3, '0', STR_PAD_LEFT);

        return view('orders.create', compact('title', 'orderId', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => 'nullable|numeric',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|string|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'customer_country' => 'nullable|string|max:100',
            'order_date' => 'required|date',
            'reference_number' => 'nullable|string|max:255',
            'order_number' => 'nullable|string|max:255',
            'object' => 'nullable|string|max:255',
            'cargo' => 'nullable|string|max:255',
            'status' => 'required|in:new,quotation,invoice',
            'currency' => 'required|string|max:10',
            'exchange_rate' => 'integer',
            'vat' => 'nullable|numeric|max:100',
        ]);

        try {
            if ($data['customer_id'] == null) {
                $customer = Customer::create([
                    'name' => $data['customer_name'],
                    'email' => $data['customer_email'],
                    'phone' => $data['customer_phone'],
                    'country' => $data['customer_country'],
                    'status' => 'Common',
                ]);

                $data['customer_id'] = $customer->id;
            }

            $order = Order::create($data);

            return redirect()->route('order.show', $order->id)->with('success', 'Order created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Duplicate entry email ' . $data['customer_email']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::with(['orderItems', 'customer'])->findOrFail($id);

        $title = "Order";

        // dd($order);

        return view('orders.show', compact('order', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $order = Order::with([ 'customer'])->findOrFail($id);
        $order_count = count($order->orderItems);

        $customers = Customer::all();
        $title = "Order";

        return view('orders.edit', compact('order', 'order_count', 'customers', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $data = $request->validate([
            'customer_id' => 'nullable|numeric',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|string|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'customer_country' => 'nullable|string|max:100',
            'order_date' => 'required|date',
            'reference_number' => 'nullable|string|max:255',
            'order_number' => 'nullable|string|max:255',
            'object' => 'nullable|string|max:255',
            'cargo' => 'nullable|string|max:255',
            'status' => 'required|in:new,quotation,invoice',
            'currency' => 'nullable|string|max:10',
            'exchange_rate' => 'required|integer',
            'vat' => 'nullable|numeric|max:100',
            'total' => 'required|numeric',
            'vat_total' => 'required|numeric',
            'grand_total' => 'required|numeric',
            'deposit_amount' => 'nullable|numeric',
            'deposit_description' => 'nullable|string|max:255',
            'terms_conditions' => 'nullable|string',
        ]);

        // dd($data);

        try {
            if ($data['customer_id'] == null) {
                $customer = Customer::create([
                    'name' => $data['customer_name'],
                    'email' => $data['customer_email'],
                    'phone' => $data['customer_phone'],
                    'country' => $data['customer_country'],
                    'status' => 'Common',
                ]);
                $data['customer_id'] = $customer->id;
            }

            if ($request->vat == null) {
                $data['vat'] = 0;
            }

            $vat_total = $data['total'] * ($data['vat'] / 100);
            $grand_total = $data['total'] + $vat_total;

            $data['vat_total'] = $vat_total;
            $data['grand_total'] = $grand_total;

            $order = Order::findOrFail($id);

            $order->update($data);

            return redirect()->route('order.show', $order->id)->with('success', 'Order updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Duplicate entry email ' . $data['customer_email']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($itemId) {}

    public function exportPdf($id)
    {
        $order = Order::with('customer', 'orderItems')->findOrFail($id);
        $customer_name = $order->customer->name;

        $orderItemsImage = [];
        foreach ($order->orderItems as $item) {
            $orderItemsImage[] = public_path('storage/' . $item->image);
        }

        $data = [
            'title' => $order->status . ' - ' . $order->order_date .' - ' . $customer_name,
            'order' => $order,
            'orderItems' => $order->orderItems,
            'orderItemsImage' => $orderItemsImage,
            'customerName' => $customer_name
        ];

        $itemHeight = 15; // Example height per item in pixels
        $totalHeight = count($order->orderItems) * $itemHeight + 1000;

        $pdf = PDF::setPaper([0, 0, 1400, $totalHeight], 'portrait')->loadView('orders.export.pdf', $data);

        return $pdf->download($data['title'] . '.pdf');
    }
}
