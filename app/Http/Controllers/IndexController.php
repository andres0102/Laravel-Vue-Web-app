<?php

namespace App\Http\Controllers;

use App\Models\Companies\Companies;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        if($request->get('order') && $request->get('order') == 'success' ){

        }
        /*getting local marketplace items*/
        $companies = Companies::where('company_on_main',1)->get();
        return view('index.index',
            [
                'companies'=> $companies,

            ]);
    }
}
