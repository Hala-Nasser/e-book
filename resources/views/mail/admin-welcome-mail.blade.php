<x-mail::message>
    # Welcome {{$name}},

    We are happy to see you here,

<x-mail::panel>
    Your account password is: {{$password}}
</x-mail::panel>
<x-mail::button :url="''">
Open E-book
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

{{--
@component('mail::message')
    # Welcome AdminName,

    We are happy to see you here,


    @component('mail::panel')
        Your account password is: PASSWORD_HERE.
    @endcomponent

    @component('mail::button', ['url' => ''])
    @endcomponent

@endcomponent --}}
