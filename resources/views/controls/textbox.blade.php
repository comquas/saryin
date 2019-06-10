<div class="form-group">
    <label for="exampleInputEmail1">{{$label}}</label>
    <input type="text" id="{{$name}}" name="{{$name}}" placeholder="Enter {{$label}}" class="form-control @error($name) is-invalid @enderror"
    value= "{{isset($value) ? $value : ''}}"
    >                                
    @error($name)
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span> 
    @enderror
</div>