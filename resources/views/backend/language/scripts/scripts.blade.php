@if($Language->all()->count())
@foreach($Language->all() as $lang)
<script>
  field_{{$lang->code}} = document.getElementById('lang-{{$lang->code}}');
  if (field_{{$lang->code}}) {
   target_{{$lang->code}} = document.getElementById('group-{{$lang->code}}');
   // Hide the target field if field isn't "Yes"
   if (!field_{{$lang->code}}.checked) target_{{$lang->code}}.style.display='none';

   field_{{$lang->code}}.onchange=function() {
    if (this.checked) {
                     target_{{$lang->code}}.style.display = '';
                  } else {
              target_{{$lang->code}}.style.display='none';
    }
   }
  }
  </script>
 @endforeach
 @endif