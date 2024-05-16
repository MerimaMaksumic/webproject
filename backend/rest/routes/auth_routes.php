<?php

require_once __DIR__ . '/../services/UserService.class.php';

Flight::group('/auth', function () {


    /**
     * @OA\Post(
     *     path="/auth/register",
     *     summary="Register a new user",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         description="User data required for registration",
     *         required=true,
     *         @OA\JsonContent(
     *             required={"first_name", "last_name", "email", "password"},
     *             @OA\Property(property="first_name", type="string", example="Merima"),
     *             @OA\Property(property="last_name", type="string", example="Maksumic"),
     *             @OA\Property(property="email", type="string", format="email", example="merima@gmail.com"),
     *             @OA\Property(property="password", type="string", format="password", example="merima123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User successfully registered",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Missing or invalid parameters"
     *     )
     * )
     */
    Flight::route('POST /register', function () {
        $data = Flight::request()->data->getData();

        $data = array_map(function ($value) {
            return is_string($value) ? trim($value) : $value;
        }, $data);

    

        $user_service = new UserService();
        $user = $user_service->add_user($data);
        if ($user) {
            Flight::json($user, 201);
        } else {
            Flight::halt(400, "User could not be registered");
        }
    });


    /**
     * @OA\Post(
     *     path="/auth/login",
     *     summary="Authenticate a user and return a JWT",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         description="Credentials needed to login",
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="emir@gmail.com"),
     *             @OA\Property(property="password", type="string", format="password", example="emir")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Authentication successful",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="token", type="string", description="JWT for authenticated user")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Email and password are required"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid email or password"
     *     )
     * )
     */
    Flight::route('POST /login', function () {
        $data = Flight::request()->data->getData();
        $email = trim($data['email']);
        $password = $data['password'];

        if (empty($email) || empty($password)) {
            Flight::halt(400, "Email and password are required");
            return;
        }

        $user_service = new UserService();
        $user = $user_service->authenticate_user($email, $password);
        if ($user) {
            $jwt = $user['token'];
            Flight::json(['token' => $jwt]);
        } else {
            Flight::halt(401, "Invalid email or password");
        }
    });
});