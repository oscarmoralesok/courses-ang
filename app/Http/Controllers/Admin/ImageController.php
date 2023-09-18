<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    
    public function upload( Request $request )
    {
        $img = Storage::disk('public') -> put( 'img/lessons', $request -> file('upload'));

        return [
            'url' => url( $img ),
        ];
    }

}
