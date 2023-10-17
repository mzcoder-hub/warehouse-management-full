<?php

namespace App\Http\Controllers;

use App\Models\Inventorie;
use App\Models\PurchaseDetails;
use App\Models\Purchases;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchasesController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        if ($user->role == 'super admin' || 'manager') {
            $purchases = Purchases::with('purchaseDetails')->latest()->paginate(10);
            $products = Inventorie::all();

            return view('purchases.index', compact('purchases', 'products'));
        } elseif ($user->role == 'purchase') {
            $purchases = Purchases::with('purchaseDetails')->where('user_id', $user->id)->latest()->paginate(10);
            $products = Inventorie::all();

            return view('purchases.index', compact('purchases', 'products'));
        }
    }

    public function getCreatePurchases()
    {
        $products = Inventorie::all();

        return view('purchases.create', compact('products'));
    }

    public function storePurchases(Request $request)
    {
        $product = Inventorie::where('id', $request->product)->first();
        $stockProduct = $product->stock + $request->qty;

        $user = Auth::user();

        DB::beginTransaction();

        try {
            $purchase = Purchases::create([
                'number' => rand(1, 1000),
                'date' => now()->toDateString(),
                'user_id' => $user->id
            ]);

            $purchaseDetails = PurchaseDetails::create([
                'purchases_id' => $purchase->id,
                'inventory_id' => $request->product,
                'qty' => $request->qty,
                'price' => $request->input('hiddenPrice')
            ]);

            $product->update(['stock' => $stockProduct]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        return redirect()->back()->with('successCreate', 'Data Sales berhasil di tambahkan!');
    }

    public function edit($idPurchase)
    {
        $purchases = Purchases::where('id', $idPurchase)->first();

        if (!$purchases) {
            return response()->json([
                'success' => false,
                'message' => 'Sales not found.',
            ], 404);
        }
        $purchaseDetails = PurchaseDetails::where('purchases_id', $purchases->id)->first();
        $inventory = Inventorie::where('id', $purchaseDetails->inventory_id)->first();
        $product = [
            'inventory_id' => $inventory->id,
            'name' => $inventory->name,
            'price' => $inventory->price,
            'stock' => $inventory->stock,
        ];

        $maxStock = $purchases->purchaseDetails->qty + $product['stock'];

        return view('purchases.edit', compact('purchases', 'product', 'maxStock'));
    }

    public function update(Request $request, $id)
    {
        $newQty = $request->input('qty');
        $newPrice = $request->input('hiddenPrice'); // Tambahan untuk memperbarui price

        // Temukan transaksi pembelian
        $purchase = Purchases::find($id);

        // Simpan nilai qty sebelumnya
        $oldQty = $purchase->purchaseDetails->qty;

        // Temukan barang inventaris yang terkait dengan pembelian
        $inventory = Inventorie::find($purchase->purchaseDetails->inventory_id);

        // Hitung selisih qty baru dan qty sebelumnya
        $qtyChange = $newQty - $oldQty;

        // Periksa jika ada perubahan qty yang perlu diupdate
        if ($qtyChange != 0) {
            // Periksa jika ada penambahan stok atau pengurangan stok
            if ($qtyChange > 0) {
                // Penambahan stok
                $inventory->stock += $qtyChange;
            } else {
                // Pengurangan stok
                $inventory->stock -= abs($qtyChange);
            }
        }

        // Memperbarui price (harga) sesuai dengan input
        $purchase->purchaseDetails->price = $newPrice;

        // Memperbarui qty dalam detail pembelian
        $purchase->purchaseDetails->qty = $newQty;

        // Simpan perubahan qty dalam detail pembelian
        $purchase->purchaseDetails->save();

        // Simpan perubahan stok inventaris
        $inventory->save();

        return redirect()->back()->with('successUpdate', 'Data pembelian berhasil diperbarui.');
    }

    public function deletePurchase($idPurchase)
    {
        $purchase = Purchases::where('id', $idPurchase)->first();

        if (!$purchase) {
            return response()->json([
                'success' => false,
                'message' => 'Purchase not found.',
            ], 404);
        }

        $purchase->delete();

        return response()->json([
            'success' => true,
            'message' => 'purchase berhasil di delete.',
        ]);
    }
}
