<?php
namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
use App\Models\CompraVenda;
use App\Http\Utils;
use App\Http\QrCodeService;
use SimpleSoftwareIO\QrCode\Facades\QrCode;



class DoacaoController extends Controller
{
    private QrCodeService $qrService;

    public function __construct(QrCodeService $qrService)
    {
        $this->qrService = $qrService;
    }


    public function gerarPdf($id)
    {

        $qrcode_base64 =  null;

        return Pdf::loadView('iupdoacao', [
            'qrcode_base64' =>  $qrcode_base64,
            'tipo' => 'IUPDOACAO'
        ])->setPaper([0, 0, 600, 520])
          ->stream('iupdoacao.pdf');
    }

}
