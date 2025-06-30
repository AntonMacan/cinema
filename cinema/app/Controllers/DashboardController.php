<?php

namespace App\Controllers;

class DashboardController extends BaseController
{
    public function index()
    {
        $data = [
            'nome' => session()->get('nome')
        ];

        return view('dashboard', $data);
    }
}