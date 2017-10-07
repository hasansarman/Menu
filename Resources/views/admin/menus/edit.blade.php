@extends('layouts.master')

@section('content-header')
<h1>
    {{ trans('menu::menu.titles.edit menu') }}
</h1>
<ol class="breadcrumb">
    <li><a href="{{ URL::route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
    <li><a href="{{ URL::route('admin.menu.menu.index') }}">{{ trans('menu::menu.breadcrumb.menu') }}</a></li>
    <li>{{ trans('menu::menu.breadcrumb.edit menu') }}</li>
</ol>
@stop

@push('css-stack')
    <link href="{!! Module::asset('menu:css/nestable.css') !!}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
{!! Form::open(['route' => ['admin.menu.menu.update', $menu->ID], 'method' => 'put']) !!}
<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                <a href="{{ URL::route('dashboard.menuitem.create', [$menu->ID]) }}" class="btn btn-primary btn-flat">
                    <i class="fa fa-pencil"></i> {{ trans('menu::menu.button.create menu item') }}
                </a>
            </div>
        </div>
        <div class="box box-primary" style="overflow: hidden;">
            <div class="box-body">
                {!! $menuStructure !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-primary">

            <div class="box-body">
                <div class="nav-tabs-custom">

                    <div class="tab-content">
                                 @include('menu::admin.menus.partials.edit-trans-fields', ['lang' => ''])

                    </div>
                </div>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">{{ trans('core::core.title.non translatable fields') }}</h3>
            </div>
            <div class="box-body">
                @include('menu::admin.menus.partials.edit-fields')
            </div>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.update') }}</button>
            <a class="btn btn-danger pull-right btn-flat" href="{{ URL::route('admin.menu.menu.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
        </div>
    </div>
</div>
{!! Form::close() !!}
<script>
$( document ).ready(function() {
    $(document).keypressAction({
        actions: [
            { key: 'c', route: "<?= route('dashboard.menuitem.create', [$menu->ID]) ?>" },
            { key: 'b', route: "<?= route('admin.menu.menu.index') ?>" }
        ]
    });

    $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });

    $('input[type="checkbox"]').on('ifChecked', function(){
      $(this).parent().find('input[type=hidden]').remove();
    });

    $('input[type="checkbox"]').on('ifUnchecked', function(){
      var name = $(this).attr('name'),
          input = '<input type="hidden" name="' + name + '" value="0" />';
      $(this).parent().append(input);
    });
});
</script>
<script src="{!! Module::asset('menu:js/jquery.nestable.js') !!}"></script>
<script>
    $(function(){
        $.ajaxSetup({
            headers:{'X-CSRF-Token': '{{ csrf_token() }}'}
        });
    });
</script>
<script>
function replaceAll(str, find, replace) {
    return str.replace(new RegExp(find, 'g'), replace);
}
$( document ).ready(function() {
    $('.dd').nestable();
    $('.dd').on('change', function() {
        var data = $('.dd').nestable('serialize');

var str=JSON.stringify(data);
//str=replaceAll(str,'"id"','"ID"');
alert(str);
        $.ajax({

            type: 'POST',
            url: '{{ route('api.menuitem.update') }}',
            data: {
              'menu': str, '_token': '<?php echo csrf_token(); ?>'},

            dataType: 'json',
            success: function(data) {

            },
            error:function (xhr, ajaxOptions, thrownError){
            }
        });
    });
});
</script>
<script>
    $( document ).ready(function() {
        $('.jsDeleteMenuItem').on('click', function(e) {
            var self = $(this),
                menuItemId = self.data('item-id');
            $.ajax({
                type: 'POST',
                url: '{{ route('api.menuitem.delete') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    menuitem: menuItemId
                },
                success: function(data) {
                    if (! data.errors) {
                        var elem = self.closest('li');
                        elem.fadeOut()
                        setTimeout(function(){
                            elem.remove()
                        }, 300);
                    }
                }
            });
        });
    });
