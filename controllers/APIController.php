<?php

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIController {
    public static function index(){
        $servicios = Servicio::all();
        echo json_encode($servicios);
    }

    public static function guardar()
    {
        $respuesta = [];
        try {
            $cita = new Cita($_POST);
            $resultado = $cita->guardar();
            if($resultado['resultado']){
                $id = $resultado['id'];
                $idServicios = explode(",", $_POST['servicios']);
                foreach ($idServicios as $idServicio) {
                    $args = [
                        'citaId' => $id,
                        'servicioId' => $idServicio
                    ];
                    $citaServicio = new CitaServicio($args);
                    $citaServicio->guardar();
                }
                $nuevaCita = Cita::find($resultado['id']);
                $respuesta = [
                    'status' => 'Ok',
                    'data' => $nuevaCita
                ];
            }            
        } catch (\Throwable $th) {
            $respuesta = [
                'status' => 'error',
                'code' => $th->getCode(),
                'message' => $th->getMessage()
            ];
        }
        echo json_encode($respuesta);        
    }

    public static function eliminar()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $cita = Cita::find($id);
            $cita->eliminar();
            header('location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
}