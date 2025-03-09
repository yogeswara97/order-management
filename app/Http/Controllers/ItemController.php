<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{

    public function createItem(string $orderId)
    {
        $currency = Order::findOrFail($orderId)->currency;
        $title = "Item";

        return view('orders.order-item.create-item', compact('orderId', 'currency','title'));
    }

    public function storeItem(Request $request, string $orderId)
    {
        // Retrieve data from the request
        $data = $request->validate([
            'item_name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255',
            'quantity' => 'required|integer|min:1',
            'unit' => 'required|string|max:50',
            'unit_price' => 'required|numeric|min:0',
            'color' => 'nullable|string|max:50',
            'total_price' => 'required|numeric|min:0',
            'format' => 'nullable|string',
            'size_w' => 'nullable|numeric|min:0',
            'size_d' => 'nullable|numeric|min:0',
            'size_h' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $path = Storage::disk('public')->put('image', $request->file('image'));
            $data['image'] = $path;
        }
        // Find the item to update
        $data['order_id'] = $orderId;

        // Create the item
        OrderItem::create($data);

        $this->updateOrderTotals($orderId);

        // Redirect to a relevant page
        return redirect()->route('order.show', $orderId)->with('success', 'Item added successfully.');
    }

    public function editItem(string $orderId, string $itemId)
    {
        $item = OrderItem::findOrFail($itemId);
        $currency = Order::findOrFail($orderId)->currency;
        $title = "Item";

        return view('orders.order-item.edit-item', compact('orderId', 'item','currency', 'title'));
    }

    public function updateItem(Request $request, string $orderId, string $itemId)
    {
        // Retrieve data from the request
        $data = $request->validate([
            'item_name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255',
            'quantity' => 'required|integer|min:1',
            'unit' => 'required|string|max:50',
            'unit_price' => 'required|numeric|min:0',
            'color' => 'nullable|string|max:50',
            'total_price' => 'required|numeric|min:0',
            'format' => 'nullable|string',
            'size_w' => 'nullable|numeric|min:0',
            'size_d' => 'nullable|numeric|min:0',
            'size_h' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $item = OrderItem::findOrFail($itemId);

        if ($request->hasFile('image')) {
            if ($item->image) {
                $itemPath = public_path('storage/' . $item->image);
                if (file_exists($itemPath)) {
                    unlink($itemPath);
                }
            }

            // Store the new image
            $path = $request->file('image')->store('image', 'public');
            $data['image'] = $path;
        }


        // Find the item to update
        $item = OrderItem::where('order_id', $orderId)->where('id', $itemId)->first();

        if (!$item) {
            return redirect()->route('order.show', $orderId)->with('error', 'Item not found.');
        }

        // Update the item
        $item->update($data);

        $this->updateOrderTotals($orderId);

        // Redirect to a relevant page
        return redirect()->route('order.show', $orderId)->with('success', 'Item updated successfully.');
    }

    public function destroyItem(string $orderId, string $itemId)
    {
        $item = OrderItem::where('order_id', $orderId)->where('id', $itemId)->first();

        if (!$item) {
            return redirect()->back()->with('error', 'Item not found.');
        }

        $itemPath = public_path('storage/' . $item->image);
        if (file_exists($itemPath)) {
            unlink($itemPath);
        }

        $item->delete();

        $this->updateOrderTotals($orderId);

        return redirect()->back()->with('success', 'Item deleted successfully.');
    }

    private function updateOrderTotals(string $orderId)
    {
        // Retrieve all items for the order
        $items = OrderItem::where('order_id', $orderId)->get();
        $vatRate = (Order::findOrFail($orderId)->vat) / 100;

        // Calculate total price
        $totalPrice = $items->sum('total_price');

        // $vatRate = 0.11;
        $vat = $totalPrice * $vatRate;

        // Calculate grand total
        $grandTotal = round($totalPrice + $vat, 2);

        // Update the order with new totals
        $order = Order::findOrFail($orderId);
        $order->vat_total = $vat;
        $order->total = $totalPrice;
        $order->grand_total = $grandTotal;
        $order->save();
    }
}
