<?php use App\Http\Controllers\HelpersController as Helpers; 

$haveaccessadd = Helpers::checkaccess('users', 'add');
$haveaccessdelete = Helpers::checkaccess('users', 'delete');

?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight hetf2"><i class="fa fa-users"></i>
            {{ __('Users') }} Edit <a href="{{URL::to('/users')}}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Back to User</a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                  @include('users._form', $datas)
                </div>
            </div>
        </div>
    </div>



@section('script')
<script type="text/javascript">
   
  $(document).ready(function (){
    check_access();
  })

  function check_access(){
    idx = '{{$id}}';
    test = '@csrf';
    token = $(test).val();
    var url = "{{ asset('/api/usersaccess') }}/" + idx;
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
      
    
</script>

@endsection    
</x-app-layout>


