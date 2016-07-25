@if($Language->all()->count())
    <div class="form-group">
        <label  style="text-align: center; width:100%;">{{ trans('backend.languages') }}</label>
        @foreach($Language->all() as $key => $lang)
        <div class="checkbox">
            <label for="checkboxes-0">
              <input type="checkbox" name="language[{{$key}}]" id="lang-{{$lang->code}}" value="{{$lang->code}}"@if(isset($trans[$lang->code])) checked @elseif(old('language.'.$key.'') == $lang->code) checked @elseif(Lang::getlocale() == $lang->code && session('default_contnent_language')!= 'no') checked @elseif(Lang::getlocale() == $lang->code && !session()->has('default_contnent_language')) checked @endif>
              {{$lang->name}}
            </label>
        </div>
        @endforeach
    </div>
@endif