<div class="box box-widget mb-1">
	<div class="box-body">
		SL: <b>{{ $loop->iteration }}</b>, &nbsp;
		Part Title: <b> {{ $item->title }}</b>, &nbsp; 
		 
		Active: <b>{{ $page->active ? 'Yes' : 'No' }}</b>,
		 

 
		<div class="pull-right">
		<a class="w3-btn w3-blue btn btn-xs " href="{{ route('admin.pageItemEdit', $item) }}">Edit Part</a>
		&nbsp; 
 
		<a class="w3-btn w3-red btn btn-xs " onclick="return confirm('Do you really want to delete?');" href="{{ route('admin.pageItemDelete', $item) }}">Delete Part</a>
		</div>
	</div>
</div>