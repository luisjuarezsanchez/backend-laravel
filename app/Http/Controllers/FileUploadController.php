<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->storeAs('uploads', $file->getClientOriginalName());

            // Convertir Excel a CSV
            $spreadsheet = IOFactory::load(Storage::path($filePath));
            $writer = IOFactory::createWriter($spreadsheet, 'Csv');
            $csvFilePath = Storage::path('uploads/temp.csv');

            $writer->save($csvFilePath);

            // Limpiar las comas en el archivo CSV
            $cleanedCsvFilePath = Storage::path('uploads/cleaned_temp.csv');
            $this->cleanCsvFile($csvFilePath, $cleanedCsvFilePath);

            // Cargar datos a la BD desde el archivo CSV limpio
            $tableName = 'temp_table';
            $this->loadCSVIntoDatabase($cleanedCsvFilePath, $tableName);

            // Llamar al Stored Procedure después de cargar los datos
            $this->callStoredProcedure();

            return response()->json(['message' => 'File uploaded, data inserted, and Stored Procedure executed successfully'], 200);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

    private function cleanCsvFile($inputFilePath, $outputFilePath)
    {
        $inputFile = fopen($inputFilePath, 'r');
        $outputFile = fopen($outputFilePath, 'w');

        // Leer la primera línea (header)
        $header = fgetcsv($inputFile);
        fputcsv($outputFile, $header);

        while (($row = fgetcsv($inputFile)) !== FALSE) {
            // Limpiar las comas de cada campo
            $cleanedRow = array_map(function ($field) {
                return str_replace(',', '', $field);
            }, $row);

            fputcsv($outputFile, $cleanedRow);
        }

        fclose($inputFile);
        fclose($outputFile);
    }

    private function loadCSVIntoDatabase($filePath, $tableName)
    {
        // Truncar la tabla temporal para eliminar todos los registros existentes
        DB::table($tableName)->truncate();

        $filePath = addslashes($filePath);
        $query = "LOAD DATA LOCAL INFILE '{$filePath}' 
                  INTO TABLE {$tableName} 
                  FIELDS TERMINATED BY ',' 
                  ENCLOSED BY '\"' 
                  LINES TERMINATED BY '\n' 
                  IGNORE 1 LINES 
                  (nombre, paterno, materno, telefono, calle, numero_exterior, numero_interior, colonia, cp)";

        DB::connection()->getPdo()->exec($query);
    }

    public function callStoredProcedure()
    {
        try {
            DB::statement('CALL insert_data_from_temp_table();');
            return response()->json(['message' => 'Stored Procedure executed successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error executing Stored Procedure: ' . $e->getMessage()], 500);
        }
    }
}
