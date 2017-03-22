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
