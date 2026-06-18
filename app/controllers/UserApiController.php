<?php
require_once 'app/models/user.model.php';
require_once 'app/libs/jwt/jwt.php';

class UserApiController {
    private $model;

    public function __construct() {
        $this->model = new UserModel();
    }

    // POST /api/auth/token
    public function getToken($req, $res) {
        // Si llegamos hasta acá, queremos saberlo
        if (empty($req->body->email) || empty($req->body->password)) {
            return $res->json(["error" => "Faltan datos en el body"], 400);
        }

        $email = $req->body->email;
        $password = $req->body->password;

        $user = $this->model->getUserByEmail($email);

        if ($user && password_verify($password, $user->password)) {
            $payload = [
                'id' => $user->id,
                'email' => $user->email,
                'level' => $user->level,
                'exp' => time() + 3600
            ];

            $token = createJWT($payload);
            return $res->json(['token' => $token], 200);
        } else {
            // Ponemos un mensaje bien explícito por si las credenciales fallan o el hash no coincide
            return $res->json([
                "error" => "Credenciales incorrectas.",
                "debug" => "Buscó el email: " . $email . ". ¿Se encontró usuario en DB?: " . ($user ? 'SI' : 'NO')
            ], 401);
        }
    }
}