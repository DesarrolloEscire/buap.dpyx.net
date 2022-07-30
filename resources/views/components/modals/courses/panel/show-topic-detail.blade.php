<div id="modalShowTopicDetail{{$topic->id}}" class="modal" tabindex="-1" style="text-align:justify;">
    <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tema {{ $index+1 }}: {{ $topic->topic_name }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            {!! $topic->description !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-shadow rounded-0" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </form>
    </div>
</div>