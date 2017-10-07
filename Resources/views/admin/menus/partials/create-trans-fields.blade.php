<div class='form-group{{ $errors->has("TITLE") ? ' has-error' : '' }}'>
    {!! Form::label("TITLE", trans('menu::menu.form.title')) !!}
    {!! Form::text("TITLE", old("TITLE"), ['class' => 'form-control', 'placeholder' => trans('menu::menu.form.title')]) !!}
    {!! $errors->first("TITLE", '<span class="help-block">:message</span>') !!}
</div>
<div class="checkbox">
    <label for="STATUS">
        <input id="STATUS"
                name="STATUS"
                type="checkbox"
                class="flat-blue"
                {{ (is_null(old("STATUS"))) ?: 'checked' }}
                value="1" />
        {{ trans('menu::menu.form.status') }}
    </label>
</div>
