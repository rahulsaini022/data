@component('mail::message')
# Case Registered

Attorney <strong>{{Auth::user()->name}}</strong> has linked you to New Case. <a href="{{ URL::to('/password/reset')}}">Click here</a> to Reset your password and then Login to your Dashboard for approval/rejection of the Case.

@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent