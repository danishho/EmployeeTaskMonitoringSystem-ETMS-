<?php

namespace App\Http\Controllers;

use App\Imports\ImportExcel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportExcelController extends Controller
{
    public function excelStore(request $request){
        Excel::import(new ImportExcel,request()->file('excel'));
        return redirect('/user/add')->with('success', 'User List Registered Successfully');
    }
}
