<div class="form-group">
    <label for="date">{{$label}}</label>
    <input type="text" id="{{$name}}" name="{{$name}}" placeholder="Enter {{$label}}" class="form-control @error($name) is-invalid @enderror"
    value= "{{isset($value) ? $value : ''}}"
    >                                
    @error($name)
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span> 
    @enderror
</div>

<script>
    $(document).ready(function() {
        $('#{{$name}}').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'dd/mm/yyyy',
            value : "{{isset($value) ? $value : ''}}"
        });
    })
</script>