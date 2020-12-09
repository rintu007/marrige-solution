<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Mail;
use Carbon\Carbon;
use App\Model\User;
use App\Model\Page;
use App\Model\AdSpace;
use App\Model\Upazila;
use App\Model\Country;
use App\Model\Division;
use App\Model\District;
use App\Model\AboutPost;
use App\Model\AuthorPost;
use App\Model\FrontSlider;
use App\Model\ServicePost;
use App\Model\PostDivision;
use App\Model\PostCategory;
use App\Model\PostDistrict;
use App\Model\Blog as Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Model\BlogTag as Tag;
use App\Model\SuccessProfile;
use App\Model\UserContactInfo;
use App\Model\UsersForAutoMail;
use App\Model\MembershipPackage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Model\BlogCategory as Category;

class WelcomeController extends Controller
{
    public function __construct()
    {
      $this->middleware('userupdate');
    }

    protected $minutes = 10;
    public function cookieResponse($response,$request)
    {
        return $response
        ->withCookie(cookie('m_v', time().'-'.str_random(3).' browser: '.$_SERVER['HTTP_USER_AGENT'].' ip: '.$request->ip(), 60 * 24));
    }


    public function testMail(Request $request)
    {
      if(env('APP_ENV') == 'production')
      {

        if(Auth::check() and Auth::isAdmin())
        {
            Mail::send('emails.email', [], function ($message) {
              $message->from('mail@matchinglifebd.com', url('/'));
              $message->to('masudbdm@gmail.com', url('/'))
              ->subject('Project Mail Testing... '.url('/'));
          });
        }
        
        

      }


      return back()->with('success', 'Mail Testing Successful');
    }

    public function searchCustomUsers()
    {
      // dd(Auth::user()->searchTerm);
      $searchTerm = Auth::user()->searchTerm;
      $now = Carbon::now();
      $minAgeDate = $now->SubYear($searchTerm->min_age)->toDateString();
      $maxAgeDate = $now->SubYear($searchTerm->max_age)->toDateString();
      // dd($searchTerm->user_status);
 
      

      $users = User::whereDoesntHave('blockerOf',function($query){
                $query->where('user_id', Auth::id());
            })
        ->whereDoesntHave('blockss', function($qq){
            $qq->where('user_second_id', Auth::id());
        })
      ->where('dob', '<=', $minAgeDate)
      ->where('dob', '>=', $maxAgeDate)
      // ->where('gender', $searchTerm->gender)
      ->where('gender', Auth::user()->oltGender())
      ->where('country', 'like' ,"%".$searchTerm->country."%")
      // ->where('country_other', 'like', "%".$searchTerm->country_other."%")
      ->where('location', 'like', "%".$searchTerm->location."%")
      ->where(function ($query) use ($searchTerm) {
                $query->orWhere('country_other', 'like', "%".$searchTerm->country_other."%")
                      ->orWhereNull('country_other');
            })
      ->where(function ($query) use ($searchTerm)
      {
        if ($searchTerm->user_status == 'Online') 
        {
          $query->where('updated_at', '>', Carbon::now()->subMinutes(4));
        } elseif ( $searchTerm->user_status == 'New')  {

          //one month old users are considered as new
          $query->where('created_at', '>', Carbon::now()->subDays(29));
        }

        elseif ( $searchTerm->user_status == 'With Picture')  
        {

          //one month old users are considered as new
          $query->whereHas('userPictures', function ($q) {
              $q->where('image_type', 'profilepic');
          });
        }

        elseif ( $searchTerm->user_status == 'Premium') 
        {
          // $query->where('expired_at', '>=', Carbon::now()); 
          $query->whereDate('expired_at', '>=', date('Y-m-d'));
        }


          
      })
      ->orderBy('updated_at', 'desc')
      ->paginate(24);

      return $users;
    }

  public function automail(Request $request)
  {
            if (Auth::check()) 
            {
                $uam = UsersForAutoMail::whereDoesntHave('items', function ($query) {
                    $query->where('created_at', '>', Carbon::now()->subDays(30));
                })
                // ->has('user')
                ->whereHas('user', function ($query) {
                    $query->where('active', 1);
                    $query->whereNotNull('img_name');
                    $query->where('user_type', 'online');
                })
                ->where('type', 'match')
                ->where('subscribed', 1)
                // ->first();
                ->limit(30)
                ->get();
                // if ($uam) 
                // {
                //     $uam->user->automailSend($uam);
                // }

                foreach($uam as $uu)
                {
                    $uu->user->automailSend($uu);
                }
            }







    // if (senderMails() == 'mail@matchinglifebd.com') 
    // {
      //for automail start
        // $date = Carbon::now()->subDays(10)->toDateString(); //for 9 day old data
        //         $start = $date.' 00:00:00';
        //         $end = $date.' 23:59:59';

        //         // sleep(rand(1,40)); //sleep 10 seconds

        //     $logs = UsersForAutoMail::has('user')->where('subscribed', 1)
        //             // ->where('updated_at', '>=', $date.' 00:00:00')
        //             // ->where('updated_at', '<=', $end)
        //             // ->whereBetween('updated_at',[$start,$end])
        //             // ->first();
        //             ->whereDate('updated_at', '<', $date)
        //             ->limit(2)
        //             ->lockForUpdate()
        //             ->get();



        //       foreach ($logs as $log) {
                
        //             $user = $log->user;
        //             $user->automailSend($log);
        //       }

        //for automail end
    // }
    

        if($request->ajax())
        {
            return Response()->json(['success' => true]);
        }

        return back();
  }

