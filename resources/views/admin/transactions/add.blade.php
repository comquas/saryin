@extends('layouts.form')
@section('script')
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

@endsection
@section('content-data')
<form enctype="multipart/form-data" method="post" action="{{$edit ? route('transactions.update',['id'=>$id] ) : route('transactions.store')}}">
    @csrf
    @if ($edit)
    @method('PUT')
    @endif

    @foreach ($formData as $form)
        @if (isset($form['route']))

        @component('controls.select2')
        @slot('label',$form['label'])
        @slot('name',$form['name'])
        @slot('edit',$edit)
        @slot('value',$form['value'])
        @slot('selectLabel',$form['selectLabel'])
        @slot('route',$form['route'])
        @endcomponent

        @elseif (isset($form['date']))


        @component('controls.date')
        @slot('label',$form['label'])
        @slot('name',$form['name'])
        @slot('edit',$edit)
        @slot('value',$form['value'])
        @endcomponent


        @elseif (isset($form['file']))


        @component('controls.file')
        @slot('label',$form['label'])
        @slot('name',$form['name'])
        @slot('edit',$edit)
        @slot('value',$form['value'])
        @endcomponent


        @else

        @component('controls.textbox')
        @slot('label',$form['label'])
        @slot('name',$form['name'])
        @slot('edit',$edit)
        @slot('value',$form['value'])

        @endcomponent

        @endif
        
    @endforeach

    <div class="form-group">
        <input type="hidden" name="type" value="{{$type}}">
        <input type="submit" class="btn btn-primary" value="Submit">
    </div>
</form>
@endsection