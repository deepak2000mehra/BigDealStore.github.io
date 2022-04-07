<div class="modal-header">
    <h5 class="modal-title" id="modalCenterTitle">Add Slider</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form id="sliderFrom" action="POST" enctype="multipart/form-data">
<div class="modal-body">
    <div class="row">
        <div class="mb-3">
            <label for="image" class="form-label">Images</label>
            <input name="file[]" class="form-control" type="file" multiple/>
            <div><strong style="color: red;">Note:-You can only 2 image at a time</strong></div>
            <span class="text-danger error-text file_error"></span>
        </div>
    </div>
    <div class="row">
        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select name="type" class="form-control">
                <option value="">Select Type</option>
                <option value="slider banner">Slider Banner</option>
                <option value="collection banner">Collection Banner</option>
                <option value="discount banner">Discount Banner</option>
                <option value="deal banner">Deal Banner</option>
                <option value="media banner">Media Banner</option>
            </select>
            <span class="text-danger error-text type_error"></span>
        </div>
    </div>
    <div class="row g-2">
        <div class="col mb-0">
          <label for="width" class="form-label">Width</label>
          <input type="text" name="width" id="width" class="form-control" placeholder="100">
          <span class="text-danger error-text width_error"></span>
        </div>
        <div class="col mb-0">
          <label for="height" class="form-label">Height</label>
          <input type="text" name="height" id="height" class="form-control" placeholder="100">
          <span class="text-danger error-text height_error"></span>
        </div>
    </div>
    <div class="row">
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" cols="30" rows="10"></textarea>
            <span class="text-danger error-text description_error"></span>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary" id="submit">Save</button>
</div>
</form>
<script>
    ClassicEditor
        .create( document.querySelector( '#description' ) )
        .catch( error => {
            console.error( error );
        } );
  </script>
<script>
    $(document).ready(function(){
        $('#loader').hide();
    });
    $('#sliderFrom').on('submit',function(e){
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:"{{ route('admin.slider.store') }}",
            method:"POST",
            data: new FormData(this),
            processData:false,
            dataType: "json",
            contentType:false,
            beforeSend: function(){
                $(document).find('span.error-text').text('');
            },
            success:function(data){
                if(data.code == 403){
                    $.each(data.message, function(prefix, val){
                        $('span.'+prefix+'_error').text(val[0]);
                    });
                }else{
                    $('#lgModal').modal('hide');
                    swal("Good job!", data.message, "success");
                    $("#slider").load(location.href + " #slider");
                }
            },
        });
    });
</script>
