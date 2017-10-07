<div class='form-group{{ $errors->has("TITLE") ? ' has-error' : '' }}'>
    {!! Form::label("TITLE", trans('menu::menu.form.title')) !!}
    <?php $old = $menuItem->TITLE; ?>
    {!! Form::text("TITLE", old("TITLE", $old), ['class' => 'form-control', 'placeholder' => trans('menu::menu.form.title')]) !!}
    {!! $errors->first("TITLE", '<span class="help-block">:message</span>') !!}
</div>
<div class="form-group link-type-depended link-internal">
    {!! Form::label("URI", trans('menu::menu.form.uri')) !!}
    <div class='input-group{{ $errors->has("URI") ? ' has-error' : '' }}'>
        <span class="input-group-addon">/-/</span>
        <?php $old = $menuItem->URI; ?>
        {!! Form::text("URI", old("URI", $old), ['class' => 'form-control', 'placeholder' => trans('menu::menu.form.uri')]) !!}
        {!! $errors->first("URI", '<span class="help-block">:message</span>') !!}
    </div>
</div>
<div class="form-group{{ $errors->has("URL") ? ' has-error' : '' }} link-type-depended link-external">
    {!! Form::label("URL", trans('menu::menu.form.url')) !!}
    <?php $old = $menuItem->URL; ?>
    {!! Form::text("URL", old("URL", $old), ['class' => 'form-control', 'placeholder' => trans('menu::menu.form.url')]) !!}
    {!! $errors->first("URL", '<span class="help-block">:message</span>') !!}
</div>
<div class="checkbox">
    <?php $old = $menuItem->STATUS; ?>
    <label for="STATUS">
        <input id="STATUS"
                name="STATUS"
                type="checkbox"
                class="flat-blue"
                {{ (bool) $old ? 'checked' : '' }}
                value="1" />
        {{ trans('menu::menu.form.status') }}
    </label>
</div>
