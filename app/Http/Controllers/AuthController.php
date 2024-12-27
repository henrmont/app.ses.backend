<?php

namespace App\Http\Controllers;

use App\Mail\VerificationMail;
use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // public function create(Request $request)
    // {
    //     $user = User::where('email',$request->email)->first();
    //     if ($user) {
    //         return response()->json(['message' => 'Email já está em uso.'], 400);
    //     } else {
    //         $user = User::create([
    //             'name' => $request->name,
    //             'email' => $request->email,
    //             'password' => Hash::make($request->password),
    //         ]);
    //         $code = VerificationCode::create([
    //             'user_id' => $user->id,
    //             'expire_at' => now()->addMinutes(1),
    //             'code' => rand(1000, 9999),
    //         ]);
    //         Mail::to($user->email, $user->name)->send(new AccountMail([
    //             'code' => $code->code,
    //             'subject' => 'Conta criada com sucesso',
    //             'expire' => $code->expire_at
    //         ]));
    //         return response()->json(['message' => 'Conta criada com sucesso. Verifique seu email!'], 200);
    //     }
    // }

    public function resend(Request $request)
    {
        $user = User::with(['verificationCode'])->where('email', $request->email)->first();
        if ($user) {
            if ($user->verificationCode) {
                $user->verificationCode->delete();
            }
            $code = VerificationCode::create([
                'user_id' => $user->id,
                'expire_at' => now()->addMinutes(10),
                'code' => rand(1000, 9999),
            ]);
            Mail::to($user->email, $user->name)->send(new VerificationMail([
                'code' => $code->code,
                'subject' => 'Código de verificação',
                'expire' => $code->expire_at
            ]));
            return response()->json(['message' => 'Código de verificação enviado!'], 200);
        } else {
            return response()->json(['message' => 'E-mail não encontrado!'], 400);
        }
    }

    public function verification(Request $request)
    {
        $user = User::with(['verificationCode'])->where('email', $request->email)->first();
        $verification = $request->one.$request->two.$request->three.$request->four;
        if ($user->verificationCode->code == $verification) {
            if ($user->verificationCode->expire_at > now()) {
                $user->update([
                    'email_verified_at' => now()
                ]);
                $user->verificationCode->delete();
                return response()->json(['message' => 'E-mail verificado com sucesso!'], 200);
            } else {
                return response()->json(['message' => 'Código de verificação expirou!'], 400);
            }
        } else {
            return response()->json(['message' => 'Código de verificação inválido!'], 400);
        }
    }

    public function recover(Request $request)
    {
        $user = User::with(['verificationCode'])->where('email', $request->email)->first();
        $verification = $request->one.$request->two.$request->three.$request->four;
        if ($user->verificationCode->code == $verification) {
            if ($user->verificationCode->expire_at < now()) {
                return response()->json(['message' => 'Código de verificação expirou!'], 400);
            }
        } else {
            return response()->json(['message' => 'Código de verificação inválido!'], 400);
        }
    }

    public function reset(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        return response()->json(['message' => 'Senha atualizada com sucesso!'], 200);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['message' => 'Credenciais inválidas.'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            return response()->json($user);
        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'token_expired'], 401);
        }
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        $token = JWTAuth::refresh(JWTAuth::getToken());
        return $this->respondWithToken($token);
    }

    public function permission()
    {
        $user = User::with(['permissions','roles.permissions'])->find(auth()->user()->id);
        $permissions = [];
        $index = [];

        foreach ($user->permissions as $vlr) {
            array_push($permissions, $vlr->name);
            array_push($index, $vlr->id);
        }

        foreach ($user->roles as $vlr) {
            foreach ($vlr->permissions as $item) {
                if (!in_array($item->id, $index)) {
                    array_push($permissions, $item->name);
                    array_push($index, $item->id);
                }
            }
        }

        $permissions = array_values($permissions);

        return response()->json($permissions);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }
}
