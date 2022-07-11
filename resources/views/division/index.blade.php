<?php use App\Http\Controllers\HelpersController as Helpers;

$haveaccessadd = Helpers::checkaccess('divisions', 'add');
$haveaccessadd = Helpers::checkaccess('divisions', 'delete');
$haveaccessdelete = Helpers::checkaccess('users', 'delete');

?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
<title>{{ $datas['title'] }}</title>
{{-- {{ dd($datas) }} --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight hetf2"><i class="bi bi-clipboard-fill"></i>
            {{ __('Division') }} <?php if($haveaccessadd): ?> <a href="{{URL::to('/divisions/create')}}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add Division</a> <?php endif; ?>
        </h2>
    </x-slot>
                                                    {{-- HEADER --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="table-responsive">
                        <table id="divisionTable"
                            class="table text-start table-striped align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr>
                                    <td></td> 
                                        <td><input type="text" class="form-control input-sm src_class_user" autocomplete="off" onkeyup="searcAjax(this)" placeholder="Division " name="division_name" id="#division_name"></td>
                                    <td>
                                        <select name="active" class="form-control input-sm src_class_user" onchange="searcAjax(this, 1)">
                                            <option value="">-- Status Active --</option>
                                            <option value="1">Active</option>
                                            <option value="0">Not Active</option>
                                        </select>                             
                                    </td>
                                </tr>
                                    <th><input type="checkbox" class="checkall" name="checkall"></th>
                                    <th class="align-center">Jabatan</th>
                                    <th class="align-center">Active</th>
                                    <th class="align-center">Action</th>
                                </tr>
                            </thead>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th class="align-center">Jabatan</th>
                                        <th class="align-center">Active</th>
                                        <th class="align-center">Action</th>
                                    </tr>
                                </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>                             
                                                                    <!-- MODAL VIEW -->
    <div class="modal fade" id="viewUser" tabindex="-1" role="dialog" aria-labelledby="viewUserTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-lg-start">
                    <h4><i class="bi bi-clipboard2-minus"></i></i></h4>
                    <h5 id="titledetailmodal" class="ms-2 modal-title"></h5>
                </div>
                <div class="modal-body">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade active show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <dl class="row mb-0">
                                <dt class="col-sm-4">Jabatan</dt>
                                <dd class="col-sm-8">: <span name="division_name" id="division_name"></dd>
                                <dt class="col-sm-4">Status</dt>
                                <dd class="col-sm-8">: <span id="activedetail"></span>
                                <dt class="col-sm-4">Status Delete</dt>
                                <dd class="col-sm-4">: <span id="flagdelete"></span></dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="closeModalViewUser" type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    @if ($haveaccessadd) :
                    <a href="{{URL::to('/divisions/edit/')}}" data-attrref="{{URL::to('/divisions/edit/')}}" id="addvbtn" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> Edit Divisi</a>
                  @endif
                    @if ($haveaccessdelete)
                        <button onClick="deleteyesshow()" data-attid="" data-deleteval="1" id="deletevbtn" class="btn btn-danger btn-sm"></a>
                            <button onClick="undeleteyesshow()" data-attid="" data-deleteval="0" id="undeletevbtn" class="btn btn-warning btn-sm"></button>
                    @endif
                </div>
            </div>
        </div>
    </div>
                                                                 
    @section('script')
        <script type="text/javascript">
            /////////////////////////////////////////////   GetData Table ///////////////////////////////////////////
            var url = "{{ asset('/api/divi/getdata') }}";
            function searcAjax(a, skip = 0) {
                if ($(a).val().length > global_length_src || skip == 1) {
                    var getparam = getAllClassAndVal("src_class_user"); // helpers
                    $('#divisionTable').DataTable().ajax.url(url + "?" + getparam).load();
                }else{
                    $('#divisionTable').DataTable().ajax.url(url).load();
                }
            }
            $(document).ready(function() {
                var getndate = getNowdate(); // helpers
                var table = $('#divisionTable').DataTable({
                    ajax: url,
                    columnDefs: [{
                            'targets': 3,
                            'searchable': false,
                            'orderable': false,
                            'className': 'dt-body-center',
                            'render': function(data, type, full, meta) {
                                return '<span class="btn btn-info btn-sm" onclick="showdetail(' + full[3] + ')">details</span>';
                            }
                        },
                        {
                            'targets': 0,
                            'searchable': false,
                            'orderable': false,
                            'className': 'dt-body-center',
                            'render': function(data, type, full, meta) {
                                return '<input type="checkbox"  class="ckc" name="checkid[' + full[0] +
                                    ']" value="' + $('<div/>').text(data).html() + '">';
                            }
                        },
                        {
                            'targets': 2,
                            'className': 'dt-body-center',
                            'render': function(data, type, full, meta) {
                       
                                if (full[2] == 0){
                                    return '<span class="btn btn-danger btn-sm">not active</span>';
                                }
                                else{

                                    return '<span class="btn btn-success btn-sm">active</span>';
                                }
                            },
                            
                        },
                        
                    ],
                    searching: false,
                });
            });
            
                appendDivisionOption();
                appendRoleOption();         
            
                    /////////////////////////////////      Modal SHOW DETAIL       //////////////////////////////////////
            function showdetail(id) {
                var addurl = $('#addvbtn').attr('data-attrref')+'/'+id;
              $('#addvbtn').attr('href', addurl);
                $('#saveee').attr('data-attid', id);
                var addurl = $('#deletevbtn').attr('data-attid', id);
                var url = "{{ asset('/division/detail') }}/" + id;
                var form = $('#viewUser');
                $('#undeletevbtn').html("Undelete");
                    $.ajax({
                        url: url,
                        type: "GET",
                        success: function(response) {
                            data = response.data;
                            if (data) {
                                $("#division_name").html(data.division_name);
                                if (data.active == 0) {
                                    $("#activedetail").html("<span class='btn btn-secondary btn-sm'><b>Not Active</b></span>");
                                } else {
                                    $("#activedetail").html("<span class='btn btn-success btn-sm'><b>Active</b></span>");
                                }
                                if (data.flag_delete == 0) {
                                    $("#flagdelete").html("<span class='btn btn-primary btn-sm'><b>ON</b></span>");
                                } else {
                                    $("#flagdelete").html("<span class='btn btn-danger btn-sm'><b>Delete</b></span>");
                                }

                                if (data.flag_delete == 0){
                                    $('#deletevbtn').show();
                                    $('#undeletevbtn').hide();
                                }
                                if (data.flag_delete == 1){
                                    $('#deletevbtn').hide();
                                    $('#undeletevbtn').show();
                                }
                               
                            }
                            reloaddata();
                            $('#viewUser').modal('show');
                  
                        }
                    }); 
                $('#deletevbtn').attr('data-attid', id);
                $('#editbtn').attr('data-attid', id);
                $('#editshow').attr('data-attid', id);
                $('#undeletevbtn').attr('data-attid', id);
                $('#deletevbtn').html('<i class="fa fa-trash"></i> Delete Divisi');
                $("#titledetailmodal").html("Detail Division")
            }
                $("#closeModalViewUser").click(function() {
                    $("#viewUser").modal('hide');
                });
                
                  /////////////////////////////////      Modal EDIT       //////////////////////////////////////
           
  function check_access(){
    idx = $('#editbtn').attr('data-attid',);
    test = '@csrf';
    token = $(test).val();
    var url = "{{ asset('/api/divisionaccess') }}/" + idx;
    $.ajax({
        url: url,
        type: "post",
        data: {
            id : idx,
            _token: token
        },
        success: function (response) {
          $.each(response.data, function(i, item) {
            if(item.val_access == 1)
              $("#"+item.name_access+'-'+item.key_access).attr('checked', true);
            else 
              $("#"+item.name_access+'-'+item.key_access).attr('checked', false);
          });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('something wrong');
            console.log(textStatus, errorThrown);
        }
    });
  }
        $(document).ready(function(){
                $('#editpostmodal').submit(function(e){
                    test = '@csrf';
                    token = $(test).val();
                    e.preventDefault();
                    idx = $('#editshow').attr('data-attid');
                    var coba1 = $("#division_name_edit").val();
                   var ll = $('input[name="active_edit"]:checked').val();
                    // console.log(ll);
                    // var coba3 = $("#active_edit2").val();
                    var url = "{{ asset('/division/store') }}";
                        if(idx)
                            url = "{{ asset('/division/update3') }}/" + idx;
                        $.ajax({
                                url: url,
                                type: "get",
                                data: {
                                    division_name : coba1,
                                    active: ll,
                                    _token: token
                                },
                                success: function (response) {
                                    data = response.data;
                                 
                                    if(data[0] == 'success') {
                                        Swal.fire({
                                            title: 'Selamat!',
                                            text: "Data Berhasil Diubah",
                                            icon: 'success'
                                        });
                                        // $("#viewUser").modal('hide');
                                        $("#editmodal").modal('hide');
                                            reloaddata();
                                    } else {
                                        Swal.fire({
                                            title: 'Gagal!',
                                            text: "You won't be able to revert this!",
                                            icon: 'error'
                                        });
                                    }
                                    
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    console.log(textStatus, errorThrown);
                                }
                        });
                });  
        });

              /////////////////////////////////      Modal DELETE       //////////////////////////////////////
            function deleteyesshow() {
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
                        var form = $('#viewUser');
                        var url = "{{ asset('/division/delete') }}/" + idx;
                        $.ajax({
                            url: url,
                            type: "get",
                            data: {
                                data: form.serialize(),
                                id: idx,
                                _token: token
                            },
                            cache: false,
                            success: function(response) {
                            
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                                $("#viewUser").modal('hide');
                       
                            reloaddata();
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.log(textStatus, errorThrown);
                            }
                        });
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
        }).then((result) => 
        {
            if (result.isConfirmed) 
            {
                var url = "{{ asset('/division/delete') }}/" + idx;
                $.ajax({
                    url: url,
                    type: "get",
                    data: {
                        id : idx,
                        _token: token,
                        undeleted : 1
                    },
                    success: function (response) 
                    {
                        Swal.fire({
                            icon: 'success',
                            title: 'Undeleted',
                            html:'Your file has been <b>Undeleted</b>'
                        });
                        var url = "{{ asset('/api/divi/getdata') }}";
                        $("#viewUser").modal('hide');
                    
                        $('#divisionTable').DataTable().ajax.url(url).load();
                        $('#deletevbtn').show();
                        $("#activspan").html('Active');
                        $("#activspan").css('color', '#198754');
                    },
                    error: function(jqXHR, textStatus, errorThrown)
                    {
                        console.log(textStatus, errorThrown);
                    }
                });
    
            } else {
                $('#undeletevbtn').show();
            }
        });
    }
              /////////////////////////////////      APPENDDIVISOPTION       //////////////////////////////////////
            function appendDivisionOption() {
                // add division
                var url = "{{ asset('/api/getdivision') }}";
                $.ajax({
                    url: url,
                    type: "get",
                    // cache: false,
                    success: function(response) {
                        $.each(response.data, function(i, item) {
                            $('#divisionselect').append($('<option>', {
                                value: item.id_division,
                                text: item.division_name,
                            }));
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            }
              /////////////////////////////////      APPEND R0LE OPTION       //////////////////////////////////////
            function appendRoleOption() {
                // add division
                var url = "{{ asset('/api/getrole') }}";
                $.ajax({
                    url: url,
                    type: "get",
                    success: function(response) {
                        $.each(response.data, function(i, item) {
                            $('#roleselect').append($('<option>', {
                                value: item.id_role,
                                text: item.role_name
                            }));
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            }
              /////////////////////////////////      RELOAD DATA       //////////////////////////////////////
            function reloaddata() {
                $('#divisionTable').DataTable().ajax.url(url).load();
            }

            function checkpart(a){
		if($("#endt-"+a).is(':checked')) {
			$(".ec-"+a).each(function(){
			    $(this).attr('checked', true);
			});
		} else {
			$(".ec-"+a).each(function(){
			    $(this).attr('checked', false);
			});
		}
	}
        </script>
    @endsection
</x-app-layout>

