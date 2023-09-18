<?php

namespace App\Http\Livewire\Admin\Users;

use App\Models\User;
use App\Notifications\WelcomeUser;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $createArray = ['role' => 1], $usr, $editArray;

    public function save()
    {
        $this -> validate([
            'createArray.name' => 'required',
            'createArray.email' => 'required|email|unique:users,email',
        ]);

        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $password = substr(str_shuffle($permitted_chars), 0, 8);
        $this -> createArray['password'] = Hash::make($password);

        $user = User::create( $this -> createArray );

        $user -> notify( new WelcomeUser($user, $password) );

        $this -> reset('createArray');
        $this -> emit('saved');
    }

    public function edit(User $user)
    {
        $this -> usr = $user;
        $this -> editArray['name'] = $user -> name;
        $this -> editArray['email'] = $user -> email;
    }

    public function update()
    {
        $this -> validate([
            'editArray.name' => 'required',
            'editArray.email' => 'required|email|unique:users,email,' . $this -> usr -> id,
        ]);

        $this -> usr -> update( $this -> editArray );

        $this -> reset('editArray');
        $this -> emit('updated');
    }

    public function destroy(User $user)
    {
        $user -> delete();
        $this -> emit('deleted');
    }

    public function render()
    {
        $users = User::orderBy('id', 'DESC') -> where('role', 1) -> paginate();
        return view('livewire.admin.users.index', compact('users'));
    }
}
