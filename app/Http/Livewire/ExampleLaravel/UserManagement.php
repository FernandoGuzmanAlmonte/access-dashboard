<?php

namespace App\Http\Livewire\ExampleLaravel;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class UserManagement extends Component
{
    public $username;
    public $email;
    public $rfid;
    public $showModal = false;
    public $users;
    public $doors;

    public function saveChanges()
    {
        $host = env("MOBILE_API_HOST", "http://localhost:3000");
        
        $response = Http::post($host . '/api/register', [
            'username' => $this->username,
            'email' => $this->email,
            "emailAdmin" => session('userAdmin')->email,
            'rfid' => $this->rfid,
        ]);

        if ($response->successful()) {
            session()->flash('message', 'Success!');
        } else {            
            session()->flash('error', 'Failed!');
        }

        $this->showModal = false;
    }

    public function hydrate()
    {   
        $host = env("MOBILE_API_HOST", "http://localhost:3000");

        $responseUsers = Http::get($host . '/api/getUsuarios', [
            "emailAdmin" => session('userAdmin')->email
        ]);
        $this->users = json_decode($responseUsers->body());

        $responseDoors = Http::get($host . '/api/puertas', [
            "emailAdmin" => session('userAdmin')->email
        ]);
        $this->doors = json_decode($responseDoors->body());
    }


    public function render()
    {
        $host = env("MOBILE_API_HOST", "http://localhost:3000");
        
        $responseUsers = Http::get($host . '/api/getUsuarios', [
            "emailAdmin" => session('userAdmin')->email
        ]);
        $this->users = json_decode($responseUsers->body());

        
        $responseDoors = Http::get($host . '/api/puertas', [
            "emailAdmin" => session('userAdmin')->email
        ]);
        if ($responseDoors->successful()) {
            $this->doors = json_decode($responseDoors->body());
        } else {
            $this->doors = [];
        }

        return view('livewire.example-laravel.user-management');
    }
}
