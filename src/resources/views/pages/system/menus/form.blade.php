<div class="col-sm-6">
    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        {!! Form::label('name', __("Name")) !!}
        <small class="text-danger" style="float:right;">
            {{ $errors->first('name') }}
        </small>
        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __("Completeaza")]) !!}
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group{{ $errors->has('order') ? ' has-error' : '' }}">
        {!! Form::label('order', __("Order")) !!}
        <small class="text-danger" style="float:right;">
            {{ $errors->first('order') }}
        </small>
        {!! Form::text('order', null, ['class' => 'form-control', 'readonly' => 'readonly', 'placeholder' => __("Fill")]) !!}
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group{{ $errors->has('icon') ? ' has-error' : '' }}">
        {!! Form::label('icon', __("Icon Class")) !!}
        <small class="text-danger" style="float:right;">
            {{ $errors->first('icon') }}
        </small>
        {!! Form::text('icon', null, ['class' => 'form-control', 'placeholder' => __("Completeaza")]) !!}
    </div>
</div>
<div class="col-sm-6">
    <label>{{ __("Icon") }}</label>
    <div class="well well-sm" style="height:34px">
        <i class="{{ isset($menu) ? $menu->icon : '' }}"></i>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group{{ $errors->has('link') ? ' has-error' : '' }}">
        {!! Form::label('link', __("Link")) !!}
        <small class="text-danger" style="float:right;">
            {{ $errors->first('link') }}
        </small>
        {!! Form::text('link', null, ['class' => 'form-control', 'placeholder' => __("Completeaza")]) !!}
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group{{ $errors->has('has_children') ? ' has-error' : '' }}">
        {!! Form::label('has_children', __("Has Children")) !!}
        <small class="text-danger" style="float:right;">
            {{ $errors->first('has_children') }}
        </small>
        {!! Form::select('has_children', $hasChildrenOptions, null, ['class' => 'form-control select']) !!}
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group{{ $errors->has('parent_id') ? ' has-error' : '' }}">
        {!! Form::label('parent_id', __("Parent")) !!}
        <small class="text-danger" style="float:right;">
            {{ $errors->first('parent_id') }}
        </small>
        {!! Form::select('parent_id', $menus, null, ['class' => 'form-control select']) !!}
    </div>
</div>