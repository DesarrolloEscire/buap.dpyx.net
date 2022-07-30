@component('mail::message')
# Estimada/o colega:

Te has registrado exitosamente en la plataforma de cursos REA BUAP. A continuación se mostrarán tus credenciales de acceso:

@component('mail::table')
| identificador      | password                  |
| :--------- | :---------------------- |
| {{$user->identifier}} | {{$password}} |
@endcomponent

Para poder accesar a la plataforma, primero necesitas verificar tu cuenta dando click en el siguiente botón:

@component('mail::button', ['url' => route('users.verify',[$user])])
verificar cuenta
@endcomponent

Gracias,<br>
Ecosistema DES BUAP
@endcomponent
