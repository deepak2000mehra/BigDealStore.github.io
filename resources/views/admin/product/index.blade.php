@extends('admin.master')
@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        
        <div class="card">
          <button type="button" class="btn btn-primary" onclick="subCategoryModal()">Add Sub Category</button>
            <h5 class="card-header">Slider</h5>
            <div class="table-responsive text-nowrap">
              <table class="table table-hover" id="category">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    
                </tbody>
              </table>
            </div>
          </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
  function subCategoryModal()
  {
      $.ajax({
          url:"{{ route('admin.subcategory.create') }}",
          method:'GET',
          success:function(res)
          {
              $('#lgModal').modal('show');
              $('#lg-modal-content').html(res);
          }
      });
  }

  function categoryEdit(id)
  {
      $.ajax({
          url:"{{ url('admin/category') }}/"+id+"/edit",
          method:'GET',
          data:{id:id},
          success:function(res)
          {
              $('#lgModal').modal('show');
              $('#lg-modal-content').html(res);
          }
      });
  }

  function categoryDelete(id)
  {
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this file!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
            url:"{{ url('admin/category') }}/"+id,
            method:'DELETE',
            data:{id:id},
            success:function(res)
            {
              swal(res.message, {
                icon: "success",
              });
              $("#category").load(location.href + " #category");
            }
          });
        } else {
          swal("Your imaginary file is safe!");
        }
      });
  }
</script>

@endsection