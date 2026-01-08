<?php

namespace App\Http\Controllers\Collaborator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class CollaboratorController extends Controller
{
    public function index()
    {
        return view('Collaborator.index');
    }
}
