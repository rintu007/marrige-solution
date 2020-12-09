
    <section class="content-header">
      <h1>
        Page
        <small>Edit</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Page</a></li>
        <li class="active">Edit</li>
      </ol>
    </section>



    <!-- Main content -->
    <section class="content"> 




<!-- Info boxes -->
      <div class="row">
      <div class="col-md-12">

      @include('alerts')


      <div class="box box-widget">
          <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-edit"></i> Page Add/Edit <span class="label label-default">{{ $page->page_title }}</span></h3>
              <div class="pull-right">
                <a class="btn w3-btn btn-xs w3-blue" target="_blank" href="{{ route('page',$page->route_name) }}">Preview Page</a> &nbsp;

                <a class="w3-btn w3-blue btn btn-xs " href="{{ route('admin.pageItems', $page) }}">Add Page Part</a>
              </div>
          </div>

            <div class="box-body">
              <div class="box box-widget mb-0">
                <div class="box-body w3-gray ">


                  <div class="box box-widget ">
                    <div class="box-body">

                    @include('admin.pages.includes.pageEditForm')

                    </div>
                  </div>


                  <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">

                      @foreach($page->items as $item)
                  @include('admin.pages.includes.pageItemSingle')
                      @endforeach
                      
                    </div>
                  </div>

 
                </div>
              </div>
            </div>
        </div>


       

 

    	{{-- <div class="box box-widget">
          <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-edit"></i> Page Edit <span class="label label-default">{{ $page->page_title }}</span></h3>
          </div>

            <div class="box-body">
            	<div class="box box-widget mb-0">
            		<div class="box-body w3-gray ">
            			   

 

<div class="box box-widget">
	<div class="box-body">
		Page ID: <b>{{ $page->id }}</b>, &nbsp;
		Page Title: <b> {{ $page->page_title }}</b>, &nbsp; 
		Route Name: <b> {{ $page->route_name }}</b>, &nbsp;
		Active: <b>{{ $page->active ? 'Yes' : 'No' }}</b>,
		List In Menu: <b>{{ $page->list_in_menu ? 'Yes' : 'No' }}</b>,
		Title Hide: <b>{{ $page->title_hide ? 'Yes' : 'No' }}</b>,

		<div class="pull-right">
		<a class="w3-btn w3-blue btn btn-xs " href="">Edit</a>
		&nbsp; 
		<a class="w3-btn w3-blue btn btn-xs " href="">Add Page Part</a>
		&nbsp; 
		<a class="w3-btn w3-red btn btn-xs " href="">Delete</a>
		</div>
	</div>
</div>

 

            		</div>
            	</div>
            </div>
        </div> --}}


        
      </div>        
      </div>
      <!-- /.row -->

 
      

    </section>
