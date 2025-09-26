<?php

header('Content-Type: application/json'); // Asegura que la respuesta sea en formato JSON
header('Access-Control-Allow-Origin: *'); // Permite el acceso desde cualquier dominio. En producción, limita esto a tu dominio.
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS'); // Incluye OPTIONS para preflight requests
header('Access-Control-Allow-Headers: Content-Type, Authorization'); // Headers permitidos

// Simulación de la "base de datos" para clientes y proveedores
// En una aplicación real, esto se manejaría con una base de datos real (ej. MySQL, PostgreSQL).
$clientes = [
    ['id' => 1, 'nombre' => 'Cliente A', 'contacto' => 'Juan Pérez', 'email' => 'juan.perez@cliente.com'],
    ['id' => 2, 'nombre' => 'Cliente B', 'contacto' => 'María Gómez', 'email' => 'maria.gomez@cliente.com'],
];

$proveedores = [
    ['id' => 1, 'nombre' => 'Proveedor X', 'contacto' => 'Carlos Ruíz', 'email' => 'carlos.ruiz@proveedor.com'],
    ['id' => 2, 'nombre' => 'Proveedor Y', 'contacto' => 'Ana Torres', 'email' => 'ana.torres@proveedor.com'],
];

// Manejo de peticiones OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Obtiene la acción solicitada desde la URL (ej. api.php?action=clientes)
$action = $_GET['action'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];
$id = $_GET['id'] ?? null;
$input = json_decode(file_get_contents('php://input'), true);

function sendResponse($status, $data) {
    http_response_code($status);
    echo json_encode($data);
    exit;
}

function findIndexById($array, $id) {
    foreach ($array as $index => $item) {
        if ($item['id'] == $id) {
            return $index;
        }
    }
    return false;
}

switch ($action) {
    // --- Rutas para Clientes ---
    case 'clientes':
        if ($id) {
            $index = findIndexById($GLOBALS['clientes'], $id);
            if ($index === false) {
                sendResponse(404, ['status' => 'error', 'message' => 'Cliente no encontrado']);
            }
            switch ($method) {
                case 'GET':
                    sendResponse(200, ['status' => 'success', 'data' => $GLOBALS['clientes'][$index]]);
                    break;
                case 'PUT':
                    $GLOBALS['clientes'][$index] = array_merge($GLOBALS['clientes'][$index], $input);
                    sendResponse(200, ['status' => 'success', 'message' => 'Cliente actualizado', 'data' => $GLOBALS['clientes'][$index]]);
                    break;
                case 'DELETE':
                    array_splice($GLOBALS['clientes'], $index, 1);
                    sendResponse(200, ['status' => 'success', 'message' => 'Cliente eliminado']);
                    break;
                default:
                    sendResponse(405, ['status' => 'error', 'message' => 'Método no permitido']);
            }
        } else {
            // Rutas para la colección de clientes
            if ($method === 'GET') {
                sendResponse(200, ['status' => 'success', 'data' => $GLOBALS['clientes']]);
            } elseif ($method === 'POST') {
                $newCliente = $input;
                $newCliente['id'] = end($GLOBALS['clientes'])['id'] + 1; // ID automático simulado
                $GLOBALS['clientes'][] = $newCliente;
                sendResponse(201, ['status' => 'success', 'message' => 'Cliente agregado', 'data' => $newCliente]);
            } else {
                sendResponse(405, ['status' => 'error', 'message' => 'Método no permitido']);
            }
        }
        break;

    // --- Rutas para Proveedores ---
    case 'proveedores':
        if ($id) {
            $index = findIndexById($GLOBALS['proveedores'], $id);
            if ($index === false) {
                sendResponse(404, ['status' => 'error', 'message' => 'Proveedor no encontrado']);
            }
            switch ($method) {
                case 'GET':
                    sendResponse(200, ['status' => 'success', 'data' => $GLOBALS['proveedores'][$index]]);
                    break;
                case 'PUT':
                    $GLOBALS['proveedores'][$index] = array_merge($GLOBALS['proveedores'][$index], $input);
                    sendResponse(200, ['status' => 'success', 'message' => 'Proveedor actualizado', 'data' => $GLOBALS['proveedores'][$index]]);
                    break;
                case 'DELETE':
                    array_splice($GLOBALS['proveedores'], $index, 1);
                    sendResponse(200, ['status' => 'success', 'message' => 'Proveedor eliminado']);
                    break;
                default:
                    sendResponse(405, ['status' => 'error', 'message' => 'Método no permitido']);
            }
        } else {
            // Rutas para la colección de proveedores
            if ($method === 'GET') {
                sendResponse(200, ['status' => 'success', 'data' => $GLOBALS['proveedores']]);
            } elseif ($method === 'POST') {
                $newProveedor = $input;
                $newProveedor['id'] = end($GLOBALS['proveedores'])['id'] + 1; // ID automático simulado
                $GLOBALS['proveedores'][] = $newProveedor;
                sendResponse(201, ['status' => 'success', 'message' => 'Proveedor agregado', 'data' => $newProveedor]);
            } else {
                sendResponse(405, ['status' => 'error', 'message' => 'Método no permitido']);
            }
        }
        break;

    default:
        // Ruta no encontrada
        sendResponse(404, ['status' => 'error', 'message' => 'Ruta del API no encontrada']);
        break;
}

?>
