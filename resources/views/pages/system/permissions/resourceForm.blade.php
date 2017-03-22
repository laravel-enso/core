<div class="col-sm-6">
    <div class="form-group{{ $errors->has('prefix') ? ' has-error' : '' }}">
        {!! Form::label('prefix', __("Resource Prefix")) !!}
        <small class="text-danger" style="float:right;">
            {{ $errors->first('prefix') }}
        </small>
        {!! Form::text('prefix', null, ['class' => 'form-control', 'placeholder' => __("Completeaza")]) !!}
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
<div class="col-sm-3">
    <div class="form-group{{ $errors->has('hasDataTables') ? ' has-error' : '' }}">
        {!! Form::label('hasDataTables', __("Data Tables")) !!}
        <small class="text-danger" style="float:right;">
            {{ $errors->first('hasDataTables') }}
        </small>
        <input type="checkbox" name="hasDataTables">
    </div>
</div>
<div class="col-sm-3">
    <div class="form-group{{ $errors->has('hasVueSelect') ? ' has-error' : '' }}">
        {!! Form::label('hasVueSelect', __("Vue Select")) !!}
        <small class="text-danger" style="float:right;">
            {{ $errors->first('hasVueSelect') }}
        </small>
        <input type="checkbox" name="hasVueSelect">
    </div>
</div>