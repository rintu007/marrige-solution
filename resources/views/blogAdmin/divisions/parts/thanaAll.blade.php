<section class="content-header">
  <h1>
    All	
    <small>Thana (উপজেলা)</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-plus"></i> All </a></li>
    <li class="active">Thana (উপজেলা)</li>
  </ol>
</section>

<section class="content">
 
 

    <div class="row">
        <div class="col-sm-12">

        	@include('alerts')


          <div class="box box-warning">
            <div class="box-header">
              <h3 class="box-title">All Divisions & Thana (উপজেলা)</h3>

              <div class="box-tools">

                <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" href="#">Add New Thana (উপজেলা)</a>

              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive ">
              <table class="table">
                <thead>
                  <tr>
                    <th style="width: 50px;">SL</th>
                    <th style="width: 50px;">ID</th>
                    <th >District (Division)</th>
                    <th style="width: 150px;">Action</th>
                  </tr>
                </thead>                
              </table>

              </div>
            <!-- /.box-body -->
 
          </div>
          <!-- /.box -->
 
              @foreach($districts as $district)
              <div class="box box-widget">
                <div class="box-body">                  
 
                  <table class="table table-service">
                    <tbody>
                        <tr>
                          <th style="width: 50px;">SL</th>
                          <th style="width: 50px;">{{$district->id}}</th>
                          <th >{{$district->name}} জেলা &nbsp; ({{$district->division->name}} বিভাগ)</th>
                          <th style="width: 150px;"></th>
                        </tr>
                      </tbody>
                  </table>
                  @foreach($district->thanas as $thana)
 
                    <table class="table table-condensed table-cat">
                      @include('blogAdmin.divisions.ajax.thanaTBody')
                    </table>
 
                  @endforeach
                </div>
              </div>
              

              @endforeach

          
        </div>
      </div>
 
	</section>



<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog ">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add New Thana</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="post" action="{{route('admin.thanaAddNewPost')}}">

                

                {{csrf_field()}}


                <div class="form-group {{ $errors->has('district') ? ' has-error' : '' }}">
                  <label for="district" class="col-sm-3 control-label">District</label>
                  <div class="col-sm-9">
                    <select name="district" id="district" class="form-control" required>
                      @if(old('district'))
                      <option>{{old('district')}}</option>
                      @else
                      <option value="">Select District</option>
                      @endif
                      
                      @foreach($districts as $district)
                        <option>{{$district->name}}</option>
                      @endforeach
                    </select>
                    @if ($errors->has('district'))
                      <span class="help-block">
                          <strong>{{ $errors->first('district') }}</strong>
                      </span>
                  @endif
                  </div>
                </div>               



                
                <div class="form-group {{ $errors->has('thana') ? ' has-error' : '' }}">
                  <label for="thana" class="col-sm-3 control-label">Thana</label>
                  <div class="col-sm-9">
                    <input type="text" name="thana" class="form-control" value="{{old('thana')}}" id="thana" placeholder="New Thana" autocomplete="off">
                    @if ($errors->has('thana'))
                      <span class="help-block">
                          <strong>{{ $errors->first('thana') }}</strong>
                      </span>
                  @endif
                  </div>
                </div>


                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-9">
                    <button type="reset" class="btn btn-default">Cancel</button>

                  <button type="submit" class="btn btn-primary pull-right">Create</button>

                  </div>
                </div> 
                </form>   
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>