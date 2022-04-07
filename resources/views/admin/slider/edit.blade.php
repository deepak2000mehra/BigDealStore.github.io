<div class="modal-header">
    <h5 class="modal-title" id="modalCenterTitle">Edit Slider</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form id="editSliderFrom" action="POST" enctype="multipart/form-data">
    @method('put')
<div class="modal-body">
    <div class="row">
        <div class="mb-3">
            <label for="image" class="form-label">Slider Images</label>
            <input name="file[]" class="form-control" type="file" multiple/>
            <div><strong style="color: red;">Note:-You can only 2 image at a time</strong></div>
            <span class="text-danger error-text file_error"></span>
        </div>
    </div>
    <div class="row">
        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select name="type"id="type" class="form-control">
                <option value="">Select Type</option>
                <option value="slider banner" @php $slider->type == 'slider banner' ? 'selected':''  @endphp>Slider Banner</option>
                <option value="collection banner" @php $slider->type == 'collection banner' ? 'selected':''  @endphp>Collection Banner</option>
                <option value="discount banner" @php $slider->type == 'discount banner' ? 'selected':''  @endphp>Discount Banner</option>
                <option value="deal banner" @php $slider->type == 'deal banner' ? 'selected':''  @endphp>Deal Banner</option>
                <option value="media banner" @php $slider->type == 'media banner' ? 'selected':''  @endphp>Media Banner</option>
            </select>
            <span class="text-danger error-text type_error"></span>
        </div>
    </div>
    <div class="row g-2">
        <div class="col mb-0">
          <label for="width" class="form-label">Width</label>
          <input type="text" id="width" class="form-control" placeholder="100">
            <span class="text-danger error-text width_error"></span>
        </div>
        <div class="col mb-0">
          <label for="height" class="form-label">Height</label>
          <input type="text" id="height" class="form-control" placeholder="100">
            <span class="text-danger error-text height_error"></span>
        </div>
    </div>
    <div class="row">
        <div class="mb-3">
            <textarea name="description" id="description" cols="30" rows="10">{{ $slider->description }}</textarea>
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
    $('#editSliderFrom').on('submit',function(e){
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:"{{ route('admin.slider.update',$slider->id) }}",
            method:"POST",
            data: new FormData(this),
            contentType:false,
            cache:false,
            processData:false,
            dataType: "json",
            beforeSend: function(){
                $('#submit').html(<div class="spinner-grow text-info" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>);
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
            error:function(data){
                console.log(data);
            }
        });
    });
</script>
