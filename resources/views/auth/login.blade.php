@extends('layouts.main')

@section('content')
<div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper auth-page">
          <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
            <div class="row w-100">
              <div class="col-lg-4 mx-auto">
                <div class="auto-form-wrapper">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                      <label class="label">Email</label>
                      
                        <input type="text" name="email" placeholder="email" class="form-control @error('email') is-invalid @enderror">
                        
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        
                      </div>
                    <div class="form-group">
                      <label class="label">Password</label>
                      
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="*********">
                        @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                      
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary submit-btn btn-block">Login</button>
                    </div>
                  </form>
                </div>
                
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
      </div>
    
@endsection
