<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return view("admin.course.list.index", compact("courses"));
    }

    public function create()
    {
        return view("admin.course.create.index");
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|unique:courses|max:255",
            "description" => "nullable|string", // Adicionado o campo description
        ]);

        Course::create($request->all());

        return redirect()->route("admin.courses.index")
                         ->with("msg", "Curso criado com sucesso!");
    }

    public function show($id)
    {
        $course = Course::findOrFail($id);
        return view("admin.course.details.index", compact("course"));
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        return view("admin.course.edit.index", compact("course"));
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $request->validate([
            "name" => "required|max:255|unique:courses,name," . $course->id,
            "description" => "nullable|string", // Adicionado o campo description
        ]);

        $course->update($request->all());

        return redirect()->route("admin.courses.index")
                         ->with("msg", "Curso atualizado com sucesso!");
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        return redirect()->route("admin.courses.index")
                         ->with("msg", "Curso excluído com sucesso!");
    }
}


