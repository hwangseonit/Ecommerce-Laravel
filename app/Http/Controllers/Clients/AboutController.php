<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Http\Request;

use function Termwind\render;

class AboutController extends Controller
{
    public function index()
    {
        $breadcrumbs = Breadcrumbs::generate('about.index');
        return view('pages.client.about', [
            'title' => 'Giới thiệu',
            'breadcrumbs' => $breadcrumbs
        ]);
    }

}