   public function welcome(Request $request)
   {
   
    $frontPages = Cache::remember('frontPages', 518400, function () {
                return Page::where('active', true)->get();
            });

      if (Auth::check()) {

        $me = Auth::user();

        if(!$me->uploadedPP())
        {
          return redirect()->route('user.myPhotoUpload')->with('success', ' Hello! '. $me->name .' your login password have been sent to your phone number and email address. '.'The first part of your registration process is successfully completed. Please, update your other informations and profile picture.');
        }        

        return view('welcome.welcome', [
          'frontPages'=>$frontPages,
          'me'=>$me
        ]);

        
      }
      

      // $users = User::inRandomOrder()->paginate(24);
   		// $users = User::orderBy('updated_at', 'desc')->paginate(48);
        // $sliders = FrontSlider::all();

      $sliders = Cache::remember('frontSliders', 518400, function () {
                return FrontSlider::all();
            });


      $mPackage1 = Cache::remember('mPackage1', 518400, function () {
            return MembershipPackage::whereIn('id', ['1','2','3','4'])->get();
        });

      // $mPackage2 = Cache::remember('mPackage2', 518400, function () {
      //       return MembershipPackage::whereIn('id', ['5','6','7','8'])->get();
      //   });
        
        // $stories = SuccessProfile::latest()->paginate(6);

        // $stories = Cache::remember('frontStories', 518400, function () {
        //         return SuccessProfile::latest()->paginate(2);
        //     });

        // $aboutPosts = Cache::remember('aboutPosts', 518400, function () {
        //         return AboutPost::where('active', true)->latest()->paginate(2);
        //     });


        // $servicePosts = Cache::remember('servicePosts', 518400, function () {
        //         return ServicePost::where('active', true)->latest()->paginate(4);
        //     });

      $districts = Cache::remember('districts', 518400, function () {
                return District::select(['name'])->orderBy('name')->get();
            });

      $countries = Cache::remember('countries', 518400, function () {
                    return Country::select('name as title')->get();
                });


        $randomPosts = Post::where('publish_status','published')
                    ->where('feature_img_name', '<>', null)
                    ->inRandomOrder()
                    ->take(3)
                    ->get();

        // $welData = Page::whereId(10)->first();


        

      // return view('welcome.welcome',[
   		// return view('welcome.wp.home',[
      // return view('welcome.wc',[
      //       'districts'=>$districts,
      //       // 'users'=>$users,
      //       'sliders'=>$sliders,
      //       // 'stories'=>$stories,
      //       'mPackage1'=>$mPackage1,
      //       // 'mPackage2'=>$mPackage2,
      //       'frontPages'=>$frontPages,
      //       // 'aboutPosts' =>$aboutPosts,
      //       'randomPosts' =>$randomPosts,
      //       // 'servicePosts' =>$servicePosts,
      //       // 'welcomeData' => $welData,
      //       'brides' => User::where('gender', 'Female')->paginate(2),
      //      'grooms' => User::where('gender', 'Male')->paginate(2),
      //      'profiles' => User::inRandomOrder()->limit(10)->get(),
      //      'countries' => $countries

      //   ]);
      $stories = SuccessProfile::orderBy("id", "asc")->limit(3)->get();
      
      return view('bgbd.front.home-public',[
      'stories'=> $stories]);
      // return view('bgbd.front.home-public');
   }

 // 'brides' => User::where('img_name', '<>', null)->where('gender', 'Female')->inRandomOrder()->limit(2)->get(),
 //        'grooms' => User::where('img_name', '<>', null)->where('gender', 'Male')->inRandomOrder()->limit(2)->get(),

// paginations for grooms



// function fetch_data(Request $request)
//     {
//      if($request->ajax())
//      {
//       $grooms = User::where('gender', 'Male')->paginate(2);
//       return view('welcome.welcomeNew', compact('grooms'))->render();
//      }
//     }



   public function pages(Request $request)
   {
      if(view()->exists('welcome.wp.'.$request->page_view))
      {
        if($request->page_view == 'story')
        { 
             $stories = SuccessProfile::latest()->paginate(10);

              return view('welcome.wp.'.$request->page_view, ['stories'=> $stories]);
        }
        elseif($request->page_view == 'about_us')
        {
          $aboutPosts = AboutPost::where('active', true)->latest()->paginate(6);

          $authorPosts = AuthorPost::where('active', true)->paginate(12);

          return view('welcome.wp.'.$request->page_view, ['aboutPosts'=> $aboutPosts, 'authorPosts' => $authorPosts]);
        }
        else
        {

          $mPackage1 = Cache::remember('mPackage1', 518400, function () {
            return MembershipPackage::whereIn('id', ['1','2','3','4'])->get();
            });

            $mPackage2 = Cache::remember('mPackage2', 518400, function () {
            return MembershipPackage::whereIn('id', ['5','6','7','8'])->get();
        });

          return view('welcome.wp.'.$request->page_view,[
            'mPackage1'=> $mPackage1, 
            'mPackage2'=> $mPackage2
          ]);
        }
      }
      abort(404);     
   }

   

   public function components()
   {
   		return view('welcome.components', ['u'=>Auth::user()]);
   }

   	public function test(Request $request)
    {

	   	if (View::exists("welcome.testViews.{$request->view}")) 
	   	{
	    
	    	return view("welcome.testViews.{$request->view}");
  		}
  		else
  		{
  			return view('welcome.testViews.1');
  		}
	  }

	public function username(Request $request)
	{
    $frontPages = Cache::remember('frontPages', 518400, function () {
                return Page::where('active', true)->get();
            });
    if(Auth::check())
    {
      if(Auth::user()->isAdmin())
      {
        $user = User::withoutGlobalScopes()->where('username', $request->username)->first();
        if($user)
        {
          return view('welcome.userDetails',[
            'user'=>$user,
            'frontPages'=>$frontPages
          ]);
        }
        abort('404');
      }

      $user = User::where('username', $request->username) 
      ->whereDoesntHave('blockerOf',function($query){
                $query->where('user_id', Auth::id());
            })
        ->whereDoesntHave('blockss', function($qq){
            $qq->where('user_second_id', Auth::id());
        })
        ->whereHas('userPictures', function ($query) {
            $query->where('image_type', 'profilepic');
            $query->where('checked', true);
          })
        ->first();
    }
    else
    {
      $user = User::where('username', $request->username)
      ->whereHas('userPictures', function ($query) {
            $query->where('image_type', 'profilepic');
            $query->where('checked', true);
          })
      ->first();
    }
		
		if($user)
		{
      if (Auth::check()) {
          $v = $user->iAmVisitedBy(Auth::user());  
             
      }

			return view('welcome.userDetails',[
        'user'=>$user,
        'frontPages'=>$frontPages
      ]);
		}
		abort('404');
	}

	public function search(Request $request)
	{

    if (Auth::check()) {
      if (! Auth::user()->searchTerm) {
        Auth::user()->searchTerm()->create(['addedby_id' => Auth::id()]);
      }
    }

		$v = $request->view ?: 'searchAll';

    if ($v == 'searchPhoto') 
    {
      if (Auth::check()) 
        {
           


          $users = User::whereHas('userPictures', function ($query) {
            $query->where('image_type', 'profilepic');
          })
          ->whereDoesntHave('blockerOf',function($query){
                $query->where('user_id', Auth::id());
            })
        ->whereDoesntHave('blockss', function($qq){
            $qq->where('user_second_id', Auth::id());
        })
          ->where('gender', Auth::user()->oltGender())
          ->orderBy('updated_at', 'desc')->paginate(24);
        }
        else 
        {
          $users = User::whereHas('userPictures', function ($query) {
              $query->where('image_type', 'profilepic');
          })->orderBy('updated_at', 'desc')->paginate(24);
        }  
    }

    elseif ($v == 'searchProfession') {

      $request->session()->flash('uSearch','searchProfession');

      if (Auth::check()) {
 

        $users = User::whereHas('educationWork')
        ->whereDoesntHave('blockerOf',function($query){
                $query->where('user_id', Auth::id());
            })
        ->whereDoesntHave('blockss', function($qq){
            $qq->where('user_second_id', Auth::id());
        })
        ->where('gender', Auth::user()->oltGender())
        ->orderBy('updated_at', 'desc')->paginate(24);
      }
      else{
        $users = User::whereHas('educationWork')->orderBy('updated_at', 'desc')->paginate(24);
      }

      
    }

    elseif ($v == 'searchCustom') {

      
    $users = $this->searchCustomUsers();
      
    }
    else{
 

      $users = Auth::check() ? User::whereDoesntHave('blockerOf',function($query){
                $query->where('user_id', Auth::id());
            })
        ->whereDoesntHave('blockss', function($qq){
            $qq->where('user_second_id', Auth::id());
        })
      // ->where('gender', Auth::user()->oltGender())
      ->orderBy('updated_at', 'desc')
      ->paginate(24) : User::orderBy('updated_at', 'desc')
      ->paginate(24);
    }

    if($request->ajax())
    {
        return Response()->json(View("user.searches.ajax.view.{$v}", [
          'u'=>Auth::user(),
          'users' => $users
        ])->render());
    }



		
		return view('user.searches.search', [
			'v' => $v,
			'u' => Auth::user(),
			'users'=> $users,
		]);
	}

  

