<?php

namespace App\Exports;

use App\Models\Sales;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesExport implements FromCollection, WithHeadings
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
        $sales = Sales::with('user', 'salesDetails')->get();

        $mappedSales = $sales->map(function ($sale) {
            $sale = [
                'number' => $sale->number,
                'user' => $sale->user->name,
                'tanggal' => $sale->date,
                'product name' => $sale->salesDetails->inventory->name,
                'quantity' => $sale->salesDetails->qty,
                'price' => 'Rp.' . number_format($sale->salesDetails->price, 0, ',', '.')
            ];

            return $sale;
        });

        return $mappedSales;
    }
}
