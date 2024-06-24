<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateSpGetPersonasPaginated extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE PROCEDURE sp_GetPersonasPaginated(
                IN pageNumber INT,
                IN pageSize INT
            )
            BEGIN
                DECLARE start_index INT;
                SET start_index = (pageNumber - 1) * pageSize;

                SET @sql = CONCAT(
                    "SELECT persona.id, persona.nombre, persona.paterno, persona.materno,
       GROUP_CONCAT(DISTINCT direccion.calle) AS calle,
       GROUP_CONCAT(DISTINCT direccion.numero_exterior) AS numero_exterior,
       GROUP_CONCAT(DISTINCT direccion.numero_interior) AS numero_interior,
       GROUP_CONCAT(DISTINCT direccion.colonia) AS colonia,
       GROUP_CONCAT(DISTINCT direccion.cp) AS cp,
       GROUP_CONCAT(DISTINCT telefono.telefono) AS telefono
            FROM persona
            INNER JOIN telefono ON persona.id = telefono.persona_id
            INNER JOIN direccion ON persona.id = direccion.persona_id
            GROUP BY persona.id, persona.nombre, persona.paterno, persona.materno
                     LIMIT ", start_index, ", ", pageSize
                );

                PREPARE stmt FROM @sql;
                EXECUTE stmt;
                DEALLOCATE PREPARE stmt;
            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_GetPersonasPaginated;');
    }
}
