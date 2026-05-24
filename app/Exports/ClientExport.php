<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClientExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $clients = Client::all();

        $clientsCollection = Collect([]);

        foreach ($clients as $client) {
            $clientsCollection->push([
                'id' => $client->id,
                'name_surname' => $client->name_surname,
                'email' => $client->email,
                'phone' => $client->phone,
                'message' => $client->message,
            ]);
        }

        return $clientsCollection;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombres y Apellidos',
            'Email',
            'Celular',
            'Consulta (Opcional)',
        ];
    }
}
