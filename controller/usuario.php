<?php

class AuthController{
    public function register(){
        $data = json_decode(file_get_contents('php://input'), true)

        if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
            http_response_code(422);
            echo json_encode(["error" => "Email inválido"]);
            return;
        }
        if (strlen($data['password']) < 8) {
            http_response_code(422);
            echo json_encode(["error" => "Contraseña muy corta"]);
            return;
        }
        
        $usuario = new Usuario();
        $result  = $usuario->register($data['nombre'], $data['email'], $data['password']);

        http_response_code(201);
        echo json_encode($result);

    }

    public function login(){
        $data = json_decode(file_get_contents('php://input'), true); 

        $usuario = new Usuario();
        $result = $usuario->login($data['email'], $data['password']);

        if (!$result['success']){  
            http_response_code(401);
            echo json_encode(["error" => "Credenciales incorrectas"]); 
            return;
        }

        $_SESSION['usuario'] = $result['user'];
        echo json_encode($result);
    }

}