	public function searchZone(Request $request)
    {
    	$v = $request->partView;

    	if ($v == 'searchPhoto') {
        
        if (Auth::check()) 
        {

          $users = User::whereHas('userPictures', function ($query) {
            $query->where('image_type', 'profilepic');
          })
          ->whereDoesntHave('blockerOf',function($query){
                $query->where('user_id', Auth::id());
            })
        ->whereDoesntHave('blockss', function($qq){
            $qq->where('user_second_id', Auth::id());
        })
          ->where('gender', Auth::user()->oltGender())
          ->orderBy('updated_at', 'desc')->paginate(24);
        }
        else 
        {
          $users = User::whereHas('userPictures', function ($query) {
              $query->where('image_type', 'profilepic');
          })->orderBy('updated_at', 'desc')->paginate(24);

        }        
      }

      elseif ($v == 'searchProfession') {
        
        if (Auth::check()) {

          $users = User::whereHas('educationWork')
          ->whereDoesntHave('blockerOf',function($query){
                $query->where('user_id', Auth::id());
            })
        ->whereDoesntHave('blockss', function($qq){
            $qq->where('user_second_id', Auth::id());
        })
          ->where('gender', Auth::user()->oltGender())
          ->orderBy('updated_at', 'desc')->paginate(24);
        }
        else{
          $users = User::whereHas('educationWork')->orderBy('updated_at', 'desc')->paginate(24);
        }

      }

      elseif ($v == 'searchCustom') {

      $users =  $this->searchCustomUsers();  
    }
      else{
        
        $users = Auth::check() ? User::whereDoesntHave('blockerOf',function($query){
                $query->where('user_id', Auth::id());
            })
        ->whereDoesntHave('blockss', function($qq){
            $qq->where('user_second_id', Auth::id());
        })
      ->where('gender', Auth::user()->oltGender())
      ->orderBy('updated_at', 'desc')
      ->paginate(24) : User::orderBy('updated_at', 'desc')
      ->paginate(24);

      }

        
    	
    	if($request->ajax())
        {
            return Response()->json(View("user.searches.ajax.view.{$v}", [
            	'u'=>Auth::user(),
            	'users' => $users
            ])->render());
        }
    }

    public function userSearchByProfessionAjax(Request $request)
    {
      $request->session()->flash('uSearch','searchProfession');

        if (Auth::check()) {
   

          $users = User::whereHas('educationWork', function ($query) use ($request) 
          {
              $query->where('my_profession', 'like', $request->q."%")
              ->orWhere('my_profession_other', 'like', $request->q."%");
          })
          ->whereDoesntHave('blockerOf',function($query){
                $query->where('user_id', Auth::id());
            })
        ->whereDoesntHave('blockss', function($qq){
            $qq->where('user_second_id', Auth::id());
        })
          ->where('gender', Auth::user()->oltGender())
          ->orderBy('updated_at', 'desc')->paginate(24);
        }
        else{
          $users = User::whereHas('educationWork', function ($qu) use ($request) 
          {
              $qu->where('my_profession', 'like', $request->q."%")
              ->orWhere('my_profession_other', 'like', $request->q."%");
          })->orderBy('updated_at', 'desc')->paginate(24);
        }
        $v = 'searchProfession';
        $users->withPath('/user/search-zone/searchProfession');

        if($request->ajax())
        {
            
            return Response()->json(View("user.searches.includes.searchedUsers", [
              'u'=>Auth::user(),
              'users' => $users
            ])->render());
        }
    }

    //page
    public function page($page, Request $request)
    {
        $page = Page::where('route_name', $page)
        ->where('active', true)->first();

        if($page){


          $mPackage1 = Cache::remember('mPackage1', 518400, function () {
            return MembershipPackage::whereIn('id', ['1','2','3','4'])->get();
        });

      $mPackage2 = Cache::remember('mPackage2', 518400, function () {
            return MembershipPackage::whereIn('id', ['5','6','7','8'])->get();
        });

      $frontPages = Cache::remember('frontPages', 518400, function () {
                return Page::where('active', true)->get();
            });



            return view('welcome.page',[
              'page' => $page,
              'mPackage1'=>$mPackage1,
              'mPackage2'=>$mPackage2,
              'frontPages'=>$frontPages
              ]);
            
        }
        else{
            abort(404);
        }
           
    }
    //page

    public function userAutomailListCreate(Request $request)
    {
      User::orderBy('id')->chunk(100, function ($users) 
      {
          foreach ($users as $user) 
          {
            $user->listForAutoMail()->firstOrCreate([]);
          }
      });

      return redirect('/masudbdm')->with('success', 'Auto Mail List Successfully Generated.');
    }

