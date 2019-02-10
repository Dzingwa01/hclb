@component('mail::message')
<h1>Invitation to join HCLB</h1>
<p> Dear {{$user->name. ' ' . $user->surname}}</p><br/>
<p>You have been invited to join HCLB. Please activate your account by clicking the button below.
</p>
<p>Your username is {{$user->email}} and password is <b>secret</b>. Please remember to update your password on first login.</p>

@component('mail::button', ['url' => $url])
        Activate account
@endcomponent

Thanks,<br>
{{'The '. config('app.name').' Team' }}
@endcomponent
