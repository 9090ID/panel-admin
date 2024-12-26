<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CKEditorController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = time() . '-' . $file->getClientOriginalName();
            $path = public_path('fotoartikel');
            
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $file->move($path, $filename);

            $url = asset('fotoartikel' . $filename);
            return response()->json([
                'url' => $url
            ]);
        }

        return response()->json(['error' => 'Failed to upload'], 400);
    }
}
