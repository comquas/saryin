<div class="form-group">
    <label for="category">{{$label}}</label>

    <div class="row">
        <div class="col-md-11 col-sm-12">
            <select class="form-control" name="{{$name}}" id="{{$name}}">
                @if ($edit)
                <option value="{{$value}}">{{$selectLabel}}</option>
                @endif

            </select>
        </div>
        <div class="col-md-1 col-sm-12">
            <button id="{{$name}}_clear"" class=" select-btn btn btn-secondary btn-icons">
                <i class="mdi mdi-close"></i>
            </button>
        </div>
    </div>

    @error($name)
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>



<script>
    $(document).ready(function() {

        $("#{{$name}}_clear").on('click',function() {
            $('#{{$name}}').val(null).trigger('change');
            return false;
        })
        
        $('#{{$name}}').select2({
            multiple: false,
            closeOnSelect: true,
            ajax: {
                url: "{{$route}}",
                processResults: function (data) {
                // Tranforms the top-level key of the response object from 'items' to 'results'
                    var final = {
                        results: data
                    };
                    return final;
                }
            }
        });
    });
</script>