<?php

namespace App\Http\Controllers;

use App\Models\Inventorie;
use Illuminate\Http\Request;

class InventoriesController extends Controller
{
    public function showAllInventories()
    {
        $inventories = Inventorie::latest()->paginate(10);

        return view('inventories', compact('inventories'));
    }

    public function create(Request $request)
    {
        $payload = [
            'code' => $request->code,
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'commision_rate' => $request->commision_rate
        ];

        Inventorie::create($payload);

        return redirect()->back()->with('success', 'Product berhasil di buat');
    }

    public function edit($id)
    {
        $product = Inventorie::where('id', $id)->first();

        return view('edit-product', compact('product'));
    }

    public function updated(Request $request)
    {
        $payload = [
            'code' => $request->code,
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'commision_rate' => $request->commision_rate
        ];

        $product = Inventorie::where('id', $request->id)->first();
        $product->update($payload);

        return redirect()->back()->with('successUpdate', 'Product berhasil diupdate');
    }

    public function delete($id)
    {
        $product = Inventorie::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.',
            ], 404);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product berhasil di delete.',
        ]);
    }
}
