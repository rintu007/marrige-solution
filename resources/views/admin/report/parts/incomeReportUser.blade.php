<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Member Entry
    <small>Report</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Member Entry</a></li>
    <li class="active">Report</li>
  </ol>
</section>

    <!-- Main content -->
<section class="content"> 

    <div class="box box-widget" style="margin-bottom: 1px;">
    	<div class="box-body">
	    	<div class="row">
	    		<div class="col-sm-2">
	    			<div class="dropdown">
					  <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Select Date
					  <span class="caret"></span></button>
					  <ul class="dropdown-menu">
					    <li><a class="select-date" href="{{route('admin.incomeReportUserSearch', 'today')}}">Today</a></li>
					    <li><a class="select-date" href="{{route('admin.incomeReportUserSearch', 'yesterday')}}">Yesterday</a></li>
					    <li><a class="select-date" href="{{route('admin.incomeReportUserSearch', 7)}}">Last 7 Days</a></li>
					    <li><a class="select-date" href="{{route('admin.incomeReportUserSearch', 30)}}">Last 30 Days</a></li>
					    <li><a class="select-date" href="{{route('admin.incomeReportUserSearch', 'this_month')}}">This Month</a></li>
					    <li><a class="select-date" href="{{route('admin.incomeReportUserSearch', 'last_month')}}">Last Month</a></li>
					  </ul>
					</div>
	    		</div>
	    		<div class="col-sm-10">
				    <form class="form-inline select-date-interval" method="get" action="{{route('admin.incomeReportUserSearchByDateInterval')}}">
					  <div class="form-group form-group-sm">
					    <label for="date_from">From:</label>
					    <input type="date" name="date_from" class="form-control" id="date_from">
					  </div>
					  <div class="form-group form-group-sm">
					    <label for="date_to">To:</label>
					    <input type="date" name="date_to" class="form-control" id="date_to">
					  </div>
					   
					  <button type="submit" class="btn btn-primary btn-sm">Submit</button>
					</form>
	    		</div>
	    	</div> 
	    </div>
	</div>
	<div class="box box-widget">
		<div class="box-body">


<label class="radio-inline"><input value="all_users" type="radio" name="user_type" checked>All Users</label>
<label class="radio-inline"><input value="golden" type="radio" name="user_type">Golden</label>
<label class="radio-inline"><input value="golden_plus" type="radio" name="user_type">Golden Plus</label>
<label class="radio-inline"><input value="diamond" type="radio" name="user_type">Diamond</label>
<label class="radio-inline"><input value="diamond_plus" type="radio" name="user_type">Diamond Plus</label>


		</div>
	</div>

	<div class="sales-account-part">
		
		<div class="box box-widget">
			<div class="box-body" style="min-height: 400px;">
				
				<table class="table table-condensed">
					<thead>
						<tr>
							<th>SL</th>
							<th>ID</th>
							<th>Name</th>
							<th>Mobile</th>
							<th>Email</th>
							<th>Link</th>
							<th>Created at</th>
							<th>Action</th> 
						</tr>
					</thead>
				</table>
			</div>
			<div class="overlay text-center w3-text-deep-orange">
			<br> <br> <br>              
              <h2><b class="w3-animate-fading">Select Date (or Select Date to Date) and Submit</b></h2>
            </div>
		</div>

		
	</div>


</section>
