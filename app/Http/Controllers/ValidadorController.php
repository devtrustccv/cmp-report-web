<?php

namespace App\Http\Controllers;

use App\Services\UrlCryptoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidadorController extends Controller
{
    private const TIPOS = [
        'certidao_matricial' => [
            'label' => 'Certidão Matricial',
            'path'  => 'reports/certidao-matricial',
        ],
        'iupremforo' => [
            'label' => 'IUP - Remição de Foro',
            'path'  => 'iupremforo',
        ],
        'iuppartilha' => [
            'label' => 'IUP - Partilha',
            'path'  => 'iuppartilha',
        ],
        'iupdoacao' => [
            'label' => 'IUP - Doação',
            'path'  => 'iupdoacao',
        ],
        'iupsucessorio' => [
            'label' => 'IUP - Sucessório',
            'path'  => 'iupsucessorio',
        ],
        'iupterreno' => [
            'label' => 'IUP - Terreno',
            'path'  => 'iupterreno',
        ],
        'compra-venda' => [
            'label' => 'Compra e Venda',
            'path'  => 'compra-venda',
        ],
    ];

    public function __construct(private UrlCryptoService $cryptoService)
    {
    }

    public function index()
    {
        return view('home_cmp', [
            'tipos' => self::TIPOS,
        ]);
    }

    public function validar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tipo' => 'required|string|in:' . implode(',', array_keys(self::TIPOS)),
            'duc'  => 'required|digits_between:1,20',
        ], [], [
            'tipo' => 'Tipo de documento',
            'duc'  => 'DUC',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $tipo = $request->get('tipo');
        $duc = $request->get('duc');

        $path = self::TIPOS[$tipo]['path'];

        $queryString = http_build_query([
            'id' => (int) $duc,
            'verificacao' => 2,
        ]);

        $token = $this->cryptoService->encrypt($queryString);

        return redirect('/' . trim($path, '/') . '/' . $token);
    }
}
