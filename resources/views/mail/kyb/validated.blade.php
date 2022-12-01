@component('mail::message')
# KYB Validated

Les document que vous avez envoyé pour la creation de votre boutique ont été validés!

@component('mail::button', ['url' => route('store.view'), 'color' => 'green'])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
