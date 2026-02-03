<!-- Modal Dinâmica Única -->
<div class="modal fade" id="globalModal" tabindex="-1" aria-labelledby="globalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="globalModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<script>
    // Lógica de Modal Dinâmica
    function showModal(type, title, message, footer = '') {
        const modal = new bootstrap.Modal(document.getElementById('globalModal'));
        const modalHeader = document.querySelector('#globalModal .modal-header');
        const modalBody = document.querySelector('#globalModal .modal-body');
        const modalFooter = document.querySelector('#globalModal .modal-footer');

        modalHeader.className = 'modal-header';
        if (type === 'success') modalHeader.classList.add('bg-success', 'text-white');
        else if (type === 'error') modalHeader.classList.add('bg-danger', 'text-white');
        else if (type === 'delete') modalHeader.classList.add('bg-danger', 'text-white');

        document.getElementById('globalModalLabel').textContent = title;
        modalBody.innerHTML = message;
        modalFooter.innerHTML = footer;

        modal.show();
    }

    // Modais de Sucesso e Erro
    @if (session('success'))
        showModal('success', 'Sucesso', '{{ session('success') }}');
    @endif
    @if (session('error'))
        showModal('error', 'Error', '{{ session('error') }}');
    @endif
    //erros de validação
    @if ($errors->any())
        showModal('error', 'Erro(s)',
            '@foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach'
        );
    @endif
</script>
