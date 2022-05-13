<?php

namespace App\Modules\Admin\Controllers\Product;

use App\Bll\ExcelProducts;
use App\Jobs\UploadProductsJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExcelController extends Controller
{
    function importData(Request $request, Schedule $schedule)
    {


        $file_in_db = NULL;

        $this->validate($request, [
            'file_products' => 'required|file|mimes:xls,xlsx'
        ]);

        //file save
        if ($request->file_products){
            $path = public_path() . '/uploads/products_file';
            $file = new Filesystem;
            $file->cleanDirectory($path);
            $file = request('file_products');
            $file_name = request('file_products')->getClientOriginalName();
            $file->move($path, $file_name);
        }
        UploadProductsJob::dispatch();
        return back()->withSuccess('Great! Data has been successfully uploaded.');

    }

}
