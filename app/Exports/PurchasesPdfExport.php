<?php

namespace App\Exports;

use App\Models\Purchases;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PurchasesPdfExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'Number',
            'User',
            'Tanggal',
            'Product Name',
            'Quantity',
            'Price',
        ];
    }

    public function collection()
    {
        $purchases = Purchases::with('user', 'purchaseDetails')->get();

        $mappedPurchases = $purchases->map(function ($purchase) {
            $purchase = [
                'number' => $purchase->number,
                'user' => $purchase->user->name,
                'tanggal' => $purchase->date,
                'product name' => $purchase->purchaseDetails->inventory->name,
                'quantity' => $purchase->purchaseDetails->qty,
                'price' => 'Rp.' . number_format($purchase->purchaseDetails->price, 0, ',', '.')
            ];

            return $purchase;
        });

        return $mappedPurchases;
    }
}
