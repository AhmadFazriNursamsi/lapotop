{{-- @extends('division.index') --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
<div class="card-body">
	
    <form role="form" action="{{url('divisions/').'/'.$datas['urls']}}" method="post">
      {{ csrf_field() }}
      <div class="box-body">
        <div class="row">
        	<div class="col-md-4">
        		<h2 class="btn btn-sm btn-primary">Main Info</h2>
	    		<div class="col-md-10">
		            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} has-feedback">
		              <label for="division_name" style="background: #b2d9ff; width: 100%; padding: 5px; margin: 5px 0;">Divisi <span class="red-required">*</span></label>
		              <input type="text" name="division_name" value="<?php if(isset($users->division_name)) echo $users->division_name;?>" class="form-control form-control-sm" required id="name" placeholder="Divisi">
		                
		                @if ($errors->has('name'))
		                    <span class="help-block">
		                        <strong>{{ $errors->first('name') }}</strong>
		                    </span>
		                @endif
		            </div>
		        </div> <!--col-md-4-->

		    

		        <div class="col-md-10">
		            <div class="form-group{{ $errors->has('active') ? ' has-error' : '' }} has-feedback">
		              <label for="active" style="background: #b2d9ff; width: 100%; padding: 5px; margin: 5px 0;">active <span class="red-required">*</span></label>
		              	<input type="radio" id="active" name="active" value="1" <?php if((isset($users->active) && $users->active == 1) || !isset($users->active)) echo "checked";?> >
						<label for="active">Active</label><br>
						<input type="radio" id="not_active" name="active" value="0" <?php if(isset($users->active) && $users->active == 0) echo "checked";?>>
						<label for="not_active">Not Active</label><br>
		            </div>
		        </div> <!--col-md-4-->


		        <hr>
		    </div><!--col-md-6-->


		    <div class="col-md-6">
	    		<h2 class="btn btn-sm btn-primary">Divisions Access</h2>

	    		<dl class="row mb-0" id="datauser-2">

	    			<?php foreach ($datas['user_access'] as $key => $post) :?>
				    <dt class="col-sm-12" style="border: 1px solid #DDD; background: #b2d9ff; width: 100%; padding: 5px; margin: 5px 0; margin-top:15px; margin-bottom:15px;">
				    	<input type="checkbox" class="form-check-input" id="endt-{{$post->name_access}}" onclick="checkpart('{{$post->name_access}}')">  || 
				    	<label style="font-size: 18px" class="form-check-label" for="endt-{{$post->name_access}}"><?= $post->name_access?></label>
				    </dt>
				    <div class="col-sm-2">
				    	<input type="hidden" name="eCheck1[{{$post->name_access}}][view]" value="0">
					    <input type="checkbox" class="form-check-input eCheck1 ec-{{$post->name_access}}" id="{{$post->name_access}}-view" name="eCheck1[{{$post->name_access}}][view]" value="1">
					    <label class="form-check-label" for="{{$post->name_access}}-view">view</label>
					</div>
					<div class="col-sm-2">
						<input type="hidden" name="eCheck1[{{$post->name_access}}][add]" value="0">
					    <input type="checkbox" class="form-check-input eCheck1 ec-{{$post->name_access}}" id="{{$post->name_access}}-add" name="eCheck1[{{$post->name_access}}][add]" value="1">
					    <label class="form-check-label" for="{{$post->name_access}}-add">add</label>
					</div>
					<div class="col-sm-2">
						<input type="hidden" name="eCheck1[{{$post->name_access}}][edit]" value="0">
					    <input type="checkbox" class="form-check-input eCheck1 ec-{{$post->name_access}}" id="{{$post->name_access}}-edit" name="eCheck1[{{$post->name_access}}][edit]" value="1">
					    <label class="form-check-label" for="{{$post->name_access}}-edit">edit</label>
					</div>
					<div class="col-sm-2">
						<input type="hidden" name="eCheck1[{{$post->name_access}}][delete]" value="0">
					    <input type="checkbox" class="form-check-input eCheck1 ec-{{$post->name_access}}" id="{{$post->name_access}}-delete" name="eCheck1[{{$post->name_access}}][delete]" value="1">
					    <label class="form-check-label" for="{{$post->name_access}}-delete">delete</label>
					</div>
					<div class="col-sm-2">
						<input type="hidden" name="eCheck1[{{$post->name_access}}][import]" value="0">
					    <input type="checkbox" class="form-check-input eCheck1 ec-{{$post->name_access}}" id="{{$post->name_access}}-import" name="eCheck1[{{$post->name_access}}][import]" value="1">
					    <label class="form-check-label" for="{{$post->name_access}}-import">import</label>
					</div>
					<div class="col-sm-2">
						<input type="hidden" name="eCheck1[{{$post->name_access}}][export]" value="0">
					    <input type="checkbox" class="form-check-input eCheck1 ec-{{$post->name_access}}" id="{{$post->name_access}}-export" name="eCheck1[{{$post->name_access}}][export]" value="1">
					    <label class="form-check-label" for="{{$post->name_access}}-export">export</label>
					</div>
					<?php endforeach;?>

			    	
				</dl>


		    </div><!--col-md-6-->

        </div> <!-- row -->

      </div>
      <!-- /.box-body -->

      <div class="box-footer">
        <div class=" pull-right">
        	<br>
          <button type="submit" class="btn btn-info btn-sm" style="position: fixed; bottom: 46px; right: 46px;"><i class="fa fa-send" aria-hidden="true"></i> Submit</button>
        </div>
      </div>
    </form>
</div>

<script type="text/javascript">
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

