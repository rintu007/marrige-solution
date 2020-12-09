
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        {{-- <li class="header">MAIN NAVIGATION</li> --}}

        <li class=" treeview{{ session('lsbm') == 'dashboard' ? ' active ' : '' }}">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ session('lsbsm') == 'dashboard' ? ' active ' : '' }}"><a href="{{route('editor.dashboard')}}"><i class="fa fa-circle-o"></i> Dashboard </a></li>

          </ul>
        </li>

        <li class=" treeview{{ session('lsbm') == 'posts' ? ' active ' : '' }}">
          <a href="#">
            <i class="fa fa-file-text"></i> <span>Posts</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ session('lsbsm') == 'postAddNew' ? ' active ' : '' }}"><a href="{{route('editor.postAddNew')}}"><i class="fa fa-circle-o"></i> Add New Post </a></li>

            <li class="{{ session('lsbsm') == 'postsAll' ? ' active ' : '' }}"><a href="{{route('editor.postsAll')}}"><i class="fa fa-circle-o"></i> Posts All </a></li>
          </ul>
        </li>

        <li class=" treeview{{ session('lsbm') == 'media' ? ' active ' : '' }}">
          <a href="#">
            <i class="fa fa-upload"></i> <span>Media</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ session('lsbsm') == 'mediaAll' ? ' active ' : '' }}"><a href="{{route('editor.mediaAll')}}"><i class="fa fa-circle-o"></i> Media All </a></li>

          </ul>
        </li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>