<?php

namespace App\Services;

use App\Models\Grupo;

class GrupoService
{
    // Lógica del servicio para manejar grupos

    public function crearGrupo(array $data)
    {
        return Grupo::create($data);
    }

    public function getGrupoById(string $id): array
    {
        $grupo = Grupo::find($id);

        if (!$grupo) {
            return [
                'message' => 'Grupo no encontrado',
                'status' => 404
            ];
        }else {
            return [
                'message' => 'Grupo encontrado exitosamente.',
                'status' => 200,
                'data' => $grupo->ObtenerDatosGrupo()
            ];
        }
    }

    public function actualizarGrupo(String $id, array $data)
    {
        $grupo = Grupo::find($id);

        if (!$grupo) {
            return [
                'message' => 'Grupo no encontrado',
                'status' => 404
            ];
        }else {
            $grupo->update($data);
            return [
                'message' => 'Grupo actualizado exitosamente.',
                'status' => 200,
                'data' => $grupo
            ];

        }

    }

    public function eliminarGrupo(String $id)
    {
        $grupo = Grupo::find($id);

        if (!$grupo) {
            return [
                'message' => 'Grupo no encontrado',
                'status' => 404
            ];
        }else {
            $grupo->delete();
            return [
                'message' => 'Grupo eliminado exitosamente.',
                'status' => 200,
                'data' => $grupo
            ];
        }
    }
}

