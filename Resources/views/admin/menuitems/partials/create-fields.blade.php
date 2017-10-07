<div class="form-group{{ $errors->has("ICON") ? ' has-error' : '' }}">
    {!! Form::label("ICON", trans('menu::menu-items.form.icon')) !!}
    {!! Form::text("ICON", old("ICON"), ['class' => 'form-control', 'placeholder' => trans('menu::menu-items.form.icon')]) !!}
    {!! $errors->first("ICON", '<span class="help-block">:message</span>') !!}
</div>
<div class="form-group{{ $errors->has('CLASS') ? ' has-error' : '' }}">
    {!! Form::label('CLASS', trans('menu::menu-items.form.class')) !!}
    {!! Form::text('CLASS', old('CLASS'), ['class' => 'form-control']) !!}
    {!! $errors->first('CLASS', '<span class="help-block">:message</span>') !!}
</div>
<div class="form-group link-type-depended link-page">
    <label for="PAGE">{{ trans('menu::menu-items.form.page') }}</label>
    <select class="form-control" name="PAGE_ID" id="PAGE">
        <option value=""></option>
        <?php foreach ($pages as $page): ?>
        <option value="{{ $page->ID }}">{{ $page->TITLE }}</option>
        <?php endforeach; ?>
    </select>
</div>
<div class="form-group">
    <label for="PARENT_ID">{{ trans('menu::menu-items.form.parent menu item') }}</label>
    <select class="form-control" name="PARENT_ID" id="PARENT_ID">
        <option value=""></option>
        <?php foreach ($menuSelect as $parentMenuItemId => $parentMenuItemName): ?>
        <option value="{{ $parentMenuItemId }}">{{ $parentMenuItemName }}</option>
        <?php endforeach; ?>
    </select>
</div>

<div class="form-group">
    <label for="TARGET">{{ trans('menu::menu-items.form.target') }}</label>
    <select class="form-control" name="TARGET" id="TARGET">
        <option value="_self">{{ trans('menu::menu-items.form.same tab') }}</option>
        <option value="_blank">{{ trans('menu::menu-items.form.new tab') }}</option>
    </select>
</div>
