<div class="d-inline">
    <!-- Order your soul. Reduce your wants. - Augustine -->
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-danger rounded-0 btn-shadow" data-toggle="modal"
        data-target="#deleteUser{{$user->id}}">
        <i class="fas fa-trash"></i>
    </button>

    <!-- Modal -->
    <div class="modal fade" id="deleteUser{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Eliminar usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('users.destroy',[$user])}}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="text-uppercase">
                                            {{strtoupper($user->name)}}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            @if ($repositories->count())
                            <div class="col-12 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        El usuario cuenta con <b>{{$repositories->count()}}</b> REAS que serán eliminados.
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if ($evaluations->count())
                            <div class="col-12 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        El usuario tiene <b>{{$evaluations->count()}}</b> evaluaciones a su cargo que deben cambiar de responsable.
                                        <br>
                                        <select name="newEvaluatorId" id="" class="form-control">
                                            <option value="" hidden>seleccionar</option>
                                            @foreach ($evaluators as $evaluator)
                                                <option value="{{$evaluator->id}}">{{$evaluator->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger rounded-0 btn-shadow">
                            <span data-toggle="tooltip" title="Eliminar" wire:ignore.self>
                                <i class="fas fa-trash"></i>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>