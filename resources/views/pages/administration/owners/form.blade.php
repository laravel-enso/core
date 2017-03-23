<div class="col-sm-6">
    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        {!! Form::label('name', __("Name")) !!}
        <small class="text-danger" style="float:right;">
            {{ $errors->first('name') }}
        </small>
        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __("Please Fill")]) !!}
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group{{ $errors->has('fiscal_code') ? ' has-error' : '' }}">
        {!! Form::label('fiscal_code', __("IFSC")) !!}
        <small class="text-danger" style="float:right;">
            {{ $errors->first('fiscal_code') }}
        </small>
        {!! Form::text('fiscal_code', null, ['class' => 'form-control', 'placeholder' => __("Please Fill")]) !!}
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group{{ $errors->has('reg_com_nr') ? ' has-error' : '' }}">
        {!! Form::label('reg_com_nr', __("Registry Of Commerce")) !!}
        <small class="text-danger" style="float:right;">
            {{ $errors->first('reg_com_nr') }}
        </small>
        {!! Form::text('reg_com_nr', null, ['class' => 'form-control', 'placeholder' => __("Please Fill")]) !!}
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
        {!! Form::label('city', __("City")) !!}
        <small class="text-danger" style="float:right;">
            {{ $errors->first('city') }}
        </small>
        {!! Form::text('city', null, ['class' => 'form-control', 'placeholder' => __("Please Fill")]) !!}
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group{{ $errors->has('county') ? ' has-error' : '' }}">
        {!! Form::label('county', __("County")) !!}
        <small class="text-danger" style="float:right;">
            {{ $errors->first('county') }}
        </small>
        {!! Form::text('county', null, ['class' => 'form-control', 'placeholder' => __("Please Fill")]) !!}
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
        {!! Form::label('address', __("Address")) !!}
        <small class="text-danger" style="float:right;">
            {{ $errors->first('address') }}
        </small>
        {!! Form::text('address', null, ['class' => 'form-control', 'placeholder' => __("Please Fill")]) !!}
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group{{ $errors->has('postal_code') ? ' has-error' : '' }}">
        {!! Form::label('postal_code', __("Postal Code")) !!}
        <small class="text-danger" style="float:right;">
            {{ $errors->first('postal_code') }}
        </small>
        {!! Form::text('postal_code', null, ['class' => 'form-control', 'placeholder' => __("Please Fill")]) !!}
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group{{ $errors->has('bank') ? ' has-error' : '' }}">
        {!! Form::label('bank', __("Bank")) !!}
        <small class="text-danger" style="float:right;">
            {{ $errors->first('bank') }}
        </small>
        {!! Form::text('bank', null, ['class' => 'form-control', 'placeholder' => __("Please Fill")]) !!}
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group{{ $errors->has('bank_account') ? ' has-error' : '' }}">
        {!! Form::label('bank_account', __("Bank Account")) !!}
        <small class="text-danger" style="float:right;">
            {{ $errors->first('bank_account') }}
        </small>
        {!! Form::text('bank_account', null, ['class' => 'form-control', 'placeholder' => __("Please Fill")]) !!}
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group{{ $errors->has('contact') ? ' has-error' : '' }}">
        {!! Form::label('contact', __("Contact")) !!}
        <small class="text-danger" style="float:right;">
            {{ $errors->first('contact') }}
        </small>
        {!! Form::text('contact', null, ['class' => 'form-control', 'placeholder' => __("Please Fill")]) !!}
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
        {!! Form::label('phone', __("Phone")) !!}
        <small class="text-danger" style="float:right;">
            {{ $errors->first('phone') }}
        </small>
        {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => __("Please Fill")]) !!}
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
        {!! Form::label('email', __("Email")) !!}
        <small class="text-danger" style="float:right;">
            {{ $errors->first('email') }}
        </small>
        {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => __("Please Fill")]) !!}
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group{{ $errors->has('is_individual') ? ' has-error' : '' }}">
        {!! Form::label('is_individual', __("Individual")) !!}
        <small class="text-danger" style="float:right;">
            {{ $errors->first('is_individual') }}
        </small>
        {!! Form::select('is_individual', $types, null, ['class' => 'form-control select']) !!}
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group{{ $errors->has('is_active') ? ' has-error' : '' }}">
        {!! Form::label('is_active', __("Active")) !!}
        <small class="text-danger" style="float:right;">
            {{ $errors->first('is_active') }}
        </small>
        {!! Form::select('is_active', $statuses, null, ['class' => 'form-control select']) !!}
    </div>
</div>