{{-- @php
    $urlLimit = route('admin.input.limit');
@endphp --}}
<div class="row">
    <h3>Informações sobre o produto</h3>
    <hr>
    <div class="col-md-6 mb-3">
        <div class="form-floating">
            <select type="text" name="infrastructureId" id="infrastructureId" class="form-select" placeholder=""
                value="{{ old('infrastructureId') }}">
                <option value="">selecione</option>
                @foreach ($infrastructures as $item)
                    <option value="{{ $item->id }}"> {{ $item->name }}</option>
                @endforeach
            </select>
            <label for="infrastructureId">Nome</label>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-floating">
            <input type="number" name="quantity" id="quantity" min="1" class="form-control" placeholder=""
                value="{{ old('quantity', 0) }}" min="0">
            <label for="quantity">Qtd. Inicial em Estoque</label>
        </div>
    </div>
    <div class="col-md-12 mb-3">
        <div class="form-floating">
            <input type="file" name="document" id="document" class="form-control" placeholder="">
            <label for="document">Documento</label>
        </div>
    </div>
    <div class="col-md-12 mb-3">
        <div class="form-floating">
            <textarea name="Notes" id="Notes" class="form-control" placeholder="" style="height: 100px;">{{ old('Notes') }}</textarea>
            <label for="Notes">Observações</label>
        </div>
    </div>
</div>
<div class="d-grid gap-2 col-4 mx-auto mt-4">
    <button class="btn btn-success"><i class="fas fa-check-circle me-1"></i> Salvar</button>
</div>

<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script>
    $(document).ready(function() {

        $('#infrastructureId').on('change', function() {
            let infrastructureId = $(this).val();

            // se não selecionou nada
            if (!infrastructureId) {
                $('#quantity').attr('max', 0).val(0);
                return;
            }

            $.ajax({
                url: `/infraestrutura/limite/${infrastructureId}`,
                type: 'GET',
                dataType: 'json',
                success: function(data) {

                    let maxQuantity = data.quantity;

                    // define o limite máximo
                    $('#quantity')
                        .attr('max', maxQuantity)
                        .attr('min', 1);

                    // se o valor atual for maior que o permitido, corrige
                    if (parseInt($('#quantity').val()) > maxQuantity) {
                        $('#quantity').val(maxQuantity);
                    }

                },
                error: function() {
                    alert('Erro ao buscar o limite do material.');
                    $('#quantity').attr('max', 0).val(0);
                }
            });
        });
    })
</script>
