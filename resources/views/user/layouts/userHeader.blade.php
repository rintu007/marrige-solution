
<nav class="navbar   fixed-top  navbar-expand-lg bg-bg bg-danger" color-on-scroll="100" id="sectionsNav">


    
        <div class="container" id="no-ads">
            <div class="navbar-translate">
                <a 
                title="" 
                rel="tooltip" 
                data-placement="bottom" 
                class="navbar-brand" 
                data-original-title="{{ env('APP_NAME_BIG') }}" 
                href="{{url('/')}}">
                <img class="img-responsive img-thumbnail" src="{{ asset($websiteParameter->logo ? 'storage/logo/'.$websiteParameter->logo : 'img/logo.jpg') }}" alt="{{ env('APP_NAME_BIG') }}" style="width: 213px;border-radius: 4px;margin-top: -19px;">
                </a>

            @if (!Browser::isDesktop())

                <a  href="{{ route('user.myNotifications') }}" >
            <span class="w3-large w3-text-white">

                @if(Auth::user()->touchMains())
             <i class="material-icons w3-xlarge">notifications_active</i> 
         <span style="margin-left: -10px;" class="badge ntfy-badge badge-default w3-card w3-white text-red ">{{ Auth::user()->touchMains() }}</span>
         @else
         <i class="material-icons w3-xlarge">notifications_none</i> 
         @endif
     </span>
        </a>

        <a  href="{{ route('userMessageDashboard') }}" >
            <span class="w3-large w3-text-white">
                @if(Auth::user()->touchMsg())
             <i class="material-icons w3-xlarge">message</i> 
         <span style="margin-left: -10px;" class="badge ntfy-badge badge-default w3-card w3-white text-red ">{{ Auth::user()->touchMsg() }}</span> 
         @else
         <i class="material-icons w3-xlarge">chat_bubble_outline</i> 
         @endif
     </span>
        </a>

        @endif

                <button class="navbar-toggler" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    <span class="navbar-toggler-icon"></span>
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>


            <div class="collapse navbar-collapse">


                <ul class="navbar-nav ml-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="tel:+{{ bdMobile(env('CONTACT_MOBILE1')) }}" >
                            <span class="w3-large">
                             <i class="material-icons">local_phone</i> 
                         +{{ bdMobile(env('CONTACT_MOBILE1')) }}</span>
                        </a>
                    </li>

                    @if (Browser::isDesktop())
                    
                    
                    {{-- <li class="nav-item ">
                        <a class="nav-link" href="{{ route('user.myNotifications') }}" >
                            @if(Auth::user()->touchMains())
                            <span class="w3-large">
                             <i class="material-icons w3-xlarge">notifications_active</i> 
                         <span style="margin-left: -10px;" class="badge ntfy-badge badge-default w3-white w3-card text-red ">{{ Auth::user()->touchMains() }}</span></span>
                         @else
                         <i class="material-icons w3-xlarge">notifications_none</i> 
                         @endif
                        </a>
                    </li> --}}



                    @endif
                    {{-- 


                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0)" >
                            <i class="material-icons">view_module
</i> Gallery
                        </a>
                    </li> --}}

                    


                    @if (Browser::isDesktop())

                    {{-- <li class="nav-item">
                        <a class="nav-link" href="https://www.taslimamarriagemedia.com/diary/" >
                             <img src="{{ asset('img/book.svg') }}" alt="{{ env('APP_NAME_BIG') }}" width="27"> Blog
                        </a>
                    </li> --}}
                    
                    @else                    
                    @include('user.includes.others.myLeftMobileMenu')
                    @endif

                    @include('welcome.includes.others.pageLinkList')
                    
                    @if (Browser::isDesktop())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('welcome.successProfiles') }}" >
                            <i class="material-icons">contact_phone</i> Stories
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link"  href="{{ route('userMessageDashboard') }}" >
            <span class="">
                @if(Auth::user()->touchMsg())
             <i class="material-icons ">message</i> 
         <span style="margin-left: -10px;" class="badge ntfy-badge badge-default w3-card w3-white text-red ">{{ Auth::user()->touchMsg() }}</span>
         @else
         <i class="material-icons ">chat_bubble_outline</i> Message
         @endif
     </span>
        </a>
                    </li>

                    @endif



 

                    <li class="dropdown nav-item">

                         

                        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                            <i class="material-icons">apps</i> {{str_limit(Auth::user()->email, 15,'..')}}
                        </a>
                        <div class="dropdown-menu dropdown-with-icons">


                            @if(Auth::user()->isAdmin())
                                <a href="{{route('admin.dashboard')}}" class="dropdown-item ">
                                <i class="material-icons">layers</i> Admin Dashboard
                                </a>
                            @endif

                            @if(Auth::user()->isBlogAdmin())
                                <a href="{{route('blogAdmin.dashboard')}}" class="dropdown-item">
                                <i class="material-icons">layers</i> Blog Admin Dashboard
                                </a>
                            @endif

                            

                            <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                                <i class="material-icons">content_paste</i> Logout
                            </a>


 

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
                </form>
                        </div>

                         
                        
                    </li>

                    {{-- @include('welcome.includes.others.userSearchLinkList') --}}


                    



                    {{-- <li class="dropdown nav-item">
                        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                            <i class="material-icons">settings</i> Settings
                        </a>
                        <div class="dropdown-menu dropdown-with-icons">
                            <a href="{{route('welcome.username',$u->username)}}" class="dropdown-item">
                                <i class="material-icons">layers</i> View Profile
                            </a>

                            <a href="{{route('user.settings','edit_my_profile')}}" class="dropdown-item">
                                <i class="material-icons">layers</i> Edit my profile
                            </a>

                            
                            <a href="{{route('user.settings', 'edit_personal_info_for_office')}}" class="dropdown-item">
                                <i class="material-icons">layers</i> Edit Personal Information
                            </a>

                            <a href="{{route('user.myProfile')}}" class="dropdown-item">
                                <i class="material-icons">photo_library</i> Edit my Photos
                            </a>

                            <a href="{{route('user.allRelatedUsers', 'favourite')}}" class="dropdown-item">
                                <i class="material-icons">account_circle</i> My Favourite Users
                            </a>

                            <a href="{{route('user.allRelatedUsers', 'block')}}" class="dropdown-item">
                                <i class="material-icons">account_circle</i> My Blocked Users
                            </a>

                             

                            <a href="{{route('user.settings', 'change_password')}}" class="dropdown-item">
                                <i class="material-icons">account_circle</i> Change Password
                            </a>

                            <a href="{{route('user.settings', 'change_email')}}" class="dropdown-item">
                                <i class="material-icons">account_circle</i> Change Email
                            </a>

                            <a href="{{route('user.settings', 'change_contact')}}" class="dropdown-item">
                                <i class="material-icons">account_circle</i> Update Contact Number
                            </a>

                             

                            <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                                <i class="material-icons">content_paste</i> Logout
                            </a>

                        </div>
                    </li> --}}

 
                    {{-- <li class="nav-item">
                        <a class="nav-link" rel="tooltip" title="" data-placement="bottom" href="javascript::void(0)" target="_blank" data-original-title="Follow us on Twitter">
                            <i class="fa fa-twitter"></i>
                        </a>
                    </li> --}}
                    {{-- <li class="nav-item">
                        <a class="nav-link" rel="tooltip" title="" data-placement="bottom" href="{{ url('https://www.facebook.com/taslimamediabd/') }}" target="_blank" data-original-title="Like us on Facebook">
                            <i class="fa fa-facebook-square"></i>
                        </a>
                    </li> --}}
                    @include('welcome.includes.others.socialLinkList')
                    {{-- <li class="nav-item">
                        <a class="nav-link" rel="tooltip" title="" data-placement="bottom" href="javascript::void(0)" target="_blank" data-original-title="Follow us on Instagram">
                            <i class="fa fa-instagram"></i>
                        </a>
                    </li> --}}

                </ul>

                

            </div>

        </div>





    </nav>