    public function copyUsers(Request $request)
    {
      // $users = DB::connection('mysql_old')->ta;

      DB::connection('mysql_old')->table('accounts')->orderBy('ac_id')->chunk(100, function ($users) 
      {
          foreach ($users as $user) 
          {
              $nu = User::where('email', $user->ac_email)->where('mobile', $user->ac_mobile)->first();
              if($nu)
              {

              }else
              {

                $dob = 0;
                $religion = null;
                $profile_created_by = 'Self';
                $living_country = null;
                $living_city = null;
                $home_district = null;
                $home_country = null;
                $about_me = null;
                $about_family = null;
                $father = null;
                $mother = null;
                $present_address = null;
                $permanent_address = null;
                $complexion = null;


                $profile = DB::connection('mysql_old')->table('profiles')->where('profile_id', $user->ac_id)->first();

                if ($profile) {

                  $dob = $profile->dob;
                  if($profile->religion == 1)
                  {
                    $religion = 'Muslim';
                  }elseif($profile->religion == 2)
                  {
                    $religion = 'Hindu';
                  }
                  elseif($profile->religion == 3)
                  {
                    $religion = 'Buddist';
                  }
                  elseif($profile->religion == 4)
                  {
                    $religion = 'Christian';
                  }
                  else
                  {
                    $religion = 'Others';
                  }

                  $living_country = $profile->living_country;
                  $living_city = $profile->living_city;
                  $home_district = $profile->home_district;
                  $home_country = $profile->home_country;
                  $about_me = $profile->about_me;
                  $about_family = $profile->about_family;
                  $father = $profile->father;
                  $mother = $profile->mother;
                  $present_address = $profile->address_details;
                  $permanent_address = $profile->permanent_address;
                  $complexion = $profile->complexion;

                }


                $pass = rand(100000, 999999);
                
                $uPass = $user->my_password;
                if($uPass)
                {
                  if(strlen($uPass) >= 6)
                  {
                    $pass = $user->my_password;
                  }
                }

                 $nu = new User;
                  $nu->name = $user->ac_name;
                  $nu->mobile = $user->ac_mobile;
                  $nu->guardian_mobile = $user->guardian_contact_number;
                  $nu->username = time().rand(99,999);
                  $nu->email = $user->ac_email;
                  $nu->password = Hash::make($pass);
                  $nu->password_temp = $pass;
                  $nu->gender = ($user->looking_for == 1) ? 'Male' : 'Female';
                  $nu->country = $living_country;
                  $nu->profile_created_by = 'Self';
                  $nu->religion = $religion;
                  $nu->social_order = null;
                  $nu->looking_for = ($user->looking_for == 1) ? 'Bride (Female)' : 'Groom (Male)';
                  $nu->dob = $dob;
                  $nu->created_at = $user->ac_created;
                  $nu->save();

                  $contactInfo = new UserContactInfo;
                  $contactInfo->user_id = $nu->id;
                  // $contactInfo->alternative_email = $user->alternative_email ?: null;
                  $contactInfo->alternative_mobile = $user->alternative_contact_number ?: null;
                  $contactInfo->name_of_contact_person = $user->guardian_name ?: null;
                  $contactInfo->present_address = $present_address ?: null;
                  $contactInfo->permanent_address = $permanent_address ?: null;
                  $contactInfo->about_me = $about_me ?: null;
                  $contactInfo->about_family = $about_family ?: null;
                  $contactInfo->save();
              }
          }
      });

      return redirect('/masudbdm')->with('success', 'Data Successfully Saved.');
    }

    public function copyPosts(Request $request)
    {
      DB::connection('mysql_old')->table('blog_posts')->orderBy('id')->chunk(100, function ($blogs) 
      {
          foreach ($blogs as $blog) 
          {
               
              $nb = new Post;
              $nb->title = $blog->post_title;
              $nb->description = $blog->post_content;
              $nb->excerpt = strip_tags(str_limit($blog->post_content, 70,''));
              $nb->tags = null;
              $nb->categories = null;
              $nb->read = 0;
              $nb->date = $blog->post_date;
              $nb->headline = 1;
              $nb->front_slider = 0;
              $nb->publish_status = 'published';
              $nb->addedby_id = Auth::id();
              $nb->editedby_id = null;
              $nb->created_at = $blog->post_date;
              $nb->save();
          }
      });

      return redirect('/masudbdm')->with('success', 'Data Successfully Saved.');
    }

    public function copyRegions()
    {

      // $divs = DB::connection('mysql_region')->table('divisions')->orderBy('id')->get();


      // foreach ($divs as $division) 
      // {
 
      //       $div = new Division;
      //       $div->name = $division->name;
      //       $div->bn_name = $division->bn_name;
      //       $div->save();

      //       foreach (DB::connection('mysql_region')->table('districts')->orderBy('id')->get() as $district) {

      //         $dis = District::where('division_id', $div->id)->first();
      //         if ($dis)
      //         {}
      //         else {

      //           $dis = new District;
      //           $dis->division_id = $div->id;
      //           $dis->name = $district->name;
      //           $dis->bn_name = $district->bn_name;
      //           $dis->lat = $district->lat;
      //           $dis->lon = $district->lon;
      //           $dis->website = $district->website;
      //           $dis->save();

      //           // foreach (DB::connection('mysql_region')->table('upazilas')->orderBy('id')->get() as $upazila) {

      //           //   $thana = Upazila::where('district_id', $dis->id)->first();
      //           //   if($thana)
      //           //   {}
      //           //   else
      //           //   { if($upazila->name != 'Others')
      //           //     {
      //           //       $thana = new Upazila;
      //           //       $thana->division_id = $div->id;
      //           //       $thana->district_id = $dis->id;
      //           //       $thana->name = $upazila->name;
      //           //       $thana->bn_name = $upazila->bn_name;
      //           //       $thana->save();
      //           //     }
                    
      //           //   }
                  
      //           // }
      //         }
      //     }
      //   }

      // DB::connection('mysql_region')->table('divisions')->orderBy('id')->chunk(100, function ($divs)
      // {
        
      // });

      // $divs = Division::orderBy('id')->get();
      // foreach($divs as $div)
      // {
      //   $districts = DB::connection('mysql_region')->table('districts')->where('division_id', $div->id)->orderBy('id')->get();

      //   foreach ($districts as $district) 
      //   {
      //     $dis = new District;
      //     $dis->division_id = $div->id;
      //     $dis->name = $district->name;
      //     $dis->bn_name = $district->bn_name;
      //     $dis->lat = $district->lat;
      //     $dis->lon = $district->lon;
      //     $dis->website = $district->website;
      //     $dis->save();
      //   }  
      // }

 
        // $upazilas = DB::connection('mysql_region')->table('upazilas')->get();
        // foreach ($upazilas as $upa) 
        // {
        //   if($upa->name != 'Others')
        //   {
        //     $dis = District::where('id', $upa->district_id)->first();
        //     $thana = new Upazila;
        //     $thana->division_id = $dis->division_id;
        //     $thana->district_id = $upa->district_id;
        //     $thana->name = $upa->name;
        //     $thana->bn_name = $upa->bn_name;
        //     $thana->save();
        //   }
        // }


 

      return redirect('/masudbdm')->with('success', 'Data Successfully Saved.');
    }


    // public function copyDist(Request $request)
    // {


    //   $districts = DB::connection('mysql_region')->table('districts')->orderBy('id')->get();

    //     foreach ($districts as $district) 
    //     {
    //       $dis = new District;
    //       $dis->division_id = $district->division_id;
    //       $dis->name = $district->name;
    //       $dis->bn_name = $district->bn_name;
    //       $dis->lat = $district->lat;
    //       $dis->lon = $district->lon;
    //       $dis->website = $district->website;
    //       $dis->save();
    //     } 
 
    //   return redirect('/masudbdm')->with('success', 'Data Successfully Saved.');
    // }

