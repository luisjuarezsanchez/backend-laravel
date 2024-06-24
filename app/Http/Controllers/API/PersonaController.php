<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Persona;
use Illuminate\Support\Facades\DB;

class PersonaController extends Controller
{
    public function index()
    {
        // Consultar todas las personas desde la tabla persona
        $personas = Persona::all();

        // Devolver los datos como una respuesta JSON
        return response()->json($personas);
    }

    public function getPersonasPaginated(Request $request)
    {
        // Obtener los parámetros de paginación de la solicitud
        $pageNumber = $request->input('pageNumber', 1);
        $pageSize = $request->input('pageSize', 100);

        // Llamar al procedimiento almacenado
        $personas = DB::select('CALL sp_GetPersonasPaginated(?, ?)', [$pageNumber, $pageSize]);

        // Retornar los resultados como JSON
        return response()->json($personas);
    }

    public function deleteAll()
    {
        try {
            DB::beginTransaction();

            DB::statement('DELETE FROM direccion');
            DB::statement('DELETE FROM telefono');
            DB::statement('DELETE FROM persona');

            DB::commit();

            return response()->json(['message' => 'Datos eliminados correctamente.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al eliminar datos: ' . $e->getMessage()], 500);
        }
    }
}
