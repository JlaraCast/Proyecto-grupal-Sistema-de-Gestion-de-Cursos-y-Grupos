<?php

namespace App\Services;

use App\Models\Curso;

class CursoService
{
    // Lógica del servicio para manejar cursos

    public function crearCurso(array $data)
    {
        return Curso::create($data);
    }

    public function getCursoById(string $id): array
    {
        $curso = Curso::find($id);

        if (!$curso) {
            return [
                'message' => 'Curso no encontrado',
                'status' => 404
            ];
        }else {
            return [
                'message' => 'Curso encontrado exitosamente.',
                'status' => 200,
                'data' => $curso->ObtenerDatosCurso()
            ];
        }
    }


    public function actualizarCurso(String $id, array $data)
    {
        $curso = Curso::find($id);

        if (!$curso) {
            return [
                'message' => 'Curso no encontrado',
                'status' => 404
            ];
        } else {

            $curso->update($data);
            return [
                'message' => 'Curso actualizado exitosamente.',
                'status' => 200,
                'data' => $curso
            ];
        }
    }

    public function eliminarCurso(String $id)
    {
        $curso = Curso::find($id);

        if (!$curso) {
            return [
                'message' => 'Curso no encontrado',
                'status' => 404
            ];
        } else {
            $curso->delete();
            return [
                'message' => 'Curso eliminado exitosamente.',
                'status' => 200,
                'data' => $curso
            ];
        }
    }
}
