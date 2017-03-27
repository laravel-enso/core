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
    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
        {!! Form::label('description', __("Description")) !!}
        <small class="text-danger" style="float:right;">
            {{ $errors->first('description') }}
        </small>
        {!! Form::text('description', null, ['class' => 'form-control', 'placeholder' => __("Fill")]) !!}
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
        {!! Form::label('type', __("Type")) !!}
        <small class="text-danger" style="float:right;">
            {{ $errors->first('type') }}
        </small>
        {!! Form::select('type', $permissionTypes, null, ['class' => 'form-control select']) !!}
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group{{ $errors->has('permissions_group_id') ? ' has-error' : '' }}">
        {!! Form::label('permissions_group_id', __("Permissions Group")) !!}
        <small class="text-danger" style="float:right;">
            {{ $errors->first('permissions_group_id') }}
        </small>
        {!! Form::select('permissions_group_id', $permissionsGroups, null, ['class' => 'form-control select']) !!}
    </div>
</div>