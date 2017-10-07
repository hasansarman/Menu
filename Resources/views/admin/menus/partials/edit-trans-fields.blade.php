<div class='form-group{{ $errors->has("TITLE") ? ' has-error' : '' }}'>
    {!! Form::label("TITLE", trans('menu::menu.form.title')) !!}
    <?php $old = $menu->TITLE;?>
    {!! Form::text("TITLE", old("TITLE", $old), ['class' => 'form-control', 'placeholder' => trans('menu::menu.form.title')]) !!}
    {!! $errors->first("TITLE", '<span class="help-block">:message</span>') !!}
</div>
<div class="checkbox">
    <?php $old =  $menu->STATUS ?>
    <label for="STATUS">
        <input id="STATUS"
                name="STATUS"
                type="checkbox"
                class="flat-blue"
                {{ ((bool) $old) ? 'checked' : '' }}
                value="1" />
        {{ trans('menu::menu.form.status') }}
    </label>
</div>
