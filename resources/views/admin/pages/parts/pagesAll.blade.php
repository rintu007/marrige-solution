
    <section class="content-header">
      <h1>
        Pages
        <small>All</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Pages</a></li>
        <li class="active">All</li>
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
              <h3 class="box-title"><i class="fa fa-plus"></i> Add New Page</h3>
               

              
            </div>

            <div class="box-body">

 								@include('admin.pages.includes.pageCreateForm')
            	






 

               
            </div>

 
        </div>







    	<div class="box box-widget">
          <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-th"></i> All Pages</h3>
          </div>

            <div class="box-body">
            	<div class="box box-widget mb-0">
            		<div class="box-body w3-gray ">
            			   

@foreach($pages as $page)

@include('admin.pages.includes.pageSingle')

@endforeach 

            		</div>
            	</div>
            </div>
        </div>


        
      </div>        
      </div>
      <!-- /.row -->

 
      

    </section>
