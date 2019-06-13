@extends('layouts.form')

@section('content-data')
<?php
$catType = [
  1 => "Income",
  2 => "Expenses",
  3 => "Assets"
]
?>
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
                  <form class="form-inline"  action="{{route('categories.destroy',['id'=>$category->id])}}" method="POST">
                    <a href="{{route('categories.edit',['id'=>$category->id])}}" class="btn btn-info"><i class="mdi mdi-pencil"></i> </a> &nbsp; 
                    @csrf
                    @method('DELETE')
                        <button class="btn btn-danger" type="submit"><i class="mdi mdi-delete"></i></button>
                  </form>
                </a></td>
             </tr>
         @endforeach
        </tbody>
      </table>

      {{ $categories->links() }}
@endsection
