<div class="form-group">
    <label for="exampleInputEmail1">{{$label}}</label>
    @if ($value != "")
        @if(strtolower(substr($value,-4)) == ".jpg" || strtolower(substr($value,-5)) == ".jpeg" || strtolower(substr($value,-4)) == ".png")
            <figure>
                <a target="_blank" href="{{$value}}">
                    <img src="{{$value}}" class="thumb-img">
                </a>
            </figure>
        @endif

        <p>Download file at <a target="_blank" href="{{$value}}">{{$value}}</p>    
    @endif
    
    <input type="file" id="{{$name}}" name="{{$name}}" placeholder="Select file for {{$label}}" class="form-control @error($name) is-invalid @enderror">                                
    @error($name)
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span> 
    @enderror
</div>