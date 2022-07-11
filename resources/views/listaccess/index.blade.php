<?php use App\Http\Controllers\HelpersController as Helpers; 

$haveaccessadd = Helpers::checkaccess('listaccess', 'add');
$haveaccessdelete = Helpers::checkaccess('listaccess', 'delete');

?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight hetf2"><i class="fa fa-users"></i>
            {{ __('Users') }} <?php if($haveaccessadd): ?> <button type="button" id="btnAdd" class="btn btn-sm btn-success m-2" data-toggle="modal" data-target="#addUser"><i class="fa fa-plus me-2"></i>Add List Access</button> <?php endif; ?>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                   <div class="table-responsive">
                        <table id="datastable" class="table text-start table-striped align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr>
                                    <td></td>
                                    <td><input type="text" class="form-control input-sm src_class_user" autocomplete="off" onkeyup="searcAjax(this)" placeholder="Name Access" name="name_access"></td>
                                    <td><input type="text" class="form-control input-sm src_class_user" autocomplete="off" onkeyup="searcAjax(this)" placeholder="Name Url" name="name_url"></td>
                                    <td>
                                      <select name="active" class="form-control input-sm src_class_user" onchange="searcAjax(this, 1)">
                                          <option value="">-- Status Active --</option>
                                          <option value="0">Active</option>
                                          <option value="1">Not Active</option>
                                        </select>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th style="text-align: center;"><input type="checkbox" class="checkall" name="checkall"></th>
                                    <th class="align-center">Name Access</th>
                                    <th class="align-center">Name Url</th>
                                    <th style="text-align: center;" class="align-center">Status</th>
                                    <th style="text-align: center;" class="align-center">Action</th>
                                </tr>
                                
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th class="align-center">Name Access</th>
                                    <th class="align-center">Name Url</th>
                                    <th style="text-align: center;" class="align-center">Status</th>
                                    <th style="text-align: center;" class="align-center">Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- view modal -->
<div class="modal fade" id="view" tabindex="-1" role="dialog" aria-labelledby="viewTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">


    <div class="modal-body">
      <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Main Info</button>
                </li>
            </ul>

            <div class="tab-content" id="pills-tabContent">
          <div class="tab-pane fade active show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <dl class="row mb-0" id="datauser-1"></dl>
          </div>

      </div>
    </div>

    <div class="modal-footer">
      <button id="closeModal" type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
      @if ($haveaccessadd) :
        <span id="editvbtn" data-attid="" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> Edit List Access</span>
      @endif

      @if ($haveaccessdelete) :
        <button onClick="deleteyesshow()" data-attid="" data-deleteval="1" id="deletevbtn" class="btn btn-danger btn-sm"></a>
        <button onClick="undeleteyesshow()" data-attid="" data-deleteval="0" id="undeletevbtn" class="btn btn-success btn-sm"></a>
      @endif
    </div>
    </div>
  </div>
</div>

@if ($haveaccessadd) :
<!-- add modal -->
<div class="modal fade" id="viewad" tabindex="-1" role="dialog" aria-labelledby="viewTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLongTitle"></h5>
                <button type="button" class="close-modal btn btn-sm btn-danger close closeModalad" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id="smbtn">
                            <div class="input-group mb-3">
                                <label style="background: #b2d9ff; width: 100%; padding: 5px; margin: 5px 0;">Don't use Space and Uppercase <span class="red-required">*</span></label>
                                <input type="hidden" id="id_access" class="inpt-cst-add" name="id_access">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-at me-2"></i></span>
                                <input type="text" id="name_access" name="name_access" class="form-control inpt-cst-add" required placeholder="Name Access" aria-label="Name Access" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-at me-2"></i></span>
                                <input type="text" id="name_url" name="name_url" class="form-control inpt-cst-add" required placeholder="Name URL" aria-label="Name URL" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3" style="float: right; text-align: right; right: 0; width: 185px;">
                                <button type="button" class="btn btn-secondary btn-sm closeModalad" data-dismiss="modal">Close</button>
                                <button type="submit" id="addvbtn" data-attid="" class="btn btn-success btn-sm"></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@section('script')
