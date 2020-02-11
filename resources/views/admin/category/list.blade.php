@extends('layouts.form')

@section('content-data')
<?php
$catType = [
  1 => "Income",
  2 => "Expenses",
  3 => "Assets"
]
?>

<form method="GET" action="{{route('categories.index')}}">
  <div class="row">
    <div class="col-md-12">
      <div class="form-group row">
        <label for="colFormLabelSm" class="col-sm-1 col-form-label col-form-label-sm text-left">Type</label>
        <div class="col-sm-4">
          <select name="type" class="form-control form-control-sm">
            <option value="0">All</option>
            @foreach ($catType as $key=>$item)
            <option value="{{$key}}" {{$type == $key ? "selected" : ""}}>{{$item}}</option>
            @endforeach
          </select>
        </div>
        <div class="col-sm-4">
          <input class="btn btn-primary" type="submit" value="Submit">
        </div>
        <div class="col-sm-3">
          <a class="btn btn-primary" href="#">
            <span class="mdi mdi-plus" aria-hidden="true">&nbsp;</span>
            Add
          </a>
        </div>
      </div>
    </div>
  </div>
</form>
<div class="row">
  <table class="table">
    <thead>
      <tr>
        <th>id</th>
        <th>Name</th>
        <th>Type</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
            $no = ($pageno - 1) * 50;
            $no = $no + 1;
          ?>
      @foreach ($categories as $category)
      <tr>
        <td>{{$no++}}</td>
        <td>{{$category->name}}</td>
        <td>{{$catType[$category->type]}}</td>
        <td>
          <form class="form-inline" action="{{route('categories.destroy',$category->id)}}" method="POST">

            <a href="{{route('categories.edit', $category->id)}}" class="btn btn-info"><i class="mdi mdi-pencil"></i>
            </a> &nbsp;

            @csrf
            @method('DELETE')
            <button class="btn btn-danger" type="submit"><i class="mdi mdi-delete"></i></button>
          </form>
          </a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
{{ $categories->links() }}

@endsection