<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Explore\Pamper;

class PamperController extends Controller
{
    public function index()
    {
    	return view('explore.pages.pamper',
    		[
    			'pampers' => Pamper::all(),
    		]);
    }

    public function pamperDetail($id)
    {
    	$pamper = Pamper::findOrFail($id);
    	$user = $pamper->user;
        $services = $user->services;
        // $gallery = $user->galleries;
    	return view('explore.pages.pamper-details',
    		[
    			'client' => $user,
    			'services' => $services,
    			'pamper' => $pamper,
    		]);
    }
}
