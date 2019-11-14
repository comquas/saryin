@extends('layouts.admin')

@section('body')
<link rel="stylesheet" href="{{asset('vendors/chartjs/Chart.css')}}">
<script src="{{asset('vendors/chartjs/Chart.min.js')}}"></script>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3" id="inlahk">
                            </div>
                            <div class="col-md-3" id="outlahk">
                            </div>
                            <div class="col-md-3" id="profitlahk">
                            </div>
                            <div class="col-md-3" id="assetlahk">
                            </div>
                            
                        </div>
                    </div>
            </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                        <h4 class="card-title mb-0">Yearly Report</h4>
                </div>
                <div class="col-md-3">
                        <select class="form-control" id="dyears" name="dyears">
                                @foreach ($transactionYears as $transaction)
                                    <option value="{{$transaction->year}}">{{$transaction->year}}</option>
                                @endforeach
                            </select>
                </div>
            </div>
            
            <canvas class="mt-5 chartjs-render-monitor" height="500" id="monthbyyear" width="1296"></canvas>           
        </div>
      </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="card-title mb-0">Montly Expend Report</h4>
                    <canvas class="mt-5 chartjs-render-monitor" height="250" id="expendpiechart"></canvas>
                </div>
            <div class="col-md-6"></div>                
            </div>         
        </div>
      </div>
    </div>
</div>


@endsection
@section('script')
<script src="{{asset('js/dashboard.js')}}"></script>
<script src="{{ asset('js/dashboard-pie-chart.js') }}"></script>
@endsection