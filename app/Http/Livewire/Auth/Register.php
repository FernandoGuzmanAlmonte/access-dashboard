<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Register extends Component
{

    public $name ='';
    public $email = '';
    public $password = '';

    protected $rules=[
        'email' => 'required|email',
        'password' => 'required'
    ];


    public function store(){

        $host = env("MOBILE_API_HOST", "http://localhost:3000");

        $responseUserAdmin = Http::post($host . '/api/registerAdmin', [
            'username' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ]);
        

        if ($responseUserAdmin->successful()) {
            $userAdmin = json_decode($responseUserAdmin->body());
            session(['userAdmin' => $userAdmin]);

            return redirect('/dashboard');
        } else {
            session()->flash('error', 'Hubo un problema con el registro.');
        }
    } 

    public function render()
    {
        return view('livewire.auth.register');
    }
}
