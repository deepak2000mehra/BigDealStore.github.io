<div class="modal-header">
    <h5 class="modal-title" id="modalCenterTitle">Add Category</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form id="categoryFrom" action="POST" enctype="multipart/form-data">
<div class="modal-body">
    <div class="row">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input name="name" class="form-control" type="name" placeholder="Name">
            <span class="text-danger error-text name_error"></span>
        </div>
    </div>
    <div class="row">
        <div class="mb-3">
            <label for="file" class="form-label">Images</label>
            <input name="file" class="form-control" type="file">
            <span class="text-danger error-text file_error"></span>
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
    $('#categoryFrom').on('submit',function(e){
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:"{{ route('admin.category.store') }}",
            method:"POST",
            data: new FormData(this),
            contentType:false,
            cache:false,
            processData:false,
            dataType: "json",
            success:function(data){
                if(data.code == 403){
                    $.each(data.message, function(prefix, val){
                        $('span.'+prefix+'_error').text(val[0]);
                    });
                }else{
                    $('#lgModal').modal('hide');
                    swal("Good job!", data.message, "success");
                    $("#category").load(location.href + " #category");
                }
            }
        });
    });
</script>
