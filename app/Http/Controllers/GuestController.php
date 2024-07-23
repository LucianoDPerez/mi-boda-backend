<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use WaAPI\WaAPI\WaAPI;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Guest::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|email|max:255|unique:guests',
            'confirmation' => 'required|boolean'
        ]);

        $guest = Guest::create($request->all());

        return response()->json($guest, 201);
    }

    public function show(string $phone)
    {
        $guest = Guest::where('phone', $phone)->first();

        return response()->json($guest);
    }

    public function update(Request $request)
    {
        //return response()->json('ok!!!');
        $data = $request->all();

        //return response()->json($data);

        $phone = "+" . $data['phone'];

        try {
            $guest = Guest::where('phone', $phone)->first();

            if (!$guest) {
                return response()->json(['message' => 'Guest not found'], 404);
            }

            $guest->confirmation = true;
            $guest->save();

            return response()->json($guest, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred'], 500);
        }
    }


    public function destroy(Guest $guest)
    {
        $guest->delete();

        return response()->json(null, 204);
    }

    public function generateUrls()
    {
        $guests = Guest::all();
        $urls = [];

        foreach ($guests as $guest) {
            $phone = $guest->phone;
            $phone = str_replace(" ", "%20", $phone);
            $url = 'https://bsapps.site/?phone=' . $phone;

            $urls[] = $url;
        }

        return response()->json(['urls' => $urls]);
    }

    public function whatsapp() {
        $waAPI = new WaAPI();
        return response()->json($waAPI->sendMessage('5493436446919@c.us', 'Probando mi bot whatsapp una vez mas!!!'));
    }
}
