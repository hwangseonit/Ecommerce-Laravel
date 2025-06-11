<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Http\Request;

use function Termwind\render;

class ContactController extends Controller
{
    public function index()
    {
        $breadcrumbs = Breadcrumbs::generate('contact.index');
        return view('pages.client.contact', [
            'title' => 'Liên hệ',
            'breadcrumbs' => $breadcrumbs
        ]);
    }

}
