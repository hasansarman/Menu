@extends('layouts.master')

@section('content-header')
<h1>
    {{ trans('menu::menu.titles.create menu item') }}
</h1>
<ol class="breadcrumb">
    <li><a href="{{ URL::route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
    <li><a href="{{ URL::route('admin.menu.menu.index') }}">{{ trans('menu::menu.breadcrumb.menu') }}</a></li>
    <li>{{ trans('menu::menu.breadcrumb.create menu item') }}</li>
</ol>
@stop

@section('content')
{!! Form::open(['route' => ['dashboard.menuitem.store', $menu->ID], 'method' => 'post']) !!}
<div class="row">
    <div class="col-md-9">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">{{ trans('core::core.title.translatable fields') }}</h3>
            </div>
            <div class="box-body">
                <div class="nav-tabs-custom">

                    <div class="tab-content">
                               @include('menu::admin.menuitems.partials.create-trans-fields', ['lang' => ''])

                    </div>
                </div>
            </div>
        </div>
        <div class="box box-primary">

            <div class="box-body">
                @include('menu::admin.menuitems.partials.create-fields')
            </div>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.create') }}</button>
            <a class="btn btn-danger pull-right btn-flat" href="{{ URL::route('admin.menu.menu.edit', [$menu->ID])}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">{{ trans('menu::menu-items.link-type.link type') }}</h3>
            </div>
            <div class="box-body">
                <div class="radio">
                    <input type="radio" id="link-page" name="LINK_TYPE" value="page" checked><label for="link-page">{{ trans('menu::menu-items.link-type.page') }}</label>
                </div>
                <div class="radio">
                    <input type="radio" id="link-internal" name="LINK_TYPE" value="internal"><label for="link-internal">{{ trans('menu::menu-items.link-type.internal') }}</label>
                </div>
                <div class="radio">
                    <input type="radio" id="link-external" name="LINK_TYPE" value="external"><label for="link-external">{{ trans('menu::menu-items.link-type.external') }}</label>
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('core::core.back to index', ['name' => 'menu']) }}</dd>
    </dl>
@stop

@push('js-stack')
<script>
$( document ).ready(function() {
    $(document).keypressAction({
        actions: [
            { key: 'b', route: "<?= route('admin.menu.menu.edit', [$menu->id]) ?>" }
        ]
    });
    $('.link-type-depended').hide();
    $('.link-page').fadeIn();
    $('[name="link_type"]').iCheck({
        checkboxClass: 'icheckbox_minimal',
        radioClass: 'iradio_flat-blue'
    }).on('ifChecked',function(){
        $('.link-type-depended').hide();
        $('.link-'+$(this).val()).fadeIn();
    });
    $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });
});
</script>
@endpush