    // public function copyThana(Request $request)
    // {


       

    //     $upazilas = DB::connection('mysql_region')->table('upazilas')->get();
    //     foreach ($upazilas as $upa) 
    //     {
    //       if($upa->name != 'Others')
    //       {
    //         $dis = District::where('id', $upa->district_id)->first();
    //         $thana = new Upazila;
    //         $thana->division_id = $dis->division_id;
    //         $thana->district_id = $dis->id;
    //         $thana->name = $upa->name;
    //         $thana->bn_name = $upa->bn_name;
    //         $thana->save();
    //       }
    //     }
 
    //   return redirect('/masudbdm')->with('success', 'Data Successfully Saved.');
    // }
 

    public function successStory(SuccessProfile $story)
    {

      $mPackage1 = Cache::remember('mPackage1', 518400, function () {
            return MembershipPackage::whereIn('id', ['1','2','3','4'])->get();
        });

      $mPackage2 = Cache::remember('mPackage2', 518400, function () {
            return MembershipPackage::whereIn('id', ['5','6','7','8'])->get();
        });

      $frontPages = Cache::remember('frontPages', 518400, function () {
                return Page::where('active', true)->get();
            });

      return view('welcome.successStory.storyDetails',[
        'story'=> $story,
        'mPackage1'=>$mPackage1,
        'mPackage2'=>$mPackage2,
        'frontPages'=>$frontPages
      ]);
    }

    public function successProfiles(Request $request)
    {

      $mPackage1 = Cache::remember('mPackage1', 518400, function () {
            return MembershipPackage::whereIn('id', ['1','2','3','4'])->get();
        });

      $mPackage2 = Cache::remember('mPackage2', 518400, function () {
            return MembershipPackage::whereIn('id', ['5','6','7','8'])->get();
        });

      $frontPages = Cache::remember('frontPages', 518400, function () {
                return Page::where('active', true)->get();
            });

      $stories = SuccessProfile::latest()->paginate(1);
      return view('welcome.successStory.successProfiles', [
        'stories' => $stories,
        'mPackage1'=>$mPackage1,
        'mPackage2'=>$mPackage2,
        'frontPages'=>$frontPages
      ]);
    }

    //tags //blog tags

    public function selectTagsOrAddNew(Request $request)
    {
        $tags = Tag::where('title', 'like', '%'.$request->q.'%')
        ->select(['title'])->take(30)->get();
        if($tags->count())
        {
            if ($request->ajax())
            {
                return $tags;
            }
        }
        else
        {
            if ($request->ajax())
            {
                return $tags;
            }
        }
    }
    //tags //blog tags

    //for blog start

    public function selectDistrictForPost(Request $request)
    {
      // dd($request->division);

        $districts = District::where('division_id', $request->division)
        ->where('name', 'like', '%'.$request->q.'%')
        ->select(['name as district'])
        ->get();


        // $to = District::where('division_id', 'like', $request->q.'%')
        // ->where('from', 'like', '%'.$request->from.'%')
        // ->groupBy('to')        
        // ->select(['to'])
        // ->take(30)
        // ->get();
        
        if($districts->count())
        {
            if ($request->ajax())
            {
                // return Response()->json(['items'=>$users]);
                return $districts;
            }
        }
        else
        {
            if ($request->ajax())
            {
                return $districts;
            }
        }
    }

    public function selectThanaForPost(Request $request)
    {
        $district = District::where('name',$request->district)->first();
        if($district)
        {
            $thanas = Upazila::where('district_id', $district->id)
            ->where('name', 'like', '%'.$request->q.'%')
            ->select(['name as thana'])
            ->get();
            
            if($thanas->count())
            {
                if ($request->ajax())
                {
                    return $thanas;
                }
            }
            else
            {
                if ($request->ajax())
                {
                    return $thanas;
                }
            }
        }
        
    }

    public function divSelected(Request $request)
    {

        if($request->ajax())
        {
            $div = Division::where('id', $request->q)->first();
            if($div)
            {
                return Response()->json(array(
                'success' => true,
                'datas' => $div->districts
                ));
            }
        }  
    }

    public function distSelected(Request $request)
    {
        if($request->ajax())
        {
            $dist = District::where('id', $request->q)->first();
            if($dist)
            {
                return Response()->json(array(
                'success' => true,
                'datas' => $dist->thanas
                ));
            }
        }  
    }


//post details check
    public function postDetailsCheck(Post $post, Request $request){

        if(Auth::check())
        {
            if($post->deletePermission())
            {
                $latestPosts = Post::where('publish_status','published')->latest()->paginate(5);
                $popularPosts = Post::where('publish_status','published')->orderBy('read','desc')->paginate(5);
                $headlines = Post::where('publish_status','published')->where('headline',true)->latest()->paginate(10);
                $catsAll = Category::whereHas('posts', function ($query) {
            $query->where('publish_status', 'published');
        })->get();
                return view('blog.postDetails',[
                    'post'=>$post,
                    'latestPosts'=>$latestPosts,
                    'popularPosts'=>$popularPosts,
                    'catsAll'=>$catsAll,
                    'headlines'=>$headlines,
                    'topAd'=>AdSpace::find(1),
                    'topOfDetails1'=>AdSpace::find(9),
                    'relatedPosts' => null
                ]);
            }
        }
 
        else{
            abort(403);
        }
        
    }
//post details check


    //post details
    public function postDetailsWithTitle( Request $request)
    {
      // dd($request->post);
      $post = Post::where('id', $request->post)->first();
      if(!$post)
      {
        abort(404);
      }
      else{

        if($post->publish_status == 'published')
        {
            $post->increment('read');

            $catIds = $post->blogCategories()->pluck('category_id');
            $postIds = PostCategory::whereIn('category_id', $catIds)->latest()->limit(100)->pluck('post_id');

            $relatedPosts = Post::where('publish_status','published')
                ->whereIn('id',$postIds)
                ->latest()
                ->paginate(12); 

            $latestPosts = Post::where('publish_status','published')->latest()->paginate(5);
            $popularPosts = Post::where('publish_status','published')->orderBy('read','desc')->paginate(5);
            $headlines = Post::where('publish_status','published')->where('headline',true)->latest()->paginate(10);
            $catsAll = Category::whereHas('posts', function ($query) {
            $query->where('publish_status', 'published');
        })->get();
            return view('blog.postDetails',[
                'post'=>$post,
                'latestPosts'=>$latestPosts,
                'popularPosts'=>$popularPosts,
                'catsAll'=>$catsAll,
                'headlines'=>$headlines,
                'topAd'=>AdSpace::find(1),
                'topOfDetails1'=>AdSpace::find(9),
                'relatedPosts'=>$relatedPosts
            ]);
        }
        else{
            abort(404);
        }
        
      }
    }

