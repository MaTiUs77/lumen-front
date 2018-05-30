<?php

namespace App\Http\Controllers;

class RRHH extends Controller
{
    public function alumnos_nominal ()
    {
        return view('rrhh.alumnos_nominal');
    }

    public function matriculas_por_seccion ()
    {
        return view('rrhh.matriculas_por_seccion');
    }
}
