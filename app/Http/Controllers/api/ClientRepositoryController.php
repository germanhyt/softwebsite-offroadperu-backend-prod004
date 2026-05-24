<?php

namespace App\Http\Controllers\api;

use App\Exports\ClientExport;
use App\Http\Controllers\Controller;
use App\Interfaces\ClientRepositoryInterface;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ClientRepositoryController extends Controller
{
    //
    private ClientRepositoryInterface $clientRepository;

    public function __construct(ClientRepositoryInterface $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function save(Request $request)
    {
        $data = $request->validate([
            'name_surname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
        ]);
        // 

        $existingClient = $this->clientRepository->findByEmail($data['email']);
        if ($existingClient) {
            return response()->json(['message' => 'El email ya se encuentra registrado'], 409);
        }

        $result = $this->clientRepository->save($data);

        if ($result) {
            return response()->json(['ok' => true, 'message' => 'Registro completado'], 201);
        } else {
            return response()->json(['ok' => false, 'message' => 'No se pudo completar el registro'], 500);
        }
    }


    public function export()
    {
        $fileNamne = 'clientes.xlsx';

        return Excel::download(new ClientExport, $fileNamne);
    }
}
