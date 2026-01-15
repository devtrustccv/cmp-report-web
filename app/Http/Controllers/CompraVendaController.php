<?php
namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
use App\Models\CompraVenda;
use App\Http\Utils;


class CompraVendaController extends Controller
{
    public function gerarPdf($id)
    {
        $baseUrl = config('services.compra_venda.base_url');

        $response = Http::withoutVerifying()->get("{$baseUrl}/{$id}");

        if ($response->failed()) {
            abort(404, "Documento não encontrado na API");
        }

        

        $dadosApi = $response->json();

        
        $dados = new CompraVenda($dadosApi);

        return Pdf::loadView('iupcompra', [
                'dados' => $dados
            ])
            ->setPaper('A4')
            ->stream('iupcompra.pdf');
    }

}
