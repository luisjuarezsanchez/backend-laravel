<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        // Validar el archivo
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        // Almacenar el archivo
        if ($request->file()) {
            $filePath = $request->file('file')->store('uploads', 'public');

            return response()->json(['message' => 'File uploaded successfully', 'path' => $filePath], 200);
        }

        return response()->json(['message' => 'File not uploaded'], 400);
    }
}
