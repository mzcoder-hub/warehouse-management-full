<?php

namespace App\Http\Controllers;

use App\Models\Inventorie;
use App\Models\Sales;
use App\Models\SalesDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SalessController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        if ($user->role == 'super admin' || 'manager') {
            $sales = Sales::with('salesDetails', 'user')->latest()->paginate(10);
            $products = Inventorie::all();

            return view('sales.index', compact('sales', 'products'));
        } elseif ($user->role === 'sales') {
            $sales = Sales::with('salesDetails')->where('user_id', $user->id)->latest()->paginate(10);
            $products = Inventorie::all();

            return view('sales.index', compact('sales', 'products'));
        }
    }

    public function getCreateSales()
    {
        $products = Inventorie::all();

        return view('sales.create-product', compact('products'));
    }

    public function storeSales(Request $request)
    {
        $product = Inventorie::where('id', $request->product)->first();
        $stockProduct = $product->stock - $request->qty;

        $user = Auth::user();

        DB::beginTransaction();

        try {
            $sales = Sales::create([
                'number' => rand(1, 1000),
                'date' => now()->toDateString(),
                'user_id' => $user->id,
            ]);

            $salesDetail = SalesDetails::create([
                'sales_id' => $sales->id,
                'inventory_id' => $request->product,
                'qty' => $request->qty,
                'price' => $request->input('hiddenPrice'),
                'price_sale' => $request->price_sale
            ]);

            $product->update(['stock' => $stockProduct]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        return redirect()->back()->with('successCreate', 'Data Sales berhasil di tambahkan!');
    }

    public function edit($idSales)
    {
        $sales = Sales::where('id', $idSales)->first();

        if (!$sales) {
            return response()->json([
                'success' => false,
                'message' => 'Sales not found.',
            ], 404);
        }
        $salesDetails = SalesDetails::where('sales_id', $sales->id)->first();
        $inventory = Inventorie::where('id', $salesDetails->inventory_id)->first();
        $product = [
            'inventory_id' => $inventory->id,
            'name' => $inventory->name,
            'price' => $inventory->price,
            'stock' => $inventory->stock,
            'price_sale' => $salesDetails->price_sale,
        ];

        $maxStock = $sales->salesDetails->qty + $product['stock'];

        return view('sales.edit-product', compact('sales', 'product', 'maxStock'));
    }

    public function update(Request $request, $id)
    {
        $newQty = $request->input('qty');
        $newPrice = $request->input('hiddenPrice'); // Tambahan untuk memperbarui price
        $price_sale = $request->input('hiddenPriceSale'); // Tambahan untuk memperbarui price_sale
        $status = $request->input('status'); // Tambahan untuk memperbarui price_sale

        // Temukan transaksi penjualan
        $sales = Sales::find($id);

        // Periksa jika qty berubah atau lebih tinggi dari qty sebelumnya
        if ($newQty != $sales->salesDetails->qty && $newQty >= 0) {
            // Simpan nilai qty sebelumnya
            $oldQty = $sales->salesDetails->qty;

            // Lakukan pembaruan jumlah item yang dijual dalam transaksi penjualan
            $sales->salesDetails->qty = $newQty;

            $sales->salesDetails->price_sale = $price_sale;

            $sales->salesDetails->status = $status;

            // Perhitungan perubahan stok
            $stockChange = $oldQty - $newQty;

            // Perbarui stok inventaris sesuai dengan perubahan qty
            $inventory = Inventorie::find($sales->salesDetails->inventory_id);
            $inventory->stock += $stockChange; // Tambahkan atau kurangkan stok sesuai perubahan

            // Memperbarui price (harga)
            $sales->salesDetails->price = $newPrice; // Memperbarui price sesuai input

            $inventory->save(); // Simpan perubahan stok inventaris
            $sales->salesDetails->save(); // Simpan perubahan qty dan price dalam transaksi penjualan
        }

        return redirect()->back()->with('successUpdate', 'Data penjualan berhasil diperbarui.');
    }



    public function deleteSales($idSales)
    {
        // $sales = SalesDetails::where('id', $idSales)->first();
        $sales = Sales::where('id', $idSales)->first();

        if (!$sales) {
            return response()->json([
                'success' => false,
                'message' => 'Sales not found.',
            ], 404);
        }

        $sales->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sales berhasil di delete.',
        ]);
    }
}
