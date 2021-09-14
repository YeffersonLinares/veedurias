<div class="modal fade " id="modal_integrante" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                {{-- <h5 class="modal-title" id="staticBackdropLabel">Integrante</h5> --}}
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <h5 class="modal-title">Integrante</h5>
                    <div class="row m-3">
                        <div class="col">
                            <div class="row text-style">Nombres y apellidos</div>
                            <div class="row mb-3" id="mNombre">valor nombre</div>
                            <div class="row text-style">Tipo de identificación</div>
                            <div class="row mb-3" id="mTipo">valor identificación</div>
                            <div class="row text-style">Número de identificación</div>
                            <div class="row mb-3" id="mNumeroI">123123123</div>
                            <div class="row text-style">Dirección</div>
                            <div class="row" id="mDirecc">Calle 3</div>
                        </div>
                        <div class="col">
                            <div class="row text-style">Teléfono</div>
                            <div class="row mb-3" id="mTel">3123123</div>
                            <div class="row text-style">Correo electrónico</div>
                            <div class="row mb-3" id="mCorreo">Correo</div>
                            <div class="row text-style">Estado</div>
                            <div class="row" id="mEstado">Activo</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .text-style{
        font-weight: bold;
        font-size: 17px;
        color: gray;
    }
</style>
