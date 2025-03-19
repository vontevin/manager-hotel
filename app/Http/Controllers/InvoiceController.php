<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\RoomType;

class InvoiceController extends Controller
{

    public function index($id)
    {
        $booking = Booking::with(['room'])->findOrFail($id);
        
        $roomtype = $booking->room->roomType;
        
        return view('web_frontend.frontwebs.invoice', compact('booking', 'roomtype'));
    }        

    public function cardList($id)
    {
        // Find the RoomType
        $roomtype = RoomType::findOrFail($id);

        // Query the bookings table based on the room_type_id, but do it through the Room model
        $booking = Booking::whereHas('room', function ($query) use ($id) {
            $query->where('room_type_id', $id);
        })->first();

        // Return the view with roomtype and booking data
        return view('web_frontend.frontwebs.card_list', compact('roomtype', 'booking'));
    }


    // public function updateBooking(Request $request)
    // {
    //     // Find the booking record by ID
    //     $booking = Booking::findOrFail($request->booking_id);

    //     // Update the booking record details
    //     $booking->guest_name = $request->guest_name;
    //     $booking->guest_email = $request->guest_email;
    //     $booking->guest_phone = $request->guest_phone;

    //     // // Recalculate price based on check-in and check-out dates
    //     // $price = $booking->roomType->price * \Carbon\Carbon::parse($booking->check_in)->diffInDays($booking->check_out);
    //     // $booking->price = $price; // Save calculated price

    //     // Update the payment status
    //     $booking->roomType->is_paid = $request->is_paid;  // This assumes that is_paid is a field on the roomType
    //     $booking->roomType->save();  // Save the updated is_paid status

    //     // Redirect back with a success message
    //     return redirect()->route('payment.form')->with('status', 'Payment details for ' . $booking->guest_name . ' updated successfully!');
    // }

    public function deletePayment($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('payment.form')->with('status', 'Payment deleted successfully!');
    }
}
