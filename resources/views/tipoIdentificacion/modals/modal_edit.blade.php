<div class="modal fade" id="modal_edit_tipoIdentificacion" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar tipo de Identificación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editar_tipoIdentificacion">
                    @csrf
                    <input id="id_tipoIdentificacion_edit" class="validar" type="hidden" name="tipo_id" value="">
                    <div class="mb-3">
                        <label for="nombre_tipoDocumento_edit" class="col-form-label">Nombre de tipo de identificación</label>
                        <input type="text" class="form-control validar" id="nombre_tipoIdentificacion_edit"
                            name="nombre_edit">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary editar_tipoIdentificacion">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('body').on('click', '.editar_tipoIdentificacion', function() {
        if (obligatorio('validar')) {
            $.post(
                "{{ route('tipoIdentificacion.update') }}",
                $('#editar_tipoIdentificacion').serialize()
            ).done(function(data) {
                if (data.status == 200) {
                    setTimeout(function(){ $('#modal_edit_tipoIdentificacion').modal('hide');},500);
                    alertas(data.msg, 'success')
                    tabla(data)
                } else {
                    alertas(data.msg, 'error')
                }
            })
        }
    })

</script>
