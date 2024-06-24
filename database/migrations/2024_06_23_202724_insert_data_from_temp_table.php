<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertDataFromTempTable extends Migration
{
    public function up()
    {
        // Definición del Stored Procedure
        DB::unprepared('
            CREATE PROCEDURE insert_data_from_temp_table()
            BEGIN
                /* Insertando los datos en la tabla persona y detectando los duplicados */
                INSERT INTO persona (nombre, paterno, materno)
                SELECT DISTINCT t.nombre, t.paterno, t.materno
                FROM temp_table t
                LEFT JOIN persona p 
                    ON t.nombre = p.nombre 
                    AND t.paterno = p.paterno 
                    AND t.materno = p.materno
                WHERE p.nombre IS NULL;

                /* Detectando el telefono de las personas */
                INSERT INTO telefono (persona_id, telefono)
                SELECT p.id AS persona_id, temp_table.telefono
                FROM temp_table
                INNER JOIN (
                    SELECT DISTINCT id, nombre, paterno, materno
                    FROM persona
                ) AS p ON temp_table.nombre = p.nombre 
                        AND temp_table.paterno = p.paterno 
                        AND temp_table.materno = p.materno
                LEFT JOIN telefono ON p.id = telefono.persona_id AND temp_table.telefono = telefono.telefono
                WHERE telefono.id IS NULL;

                /* Detectando las direcciones de las personas */
                INSERT INTO direccion (persona_id, calle, numero_exterior, numero_interior, colonia, cp)
                SELECT p.id AS persona_id, t.calle, t.numero_exterior, t.numero_interior, t.colonia, t.cp
                FROM temp_table t
                INNER JOIN (
                    SELECT DISTINCT id, nombre, paterno, materno
                    FROM persona
                ) AS p ON t.nombre = p.nombre 
                        AND t.paterno = p.paterno 
                        AND t.materno = p.materno
                LEFT JOIN direccion dir ON p.id = dir.persona_id 
                                        AND t.calle = dir.calle 
                                        AND t.numero_exterior = dir.numero_exterior 
                                        AND t.numero_interior = dir.numero_interior 
                                        AND t.colonia = dir.colonia 
                                        AND t.cp = dir.cp
                WHERE dir.id IS NULL;
            END
        ');
    }

    public function down()
    {
        // Eliminar el Stored Procedure si es necesario
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_data_from_temp_table');
    }
}
