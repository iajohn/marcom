@component('mail::message')
#  Verify your email address

## Dear {{ucfirst($username)}},

#### Please click the below button to activate your account.

@component('mail::button', ['url' => $link])
    Verify Account
@endcomponent

Thanks, <br>
{{ getAppName() }}
@endcomponent
