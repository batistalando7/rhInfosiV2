@extends("layouts.admin.pdf")

@section("pdfTitle", "Ficha do Funcionário")

@section("titleSection")
  <h4>Ficha do Funcionário</h4>
  <p><strong>Nome:</strong> <ins>{{ $intern->fullName }}</ins></p>
@endsection

@section("contentTable")
  {{-- Foto no PDF --}}
  @if($intern->photo)
    <div style="text-align: center; margin-bottom: 20px;">
      <img src="{{ public_path("frontend/images/departments/" . $intern->photo) }}"
           style="width:120px; height:120px; object-fit:cover; border-radius:60px;">
    </div>
  @endif

  <table>
    <tbody>
      <tr>
        <th>E-mail</th>
        <td>{{ $intern->email }}</td>
      </tr>
      <tr>
        <th>Telefone</th>
        <td>
          @if($intern->phone_code) {{ $intern->phone_code }} @endif {{ $intern->mobile }}
        </td>
      </tr>
      <tr>
        <th>Bilhete de Identidade</th>
        <td>{{ $intern->bi }}</td>
      </tr>
      <tr>
        <th>Data de Nascimento</th>
        <td>{{ \Carbon\Carbon::parse($intern->birth_date)->format("d-m-Y") }}</td>
      </tr>
      <tr>
        <th>Departamento</th>
        <td>{{ $intern->department->title ?? "-" }}</td>
      </tr>
      {{-- <tr>
        <th>Cargo</th>
        <td>{{ $intern->position->name ?? "-" }}</td>
      </tr>
      <tr>
        <th>Tipo de Funcionário</th>
        <td>{{ $intern->internType->name ?? "-" }}</td>
      </tr>
      <tr>
        <th>Categoria do Funcionário</th>
        <td>{{ $intern->internCategory->name ?? "-" }}</td>
      </tr> --}}
      <tr>
        <th>Nacionalidade</th>
        <td>{{ $intern->nationality }}</td>
      </tr>
      <tr>
        <th>Gênero</th>
        <td>{{ $intern->gender }}</td>
      </tr>
      {{-- <tr>
        <th>IBAN</th>
        <td>{{ $intern->iban ?? "-" }}</td>
      </tr> --}}
      {{-- @php
        use App\Models\SalaryPayment;
        $last = SalaryPayment::where("internId", $intern->id)
                 ->orderByDesc("paymentDate")->first();
      @endphp
      <tr>
        <th>Último Salário</th>
        <td>
          @if($last) {{ number_format($last->salaryAmount, 2, ",", ".") }}
          @else - @endif
        </td>
      </tr> 
      <tr>
        <th>Data do Último Pagamento</th>
        <td>
          @if($last) {{ \Carbon\Carbon::parse($last->paymentDate)->format("d-m-Y") }}
          @else - @endif
        </td>
      </tr>--}}
    </tbody>
  </table>
@endsection
