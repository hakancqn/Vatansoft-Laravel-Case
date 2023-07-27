<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function list(){
        $users = User::get();
        return $users;
    }

    public function insert(UserRequest $request){
        $user = $request->validated();

        User::create([
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => $user['password'],
        ]);

        return 'Kullanıcı başarıyla oluşturuldu';
    }

    public function update($id, UserRequest $request){
        $user = User::find($id);
        $data = $request->validated();

        $user->name = $data['name'];
        $user->email = $data['email'];

        $user->save();

        return 'Kullanıcı başarıyla güncellendi.';
    }

    public function updatepw($id, UserRequest $request){
        $user = User::find($id);
        $data = $request->validated();

        $user->password = $data['password'];

        $user->save();

        return 'Kullanıcı şifresi başarıyla güncellendi.';
    }

    public function delete($id){
        $user = User::find($id);

        if(!$user){
            return 'Kullanıcı bulunamadı';
        }

        $user->delete();

        return 'Kullanıcı başarıyla silindi.';
    }

    public function destroy($id){
        $user = User::withTrashed()->find($id);

        if(!$user){
            return 'Kullanıcı bulunamadı';
        }

        $user->forceDelete();

        return 'Kullanıcı kalıcı olarak silindi.';
    }
}
