<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Explore\LocalShop;

class LocalShopController extends Controller
{
    public function index()
    {
    	return view('explore.pages.localshops',
    		[
    			'localshops' => LocalShop::all(),
    		]);
    }

    public function localshopDetail($id)
    {
    	$localshop = LocalShop::findOrFail($id);
    	$user = $localshop->user;
        $services = $user->services;
        // $gallery = $user->galleries;
    	return view('explore.pages.localshop-details',
    		[
    			'client' => $user,
    			'services' => $services,
    			'localshop' => $localshop,
    		]);
    }
}
