<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function list()
    {
        $users = User::get();
        return $users;
    }

    public function insert(UserRequest $request)
    {
        $user = $request->validated();

        $kontrol = User::where('email', $user['email'])->first();

        if ($kontrol) {
            return 'Bu e-posta başka bir kullanıcı tarafından kullanılıyor. Farklı bir e-posta deneyin.';
        }

        User::create([
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => $user['password'],
        ]);

        return 'Kullanıcı başarıyla oluşturuldu';
    }

    public function update($id, UserRequest $request)
    {
        $user = User::find($id);
        $data = $request->validated();

        $kontrol = User::where('email', $data['email'])->first();

        if ($kontrol) {
            return 'Bu e-posta başka bir kullanıcı tarafından kullanılıyor. Farklı bir e-posta deneyin.';
        } else if ($user->email == $data['email']) {
            return 'Zaten bu e-postayı kullanıyorsunuz.';
        } else {
            $user->name = $data['name'];
            $user->email = $data['email'];

            $user->save();

            return 'Kullanıcı başarıyla güncellendi.';
        }
    }

    public function updatepw($id, UserRequest $request)
    {
        $user = User::find($id);
        $data = $request->validated();
        $oldpw = $data['oldpw'];

        if (Hash::check($oldpw, $user->password)) {
            $user->password = $data['password'];
            $user->save();
            return 'Kullanıcı şifresi başarıyla güncellendi.';
        } else {
            return 'Eski şifreniz yanlış.';
        }
    }

    public function delete($id)
    {
        $user = User::find($id);

        if (!$user) {
            return 'Kullanıcı bulunamadı';
        }

        $user->delete();

        return 'Kullanıcı başarıyla silindi.';
    }

    public function destroy($id)
    {
        $user = User::withTrashed()->find($id);

        if (!$user) {
            return 'Kullanıcı bulunamadı';
        }

        $user->forceDelete();

        return 'Kullanıcı kalıcı olarak silindi.';
    }
}