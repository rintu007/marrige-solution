<div class="box box-widget mb-1">
	<div class="box-body">
		Page ID: <b>{{ $page->id }}</b>, &nbsp;

		Page Title: <b> {{ $page->page_title }}</b>, &nbsp; 
		Route Name: <b> {{ $page->route_name }}</b>, &nbsp;
		Active: <b>{{ $page->active ? 'Yes' : 'No' }}</b>,
		Left Sidebar: <b>{{ $page->left_sidebar ? 'Yes' : 'No' }}</b>,
		List In Menu: <b>{{ $page->list_in_menu ? 'Yes' : 'No' }}</b>,
		Title Hide: <b>{{ $page->title_hide ? 'Yes' : 'No' }}</b>,

    Parts: <b> <span class="label {{ $page->items()->whereActive(true)->count() ? 'label-success' : 'label-danger' }} ">
    	{{ $page->items()->whereActive(true)->count() }}
    		</span> </b>

		<div class="pull-right">
			<a class="btn w3-btn btn-xs w3-blue" target="_blank" href="{{ route('page',$page->route_name) }}">Preview</a> &nbsp;
		<a class="w3-btn w3-blue btn btn-xs " href="{{ route('admin.pageEdit', $page) }}">Edit</a>
		&nbsp; 
		<a class="w3-btn w3-blue btn btn-xs " href="{{ route('admin.pageItems', $page) }}">Add Page Part</a>
		&nbsp; 
		<a class="w3-btn w3-red btn btn-xs " onclick="return confirm('Do you really want to delete?');" href="{{ route('admin.pageDelete', $page) }}">Delete</a>
		</div>
	</div>
</div>