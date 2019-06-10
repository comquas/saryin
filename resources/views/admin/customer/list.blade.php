@extends('layouts.form')

@section('content-data')
<table class="table">
        <thead>
          <tr>
            <th>id</th>
            <th>Name</th>
            <th>Company</th>
            <th>Email</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $no = ($pageno - 1) * 50;
            $no = $no + 1;
          ?>
         @foreach ($customers as $customer)
             <tr>
                <td>{{$no++}}</td>
                 <td>{{$customer->name}}</td>
                 <td>{{$customer->company}}</td>
                 <td>{{$customer->email}}</td>
                 <td><a href="{{route('customers.edit',['id'=>$customer->id])}}" class="btn btn-info"><i class="mdi mdi-pencil"></i> </a> &nbsp; 
                  <form action="{{route('customers.destroy',['id'=>$customer->id])}}" method="POST">
                    @csrf
                    @method('DELETE')
                        <button class="btn btn-danger" type="submit"><i class="mdi mdi-delete"></i></button>
                  </form>
                </a></td>
             </tr>
         @endforeach
        </tbody>
      </table>

      {{ $customers->links() }}
@endsection

