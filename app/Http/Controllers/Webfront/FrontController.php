<?php

namespace App\Http\Controllers\Webfront;

use App\Models\Room;
use App\Models\Guest;
use App\Models\Client;
use App\Models\Booking;
use App\Models\Gallery;
use App\Models\Invoice;
use App\Models\Package;
use App\Models\RoomType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontController extends Controller
{
    public function index()
    {
        $rooms = Room::get();
        // $invoice = Invoice::get();
        $clients = Client::get();
        $roomtypes = RoomType::get();
        $galleries = Gallery::get();
        $packages = Package::get();
        $booking = Booking::get();
        return view('web_frontend.frontwebs.index',[
            'roomtypes' => $roomtypes,
            'galleries' => $galleries,
            'booking' => $booking,
            'packages' => $packages,
            'clients' => $clients,
            // 'invoice' => $invoice,
            'rooms' => $rooms
        ]);
    }
}
