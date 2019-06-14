@extends('layouts.admin')
@section('body')
<h4 class="card-title">{{$title}}</h4>
<div class="row">
        <div class="col-lg-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        @yield('content-controls')
                    </div>
                </div>
            </div>
        </div>
        </div>
</div>

<div class="row">
    <div class="col-lg-12 grid-margin">
        

        <div class="card">
            <div class="card-body">
                
                <div class="row">
                    <div class="col-lg-12 grid-margin">
                        @yield('content-data')
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection