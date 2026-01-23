<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Notificação de Mobilidade - Gestão de Capital Humano</title>
</head>
<body>
    <h1>Olá, {{ $employee->fullName }}</h1>
    <p>Você foi movido do departamento {{ $oldDepartment ? $oldDepartment->title : 'N/A' }} para o departamento {{ $newDepartment->title }}.</p>
    @if($causeOfMobility)
      <p><strong>Causa da Mobilidade:</strong> {{ $causeOfMobility }}</p>
    @endif
    <p>Atenciosamente,</p>
    <p>Equipe Gestão de Capital Humano</p>
</body>
</html>
