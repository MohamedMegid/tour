<!DOCTYPE html>
<html>
	<body>
		<div>{{ trans('translation.forget_password_body') }}</div>
		<a href="{{ URL::to(''.$lang.'/change-password/'.$user->id.'/' . $user->confirmation_code) }}"> {{ trans('translation.change_my_password') }} </a>
	</body>
</html>