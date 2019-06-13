@extends('layouts.form')

@section('content-data')
<table class="table">
        <thead>
          <tr>
            <th>id</th>
            <th>Name</th>
            <th>Amount</th>
            <th>Currency</th>
            <th>Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $no = ($pageno - 1) * 50;
            $no = $no + 1;
          ?>
         @foreach ($transactions as $transaction)
             <tr>
                <td>{{$no++}}</td>
                 <td>{{$transaction->name}}</td>
                 <td><span class="{{($transaction->type == 1) ? 'income' : 'expend' }}">
                  {{number_format($transaction->amount,2)}}
                </span></td>
                 <td>{{$transaction->currency}}</td>
                 <td>{{$transaction->date}}</td>
                 <td> 
                  <form class="form-inline" action="{{route('transactions.destroy',['id'=>$transaction->id])}}" method="POST">

                    <a href="{{route('transactions.edit',['id'=>$transaction->id])}}" class="btn btn-info"><i class="mdi mdi-pencil"></i> </a> &nbsp;
                    
                    @csrf
                    @method('DELETE')
                        <button class="btn btn-danger" type="submit"><i class="mdi mdi-delete"></i></button>
                  </form>
                </a></td>
             </tr>
         @endforeach
        </tbody>
      </table>

      {{ $transactions->links() }}
@endsection

