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
        $guestCounts = Guest::all();
        $perPage = 10; // Cantidad de registros por página

        $guests = Guest::orderBy('confirmation')
            ->paginate($perPage);

        // Obtén información de paginación
        $totalConfirmations = $guestCounts->where('confirmation', true)->count();
        $pendingConfirmations = $guestCounts->where('confirmation', false)->count();
        $currentPage = $guests->currentPage();
        $totalPages = $guests->lastPage();
        $previousPage = $guests->previousPageUrl() ? $guests->currentPage() - 1 : null; // Corrección
        $nextPage = $guests->nextPageUrl() ? $guests->currentPage() + 1 : null; // Corrección

        return view('guests.index', compact(
            'guests',
            'totalConfirmations',
            'pendingConfirmations',
            'currentPage',
            'totalPages',
            'previousPage',
            'nextPage'
        ));
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

            $urls[] = ['nombre: ' => $guest->name , 'link: ' => $url];
        }

        return response()->json(['urls' => $urls]);
    }

    public function whatsapp() {
        $guests = Guest::all();

        $waAPI = new WaAPI();

        foreach ($guests as $guest) {
            if ($guest->id > 32){
                $phone = $guest->phone;
                $phone_sent = str_replace(" ", "%20", $phone);
                $phone = str_replace(" ", "", $phone);
                $phone = str_replace("-", "", $phone);
                $phone = str_replace("+", "", $phone);
                $url = 'https://bsapps.site/?phone=' . $phone_sent;

                $sent = $waAPI->sendMessage($phone . '@c.us', 'Te invitamos a nuestro casamiento! ' . $url);

                if ($sent) dump([
                    'guestID' => $guest->id,
                    'name' => $guest->name,
                    'phone' => $phone,
                    'phone_sent' => $phone_sent,
                    'url' => $url
                ]);

            }
        }

        return response()->json('FINISH!!!');
    }
}
