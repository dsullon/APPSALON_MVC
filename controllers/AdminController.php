<?php

namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController {
    public static function index(Router $router)
    {
        session_start();

        isAdmin();


        $fecha = $_GET['fecha'] ?? date('Y-m-d');
        $fechas = explode('-', $fecha);
        if(!checkdate($fechas[1], $fechas[2], $fechas[0])) {
            header('location: /404');
        }

        $consulta = "SELECT A.id, A.hora, CONCAT(B.nombre, ' ', B.apellido) AS cliente, 
                        B.email, B.telefono, D.nombre AS servicio, D.precio
                    FROM citas A LEFT OUTER JOIN usuarios B
                        ON A.usuarioId = B.id LEFT OUTER JOIN citasservicios C
                        ON A.id = C.citaId LEFT OUTER JOIN servicios D
                        ON C.servicioId = D.id
                    WHERE A.fecha = '$fecha'";
        $citas = AdminCita::SQL($consulta);        

        $router->render('admin/index', [
            'nombre' => $_SESSION['nombre'],
            'citas' => $citas,
            'fecha' => $fecha
        ]);
    }
}