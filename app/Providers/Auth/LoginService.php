<?php

    namespace App\Providers\Auth;

    use Exception;
    use Tymon\JWTAuth\Facades\JWTAuth;

    class LoginService {

        public function execute(array $credentials) {

            if (!$token = auth()->setTTL(8640*60)->attempt($credentials)) {

                throw new Exception('Autenticação não autorizada.', 401);

            }

            return [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => auth()->factory()->getTTL(),
                'name_user' => auth()->user()->name,
                'email_user' => auth()->user()->email
            ];

        }

    }

?>