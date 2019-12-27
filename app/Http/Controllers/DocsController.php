<?php

namespace App\Http\Controllers;

class DocsController extends Controller
{
    protected static function getUrlToDocs()
    {
        return '/' . config('l5-swagger.routes.docs') . '/' . config('l5-swagger.paths.docs_json');
    }

    public function redoc()
    {
        return view('docs.redoc', [
            'urlToDocs' => self::getUrlToDocs(),
        ]);
    }

    public function swagger()
    {
        return view('docs.swagger', [
            'urlToDocs' => self::getUrlToDocs(),
        ]);
    }
}
