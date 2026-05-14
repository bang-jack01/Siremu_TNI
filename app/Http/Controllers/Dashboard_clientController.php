<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prajurit;
use Illuminate\Support\Facades\Auth;

class Dashboard_clientController extends Controller
{
    public function index()
    {
        $prajurit = Auth::user()->prajurit;
        return view('client.dashboard', compact('prajurit'));
    }
}

