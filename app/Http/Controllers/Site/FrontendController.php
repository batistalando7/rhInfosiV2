<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Statute;
use App\Models\Admin;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $response['departments'] = Department::all();
        return view('site.home.index', $response);
    }

    public function about()
    {
        return view('site.about.index');
    }

    public function statute()
    {
        $response['statute'] = Statute::orderBy('created_at', 'desc')->first();
        return view('site.statute.index', $response);
    }

    public function directors()
    {
        // traz todos os diretores em um array
        $response['directors'] = Admin::where('role', 'director')->get();
        return view('site.directors.index', $response);
    }

    //exibe detalhes de um único diretor
    public function showDirector($id)
    {
        $response['director'] = Admin::findOrFail($id);
        return view('site.diretors.directorShow', $response);
    }

    /* public function contact()
    {
        return view('site.contact.index');
    } */
}