    public function postDetails(Post $post, Request $request){

        return redirect()->route('welcome.postDetailsWithTitle',['post'=>$post,'title' => new_slug($post->title)]);
        
    }


    // public function postDetails(Post $post, Request $request){

    //     if($post->publish_status == 'published')
    //     {
    //         $post->increment('read');

    //         $catIds = $post->blogCategories()->pluck('category_id');
    //         $postIds = PostCategory::whereIn('category_id', $catIds)->latest()->limit(100)->pluck('post_id');

    //         $relatedPosts = Post::where('publish_status','published')
    //             ->whereIn('id',$postIds)
    //             ->latest()
    //             ->paginate(12); 

    //         $latestPosts = Post::where('publish_status','published')->latest()->paginate(5);
    //         $popularPosts = Post::where('publish_status','published')->orderBy('read','desc')->paginate(5);
    //         $headlines = Post::where('publish_status','published')->where('headline',true)->latest()->paginate(10);
    //         $catsAll = Category::whereHas('posts', function ($query) {
    //         $query->where('publish_status', 'published');
    //     })->get();
    //         return view('blog.postDetails',[
    //             'post'=>$post,
    //             'latestPosts'=>$latestPosts,
    //             'popularPosts'=>$popularPosts,
    //             'catsAll'=>$catsAll,
    //             'headlines'=>$headlines,
    //             'topAd'=>AdSpace::find(1),
    //             'topOfDetails1'=>AdSpace::find(9),
    //             'relatedPosts'=>$relatedPosts
    //         ]);
    //     }
    //     else{
    //         abort(404);
    //     }
        
    // }


//post details



//category

    public function postCategory(Category $cat, Request $request)
    {
            $latestPosts = Post::where('publish_status','published')->latest()->paginate(5);
            $popularPosts = Post::where('publish_status','published')->orderBy('read','desc')->paginate(5);
            $headlines = Post::where('publish_status','published')->where('headline',true)->latest()->paginate(10);
            $catsAll = Category::whereHas('posts', function ($query) {
            $query->where('publish_status', 'published');
            })->get();
            // $catPostFirstRow = $cat->posts()->where('publish_status','published')->latest()->take(2)->get();
            $catPosts = $cat->posts()->where('publish_status','published')->latest()->paginate(15);
            return view('blog.postCategory',[
                'cate'=>$cat,
                'latestPosts'=>$latestPosts,
                'popularPosts'=>$popularPosts,
                'catsAll'=>$catsAll,
                'headlines'=>$headlines,
                'catPosts'=>$catPosts,
                'topAd'=>AdSpace::find(1),
                'topOfDetails1'=>AdSpace::find(9),
            ]);
    }
//category

//division //div
    public function postDivision(Request $request)
    {
        if($request->thana != null)
        {
            $data = Upazila::where('id',$request->thana)->first();
            if($data)
            {
                $thana = $data;
                $dist = $data->district;
                $div = $data->division;
            }


        }elseif($request->district != null)
        {
            $data = District::where('id',$request->district)->first();
            if($data)
            {
                $thana = null;
                $dist = $data;
                $div = $data->division;
            }

            
        }
        else
        {
            $data = Division::where('id',$request->div)->first();
            if($data)
            {
                $thana = null;
                $dist = null;
                $div = $data;
            }
        }
            
            
            if($data)
            {
                $latestPosts = Post::where('publish_status','published')->latest()->paginate(5);
                $popularPosts = Post::where('publish_status','published')->orderBy('read','desc')->paginate(5);
                $headlines = Post::where('publish_status','published')->where('headline',true)->latest()->paginate(10);
                $catsAll = Category::whereHas('posts', function ($query) {
                $query->where('publish_status', 'published');
            })->get();
                $divPosts = $data->posts()->where('publish_status','published')->latest()->paginate(12);

                $divsAll = Division::all();
                return view('blog.postDivision',[
                    'div'=>$div,
                    'thana'=>$thana,
                    'dist'=>$dist,
                    'latestPosts'=>$latestPosts,
                    'popularPosts'=>$popularPosts,
                    'catsAll'=>$catsAll,
                    'headlines'=>$headlines,
                    'divPosts'=>$divPosts,
                    'divs'=>$divsAll,
                    'topAd'=>AdSpace::find(1),
                    'topOfDetails1'=>AdSpace::find(9),
                ]);
            }
            else
            {
                abort(404);
            }
            
    }
//division //div


//blog
    public function blog(Request $request)
    {
        // $latestGallery = Cache::remember('img_gallery_latest', $this->minutes, function () {
        //     return ImageGallery::has('items')->where('publish_status','published')->latest()->first();
        // });


        // $galleries = Cache::remember('galleries', $this->minutes, function () {
        //     return ImageGallery::has('items')->where('publish_status','published')
        //     // ->whereNotIn('id',[$latestGallery->id])
        //     ->latest()->paginate(6);
        // });

        // $vgs = Cache::remember('video_galleries', $this->minutes, function () {
        //     return VideoGallery::where('publish_status','published')
        //             ->latest()->paginate(4);
        // });

        $latestPosts = Cache::remember('latest_posts', $this->minutes, function () {
            return Post::where('publish_status','published')->latest()->paginate(20);
        });

        // $randomPosts = Post::where('publish_status','published')
        //             ->inRandomOrder()
        //             ->take(7)
        //             ->get();

        $randomPosts = null;

        $popularPosts = Cache::remember('popular_posts', $this->minutes, function () {
            return Post::where('publish_status','published')->orderBy('read','desc')->paginate(20);
        });

        $headlines = Cache::remember('headlines', $this->minutes, function () {
            return Post::where('publish_status','published')->where('headline',true)->latest()->paginate(10);
        });

        $frontSliders = Cache::remember('front_slider', $this->minutes, function () {
            return Post::where('publish_status','published')->where('front_slider',true)->latest()->paginate(5);
        });

        $divs = Cache::remember('divisions', $this->minutes, function () {
            return Division::all();
        });

        $catsAll = Cache::remember('cats_all', $this->minutes, function () {
            return Category::whereHas('posts', function ($query) {
                $query->where('publish_status', 'published');
            })->get();
        });

        $divPosts = Cache::remember('div_posts', $this->minutes, function () {
            return Post::has('divisions')
                ->where('publish_status','published')
                ->latest()->paginate(8);
        });

        // $highlightPosts = Cache::remember('highlight_posts', $this->minutes, function () {
        //     return Post::where('publish_status','published')->where('highlight',true)->latest()->paginate(8);
        // });

        $highlightPosts = null;

        $latest = Post::where('publish_status','published')->orderBy('updated_at','desc')->first();
        $today = Carbon::now();
        $time = $latest->updated_at->diffForHumans();

        $crimeCat = Cache::remember('crime_cat', $this->minutes, function () {
            return Category::where('title', 'অপরাধ-ক্রাইম')->first();
        });

        $binodonCat = Cache::remember('crime_cat', $this->minutes, function () {
            return Category::where('title', 'বিনোদন ও সেলিব্রেটি')->first();
        });

        if($binodonCat){
            $crimePosts = $binodonCat->posts()->where('publish_status','published')->latest()->take(10)->get();
        }else{
            $binodonCat = array();
        }

        if($crimeCat){
            $crimePosts = $crimeCat->posts()->where('publish_status','published')->latest()->take(10)->get();
        }else{
            $crimePosts = array();
        }

        $adSpacesAll = Cache::remember('add_spaces_all', $this->minutes, function () {
            return AdSpace::all();
        });

        // $voteOfToday = Vote::whereDate('date', date('Y-m-d'))->first();
        // $cookie = $request->cookie('m_v');
        // if($cookie && $voteOfToday)
        // {
        //     $m_v = $voteOfToday->casts()->where('cookie',$cookie)->first();
        // }else{
        //     $m_v = null;
        // }

        $frontLeft1     = $adSpacesAll->find(2);
        $frontLeft2     = $adSpacesAll->find(3);
        $frontLeft3     = $adSpacesAll->find(4);
        $tvCode         = $adSpacesAll->find(5);
        $frontRight1    = $adSpacesAll->find(6);
        $frontRight2    = $adSpacesAll->find(8);
        $salahTime      = $adSpacesAll->find(7);


        

      $view =  view('blog.welcome', [
            'latestPosts'=>$latestPosts,
            'randomPosts'=>$randomPosts,
            'popularPosts'=>$popularPosts,
            'catsAll'=>$catsAll,
            'headlines'=>$headlines,
            'frontSliders'=>$frontSliders,
            'divs'=>$divs,
            'divPosts'=>$divPosts,
            'highlightPosts'=>$highlightPosts,
            'time'=>$time,
            'crimePosts'=>$crimePosts,
            'binodonCat'=>$binodonCat,
            'today'=>$today,
            // 'latestGallery'=>$latestGallery,
            // 'galleries' =>$galleries,
            // 'videoGalleries'=>$vgs,
            'topAd'=>$adSpacesAll->find(1),
            'frontLeft1'=>$frontLeft1,
            'frontLeft2'=>$frontLeft2,
            'frontLeft3'=>$frontLeft3,
            'tvCode'=>$tvCode,
            'frontRight1'=>$frontRight1,
            'frontRight2'=>$frontRight2,
            'salahTime'=>$salahTime,
            // 'voteOfToday'=> $voteOfToday,
            // 'm_v' =>$m_v,

      ]);

        $response = new Response($view);

        // if($cookie)
        // {
        //     return $response;
        // }
        // else{

            return $this->cookieResponse($response,$request);            
        // }
    }
//blog


