<div id="modalMantenimientoCelulas" class="modal modal-fill fade" data-backdrop="false" tabindex="-1">
    <div class="modal-dialog modal-lg" style="width: 30% !important;">
        <form enctype="multipart/form-data" action="{{ route('auth.celula.update') }}" id="registroCelulas" method="POST"
            data-ajax="true" data-close-modal="true" data-ajax-loading="#loading"
            data-ajax-success="OnSuccessRegistroCelulas" data-ajax-failure="OnFailureRegistroCelulas">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $Entity != null ? 'Modificar' : ' Registrar' }} Celula</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="id" name="id" value="{{ $Entity != null ? $Entity->id : 0 }}">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="liderid" class="m-0 label-primary" style="font-size: 15px;">
                                    <i class="fa fa-tag"></i> Líder de Célula
                                </label>
                                <select class="form-control form-control-lg" id="lider_id" name="lider_id" required>
                                    <option value="" disabled selected>Seleccione Líder..</option>
                                    @foreach ($user as $user)
                                        <option value="{{ $user->id }}">{{ $user->nombres }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="nombre">Nombre de Célula</label>
                                <input type="text" class="form-input form-control-lg" name="nombre"
                                    value="{{ $Entity ? $Entity->nombre : '' }}" id="nombre" autocomplete="off">
                                <span data-valmsg-for="nombre" class="text-danger"></span>
                            </div>
                            <div class="col-md-12">
                                <label for="descripcion">Descripcion</label>
                                <input type="text" class="form-input form-control-lg" name="descripcion"
                                    value="{{ $Entity ? $Entity->descripcion : '' }}" id="descripcion" autocomplete="off">
                                <span data-valmsg-for="descripcion" class="text-danger"></span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit"
                        class="btn btn-bold btn-pure btn-primary">{{ $Entity != null ? 'Modificar' : ' Registrar' }}
                        Celula</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" src="{{ asset('auth/js/celula/_Mantenimiento.js') }}"></script>
