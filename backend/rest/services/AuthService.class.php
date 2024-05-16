<?php

require_once __DIR__ . "/../dao/AuthDao.class.php";
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthService {

    private $auth_dao;

    public function __construct() {
        $this->auth_dao = new AuthDao();
    }

    public function get_user_by_email($email){
        return $this->auth_dao->get_user_by_email($email);
    }


    public function authenticate_user($email, $password)
    {
        $user = $this->auth_dao->get_user_by_email($email);
        if ($user && password_verify($password, $user['password'])) {
            $issuedAt = time();
            $expirationTime = $issuedAt + 3600 * 24;
            $payload = [
                'iat' => $issuedAt,
                'exp' => $expirationTime,
                'userId' => $user['id'],
                'email' => $user['email'],
                'role' => $user['role']
            ];

            $jwt = JWT::encode($payload, JWT_SECRET, 'HS256');
            $user['token'] = $jwt;


            return $user;
        }
        return null;
    }

    
}