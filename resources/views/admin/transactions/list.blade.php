@extends('layouts.formcontrols')

@section('content-controls')
<form method="GET" action="{{route('transactions.index')}}">
    <input type="hidden" name="page" value="{{$pageno}}">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group row">
              <input placeholder="Name" type="text" autocomplete="off" name="q" value="{{$query}}">
            </div>
        </div>
    </div>
  <div class="row">
      

      <div class="col-md-3">
  
          <div class="form-group row">
            
              <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm text-right">Sort</label>
              <div class="col-sm-5">
                  <select name="orderBy" class="form-control form-control-sm">
                      <option value=""></option>
                    <option value="1" {{$orderBy == "date" ? "selected" : ""}}>Date</option>
                    <option value="2" {{$orderBy == "id" ? "selected" : ""}}>ID</option>
                  </select>
              </div>
              <div class="col-sm-4">
                  <select name="orderType" class="form-control form-control-sm">
                      <option value=""></option>
                    <option value="1" {{$orderType == "asc" ? "selected" : ""}}>Asc</option>
                    <option value="2" {{$orderType == "desc" ? "selected" : ""}}>Des</option>
                  </select>
              </div>
          </div>
  
      </div>
      <div class="col-md-4">
  
          <div class="form-group row">
              <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm text-right">Date Range</label>
              <div class="col-sm-8">
              <input value="{{$dates}}" type="text" name="dates" class="form-control form-control-sm" id="dates">
              </div>
          </div>
        
      </div>
      <div class="col-md-3">
  
          <div class="form-group row">
              <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm text-right">Type</label>
              <div class="col-sm-9">
                <select name="type" class="form-control form-control-sm">
                  <option value=""></option>
                  <option value="1" {{$type == 1 ? "selected" : ""}}>Income</option>
                  <option value="2" {{$type == 2 ? "selected" : ""}}>Expense</option>
                  <option value="3" {{$type == 3 ? "selected" : ""}}>Assets</option>
                  <option value="4" {{$type == 4 ? "selected" : ""}}>Expense + Assets</option>
                  
                </select>
              </div>
          </div>
  
      </div>
      <div class="col-md-2">
        <input type="submit" class="btn btn-primary" value="Search">
      </div>
  </div>
  </form>
  
  
@endsection

@section('content-data')
<div class="d-flex flex-column flex-lg-row">
  <div class="wrapper pr-5">
      <h5 class="mb-0">Income</h5>
      <small class="income">{{number_format($inAmount,0)}}</small>
  </div>
  <div class="wrapper pr-5">
      <h5 class="mb-0">Expense</h5>
      <small class="expend">{{number_format($outAmount,0)}}</small>
  </div>
  <div class="wrapper pr-5">
      <h5 class="mb-0">Real Amount</h5>
      <small>{{number_format($diffAmount,0)}}</small>
  </div>
</div>
<table class="table">
        <thead>
          <tr>
            <th>ID</th>
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
                
                <td>{{$transaction->id}}</td>
                 <td>{{$transaction->name}}</td>
                 <td><span class="{{($transaction->type == 1) ? 'income' : 'expend' }}">
                  {{number_format($transaction->amount,0)}}
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

@section('header')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('script')
<script>
  $(document).ready(function() {
    $('input[name="dates"]').daterangepicker({
      autoUpdateInput: false,
      locale: {
          cancelLabel: 'Clear'
      }
    });

    $('input[name="dates"]').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
  });

  $('input[name="dates"]').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });


  });
</script>
@endsection