</script>
<style>
.dd {
  position: relative;
  display: block;
  margin: 0;
  padding: 0;
  list-style: none;
  font-size: 13px;
  line-height: 29px;
}
.dd-list {
  display: block;
  position: relative;
  margin: 0;
  padding: 0;
  list-style: none;
}
.dd-list .dd-list {
  padding-left: 30px;
}
.dd-collapsed .dd-list {
  display: none;
}
.dd-item,
.dd-item-root,
.dd-empty,
.dd-placeholder {
  display: block;
  position: relative;
  margin: 0;
  padding: 0;
  min-height: 20px;
  font-size: 13px;
  line-height: 20px;
}
.dd-handle-root,
.dd-handle {
  display: block;
  margin: 5px 0;
  padding: 4px 10px;
  color: #333;
  text-decoration: none;
  font-weight: bold;
  border: 1px solid #ccc;
  background: #fafafa;
  -webkit-border-radius: 3px;
  border-radius: 3px;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
}
.dd-handle:hover {
  color: #2ea8e5;
  background: #fff;
  cursor: move;
}
.dd-item-root > .btn {
  display: none;
}
.dd-item-root > button,
.dd-item > button {
  display: block;
  position: relative;
  cursor: pointer;
  float: right;
  width: 25px;
  height: 20px;
  margin: 5px 0;
  padding: 0;
  text-indent: 100%;
  white-space: nowrap;
  overflow: hidden;
  border: 0;
  background: transparent;
  font-size: 12px;
  line-height: 1;
  text-align: center;
  font-weight: bold;
}
.dd-item-root > button:before,
.dd-item > button:before {
  content: '+';
  display: block;
  position: absolute;
  width: 100%;
  text-align: center;
  text-indent: 0;
  font-size: 20px;
  line-height: 9px;
}
.dd-item-root > button[data-action="collapse"]:before,
.dd-item > button[data-action="collapse"]:before {
  content: '-';
  font-size: 20px;
  line-height: 9px;
}
.dd-placeholder,
.dd-empty {
  margin: 5px 0;
  padding: 0;
  min-height: 30px;
  background: #f2fbff;
  border: 1px dashed #b6bcbf;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
}
.dd-empty {
  border: 1px dashed #bbb;
  min-height: 100px;
  background-color: #e5e5e5;
  background-image: -webkit-linear-gradient(45deg, #ffffff 25%, transparent 25%, transparent 75%, #ffffff 75%, #ffffff), -webkit-linear-gradient(45deg, #ffffff 25%, transparent 25%, transparent 75%, #ffffff 75%, #ffffff);
  background-image: -moz-linear-gradient(45deg, #ffffff 25%, transparent 25%, transparent 75%, #ffffff 75%, #ffffff), -moz-linear-gradient(45deg, #ffffff 25%, transparent 25%, transparent 75%, #ffffff 75%, #ffffff);
  background-image: linear-gradient(45deg, #ffffff 25%, transparent 25%, transparent 75%, #ffffff 75%, #ffffff), linear-gradient(45deg, #ffffff 25%, transparent 25%, transparent 75%, #ffffff 75%, #ffffff);
  background-size: 60px 60px;
  background-position: 0 0, 30px 30px;
}
.dd-dragel {
  position: absolute;
  pointer-events: none;
  z-index: 9999;
}
.dd-dragel > .dd-item .dd-handle {
  margin-top: 0;
}
.dd-dragel .dd-handle {
  -webkit-box-shadow: 2px 4px 6px 0 rgba(0, 0, 0, 0.1);
  box-shadow: 2px 4px 6px 0 rgba(0, 0, 0, 0.1);
}
/**
 * Nestable Extras
 */
.nestable-lists {
  display: block;
  clear: both;
  padding: 30px 0;
  width: 100%;
  border: 0;
  border-top: 2px solid #ddd;
  border-bottom: 2px solid #ddd;
}
#nestable-menu {
  padding: 0;
  margin: 20px 0;
}
#nestable-output,
#nestable2-output {
  width: 100%;
  height: 7em;
  font-size: 0.75em;
  line-height: 1.333333em;
  font-family: Consolas, monospace;
  padding: 5px;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
}
#nestable2 .dd-handle {
  color: #fff;
  border: 1px solid #999;
  background: #bbb;
  background: -webkit-linear-gradient(top, #bbbbbb 0%, #999999 100%);
  background: -moz-linear-gradient(top, #bbbbbb 0%, #999999 100%);
  background: linear-gradient(top, #bbbbbb 0%, #999999 100%);
}
#nestable2 .dd-handle:hover {
  background: #bbb;
}
#nestable2 .dd-item > button:before {
  color: #fff;
}
@media only screen and (min-width: 700px) {
  .dd {
    float: left;
    width: 100%;
  }
  .dd + .dd {
    margin-left: 2%;
  }
}
.dd-hover > .dd-handle {
  background: #2ea8e5 !important;
}

</style>
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('menu::menu.titles.create menu item') }}</dd>
        <dt><code>b</code></dt>
        <dd>{{ trans('menu::menu.navigation.back to index') }}</dd>
    </dl>
@stop

@push('js-stack')

@endpush
