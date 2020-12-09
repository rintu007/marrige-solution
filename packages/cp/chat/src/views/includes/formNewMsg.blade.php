<div class="box box-widget">
<form role="form"  class="msgFormForNewMsg" id="msgForm" method="POST" action="{{route('msgNewCreate')}}">

        <div class="box-header with-border">
          <h3 class="box-title"><span class="fa fa-edit"></span> {{$ru ? $ru->username : 'No People'}}</h3>
          <!-- tools box -->
          <div class="pull-right box-tools">
            <!-- button with a dropdown -->
            
          </div><!-- /. tools -->
        </div><!-- /.box-header -->
        <div class="box-body">
        <div class="message-list">

          

        </div>
        <div class="loadingNewMsg" style="display: none;"><span class='loadNewMsg ion-load-c fa fa-spin '></span> Loading...</div>
        <hr>


        {{csrf_field()}}

            <input type="hidden" name="users" value="{{$ru ? $ru->id : ''}}">
              <!-- textarea -->
              <div class="form-group">
                <textarea required class="form-control input_box" name="message_body" rows="3" placeholder="Write Your Message..."></textarea>
              </div>

        
        
 
            <div class="form-group text-center">

           

 <button style="margin-top: 12px;" type="submit" id="btn_msg_new_final" class="btn-xs pull-right btn btn-default w3-purple"><span class="fa fa-share"></span><span class=""> Submit</span></button> 
 

</div>
    



        </div><!-- /.box-body -->
</form>
        <!-- Loading (remove the following to stop the loading)-->
        <div class="overlay overlay-post" style="display: {{$ru ? 'none' : ''}};">
          <i class="fa fa-edit fa-2x text-green"></i>
        </div>
        <!-- end loading -->


      </div><!-- /.box -->      