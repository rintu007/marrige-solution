
    <section class="content-header">
      <h1>
        Reports
        <small>All</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Reports</a></li>
        <li class="active">All</li>
      </ol>
    </section>



    <!-- Main content -->
    <section class="content"> 




<!-- Info boxes -->
      <div class="row">
      <div class="col-md-12">

      @include('alerts.alerts')

        <div class="box box-widget">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-th"></i> All Reports</h3>              
            </div>

            <div class="box-body">
              <table class="table table-bordered ">
          <thead>
            <tr>
              <th>Report About</th>
 
              <th>Comment</th>
              <th>Report By</th>
              <th>Status</th>
              <th width="150">Action</th>
            </tr>
          </thead>
          <tbody>

          @foreach($reports as $report)
            <tr>            
              <td>
                @if($report->reportAbout)
                ID: {{ $report->reportAbout->id }} <br>
                Name: {{ $report->reportAbout->name }}<br> 
                Username: {{ $report->reportAbout->username }}<br>
                Email: {{ $report->reportAbout->email }} <br> 
                <a target="_blank" href="{{ url('/', $report->reportAbout->username) }}">Details</a>
                @endif
              </td>
              <td>
                {{ $report->comment }}
              </td>

              <td>
                @if($report->reportBy)
                ID: {{ $report->reportBy->id }}<br>
                Name: {{ $report->reportBy->name }}<br> 
                Username: {{ $report->reportBy->username }}<br>
                Email: {{ $report->reportBy->email }}<br> 
                <a target="_blank" href="{{ url('/', $report->reportBy->username) }}">Details</a>
                @endif
              </td>

              <td>
                @if ($report->status == 'pending')
                  <span class="label label-default">{{ $report->status }}</span>
                @else
                  <span class="label label-success">{{ $report->status }}</span>
                @endif

              </td>
 
              <td width="150">

            <div class="btn-group btn-group-xs">
                <a class="btn btn-primary" href="{{ route('admin.reportChecked', $report) }}">Checked</a>
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                  <span class="caret"></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                  <li><a onclick="return confirm('Do you really want to delete?');" class="w3-btn w3-round w3-red w3-small" href="{{ route('admin.reportDelete', $report) }}">Delete</a></li>
                   
                </ul>
              </div>
 
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
            </div>

            <div class="box-footer text-center">
              {{$reports->render()}}
            </div>
        </div>
        
      </div>        
      </div>
      <!-- /.row -->



    </section>
