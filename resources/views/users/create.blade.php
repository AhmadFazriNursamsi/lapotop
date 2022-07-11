<?php use App\Http\Controllers\HelpersController as Helpers; 

$haveaccessadd = Helpers::checkaccess('users', 'add');
$haveaccessdelete = Helpers::checkaccess('users', 'delete');

?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight hetf2"><i class="fa fa-users"></i>
            {{ __('Users') }} Create <a href="{{URL::to('/users')}}" class="btn btn-warning btn-sm"><i class="fa fa-arrow-circle-left"></i> Back to User</a>
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
    
</script>

@endsection    
</x-app-layout>


