<?php

namespace App\Http\Controllers;

use App\Exports\SalesExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesCsvExport;
use App\Exports\SalesPdfExport;
use App\Exports\PurchasesExcelExport;
use App\Exports\PurchasesPdfExport;
use App\Exports\PurchasesCsvExport;


class ExportController extends Controller
{
    public function exportExcel()
    {
        return Excel::download(new SalesExport, 'sales.xlsx');
    }

    public function exportPdf()
    {
        return Excel::download(new SalesPdfExport, 'sales.pdf');
    }

    public function exportCsv()
    {
        return Excel::download(new SalesCsvExport, 'sales.csv');
    }
    public function purchaseExportExcel()
    {
        return Excel::download(new PurchasesExcelExport, 'purchases.xlsx');
    }

    public function purchaseExportPdf()
    {
        return Excel::download(new PurchasesPdfExport, 'purchases.pdf');
    }

    public function purchaseExportCsv()
    {
        return Excel::download(new PurchasesCsvExport, 'purchase.csv');
    }
}
