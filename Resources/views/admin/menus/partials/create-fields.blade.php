<div class='form-group{{ $errors->has('NAME') ? ' has-error' : '' }}'>
    {!! Form::label('NAME', trans('menu::menu.form.name')) !!}
    {!! Form::text('NAME', old('NAME'), ['class' => 'form-control', 'placeholder' => trans('menu::menu.form.name')]) !!}
    {!! $errors->first('NAME', '<span class="help-block">:message</span>') !!}
</div>
