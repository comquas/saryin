@extends('layouts.form')
@section('content-data')
<form method="post" action="{{$edit ? route('customers.update',['id'=>$id] ) : route('customers.store')}}">
    @csrf
    @if ($edit)
    @method('PUT')
    @endif

    @foreach ($formData as $form)
        @component('controls.textbox')
        @slot('label',$form['label'])
        @slot('name',$form['name'])
        @slot('edit',$edit)
        @slot('value',$form['value'])
        @endcomponent
    @endforeach

    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Submit">
    </div>
</form>
@endsection