    //search
    public function topSearch(Request $request)
    {
        $searchPosts = Post::where('title', 'like','%'.$request->q.'%')
        ->orWhere('tags', 'like','%'.$request->q.'%')
        ->orWhere('excerpt', 'like','%'.$request->q.'%')
        ->orWhere('description', 'like','%'.$request->q.'%')
        ->latest()
        ->paginate(30);
        // $latestGallery = ImageGallery::has('items')->where('publish_status','published')->latest()->first();
        // $galleries = ImageGallery::has('items')->where('publish_status','published')
        // ->whereNotIn('id',[$latestGallery->id])
        // ->latest()->paginate(6);
        $latestPosts = Post::where('publish_status','published')->latest()->paginate(20);
        $popularPosts = Post::where('publish_status','published')->orderBy('read','desc')->paginate(20);
        $headlines = Post::where('publish_status','published')->where('headline',true)->latest()->paginate(10);
        $frontSliders = Post::where('publish_status','published')->where('front_slider',true)->latest()->paginate(5);
        $divs = Division::all();
        $catsAll = Category::whereHas('posts', function ($query) {
            $query->where('publish_status', 'published');
        })->get();
        $divPosts = Post::has('divisions')->where('publish_status','published')->latest()->paginate(8);
        // $highlightPosts = Post::where('publish_status','published')->where('highlight',true)->latest()->paginate(8);
        $latest = Post::where('publish_status','published')->orderBy('updated_at','desc')->first();
        $today = Carbon::now();
        $time = $latest->updated_at->diffForHumans();
        // $crimeCat = Category::where('title', 'অপরাধ-ক্রাইম')->first();
        // if($crimeCat){
        //     $crimePosts = $crimeCat->posts()->where('publish_status','published')->latest()->take(10)->get();
        // }else{
        //     $crimePosts = array();
        // }

        $frontLeft1 = AdSpace::find(2);
        $frontLeft2 = AdSpace::find(3);
        $frontLeft3 = AdSpace::find(4);
        $tvCode = AdSpace::find(5);
        $frontRight1 = AdSpace::find(6);
        $frontRight2 = AdSpace::find(8);
        $salahTime = AdSpace::find(7);
        

        return view('blog.topSearch', [
            'latestPosts'=>$latestPosts,
            'popularPosts'=>$popularPosts,
            'catsAll'=>$catsAll,
            'headlines'=>$headlines,
            'frontSliders'=>$frontSliders,
            'divs'=>$divs,
            'divPosts'=>$divPosts,
            // 'highlightPosts'=>$highlightPosts,
            'time'=>$time,
            // 'crimePosts'=>$crimePosts,
            'today'=>$today,
            // 'latestGallery'=>$latestGallery,
            // 'galleries' =>$galleries,
            'frontLeft1'=>$frontLeft1,
            'frontLeft2'=>$frontLeft2,
            'frontLeft3'=>$frontLeft3,
            'tvCode'=>$tvCode,
            'frontRight1'=>$frontRight1,
            'frontRight2'=>$frontRight2,
            'salahTime'=>$salahTime,
            'searchPosts'=>$searchPosts,
            'topAd'=>AdSpace::find(1),
            'topOfDetails1'=>AdSpace::find(9),
            'q'=>$request->q
        ]);
    }
    //search

    //for blog end



