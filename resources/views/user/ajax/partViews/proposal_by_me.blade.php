<div class="box box-widget mb-0" style="min-height: 600px;">

    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-users"></i>Proposals by me</h3>
    </div>

    <?php
    	$type = 'favourite';
    	$proposals = Auth::user()->ProposalFromMe();
    ?>



            	@include('user.ajax.proposals')

  </div>