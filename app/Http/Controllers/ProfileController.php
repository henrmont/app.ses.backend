<?php

namespace App\Http\Controllers;

use App\Events\NotificationEvent;
use App\Events\ProfileEvent;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function getProfile()
    {
        $profile = User::find(auth()->user()->id);
        return response()->json($profile);
    }

    public function setProfileInfo(Request $request)
    {
        $profile = User::find(auth()->user()->id);
        $profile->update([
            'name' => $request->name,
        ]);
        Notification::create([
            'user_id' => auth()->user()->id,
            'app_id' => rand(1,3),
            'title' => 'Atualização das informações',
            'message' => 'Suas informações de perfil foram atualizadas.',
        ]);
        event(new NotificationEvent(auth()->user()->id));
        event(new ProfileEvent(auth()->user()->id));

        return response()->json(['message' => 'Informações atualizada com sucesso!'], 200);
    }

    public function setProfilePicture(Request $request)
    {
        $profile = User::find(auth()->user()->id);
        $profile->update([
            'picture' => $request->picture,
        ]);
        Notification::create([
            'user_id' => auth()->user()->id,
            'app_id' => rand(1,3),
            'title' => 'Atualização da imagem de perfil',
            'message' => 'Sua imagem de perfil foi atualizada.',
        ]);
        event(new NotificationEvent(auth()->user()->id));
        event(new ProfileEvent(auth()->user()->id));

        return response()->json(['message' => 'Imagem atualizada com sucesso!'], 200);
    }

}
