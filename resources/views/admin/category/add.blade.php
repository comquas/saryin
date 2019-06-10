@extends('layouts.form') 
@section('content-data')
<form method="post" action="{{$edit ? route('categories.update',['id'=>$category->id] ) : route('categories.store')}}">
        @csrf
        @if ($edit)
            @method('PUT')
        @endif

        
@component('controls.textbox')
    @slot('label','Name')
    @slot('name','name')
    @slot('edit',$edit)
    @if ($edit)
        @slot('value',$category->name)
    @else
    @slot('value','')
    @endif
@endcomponent



        @foreach ($errors->all() as $error)
        <div>{{ $error }}</div>
        @endforeach

        <div class="form-group">
            <label for="exampleInputEmail1">Type {{$edit && $category->type == 2}}</label>
            {{-- <input type="text" id="icon" name="icon" placeholder="Enter Icon Name" class="form-control @error('icon') is-invalid @enderror">                                 --}}
            <select class="form-control @error('type') is-invalid @enderror" id="type" name="type">
                <option value=1 {{$edit && $category->type == 1 ? 'selected' : ''}}>Income</option>
                <option value=2 {{$edit && $category->type == 2 ? 'selected' : ''}}>Expenses</option>
                <option value=3 {{$edit && $category->type == 3 ? 'selected' : ''}}>Assets</option>
            </select>
            @error('type')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span> 
            @enderror
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
        </div>
</form>
@endsection


