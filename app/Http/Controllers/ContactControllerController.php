<?php

namespace App\Http\Controllers;

use App\Models\Webfront\ContactController;
use Illuminate\Http\Request;

class ContactControllerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('web_frontend.frontwebs.contact');
    }

}
