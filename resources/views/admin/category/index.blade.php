@extends('admin.master')
@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        
        <div class="card">
          <button type="button" class="btn btn-primary" onclick="categoryModal()">Add Category</button>
            <h5 class="card-header">Slider</h5>
            <div class="table-responsive text-nowrap">
              <table class="table table-hover" id="category">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($categories as $category)
                      <tr>
                        <td>{{ $category->name }}</td>
                        <td>
                          <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                              <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Lilian Fuller">
                                <img src="" alt="Avatar" class="rounded-circle" />
                              </li>
                          </ul>
                        </td>
                        @php 
                         $class = $category->active == 1 ? 'bg-label-success' : 'bg-label-danger';
                         $status = $category->active == 1 ? 'Enable' : 'Disable';
                        @endphp
                        <td><span class="badge {{ $class }} me-1">{{ $status }}</span></td>
                        <td>
                          <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="javascript:void(0)" onclick="categoryEdit({{ $category->id }})"><i class="bx bx-edit-alt me-1"></i>Edit</a>
                              <a class="dropdown-item" href="javascript:void(0);" onclick="categoryDelete({{ $category->id }})"><i class="bx bx-trash me-1"></i> Delete</a>
                            </div>
                          </div>
                        </td>
                      </tr>
                    @endforeach
                  
                </tbody>
              </table>
            </div>
          </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
  function categoryModal()
  {
      $.ajax({
          url:"{{ route('admin.category.create') }}",
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