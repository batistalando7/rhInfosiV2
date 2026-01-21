<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Department;
use App\Models\Employeee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class AdminAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        $search = $request->get('search');

        $query = Admin::with('employee');

        if (auth()->user()->role === 'department_head' || auth()->user()->role === 'employee') {
            $query->where('role', '<>', 'director');
        }

        if ($search) {
            $query->whereHas('employee', function ($q) use ($search) {
                $q->where('fullName', 'like', '%' . $search . '%');
            });
        }

        $admins = $query->orderBy('id')->get();

        return view('admin.user.list.index', compact('admins'));
    }

    public function create()
    {
        $employees   = Employeee::whereDoesntHave('admin')->orderBy('fullName')->get();
        $departments = Department::orderBy('title')->get();

        return view('admin.user.create.index', compact('employees', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employeeId'            => 'nullable|exists:employeees,id',
            'role'                  => 'required|in:admin,director,department_head,employee',
            'email'                 => 'required|email|unique:admins,email',
            'password'              => 'required|min:6|confirmed',
            'photo'                 => 'nullable|image|max:2048',
            'department_id'         => 'nullable|required_if:role,department_head|exists:departments,id',
            'department_head_name'  => 'nullable|string|max:255',
            'directorType'          => 'nullable|in:directorGeneral,directorTechnical,directorAdministrative',
            'directorName'          => 'nullable|string|max:255',
            'directorPhoto'         => 'nullable|image|max:2048',
            'biography'             => 'nullable|string',
            'linkedin'              => 'nullable|url',
        ]);

        $admin = new Admin();
        $admin->employeeId = $request->employeeId;
        $admin->role       = $request->role;
        $admin->email      = $request->email;
        $admin->password   = Hash::make($request->password);

        // Buscar o funcionário vinculado
        $employee = $request->employeeId ? Employeee::find($request->employeeId) : null;

        // Foto padrão: usar a do funcionário se existir
        $finalPhoto = null;
        if ($employee && $employee->photo) {
            $finalPhoto = $employee->photo;
        }

        // Chefe de Departamento
        if ($request->role === 'department_head') {
            $admin->department_id = $request->department_id;

            if ($request->hasFile('photo')) {
                $photoName = time() . '_' . $request->file('photo')->getClientOriginalName();
                $request->file('photo')->move(public_path('frontend/images/departments'), $photoName);
                $finalPhoto = $photoName;
            }
        }

        // Diretor
        if ($request->role === 'director') {
            $admin->directorType = $request->directorType;

            $directorName = $request->directorName;
            if (!$directorName && $employee) {
                $directorName = $employee->fullName;
            }
            $admin->directorName = $directorName;

            if ($request->hasFile('directorPhoto')) {
                $photoName = time() . '_' . $request->file('directorPhoto')->getClientOriginalName();
                $request->file('directorPhoto')->move(public_path('frontend/images/directors'), $photoName);
                $finalPhoto = $photoName;
                $admin->directorPhoto = $photoName;
            }

            $admin->biography = $request->biography;
            $admin->linkedin  = $request->linkedin;
        }

        // Atribuir a foto ao admin
        $admin->photo = $finalPhoto;

        // *** CÓPIA AUTOMÁTICA DO ARQUIVO FÍSICO PARA A PASTA DO FRONTEND ***
        if ($finalPhoto && $employee && $employee->photo && in_array($request->role, ['director', 'department_head'])) {
            $sourcePath = public_path('frontend/images/departments/' . $employee->photo);

            if (file_exists($sourcePath)) {
                if ($request->role === 'director') {
                    $destPath = public_path('frontend/images/directors/' . $employee->photo);
                    $admin->directorPhoto = $employee->photo; // garante que directorPhoto tenha o nome
                } else { // department_head
                    $destPath = public_path('frontend/images/departments/' . $employee->photo);
                }

                // Copia o arquivo físico (sobrescreve se existir)
                copy($sourcePath, $destPath);
            }
        }
        // *** FIM DA CÓPIA AUTOMÁTICA ***

        $admin->save();

        // Ajustes pós-save
        if ($admin->role === 'director' && $admin->employeeId) {
            $emp = Employeee::find($admin->employeeId);
            if ($emp) {
                $emp->departmentId = null;
                $emp->save();
            }
        }

        if ($admin->role === 'department_head' && $admin->department_id) {
            $department = Department::find($admin->department_id);
            if ($department) {
                $headName = $request->department_head_name ?: ($employee ? $employee->fullName : null);
                $department->department_head_name = $headName;
                $department->head_photo = $admin->photo;
                $department->save();
            }
        }

        return redirect()->route('admin.users.index')->with('msg', 'Administrador criado com sucesso!');
    }

    public function show($id)
    {
        $admin = Admin::with('employee')->findOrFail($id);
        return view('admin.user.details.index', compact('admin'));
    }

    public function edit($id)
    {
        $admin       = Admin::findOrFail($id);
        $employees   = Employeee::orderBy('fullName')->get();
        $departments = Department::orderBy('title')->get();

        return view('admin.user.edit.index', compact('admin', 'employees', 'departments'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'employeeId'     => 'nullable|exists:employeees,id',
            'role'           => 'required|in:admin,director,department_head,employee',
            'email'          => 'required|email|unique:admins,email,' . $id,
            'password'       => 'nullable|min:6|confirmed',
            'biography'      => 'nullable|string',
            'linkedin'       => 'nullable|url',
            'department_id'  => 'nullable|required_if:role,department_head|exists:departments,id',
        ]);

        $admin = Admin::findOrFail($id);

        $oldRole = $admin->role;

        $admin->employeeId = $request->employeeId;
        $admin->role       = $request->role;
        $admin->email      = $request->email;

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        // Limpar campos específicos ao mudar de role
        if ($admin->role !== 'director') {
            $admin->biography = null;
            $admin->linkedin  = null;
            $admin->directorType = null;
            $admin->directorName = null;
            $admin->directorPhoto = null;
        } else {
            $admin->biography = $request->biography;
            $admin->linkedin  = $request->linkedin;
        }

        if ($admin->role !== 'department_head') {
            $admin->department_id = null;
        } else {
            $admin->department_id = $request->department_id;
        }

        $admin->save();

        // Ajuste para director
        if ($admin->role === 'director' && $admin->employeeId) {
            $employee = Employeee::find($admin->employeeId);
            if ($employee) {
                $employee->departmentId = null;
                $employee->save();
            }
        }

        return redirect()->route('admin.users.edit', $id)->with('msg', 'Administrador atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);

        if ($admin->role === 'admin' && $admin->employeeId === null) {
            return redirect()->route('admin.users.index')
                ->withErrors(['msg' => 'Este administrador não pode ser excluído.']);
        }

        $admin->delete();

        return redirect()->route('admin.users.index')
            ->with('msg', 'Administrador removido com sucesso.');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Auth::guard('admin')->user();
            $token = $admin->createToken('auth_token')->plainTextToken;
            return response()->json([
                'access_token' => $token,
                'token_type'   => 'Bearer',
            ]);
        }
        return response()->json(['error' => 'Credenciais inválidas'], 401);
    }

    public function contractPdf($id)
    {
        $admin = Admin::with('employee.department')->findOrFail($id);
        if (!$admin->employee) {
            abort(404, 'Funcionário não vinculado ao administrador.');
        }
        $pdf = PDF::loadView('pdf.user.contractPdf', compact('admin'))
                  ->setPaper('a4', 'portrait');
        return $pdf->stream("Contrato_Admin_{$admin->id}.pdf");
    }
}