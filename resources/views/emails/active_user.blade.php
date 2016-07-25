<!DOCTYPE html>
<html>
	<body>
		<div>{{ trans('translation.active_user_body') }}</div>
		<a href="{{ URL::to(''.$lang.'/verify/' . $user->confirmation_code) }}"> {{ trans('translation.active_my_account') }} </a>
	</body>
</html>