<script type="text/javascript">
    var url = "{{ asset('/api/listaccess/getdata') }}";
    function searcAjax(a, skip = 0){
        if($(a).val().length > global_length_src || skip == 1) {
            var getparam = getAllClassAndVal("src_class_user"); // helpers
            $('#datastable').DataTable().ajax.url(url+"?"+getparam).load();
        }
        else {
          $('#datastable').DataTable().ajax.url(url).load();
        } 
    }

    $("#btnAdd").click(function(){
        clearInput("inpt-cst-add");
        $("#ModalLongTitle").html("Add List Access");
        $('#viewad').modal('show');
        $("#addvbtn").html('<i class="fa fa-plus"></i> Add List Access');
    });

    $("#smbtn").submit(function(e){
        e.preventDefault();

        test = '@csrf';
        token = $(test).val();
        var id_access = $("#id_access").val();
        var name_access = $("#name_access").val();
        var name_url = $("#name_url").val();

        var url = "{{ asset('api/listaccess/updatedata') }}";

        if(id_access == '')
            var url = "{{ asset('api/listaccess/insertdata') }}";

        $.ajax({
            url: url,
            type: "post",
            data: {
                id_access : id_access,
                name_access : name_access,
                name_url : name_url,
                _token: token,
            },
            success: function (response) {
                if(response.data[0] == 'success') {
                    Swal.fire({
                      icon: 'success',
                      title: 'Save',
                      html:'Your data has been <b>Saved</b>'
                    });
                } else {
                    Swal.fire({
                      icon: 'error',
                      title: 'Not Save',
                      html:'Upss !!! Your data <b>Not Saved</b>'
                    });
                }

                var url = "{{ asset('/api/listaccess/getdata') }}";
                $('#datastable').DataTable().ajax.url(url).load();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });

    $("#editvbtn").click(function(){
        idx = $('#deletevbtn').attr('data-attid');
        clearInput("inpt-cst-add");
        $("#ModalLongTitle").html("Edit List Access");
        $("#addvbtn").html('<i class="fa fa-edit"></i> Edit List Access');
        var url = "{{ asset('/api/listaccess/getdatabyid/') }}"+'/'+idx;
        test = '@csrf';
        token = $(test).val();
        $.ajax({
            url: url,
            type: "post",
            data: {
                id : idx,
                _token: token,
            },
            success: function (response) {
                $("#name_access").val(response.data[0].name_access);
                $("#name_url").val(response.data[0].name_url);
                $("#id_access").val(response.data[0].id_access);
                $('#viewad').modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });



    });

    $(".closeModalad").click(function(){
        $("#viewad").modal('hide');
    });



    $(document).ready(function(){
        
        var table = $('#datastable').DataTable({
            ajax: url,
            columnDefs: [
                 {
                   'targets': 4,
                   'searchable':false,
                   'orderable':false,
                   'className': 'dt-body-center',
                   'render': function (data, type, full, meta){
                       return '<span class="btn btn-info btn-sm" onclick="showdetail('+full[4]+')">details</span>';
                   }
                }, {
                   'targets': 3,
                   'searchable':false,
                   'className': 'dt-body-center',
                   'render': function (data, type, full, meta){
                      if(full[3] == 0)
                        return '<span class="btn btn-success btn-sm">active</span>';
                      else 
                        return '<span class="btn btn-warning btn-sm">deleted</span>';
                   }
                }, {
                   'targets': 0,
                   'searchable':false,
                   'orderable':false,
                   'className': 'dt-body-center',
                   'render': function (data, type, full, meta){
                       return '<input type="checkbox" class="ckc" name="checkid['+full[3]+']" value="' + $('<div/>').text(data).html() + '">';
                   }
                }
            ],
            searching: false,
        }); 


        $("#closeModal").click(function(){
          $("#view").modal('hide');
        });

        $('.checkall').change(function(){
            var cells = table.cells().nodes();
            $( cells ).find('.ckc:checkbox').prop('checked', $(this).is(':checked'));
        });

    });

    function showdetail(idx){
      $('#deletevbtn').html('<i class="fa fa-trash"></i> Delete List Access');
      $('#undeletevbtn').html('<i class="fa fa-repeat"></i> Undelete List Access');

      $('#deletevbtn').attr('data-attid', idx);
      $('#undeletevbtn').attr('data-attid', idx);

      $('#addvbtn').attr('data-attid', idx);
      

      $('#view').modal('show');
      test = '@csrf';
      token = $(test).val();

      var url = "{{ asset('/api/listaccess/getdatabyid/') }}"+'/'+idx;
      $.ajax({
          url: url,
          type: "post",
          data: {
            id : idx,
            _token: token
          },
          success: function (response) {
            var dhtml = '';
            if(response.data[0].flag_delete == 0){
              $('#deletevbtn').show();
              $('#undeletevbtn').hide();
            }

            if(response.data[0].flag_delete == 1){
              $('#deletevbtn').hide();
              $('#undeletevbtn').show();
            }

            $.each(response.data[0], function(i, item) {
              if(i != 'id_access') {

                  if(i == 'flag_delete' && item == 0) {
                    item = '<span id="activspan" style="color: #198754">active</span>';
                  } 
                  if(i == 'flag_delete' && item == 1) {
                    item = '<span id="activspan" style="color: #dc3545">deleted</span>';
                  }

                  dhtml += '<dt class="col-sm-4">'+i+'</dt>';
                  dhtml += '<dt class="col-sm-8">'+item+'</dt>';
              }
              
            });

            $("#datauser-1").html(dhtml);
          },
          error: function(jqXHR, textStatus, errorThrown) {
             console.log(textStatus, errorThrown);
          }
      });

    }

    function deleteyesshow(){
      $('#deletevbtn').hide();
      idx = $('#deletevbtn').attr('data-attid');
      test = '@csrf';
      token = $(test).val();
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
            if (result.isConfirmed) {
                var url = "{{ asset('/listaccess/delete') }}/" + idx;
                $.ajax({
                    url: url,
                    type: "post",
                    data: {
                        id : idx,
                        _token: token
                    },
                    success: function (response) {
                        Swal.fire({
                          icon: 'success',
                          title: 'Deleted',
                          html:'Your file has been <b>Deleted</b>'
                        });
                        var url = "{{ asset('/api/listaccess/getdata') }}";
                        $('#datastable').DataTable().ajax.url(url).load();
                        $('#undeletevbtn').show();
                        $("#activspan").html('Deleted');
                        $("#activspan").css('color', '#dc3545');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('something wrong');
                        console.log(textStatus, errorThrown);
                    }
                });

            } else {
              $('#deletevbtn').show();
            }
      })
    }

    function undeleteyesshow(){
      $('#undeletevbtn').hide();
      idx = $('#undeletevbtn').attr('data-attid');
      test = '@csrf';
      token = $(test).val();
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, undelete it!'
      }).then((result) => {
            if (result.isConfirmed) {
                var url = "{{ asset('/listaccess/delete') }}/" + idx;
                $.ajax({
                    url: url,
                    type: "post",
                    data: {
                        id : idx,
                        _token: token,
                        undeleted : 1
                    },
                    success: function (response) {
                        Swal.fire({
                          icon: 'success',
                          title: 'Undeleted',
                          html:'Your file has been <b>Undeleted</b>'
                        });
                        var url = "{{ asset('/api/listaccess/getdata') }}";
                        $('#datastable').DataTable().ajax.url(url).load();
                        $('#deletevbtn').show();
                        $("#activspan").html('Active');
                        $("#activspan").css('color', '#198754');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });

            } else {
              $('#undeletevbtn').show();
            }
      })
    }

    
</script>

@endsection    
</x-app-layout>


