<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class Tables extends Component
{
    public $movimientos;

    public function render()
    {
        $host = env("MOBILE_API_HOST", "http://localhost:3000");
        
        $response = Http::get($host . '/api/getMovimientos', [
            "emailAdmin" => session('userAdmin')->email
        ]);

        if ($response->successful() ) {
            $this->movimientos = json_decode($response->body());
            
            foreach ($this->movimientos as $movimiento) {
                $date = Carbon::parse($movimiento->fecha);
                $movimiento->fecha = $date->tz('America/Mexico_City')->format('Y-m-d H:i:s');
            }
        } else {
            $this->movimientos = [];
        }

        return view('livewire.tables');
    }
}
