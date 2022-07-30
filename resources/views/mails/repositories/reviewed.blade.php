@component('mail::message')
# El REA {{$repository->name}} tiene el status: {{$repository->status}}.

{{$comments}}

@component('mail::button', ['url' => route('repositories.index')])
Ver REA
@endcomponent

Gracias,<br>
Ecosistema DES BUAP
@endcomponent