    //new design start
    public function welcomeNew()
    {
      

    $frontPages = Cache::remember('frontPages', 518400, function () {
                return Page::where('active', true)->get();
            });

      
      

      // $users = User::inRandomOrder()->paginate(24);
      // $users = User::orderBy('updated_at', 'desc')->paginate(48);
        // $sliders = FrontSlider::all();

      $sliders = Cache::remember('frontSliders', 518400, function () {
                return FrontSlider::all();
            });


      $mPackage1 = Cache::remember('mPackage1', 518400, function () {
            return MembershipPackage::whereIn('id', ['1','2','3','4'])->get();
        });

      // $mPackage2 = Cache::remember('mPackage2', 518400, function () {
      //       return MembershipPackage::whereIn('id', ['5','6','7','8'])->get();
      //   });
        
        // $stories = SuccessProfile::latest()->paginate(6);

        $stories = Cache::remember('frontStories', 518400, function () {
                return SuccessProfile::latest()->paginate(2);
            });

        $aboutPosts = Cache::remember('aboutPosts', 518400, function () {
                return AboutPost::where('active', true)->latest()->paginate(2);
            });


        $servicePosts = Cache::remember('servicePosts', 518400, function () {
                return ServicePost::where('active', true)->latest()->paginate(4);
            });


        $randomPosts = Post::where('publish_status','published')
                    // ->where('feature_img_name', '<>', null)
                    ->inRandomOrder()
                    ->take(3)
                    ->get();

        $welData = Page::whereId(10)->first();


      return view('welcome.welcomeNew',[

        'sliders'=>$sliders,
        'stories'=>$stories,
        'mPackage1'=>$mPackage1,
        // 'mPackage2'=>$mPackage2,
        'frontPages'=>$frontPages,
        'aboutPosts' =>$aboutPosts,
        'randomPosts' =>$randomPosts,
        'servicePosts' =>$servicePosts,
        'welcomeData' => $welData,
        'brides' => User::where('img_name', '<>', null)->where('gender', 'Female')->inRandomOrder()->limit(2)->get(),
        'grooms' => User::where('img_name', '<>', null)->where('gender', 'Male')->inRandomOrder()->limit(2)->get(),

      ]);
    }

    public function membershipPackages()
    {
      return view('welcome.membershipPackages');
    }
    //new design end

    public function secondMarrige()
    {
      // dd('hello');
      $data['title'] = "Second marriage matrimony| Remarriage| Divorcee brides";
          return view('bgbd.front.second-marrige', $data);
    }

    public function aboutus()
    {
        $data['title'] = "Bridegroombd.com| Top Online Marriage Media| Patro-patri";
        $meta_tag = "Hello";

        return view('bgbd.front.about');
    }

    public function weddingservice()
    {
        $data['title'] = "Wedding Service";
        return view('bgbd.front.wedding_service', $data);
    }

    public function contactus()
    {
        $data['title'] = "Contact Us";
        return view('bgbd.front.contact', $data);
    }

    public function request()
    {
        $data['title'] = "Confidential matchmaking|100% privacy and confidentiality";
        return view('bgbd.front.request',$data);
    }

    public function featureDetails(User $user)
    {
      
      return view('bgbd.profile.public-profile', [
       'user' =>$user]);
    }

    public function feature_profile()
    {
      $users = User::Where('featured',true)->latest()
      ->paginate(12);
      return view('bgbd.front.feature-profile-public',[
        'users'=>$users
      ]);

    }

  // public function userAdvanceSearch(Request $request)
  // {
  //   // dd($request->all());
  //   $minimum_age = $request->minimum_age;
  //   $maximum_age = $request->maximum_age;

    
  //     // $minAgeDate = $now->SubYear($minimum_age)->toDateString();
  //     // $maxAgeDate = $now->SubYear($maximum_age)->toDateString();



  //        $users = User::withoutGlobalScopes()
  //       ->where('active', 1)
  //       // ->where('gender', $user->oltGender())
  //       ->where(function($q) use ($request){
  //           if($request->gender)
  //           {
  //               $q->where('gender', $request->gender);
  //           }

  //           // if($request->location)
  //           // {
  //           //     $q->where('location', $request->location);
  //           // }

  //           if($request->minimum_age and $request->maximum_age)
  //           {
  //             $start = Carbon::now()->SubYear($request->minimum_age)->toDateString();

  //             // dd($start);

  //             // dd($request->maximum_age);

  //             $end = Carbon::now()->SubYear($request->maximum_age)->toDateString();

  //             // dd($end); 
              
  //               // $q->whereDate('dob', '<');
  //               $q->whereBetween('dob',[$end,$start]);
  //             // $q->where('dob', '<', $start);
  //             // $q->where('dob', '<', $end);
  //           }
  //           elseif($request->minimum_age)
  //           {
  //               $minAgeDate = Carbon::now()->SubYear($request->minimum_age)->toDateString();

  //               // dd($minAgeDate);
                
  //               $q->where('dob', '<=', $minAgeDate);
  //               // $q->whereDate('dob','<', $minAgeDate);




  //           }

  //           elseif($request->maximum_age)
  //           {
  //               $maxAgeDate = Carbon::now()->SubYear($request->maximum_age + 1)->toDateString();
  //               $q->where('dob', '>=', $maxAgeDate);
  //               // $q->whereDate('dob','>', $maxAgeDate);

  //               // dd($maxAgeDate);
  //           }

  //           if( 
  //             $request->marital_status 
  //             or $request->religion 
  //             or $request->minimum_height 
  //             or $request->maximum_height 
  //             )
  //           {
  //               $q->whereHas('personalInfo', function ($query) use ($request) 
  //              {
  //                   if($request->religion)
  //                   {
  //                       $query->where('religion', $request->religion);
  //                   }

  //                   if($request->location)
  //                   {
  //                     $query->where('country_of_residence', $request->location);
  //                   }

  //                   if($request->marital_status)
  //                   {
  //                     // dd($request->marital_status);
  //                       $query->where('marital_status', $request->marital_status);
  //                   }

  //                   // if($request->minimum_height)
  //                   // {
  //                   //   $
  //                   //   // dd($request->minimum_height);
  //                   //     $query->where('height', '>=', $request->minimum_height);
  //                   // }

  //                   // if($request->maximum_height)
  //                   // {
  //                   //   // dd($request->maximum_height);
  //                   //     $query->where('height', '<=', $request->maximum_height);
  //                   // }
                    
  //               });
  //           }

  //           if( 
              
  //             $request->education_level 
  //             or $request->profession
              
  //             )
  //           {
  //               $q->whereHas('educationWork', function ($query) use ($request) 
  //              {
                   
  //                   if($request->education_level)
  //                   {
  //                       $query->where('education_level', $request->education_level);
  //                   } 

  //                   if($request->profession)
  //                   {
  //                       $query->where('my_profession', $request->profession);
  //                   }                    
  //               });


  //           }
  //       })
  //       // ->orderBy('id', $request->order_by)
  //       // ->limit($request->limit)
  //       // ->get();
  //       ->latest()
  //       ->paginate(24);



      
  //   return view('user.ajax.partViews.search_advance', [
  //     'v' => 'userAdvanceSearch',
  //     'users'=> $users,
  //     'minimum_age' => $minimum_age,
  //     'maximum_age' => $maximum_age,
  //     'gender' => $request->gender,
  //     'token' => $request->_token,
  //     'religion' => $request->religion,
  //     'marital_status' => $request->marital_status,
  //     'location' => $request->location,
  //     'education_level' => $request->education_level,
  //     'profession'=> $request->profession,
  //     'minimum_height' => $request->minimum_height,
  //     'maximum_height' => $request->maximum_height
  //   ]);
  // }


}
