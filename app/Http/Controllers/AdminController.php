<?php

namespace App\Http\Controllers;

use Auth;
use Mail;
use Hash;
use Validator;
use Carbon\Carbon;
use App\Model\Page;
use App\Model\User;
use App\Model\Media;
use App\Model\Report;
use App\Model\UserLog;
use App\Model\Upazila;
use App\Model\UserMail;
use App\Model\PageItem;
use App\Model\District;
use App\Model\Division;
use App\Model\UserRole;
use App\Model\UserPhoto;
use App\Model\UserAbout;
use App\Model\AboutPost;
use App\Model\AuthorPost;
use App\Model\ServicePost;
use App\Model\SmsContact;
use App\Model\SmsContactBulk;
use App\Model\QuickSmsContact;
use App\Model\SmsUploadedContact;
use App\Model\QuickSmsContactBulk;
use App\Events\SendEmailSmsToUsers;
use App\Model\SmsUploadedContactBulk;

use GuzzleHttp\Client;
use App\Model\UserPicture;
use App\Model\UserComment;
use App\Model\UserPayment;
use App\Model\FrontSlider;
use App\Model\UserProposal;
use App\Model\Blog as Post;
use App\Model\UserEducation;
use Illuminate\Http\Request;
use App\Model\SuccessProfile;
use App\Model\UserSettingItem;
use App\Model\UserContactInfo;
use App\Model\WebsiteParameter;
use App\Model\UserPersonalInfo;
use App\Model\UserSettingField;
use App\Model\UserInfoForOffice;
use App\Model\MembershipPackage;
use League\Flysystem\Filesystem;
use App\Model\UserPersonalActivity;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use App\Model\BlogCategory as Category;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Exception\GuzzleException;
use Intervention\Image\ImageManagerStatic as Image;

class AdminController extends Controller
{
    
    public function dashboard()
    {
        if(env('APP_ENV') != 'production')
        {
            //for online project
            // return back();
        }
    	$request = request();
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'dashboard','lsbsm'=>'dashboard']);

        $request->user()->update(['loggedin_at'=>Carbon::now()]);
        $request->user()->updateAdminDashboardData();


    	return view('admin.dashboard',[
            // 'all_u' => User::withoutGlobalScopes()->count(),
            // 'online_u'=>User::where('loggedin_at', '>=', Carbon::now()->subMinutes(4))->count(),


            // 'f_u' => User::where('gender', 'Female')
            // // ->where('package', '<=', 0)
            // ->where(function($s){
            //     $s->where('expired_at', '<', Carbon::now());
            //     $s->orWhereNull('expired_at');
            // })
            // ->count(),

            // 'm_u'=> User::where('gender', 'Male')
            // ->where(function($s){
            //     $s->where('expired_at', '<', Carbon::now());
            //     $s->orWhereNull('expired_at');
            // })
            // ->count(),


             

            // 'sub_u'=> User::where('expired_at', '<=', Carbon::now())->orWhereNull('expired_at')->count(),
            // 'd_p_u'=>User::whereIn('package', [4,8])
            // ->where('expired_at', '>=', Carbon::now())->count(),
            // 'd_u'=> User::whereIn('package', [3,7])
            // ->where('expired_at', '>=', Carbon::now())->count(),
            // 'g_p_u'=> User::whereIn('package', [2,6])
            // ->where('expired_at', '>=', Carbon::now())->count(),
            // 'g_u' => User::whereIn('package', [1,5])
            // ->where('expired_at', '>=', Carbon::now())->count(),
            // 'o_b_a_u'=> User::orderBy('dob', 'desc')->count(),
            // 'v_10_u'=> User::where('expired_at', '>=', Carbon::now())->where('expired_at', '<', Carbon::now()->addDays(10))->count(),
            // 'complain'=> Report::where('status', 'pending')->count(),
            // 'deac_u' => User::withoutGlobalScopes()
            // ->where('active', false)->count(),
            // 'pen_p_t'=>UserPayment::where('status', 'pending')
            // ->where('created_at', Carbon::today())->count(),

            // 'pen_p_t_m'=>UserPayment::where('status', 'pending')->whereYear('created_at', date('Y'))
            // ->whereMonth('created_at', date('m'))
            // ->count(),

            // 'paid_p_t'=>UserPayment::where('status', 'paid')
            // ->where('updated_at', Carbon::today())->count(),

            // 'paid_p_t_m'=>UserPayment::where('status', 'paid')->whereYear('updated_at', date('Y'))
            // ->whereMonth('updated_at', date('m'))
            // ->count(),

            // 'cv_new_pending' =>User::whereNotNull('file_name')->where('cv_checked', 0)->count(),
            // 'log_user_count' => User::withoutGlobalScopes()->has('logs')->count(),

            // 'logs_count' => UserLog::count(),

        ]);
    }

    public function userSettingList()
    {
    	$request = request();
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'website','lsbsm'=>'allUserSettingList']);
        $fields = UserSettingField::paginate(100);
    	return view('admin.userSettingList', ['fields'=>$fields]);
    }

    public function userSettingFieldAdd(Request $request)
    {
    	 $validation = Validator::make($request->all(),
        [ 

          'setting_field_name' => 'required|unique:user_setting_fields,title',

        ]);

        if($validation->fails())
        {
            return back()
            ->withErrors($validation)
            ->withInput()
            ->with('error', 'Something Went Worng!');
        }

        $field = new UserSettingField;
        $field->title = $request->setting_field_name;
        $field->addedby_id = Auth::id();
        $field->save();

        Cache::forget('userSettingFields');

        return back()->with('success', 'User setting field successfully created.');
    }

    public function userSettingFieldValue()
    {
        $request = request();
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'website','lsbsm'=>'userSettingFieldValue']);
        $fields = UserSettingField::with('values')->paginate(100);
        return view('admin.userSettingFieldValue', ['fields'=> $fields]);
    }

    public function userSettingFieldValueAddPost(Request $request)
    {
         $validation = Validator::make($request->all(),
        [ 

          'setting_field_name' => 'required',
          'setting_field_value' => 'required'

        ]);

        if($validation->fails())
        {
            return back()
            ->withErrors($validation)
            ->withInput()
            ->with('error', 'Something Went Worng!');
        }

        $f = trim($request->setting_field_name);
        $v = trim($request->setting_field_value);

        $field = UserSettingField::where('title', 'like', "{$f}%")->first();
        if ($field) {
            $value = new UserSettingItem;
            $value->title = $v;
            $value->field_id = $field->id;
            $value->addedby_id = Auth::id();
            $value->save();

            Cache::forget('userSettingFields');

            return back()->withInput()->with('success', 'User setting value successfully saved.');
        }
        return back()->withInput()->with('error', 'Please, select the setting name first.');
    }

    public function userSettingValueDelete(UserSettingItem $value, Request $request)
    {
        $value->delete();
        if($request->ajax())
        {
            return Response()->json(['success' => true]);
        }

        Cache::forget('userSettingFields');
        
        return back()->with('info','User Setting Value Successfully Deleted.');
    }

    public function userSettingValueEdit(UserSettingItem $value, Request $request)
    {
        if($request->ajax())
        {
            return Response()->json(View('admin.ajax.settingValueSingleTrEdit',[
                'value' => $value,
                'i'=>$request->i
            ])->render());
        }
    }

    public function UserSettingValueUpdate(UserSettingItem $value, Request $request)
    {

        $validation = Validator::make($request->all(),
        [ 
            // 'name'=> 'required|min:1|max:255|unique:user_setting_items,title,'.$value->id,
            'name'=> 'required|min:1|max:255',
        ]);
        if($validation->fails())
        {
            return Response()->json(View('admin.ajax.settingValueSingleTrTdAll',[
                'value' => $value,
                'i'=>$request->i
            ])->render());
        }

        $name = $request->name;
        $value_old_type = $value->title;
        $value->title = $name ?: $value_old_type;
        $value->editedby_id = Auth::id();
        $value->save();

        Cache::forget('userSettingFields');

        if($request->ajax())
        {
            return Response()->json(View('admin.ajax.settingValueSingleTrTdAll',[
                'value' => $value,
                'i'=>$request->i
            ])->render());
        }
    }


     //user //admin start

    public function selectNewRole(Request $request)
    { 
        $users = User::withoutGlobalScopes()->where('email', 'like', '%'.$request->q.'%')
        ->orWhere('username', 'like', '%'.$request->q.'%')
        ->orWhere('name', 'like', '%'.$request->q.'%')
        ->orWhere('mobile', 'like', '%'.$request->q.'%')
        ->select(['id','email'])->take(30)->get();
        if($users->count())
        {
            if ($request->ajax())
            {
                // return Response()->json(['items'=>$users]);
                return $users;
            }
        }
        else
        {
            if ($request->ajax())
            {
                return $users;
            }
        }
    }

    public function userSearchAjax(Request $request)
    {
         $users = User::withoutGlobalScopes()->where('email', 'like', $request->q)
        ->orWhere('username', 'like', $request->q)
        // ->orWhere('name', 'like', $request->q.'%')
        ->orWhere('mobile', 'like', '%'.$request->q)
        ->orWhere('id', 'like', $request->q)
        ->latest()
        ->take(40)
        ->get();

         
        if ($request->ajax())
        {
            return Response()->json(['page' => view('admin.users.ajax.usersTbody', ['usersAll'=> $users])->render()]);
        }


    }

    public function adminAddNewPost(Request $request)
    {
        $user = User::where('id', $request->email)->first();
        if($user)
        {
            if(!$user->isAdmin())
            {
                $user->roles()->create(['role_name'=>'admin','addedby_id'=>Auth::id()]);
                return back()->with('success', 'New Admin Successfully Created.');
            }
            else
            {
                return back()->with('error', 'This User Already Admin.');
            }            
        }
    }

    public function blogAdminAddNewPost(Request $request)
    {
        $user = User::where('id', $request->email)->first();
        if($user)
        {
            if(!$user->isBlogAdmin())
            {
                $user->roles()->create(['role_name'=>'blogAdmin','addedby_id'=>Auth::id()]);
                return back()->with('success', 'New Blog Admin Successfully Created.');
            }
            else
            {
                return back()->with('error', 'This User Already Blog Admin.');
            }            
        }
        abort(404);
    }

    public function adminsAll(Request $request)
    {
        $usersAll = UserRole::has('user')->where('role_name','admin')->latest()->paginate(20);
 
 
        

        request()->session()->forget(['lsbm','lsbsm']);
        request()->session()->put(['lsbm'=>'roles','lsbsm'=>'adminsAll']);
        return view('admin.adminsAll',[
            'usersAll'=> $usersAll
        ]);
    }

    public function blogAdminsAll(Request $request)
    {
        $usersAll = UserRole::has('user')->where('role_name','blogAdmin')->latest()->paginate(20);
 
        request()->session()->forget(['lsbm','lsbsm']);
        request()->session()->put(['lsbm'=>'roles','lsbsm'=>'blogAdminsAll']);
        return view('admin.blogAdminsAll',[
            'usersAll'=> $usersAll
        ]);
    }

    public function adminDelete(UserRole $role, Request $request)
    {
        if($role->user->id == Auth::id())
        {
            return back()->with('error', 'Your Admin Role can not be deleted by yourself.');
        }

        $role->delete();
        
        return back()->with('success', 'Admin Successfully Deleted.');

    }

    public function blogAdminDelete(UserRole $role, Request $request)
    {
        if($role->user->id == Auth::id())
        {
            return back()->with('error', 'Your blog admin role can not be deleted by yourself.');
        }

        $role->delete();
        
        return back()->with('success', 'Blog Admin Successfully Deleted.');

    }

    //user admin
    
    public function reportsAll(Request $request)
    {
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'report','lsbsm'=>'reportsAll']);
        $reports = Report::latest()->paginate(40);
        return view('admin.reportsAll',['reports'=>$reports]); 
    }

    public function reportDelete(Report $report)
    {
        $report->delete();
        return back()->with('success', 'Report successfully deleted.');
    }

    public function reportChecked(Report $report)
    {
        $report->status = 'checked';
        $report->editedby_id = Auth::id();
        $report->save();

        return back()->with('success', 'Report status successfully changed to checked');
    }

    public function frontSlidersAll(Request $request)
    {
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'website','lsbsm'=>'frontSlidersAll']);

        $sliders = FrontSlider::all();

        return view('admin.frontSlidersAll', ['sliders'=>$sliders]);

    }

    public function frontSliderAddNew(Request $request)
    {

        $validation = Validator::make($request->all(),
        [ 
            'image' => 'required|image|dimensions:min_with=1200,min_height=450'
        ]);
        if($validation->fails())
        {
             return back()
             ->withErrors($validation)
             ->withInput();
        }

        if($request->hasFile('image'))
        {

            $ffile = $request->image;
            $fimgExt = strtolower($ffile->getClientOriginalExtension());               
            $fimageNewName = str_random(8).time().'.'.$fimgExt;

            Storage::disk('upload')->put('slider/'.$fimageNewName, File::get($ffile));

            $sl = new FrontSlider;
            $sl->image_name = $fimageNewName;
            $sl->image_url = 'storage/slider/'.$fimageNewName;
            $sl->addedby_id = Auth::id();
            $sl->save();

            Cache::flush();

            return back()->with('success', 'New slider image successfully uploaded');
        }

        return back()->with('error', 'Sorry, Something went wrong');

    }

    public function frontSliderDelete(FrontSlider $slider, Request $request)
    {
        if($slider)
        {
            Storage::disk('upload')->delete('slider/'.$slider->image_name);
            $slider->delete();
            Cache::flush();
        }


        return back()->with('success', 'Front slider successfully deleted.');
        
    }

    //users 
    public function newUser(Request $request)
    {
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'users','lsbsm'=>'newUser']); 

        return view('admin.users.newUser');
    }

    public function newUserPost(Request $request)
    {
        $request->merge(array_map('trim', $request->all()));
        $validation = Validator::make($request->all(), [
           'fullName'=> 'required|min:4|max:20',
            // 'username' => 'required|string|min:4|max:20|unique:users,username',
            'email'=> 'required|email|max:30|unique:users,email',
            // 'password' => 'required|string|min:6|confirmed',
            'mobile'=> 'required|unique:users,mobile',
            'gender' => 'required',
 
            'day'=> 'required',
            'month'=> 'required',
            'year'=> 'required',
            'user_type' => 'required',
            'file' => 'required'
        ]);

        if($validation->fails())
        {
            return back()
            ->withErrors($validation)
            ->withInput()
            ->with('error', ' Try Again With correct Info');
        }

        $dob = $request->year.'-'.$request->month. '-' .$request->day;

 
 

        $pass = rand(100000, 999999);

        $un = User::latest()->value('id') + 1 . rand(100000, 999999);

                
        $user = new User;
        $user->name = $request->fullName;
        $user->mobile = $request->mobile;
        $user->username = $un;
        $user->user_type = $request->user_type;
        $user->email = $request->email;
        $user->password = Hash::make($pass);
        $user->password_temp = $pass;
        $user->gender = $request->gender;
         
        $user->dob = Date($dob);
        $user->addedby_id = Auth::id();
        $user->save();

        if($request->comment)
        {
            $comment = new UserComment;
            $comment->comment = $request->comment;
            $comment->user_id = $user->id;
            $comment->addedby_id = Auth::id();
            $comment->save();        
        }

 
        if($request->hasFile('file'))
        {
            $file = $request->file;
            $ext = $file->getClientOriginalExtension();

            $imageNewName = $user->id. '_cv_'. str_random(8).time().'.'.$ext;

            Storage::disk('upload')
            ->put('users/cv/'.$imageNewName, File::get($file));

            if($user->file_name)
            {
                Storage::disk('upload')->delete('users/cv/'.$user->file_name);
            }

            $user->file_name = $imageNewName;
            $user->file_ext = $ext;
            $user->cv_checked = 1;
            $user->save();
        }
  
        // $user->listForAutoMail()->firstOrCreate([]);

        // if(!(env('APP_ENV') == 'local'))
        // {
        //     $user->sendSmsToNewUserWithPassword();
             
        //     Mail::send('emails.welcomeNewUser', ['user'=>$user], function ($message) use ($user){
        //         $message->from('mail@matchinglifebd.com', 'Matching Life Support Section');
        //         $message->to($user->email,  '')
        //         ->subject('New Registration Successful at '.url('/'));
        //     });

        //     Mail::send('emails.welcomeNewUserToAdmin', ['user'=>$user], function ($message) use ($user){
        //         $message->from('mail@matchinglifebd.com', 'Matching Life Support Section');
        //         $message->to('info@matchinglifebd.com',  '')
        //         ->subject('New Registration Successful at '.url('/'));
        //     });
        // }

        return back()->with('success', 'New user successfully created.');
    }
    public function usersAll(Request $request)
    {
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'users','lsbsm'=>'usersAll']); 

        $usersAll = User::withoutGlobalScopes()->orderBy('id', 'desc')->paginate(50);

        return view('admin.users.usersAll',['usersAll'=>$usersAll]);
    }

        //users 
    public function usersGroup(Request $request)
    {
        $type = $request->type;
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'users','lsbsm'=>$type]);



        if ($type == 'profile_picture_pending') {
            $usersAll = User::whereHas('userPictures', function ($query) {
            $query->where('image_type', 'profilepic');
            $query->where('checked', false);
            $query->where('autoload', true);
          })
          ->latest()->paginate(50);            
        }

        elseif ($type == 'cv_new_pending') {

            $usersAll = User::whereNotNull('file_name')->where('cv_checked', 0)->latest()->paginate(50);            
        }
        elseif ($type == 'all_unchecked_users') {

            $usersAll = User::where('final_checked', false)

            ->whereDoesntHave('userPictures', function ($query) {
                $query->where('image_type', 'profilepic');
                $query->where('checked', true);
                // $query->where('autoload', true);
              })

            ->whereDoesntHave('personalInfo', function ($query) {
                $query->where('checked', true);
              })

            ->whereDoesntHave('personalActivity', function ($query) {
                $query->where('checked', true);
              })

            ->whereDoesntHave('contactInfo', function ($query) {
                $query->where('checked', true);
              })

            ->whereNull('expired_at')

            ->latest()->paginate(50);
        }

        elseif ($type == 'all_checked_users') {

            $usersAll = User::where('final_checked', true)
            ->orWhere('checked', true)
            ->orWhereNotNull('expired_at')

            ->orWhere(function($p){
                $p->whereHas('userPictures', function ($query) {
                $query->where('image_type', 'profilepic');
                $query->where('checked', true);
                // $query->where('autoload', true);
              });
            })

            ->orWhere(function($p){
                $p->whereHas('personalInfo', function ($query) {
                $query->where('checked', true);
              });
            })

            ->orWhere(function($p){
                $p->whereHas('personalActivity', function ($query) {
                $query->where('checked', true);
              });
            })

            ->orWhere(function($p){
                $p->whereHas('contactInfo', function ($query) {
                $query->where('checked', true);
              });
            })

            
            ->latest()->paginate(50);
        }

        elseif ($type == 'final_check_pending') {
            $usersAll = User::has('personalInfo')
            ->has('personalActivity')
            ->where('final_checked', false)
            ->latest()->paginate(50);
        }elseif($type== 'order_by_age'){
            $usersAll = User::orderBy('dob', 'desc')->paginate(50);
        }

        elseif ($type == 'active_users') {
            $usersAll = User::latest()->paginate(50);
        }elseif ($type == 'inactive_users') {
            $usersAll = User::withoutGlobalScopes()
            ->where('active', false)
            ->latest()->paginate(50);
        }elseif ($type == 'inactive_male_users') {
            $usersAll = User::withoutGlobalScopes()
            ->where('active', false)
            ->where('gender', 'Male')
            ->latest()->paginate(50);
        }elseif ($type == 'inactive_female_users') {
            $usersAll = User::withoutGlobalScopes()
            ->where('active', false)
            ->where('gender', 'Female')
            ->latest()->paginate(50);
        }elseif ($type == 'male_users') {
            $usersAll = User::where('gender', 'Male')
            ->latest()->paginate(50);
        }elseif ($type == 'female_users') {
            $usersAll = User::where('gender', 'Female')
            ->latest()->paginate(50);
        }elseif ($type == 'validity_10') {
            $usersAll = User::where('expired_at', '>=', Carbon::now())
            ->where('expired_at', '<', Carbon::now()->addDays(10))
            ->latest()->paginate(50);
        }elseif ($type == 'basic_info_pending') {
            $usersAll = User::where('checked', false)
            ->latest()->paginate(50);
        }elseif ($type == 'personal_info_pending') {
            $usersAll = User::whereHas('personalInfo', function ($query) {
            $query->where('checked', false);
          })->latest()->paginate(50);
        }elseif ($type == 'personal_activity_pending') {
            $usersAll = User::whereHas('personalActivity', function ($query) {
            $query->where('checked', false);
          })
            ->latest()->paginate(50);
        }elseif ($type == 'golden') {
            $usersAll = User::whereIn('package', [1,5])
            ->where('expired_at', '>=', Carbon::now())
            ->latest()->paginate(50);
        }elseif ($type == 'golden_plus') {
            $usersAll = User::whereIn('package', [2,6])
            ->where('expired_at', '>=', Carbon::now())
            ->latest()->paginate(50);
        }elseif ($type == 'diamond') {
            $usersAll = User::whereIn('package', [3,7])
            ->where('expired_at', '>=', Carbon::now())
            ->latest()->paginate(50);
        }elseif ($type == 'diamond_plus') {
            $usersAll = User::whereIn('package', [4,8])
            ->where('expired_at', '>=', Carbon::now())
            ->latest()->paginate(50);
        }elseif ($type == 'free_package') {
            $usersAll = User::where('package', 0)
            ->where('expired_at', '>=', Carbon::now())
            ->where('expired_at', '<', Carbon::now()->addDays(14))
            ->latest()->paginate(50);
        }elseif ($type == 'subscribers') {
            $usersAll = User::where('expired_at', '<=', Carbon::now())
            ->orWhereNull('expired_at')
            ->latest()->paginate(50);
        }elseif ($type == 'online_users') {
            $usersAll = User::where('loggedin_at', '>=', Carbon::now()->subMinutes(4))
            ->latest()->paginate(50);
        }

        elseif ($type == 'log_users') {
            $usersAll = User::withoutGlobalScopes()->has('logs')->latest()->paginate(50);
        }

        elseif($type == 'offline_user')
        {
            $usersAll = User::withoutGlobalScopes()
            ->where('user_type', 'offline')
            ->latest()->paginate(50);
        }

        elseif($type == 'today_registered'){

            $usersAll = User::whereDate('created_at', Carbon::today())->latest()->paginate(50);
        }
        elseif($type == 'today_inactive'){

            $usersAll = User::withoutGlobalScopes()
            ->whereDate('inactive_at', Carbon::today())->latest()
            ->where('active', false)
            ->paginate(50);
        }

        elseif($type == 'this_month_registered'){

            $usersAll = User::whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))->latest()->paginate(50);
        }

        elseif($type == 'this_month_inactive'){

            $usersAll = User::withoutGlobalScopes()
            ->where('active',false)
            ->whereYear('inactive_at', date('Y'))
            ->whereMonth('inactive_at', date('m'))->latest()->paginate(50);
        }

        else 
        {

            return redirect()->route('admin.usersAll');
        }        


        return view('admin.users.usersGroup',[
            'usersAll'=>$usersAll,
            'type' => $type
        ]);
    }

    public function makeUserActive(Request $request)
    {
        $user = User::withoutGlobalScopes()->find($request->user);
        if($user)
        {
            if($user->active)
            {
                $user->active = false;
                $user->deactivateSmsSentToUser();
                $user->deactivateEmailSentToUser($user);
                $user->inactive_at = Carbon::now();
                $user->editedby_id = Auth::id();
                $user->save();
            }else
            {
                $user->active = true;
                $user->inactive_at = Carbon::now();
                $user->activateSmsSentToUser();
                $user->activateEmailSentToUser($user);
                $user->editedby_id = Auth::id();
                $user->save();
            }

        }

        return back()->with('info', "User's activity updated.");
    }

    public function userDetailsEdit( Request $request)
    {
        $user = User::withoutGlobalScopes()->find($request->user);
        if(!$user)
        {
            abort(404);
        }

        if (! $user->searchTerm) 
        {
          $user->searchTerm()->create(['addedby_id' => Auth::id()]);
        }

        $user = User::withoutGlobalScopes()
        ->with('searchTerm')
        ->find($request->user);

        $packages = MembershipPackage::all();

        $allUpazilas =  Cache::remember('allUpazilas', 518400, function () {
            return Upazila::all(); 
        });

        $allDistricts = Cache::remember('allDistricts', 518400, function () {
                    return District::all();
                });

          return view('admin.users.userEdit', [
            'user'=> $user,
            'packages' => $packages,
            'allUpazilas'=>$allUpazilas,
            'allDistricts'=>$allDistricts
          ]);
    }

    public function userDetailsUpdatePost( Request $request)
    {

        // dd($request->all());
        $user = User::withoutGlobalScopes()->find($request->user);

        if(!$user)
        {
            abort(404);
        }

        

        $validation = Validator::make($request->all(),
        [ 
          
          // "fullName" => 'required',
          "username" => 'required|unique:users,username,'.$user->id,
          "email" => 'required|unique:users,email,'.$user->id,
          // "package" => 'required',
          // "expired_at" => 'required'
          

          // "headline" => 'required',
          // "about_me" => 'required',
          "looking_for" => 'required',
          "gender" => 'required',
          "day" => 'required',
          "month" => 'required',
          "year" => 'required',


          // "citizenship" => 'required',
          // "birth_place" => 'required',
          // "income" => 'required',
          // "going_to_marry" => 'required',
          // "marital_status" => 'required',
          // "like_to_have_children" => 'required',
          // "do_u_have_children" => 'required',
          // "living_with" => 'required',
          // "height" => 'required',
          // "body_build" => 'required',
          // "hair_color" => 'required',
          // "eye_color" => 'required',
          // "skin_color" => 'required',
          // "dress_up" => 'required',
          // "smoke_status" => 'required',
          // "disabilities_status" => 'required',
          // "how_many_siblings" => 'required',
          // "alcohol_status" => 'required',
          // "blood_group" => 'required',
          
 
        // "education_level" => 'required',
        //   "subject_studied" => 'required',
        //   "job_title" => 'required',
        //   "my_profession" => 'required',
        //   "first_language" => 'required',
        //   "second_language" => 'required',

            // 'first_name' => 'required',
            // 'last_name' => 'required',
            // 'mobile' => 'required',
            // // 'phone' => 'required',
            // // 'dob' => 'required',
            // 'day_for_office' => 'required',
            // 'month_for_office' => 'required',
            // 'year_for_office' => 'required',
            // // 'nid_number' => 'required',
            // // 'passport_number' => 'required',
            // 'present_address' => 'required',
            // 'permanent_address' => 'required',
            // // 'office_address' => 'required',
            // 'father_name' => 'required',
            // 'father_contact' => 'required',
            // 'mother_name' => 'required',
            // 'mother_contact' => 'required',

        ]);

        if($validation->fails())
        {
            // if($request->ajax())
            // {
            //     return Response()->json(array(
            //     'success' => false,
            //     'errors' => $validation->errors()->toArray()
            //     ));
            // }

            return back()
            ->withInput()
            ->withErrors($validation);
        }

        $dob = $request->year.'-'.$request->month. '-' .$request->day;

        $user->name = $request->fullName;
        $user->username = $request->username;
        
        if(Auth::user()->email == 'info@bridegroombd.com')
        {
            
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            
        }
        
        
        
        
        $user->guardian_mobile = $request->guardian_mobile;

        if($user->active and !$request->active)
        {
                $user->deactivateSmsSentToUser();
                $user->deactivateEmailSentToUser($user);
        }
        elseif(!$user->active and $request->active)
        {
                $user->activateSmsSentToUser();            
                $user->activateEmailSentToUser($user);
        }

        $user->active = $request->active ? 1 : 0;
        $user->featured = $request->featured ? 1 : 0;

        $user->checked = $request->basic_checked ? 1 : 0;
        $user->can_edit = $request->basic_can_edit ? 1 : 0;
        $user->inactive_at = Carbon::now();

        

        if($request->user_type)
        {
            $user->user_type = 'offline';
        }else
        {
            $user->user_type = 'online';
        }

        $user->dob = Date($dob);
        $user->gender = $request->gender;
        $user->package = $request->package ?: null;
        $user->religion = $request->religion;
        $user->social_order = $request->social_order;
        $user->profile_created_by = $request->profile_created_by;

        if( ($request->profile_created_by == 'Other') || 
            ($request->profile_created_by == 'Others'))
        {
            $user->profile_created_by_other = $request->profile_created_by_other;
        }else{
            
            $user->profile_created_by_other = null;
        }


        $user->country = $request->country;

        if( ($request->country == 'Other') || 
            ($request->country == 'Others'))
        {
            $user->country_other = $request->country_other;
        }else{
            
            $user->country_other = null;
        }

        // $tName = null;
        // $distName = null;
        // $divName = null;
        // if ($request->tha) {
        //     $tha = Upazila::where('id', $request->tha)->first();
        //     if($tha)
        //     {
        //         $tName = $tha->name;
        //         $distName = $tha->district->name;
        //         $divName = $tha->division->name;
        //     }            
        // }
        // elseif($request->dist){
        //     $dist = District::where('id', $request->dist)->first();
        //     if($dist)
        //     {
        //         $distName = $dist->name;
        //         $divName = $dist->division->name;
        //     }
        // }elseif($request->division)
        // {
        //     $div = Division::where('id', $request->division)->first();
        //     if($div)
        //     {
        //         $divName = $div->name;
        //     }
        // }

        $user->looking_for = $request->looking_for;
        $user->expired_at = $request->expired_at ?: null;
        $user->editedby_id = Auth::id();
        $user->save();


        $contactInfo = $user->contactInfo;

        if(!$contactInfo)
        {
            $contactInfo = new UserContactInfo; 
            $contactInfo->user_id = $user->id;
            $contactInfo->addedby_id = Auth::id();
        }
            $contactInfo->alternative_email = $request->alternative_email;
            $contactInfo->alternative_mobile = $request->alternative_mobile;
            $contactInfo->convenient_time_to_call = $request->convenient_time_to_call;
            $contactInfo->name_of_contact_person = $request->name_of_contact_person;
            $contactInfo->relation_with_contact_person = $request->relation_with_contact_person;
            $contactInfo->present_address = $request->present_address;
            $contactInfo->permanent_address = $request->permanent_address;
            $contactInfo->about_me = $request->about_me;
            $contactInfo->about_family = $request->about_family;
            $contactInfo->nid = $request->nid;
            $contactInfo->checked = $request->contact_info_checked ? 1 : 0;
            $contactInfo->can_edit = $request->contact_info_can_edit ? 1 : 0;

            $contactInfo->save();




    $personalInfo = $user->personalInfo;

    if(!$personalInfo)
    {
        $personalInfo = new UserPersonalInfo; 
        $personalInfo->user_id = $user->id;
        $personalInfo->addedby_id = $user->id;           
    }

$personalInfo->marital_status = $request->marital_status ?: null;
$personalInfo->do_u_have_children = $request->do_u_have_children ?: null;
$personalInfo->height = $request->height ?: null;
$personalInfo->body_build = $request->body_build ?: null;

$personalInfo->hair_color = $request->hair_color;

    if( ($request->hair_color == 'Other') || 
        ($request->hair_color == 'Others'))
    {
        $personalInfo->hair_color_other = $request->hair_color_other;
    }else{

        $personalInfo->hair_color_other = null;
    }

    $personalInfo->eye_color = $request->eye_color;

    if( ($request->eye_color == 'Other') || 
        ($request->eye_color == 'Others'))
    {
        $personalInfo->eye_color_other = $request->eye_color_other;
    }else{

        $personalInfo->eye_color_other = null;
    }

    $personalInfo->skin_color = $request->skin_color;

    if( ($request->skin_color == 'Other') || 
        ($request->skin_color == 'Others'))
    {
        $personalInfo->skin_color_other = $request->skin_color_other;
    }else{

        $personalInfo->skin_color_other = null;
    }

$personalInfo->zodiac_sign = $request->zodiac_sign ?: null;
$personalInfo->smoke_status = $request->smoke_status ?: null;

$personalInfo->disabilities_status = $request->disabilities_status ?: null;

    if( ($request->disabilities_status == 'Other') || 
        ($request->disabilities_status == 'Others'))
    {
        $personalInfo->disabilities_status_other = $request->disabilities_status_other;
    }else{

        $personalInfo->disabilities_status_other = null;
    }

$personalInfo->alcohol_status = $request->alcohol_status ?: null;
$personalInfo->diat_status = $request->diat_status ?: null;
$personalInfo->blood_group = $request->blood_group ?: null;


$personalInfo->education_level = $request->education_level ?: null;

if( ($request->education_level == 'Other') || 
        ($request->education_level == 'Others'))
    {
        $personalInfo->education_level_other = $request->education_level_other;
    }else{

        $personalInfo->education_level_other = null;
    }

$personalInfo->major_subject = $request->major_subject ?: null;
$personalInfo->graduate_from = $request->graduate_from ?: null;
$personalInfo->job_title = $request->job_title ?: null;
$personalInfo->my_profession = $request->my_profession ?: null;

    if( ($request->my_profession == 'Other') || 
        ($request->my_profession == 'Others'))
    {
        $personalInfo->my_profession_other = $request->my_profession_other;
    }else{

        $personalInfo->my_profession_other = null;
    }

$personalInfo->job_company_name = $request->job_company_name ?: null;
$personalInfo->income = $request->income ?: null;
$personalInfo->mother_tongue = $request->mother_tongue ?: null;

        if($request->can_speak)
        {
            $personalInfo->can_speak = implode(', ',$request->can_speak);
        }else
        {
            $personalInfo->can_speak = null;
        }

$personalInfo->father_name = $request->father_name ?: null;
$personalInfo->father_occupation = $request->father_occupation ?: null;
$personalInfo->mother_name = $request->mother_name ?: null;
$personalInfo->mother_occupation = $request->mother_occupation ?: null;
$personalInfo->number_of_brother = $request->number_of_brother ?: null;
$personalInfo->how_many_brother_married = $request->how_many_brother_married ?: null;
$personalInfo->number_of_sister = $request->number_of_sister ?: null;
$personalInfo->how_many_sister_married = $request->how_many_sister_married ?: null;
$personalInfo->district = $request->district ?: null;
$personalInfo->thana = $request->thana ?: null;
$personalInfo->zip_code = $request->zip_code ?: null;
$personalInfo->citizenship = $request->citizenship ?: null;
    if( ($request->citizenship == 'Other') || 
        ($request->citizenship == 'Others'))
    {
        $personalInfo->citizenship_other = $request->citizenship_other;
    }else{

        $personalInfo->citizenship_other = null;
    }
$personalInfo->city_of_residence = $request->city_of_residence ?: null;
$personalInfo->state_of_residence = $request->state_of_residence ?: null;
$personalInfo->country_of_residence = $request->country_of_residence ?: null;

    if( ($request->country_of_residence == 'Other') || 
        ($request->country_of_residence == 'Others'))
    {
        $personalInfo->country_of_residence_other = $request->country_of_residence_other;
    }else{

        $personalInfo->country_of_residence_other = null;
    }

$personalInfo->hear_about_us = $request->hear_about_us ?: null;
$personalInfo->checked = $request->personal_info_checked ? 1 : 0;
$personalInfo->can_edit = $request->personal_info_can_edit ? 1 : 0;
$personalInfo->save();





 

        $perAct = $user->personalActivity;

        if(!$perAct)
        {
            $perAct = new UserPersonalActivity; 
            $perAct->user_id = $user->id;
            $perAct->addedby_id = $user->id; 
        }

        if($request->my_interests)
        {
            $perAct->interests = implode(', ',$request->my_interests);
        }else
        {
            $perAct->interests = null;
        }

        if($request->favourite_music)
        {
            $perAct->favourite_music = implode(', ',$request->favourite_music);
        }else
        {
            $perAct->favourite_music = null;
        }

        if($request->favourite_reads)
        {
            $perAct->favourite_reads = implode(', ',$request->favourite_reads);
        }else
        {
            $perAct->favourite_reads = null;
        }

        if($request->favourite_movies)
        {
            $perAct->favourite_movies = implode(', ',$request->favourite_movies);
        }else
        {
            $perAct->favourite_movies = null;
        }

        if($request->favourite_cooking)
        {
            $perAct->favourite_cooking = implode(', ',$request->favourite_cooking);
        }else
        {
            $perAct->favourite_cooking = null;
        }

        if($request->favourite_dresses)
        {
            $perAct->dress_style = implode(', ',$request->favourite_dresses);
        }else
        {
            $perAct->dress_style = null;
        }

        $perAct->checked = $request->personal_activity_checked ? 1 : 0;
        $perAct->can_edit = $request->personal_activity_can_edit ? 1 : 0;
        $perAct->save();





        #partner preference
    $st = $user->searchTerm;

    $st->min_age = trim($request->minimum_age) ?: null;
    $st->max_age = trim($request->maximum_age) ?: null;

    $st->min_height = trim($request->minimum_height) ?: null;
    $st->max_height = trim($request->maximum_height) ?: null;

    $st->country = trim($request->search_country) ?: null;

    if( ($request->search_country == 'Other') || 
        ($request->search_country == 'Others'))
    {
        $st->country_other = $request->search_country_other;
    }else{

        $st->country_other = '';
    }

    $st->marital_status = trim($request->search_marital_status) ?: null;
    $st->do_u_have_children = trim($request->search_have_children) ?: null;
    $st->religion = trim($request->search_religion) ?: null;
    $st->social_order = trim($request->search_social_order) ?: null;

    if($request->search_professions)
    {
        $st->my_profession = implode(', ',$request->search_professions);
    }else
    {
        $st->my_profession = null;
    }

    if($request->search_education_level)
    {
        $st->education_level = implode(', ',$request->search_education_level);
    }else
    {
        $st->education_level = null;
    }

    if($request->search_country_of_residence)
    {
        $st->country_of_residence = implode(', ',$request->search_country_of_residence);
    }else
    {
        $st->country_of_residence = null;
    }

    $st->state_of_residence = trim($request->search_state_of_residence) ?: null;

    $st->city_of_residence = trim($request->search_city_of_residence) ?: null;
    $st->mother_tongue = trim($request->search_mother_tongue) ?: null;
    $st->skin_color = trim($request->search_skin_color) ?: null;
    $st->body_build = trim($request->search_body_build) ?: null;
    $st->smoke_status = trim($request->search_smoke_status) ?: null;
    $st->alcohol_status = trim($request->search_alcohol_status) ?: null;

    $st->checked = $request->search_checked ? 1 : 0;
    $st->can_edit = $request->search_can_edit ? 1 : 0;


    // $st->user_status = trim($request->user_status) ?: null;

    $st->save();
        #partner preference


        if ($request->final_checked) 
        {
            $user->final_checked = true;

                #send sms to user from here
                if($user->mobile)
                {
                    if(strlen(bdMobile($user->mobile)) == 13)
                    {
                        $user->finalCheckedCompletedSms();
                    }
                }
                
                #send email to user from here    
          
        }
        
        $user->save();





      return back()->with('success', 'User Details Successfully Updated.');  
    }

    public function userDetailsPrint(Request $request)
    {
        $user = User::withoutGlobalScopes()->with(['about'])->find($request->user);

        if(!$user)
        {
            abort(404);
        }

        return view('admin.users.userDetailsPrint', [ 'user' => $user ]);
    }


    //users 













//pages
     

    public function pageAddNewPost(Request $request)
    {
        // dd($request->all());
        $validation = Validator::make($request->all(),
        [
            'page_title' => 'required|max:50|string',
            'route_name' => 'required|max:50|string|unique:pages,route_name',
        ]);
        if($validation->fails())
        {
            return back()->withErrors($validation)
            ->withInput()
            ->with('error', 'Something went wrong.');
        }

 
        $page = new Page;
        $page->page_title = $request->page_title;
        $page->title_hide = $request->title_hide ? 1 : 0;
        $page->active = $request->active ? 1 : 0;
        $page->left_sidebar = $request->left_sidebar ? 1 : 0;
        $page->list_in_menu = $request->list_in_menu ? 1 : 0;
        $page->route_name = $request->route_name ? str_slug(strtolower($request->route_name)) : null;
        $page->meta_title = $request->meta_title ?: null;
        $page->meta_description = $request->meta_description ?: null;
        $page->meta_keywords = $request->meta_keywords ?: null;

        $page->addedby_id = Auth::id();
        $page->save();
 

        return back()->with('success', 'New Page Created Successfully!');
    }

    public function pagesAll(Request $request)
    {
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'pages','lsbsm'=>'pagesAll']);

        $pages = Page::orderBy('page_title')->paginate(50);
        return view('admin.pages.pagesAll', ['pages'=> $pages]);
    }

    public function pageEdit(Request $request, Page $page)
    {
        return view('admin.pages.pageEdit', ['page'=> $page]);
    }

    public function pageEditPost(Request $request, Page $page)
    {
        $validation = Validator::make($request->all(),
        [
            'page_title' => 'required|max:50|string',
            'route_name' => 'required|max:50|string|unique:pages,route_name,'.$page->id,
        ]);
        if($validation->fails())
        {
            return back()->withErrors($validation)
            ->withInput()
            ->with('error', 'Something went wrong.');
        }

        $page->page_title = $request->page_title;
        $page->title_hide = $request->title_hide ? 1 : 0;
        $page->active = $request->active ? 1 : 0;
        $page->left_sidebar = $request->left_sidebar ? 1 : 0;
        $page->list_in_menu = $request->list_in_menu ? 1 : 0;
        $page->route_name = $request->route_name ? str_slug(strtolower($request->route_name)) : null;

        $page->meta_title = $request->meta_title ?: null;
        $page->meta_description = $request->meta_description ?: null;
        $page->meta_keywords = $request->meta_keywords ?: null;

        $page->editedby_id = Auth::id();
        $page->save();
 

        return back()->with('success', 'Page Updated Successfully!');
    }

    public function pageDelete(Request $request, Page $page)
    {
        $page->items()->delete();
        $page->delete();

        return back()->with('success', 'Page Deleted Successfully');
    }

    public function pageItems(Request $request, Page $page)
    {
        $mediaAll = Media::latest()->paginate(200);
        return view('admin.pages.pageItems', [
            'page'=> $page,
            'mediaAll' => $mediaAll
        ]);
    }


    public function pageItemAddPost(Request $request, Page $page)
    {
        $validation = Validator::make($request->all(),
        [
            'title' => 'required|max:50|string',
            'description' => 'required|max:60000|string',
        ]);
        if($validation->fails())
        {
            return back()->withErrors($validation)
            ->withInput()
            ->with('error', 'Something went wrong.');
        }

        $item = new PageItem;
        $item->page_id = $page->id;
        $item->title = $request->title ?: null;
        $item->content = $request->description ?: null;
        $item->editor = $request->editor ? 1 : 0;
        $item->active = $request->active ? 1 : 0;
        $item->addedby_id = Auth::id();
        $item->save();
 

        return back()->with('success', 'Page Item Created Successfully!');
    }

    public function pageItemDelete(Request $request, PageItem $item)
    {
        $item->delete();

        return back()->with('success', 'Part of the Page Deleted Successfully');
    }

    public function pageItemEditEditor(Request $request, PageItem $item)
    {
        if($item->editor)
        {
            $item->editor = false;
        }
        else
        {
            $item->editor = true;
        }
        $item->save();

        return back();
    }

    public function pageItemEdit(Request $request, PageItem $item)
    {
        $mediaAll = Media::latest()->paginate(200);

        return view('admin.pages.pageItemEdit', [
            'it'=> $item,
            'page' => $item->page,
            'mediaAll' => $mediaAll
        ]);
    }

    public function pageItemUpdate(Request $request, PageItem $item)
    {
        $validation = Validator::make($request->all(),
        [
            'title' => 'required|max:50|string',
            'description' => 'required|max:60000|string',
        ]);
        if($validation->fails())
        {
            return back()->withErrors($validation)
            ->withInput()
            ->with('error', 'Something went wrong.');
        }

        $item->title = $request->title ?: null;
        $item->content = $request->description ?: null;
        $item->editor = $request->editor ? 1 : 0;
        $item->active = $request->active ? 1 : 0;
        $item->editedby_id = Auth::id();
        $item->save();
 

        return back()->with('success', 'Page Item Updated Successfully!');
    }


//pages

























    //about-post
    public function aboutPostAddNew(Request $request)
    {
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'website','lsbsm'=>'aboutPostAddNew']);

        return view('admin.aboutPost.aboutPostAddNew');
    }

    public function aboutPostNewPost(Request $request)
    {
        $validation = Validator::make($request->all(),
        [ 
          // "title" => "title"
          // "publish" => "on"
            "description" => "required",
            'title' => 'max:254|required',
            'feature_image' => 'image|dimensions:min_with=300,min_height=200'
        ]);

        if($validation->fails())
        {
            return back()
            ->withErrors($validation)
            ->withInput()
            ->with('error', 'Something Went Wrong!');
        }

        $post = new AboutPost;
        $post->title = $request->title ?: null;
        $post->description = $request->description ?: null;
        $post->active = $request->active ? true : false;
        $post->button_text = $request->button_text ?: null;
        $post->url = $request->url ?: null; 
        $post->addedby_id = Auth::id();


        if($request->hasFile('feature_image'))
        {

            $ffile = $request->feature_image;
            $fimgExt = strtolower($ffile->getClientOriginalExtension());               
            $fimageNewName = str_random(8).time().'.'.$fimgExt;
            $originalName = $ffile->getClientOriginalName();

            Storage::disk('upload')->put('media/image/'.$fimageNewName, File::get($ffile));

                if($post->feature_img_name)
                {

                    Storage::disk('upload')->delete('media/image/'.$post->feature_img_name);
                }

            $post->feature_img_name = $fimageNewName;
        }

        $post->save();

        Cache::flush();

        return back()->with('success', 'New about post successfully created.');
    }

    public function aboutPostAll(Request $request)
    {
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'website','lsbsm'=>'aboutPostAll']);

        $aboutPosts = AboutPost::latest()->paginate(20);
        return view('admin.aboutPost.aboutPostAll', ['posts' => $aboutPosts]);
    }

    public function aboutPostDelete(AboutPost $post, Request $request)
    {
        $post->delete();

        return back()->with('success', 'About Post Successfully Deleted.');
    }

    public function aboutPostEdit(AboutPost $post, Request $request)
    {
        return view('admin.aboutPost.aboutPostEdit', ['post' => $post]);
    }

    public function aboutPostEditPost(AboutPost $post, Request $request)
    {
        $validation = Validator::make($request->all(),
        [ 
          // "title" => "title"
          // "publish" => "on"
            "description" => "required",
            'title' => 'max:254|required',
            // 'feature_image' => 'image|dimensions:min_with=300,min_height=200,ratio=3/2'
        ]);

        if($validation->fails())
        {
            return back()
            ->withErrors($validation)
            ->withInput()
            ->with('error', 'Something Went Wrong!');
        }


        $post->title = $request->title ?: null;
        $post->description = $request->description ?: null;
        $post->active = $request->active ? true : false; 
        $post->button_text = $request->button_text ?: null;
        $post->url = $request->url ?: null;
        $post->editedby_id = Auth::id();


        if($request->hasFile('feature_image'))
        {

            $ffile = $request->feature_image;
            $fimgExt = strtolower($ffile->getClientOriginalExtension());               
            $fimageNewName = str_random(8).time().'.'.$fimgExt;
            $originalName = $ffile->getClientOriginalName();

            Storage::disk('upload')->put('media/image/'.$fimageNewName, File::get($ffile));

                if($post->feature_img_name)
                {

                    Storage::disk('upload')->delete('media/image/'.$post->feature_img_name);
                }

            $post->feature_img_name = $fimageNewName;
        }

        $post->save();

        Cache::flush();

        return back()->with('success', 'About post successfully updated.');
    }
    //about-post

    //service-post
      public function servicePostAddNew(Request $request)
    {
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'website','lsbsm'=>'servicePostAddNew']);

        return view('admin.servicePost.servicePostAddNew');
    }

    public function servicePostNewPost(Request $request)
    {
        $validation = Validator::make($request->all(),
        [ 
          // "title" => "title"
          // "publish" => "on"
            "description" => "required",
            'title' => 'max:254|required',
            'feature_image' => 'image|dimensions:min_with=150,min_height=150'
        ]);

        if($validation->fails())
        {
            return back()
            ->withErrors($validation)
            ->withInput()
            ->with('error', 'Something Went Wrong!');
        }

        $post = new ServicePost;
        $post->title = $request->title ?: null;
        $post->description = $request->description ?: null;
        $post->active = $request->active ? true : false;
        $post->button_text = $request->button_text ?: null;
        $post->url = $request->url ?: null; 
        $post->addedby_id = Auth::id();


        if($request->hasFile('feature_image'))
        {

            $ffile = $request->feature_image;
            $fimgExt = strtolower($ffile->getClientOriginalExtension());               
            $fimageNewName = str_random(8).time().'.'.$fimgExt;
            $originalName = $ffile->getClientOriginalName();

            Storage::disk('upload')->put('media/image/'.$fimageNewName, File::get($ffile));

                if($post->feature_img_name)
                {

                    Storage::disk('upload')->delete('media/image/'.$post->feature_img_name);
                }

            $post->feature_img_name = $fimageNewName;
        }

        $post->save();

        Cache::flush();

        return back()->with('success', 'New service post successfully created.');
    }

    public function servicePostAll(Request $request)
    {
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'website','lsbsm'=>'servicePostAll']);

        $servicePosts = ServicePost::latest()->paginate(20);
        return view('admin.servicePost.servicePostAll', ['posts' => $servicePosts]);
    }

    public function servicePostDelete(ServicePost $post, Request $request)
    {
        $post->delete();

        return back()->with('success', 'Service Post Successfully Deleted.');
    }

    public function servicePostEdit(ServicePost $post, Request $request)
    {
        return view('admin.servicePost.servicePostEdit', ['post' => $post]);
    }

    public function servicePostEditPost(ServicePost $post, Request $request)
    {
        $validation = Validator::make($request->all(),
        [ 
          // "title" => "title"
          // "publish" => "on"
            "description" => "required",
            'title' => 'max:254|required',
            // 'feature_image' => 'image|dimensions:min_with=300,min_height=200,ratio=3/2'
        ]);

        if($validation->fails())
        {
            return back()
            ->withErrors($validation)
            ->withInput()
            ->with('error', 'Something Went Wrong!');
        }


        $post->title = $request->title ?: null;
        $post->description = $request->description ?: null;
        $post->active = $request->active ? true : false; 
        $post->button_text = $request->button_text ?: null;
        $post->url = $request->url ?: null;
        $post->editedby_id = Auth::id();


        if($request->hasFile('feature_image'))
        {

            $ffile = $request->feature_image;
            $fimgExt = strtolower($ffile->getClientOriginalExtension());               
            $fimageNewName = str_random(8).time().'.'.$fimgExt;
            $originalName = $ffile->getClientOriginalName();

            Storage::disk('upload')->put('media/image/'.$fimageNewName, File::get($ffile));

                if($post->feature_img_name)
                {

                    Storage::disk('upload')->delete('media/image/'.$post->feature_img_name);
                }

            $post->feature_img_name = $fimageNewName;
        }

        $post->save();

        Cache::flush();

        return back()->with('success', 'Service post successfully updated.');
    }
    //service-post


    //author-post
    public function authorPostAddNew(Request $request)
    {
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'website','lsbsm'=>'authorPostAddNew']);

        return view('admin.authorPost.authorPostAddNew');
    }

    public function authorPostNewPost(Request $request)
    {
        $validation = Validator::make($request->all(),
        [ 
          // "title" => "title"
          // "publish" => "on"
            "description" => "required",
            'title' => 'max:254|required',
            'feature_image' => 'image|dimensions:min_with=300,min_height=200'
        ]);

        if($validation->fails())
        {
            return back()
            ->withErrors($validation)
            ->withInput()
            ->with('error', 'Something Went Wrong!');
        }

        $post = new AuthorPost;
        $post->title = $request->title ?: null;
        $post->description = $request->description ?: null;
        $post->active = $request->active ? true : false;
        $post->role_name = $request->role_name ?: null; 
        $post->addedby_id = Auth::id();


        if($request->hasFile('feature_image'))
        {

            $ffile = $request->feature_image;
            $fimgExt = strtolower($ffile->getClientOriginalExtension());               
            $fimageNewName = str_random(8).time().'.'.$fimgExt;
            $originalName = $ffile->getClientOriginalName();

            Storage::disk('upload')->put('media/image/'.$fimageNewName, File::get($ffile));

                if($post->feature_img_name)
                {

                    Storage::disk('upload')->delete('media/image/'.$post->feature_img_name);
                }

            $post->feature_img_name = $fimageNewName;
        }

        $post->save();

        Cache::flush();

        return back()->with('success', 'New author post successfully created.');
    }

    public function authorPostAll(Request $request)
    {
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'website','lsbsm'=>'authorPostAll']);

        $authorPosts = AuthorPost::paginate(20);
        return view('admin.authorPost.authorPostAll', ['posts' => $authorPosts]);
    }

    public function authorPostDelete(AuthorPost $post, Request $request)
    {
        $post->delete();

        return back()->with('success', 'Author Post Successfully Deleted.');
    }

    public function authorPostEdit(AuthorPost $post, Request $request)
    {
        return view('admin.authorPost.authorPostEdit', ['post' => $post]);
    }

    public function authorPostEditPost(AuthorPost $post, Request $request)
    {
        $validation = Validator::make($request->all(),
        [ 
          // "title" => "title"
          // "publish" => "on"
            "description" => "required",
            'title' => 'max:254|required',
            // 'feature_image' => 'image|dimensions:min_with=300,min_height=200,ratio=3/2'
        ]);

        if($validation->fails())
        {
            return back()
            ->withErrors($validation)
            ->withInput()
            ->with('error', 'Something Went Wrong!');
        }


        $post->title = $request->title ?: null;
        $post->description = $request->description ?: null;
        $post->active = $request->active ? true : false; 
        $post->role_name = $request->role_name ?: null;
 
        $post->editedby_id = Auth::id();


        if($request->hasFile('feature_image'))
        {

            $ffile = $request->feature_image;
            $fimgExt = strtolower($ffile->getClientOriginalExtension());               
            $fimageNewName = str_random(8).time().'.'.$fimgExt;
            $originalName = $ffile->getClientOriginalName();

            Storage::disk('upload')->put('media/image/'.$fimageNewName, File::get($ffile));

                if($post->feature_img_name)
                {

                    Storage::disk('upload')->delete('media/image/'.$post->feature_img_name);
                }

            $post->feature_img_name = $fimageNewName;
        }

        $post->save();

        Cache::flush();

        return back()->with('success', 'author post successfully updated.');
    }
    //author-post

    //page
    
    public function allPages(Request $request)
    {
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'website','lsbsm'=>'allPages']);
        $pages = Page::orderby('id','desc')->get();

        return view('admin.pages.allPages',['pages'=>$pages]);
    }

    public function newPage(Request $request){

        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'website','lsbsm'=>'newPage']);
        return view('admin.pages.newPage');
    }

    public function newPagePost(Request $request)
    {
        // dd($request->all());
        $validation = Validator::make($request->all(),
        [
            'pageTitle' => 'required|max:50|string',
            'page_route' => 'required|max:50|string',
            'details' => 'required|string',
            // 'categoryTitleBn' => 'required|min:2|max:200',
          // 'categoryImage'=> 'required|dimensions:ratio=800/350'
        ]);
        if($validation->fails())
        {
            return redirect()->route('admin.newPage')
            ->withErrors($validation)
            ->withInput()
            ->with('error', 'Something went wrong.');
        }




        
        // $image = $request->file('categoryImage');
        // $imageName = time().'.'.$image->getClientOriginalExtension();
        // $destinationPath = public_path('/images');
        // $image->move($destinationPath, $imageName);

        // Storage::disk('upload')
        // ->put('category/'.$imageName, File::get($image));
        // $image_url = 'storage/category/'.$imageName;

        $page = new Page;
        $page->page_title = $request->pageTitle;
        $page->title_hide = $request->titleHide ? 1 : 0;
        $page->page_type = $request->page_type;
        $page->active = $request->active ? 1 : 0;
        $page->route_name = $request->page_route ?: null;
        $page->content = $request->details ?: null;
        $page->meta_title = $request->meta_title ?: $page->page_title;
        $page->meta_description = $request->meta_description ?: null;
        $page->meta_keywords = $request->meta_keywords ?: null;
        $page->addedby_id = Auth::id();
        $page->save();

        // Cache::flush();

        Cache::forget('frontPages');


        return redirect()->route('admin.newPage')->with('success', 'New Page Created Successfully!');
    }


    public function editPage($page, Request $request){
        $page = Page::where('id', $page)->first();

        return view('admin.pages.editPage',['page'=>$page]);
    }

    public function editPagePost($page, Request $request){
        $page= Page::where('id', $page)->first();
        // dd($request->all());

        $validation = Validator::make($request->all(),
        [
            'pageTitle' => 'required|max:50|string',
            'page_route' => 'required|max:50|string',
            'details' => 'required|string',
        ]);
        if($validation->fails())
        {
            return redirect()->route('admin.editPage',['page'=>$page])
            ->withErrors($validation)
            ->withInput()
            ->with('error', 'Something went wrong.');
        }

        $page->page_title = $request->pageTitle;
        $page->title_hide = $request->titleHide ? 1 : 0;
        $page->active = $request->active ? 1 : 0;
        $page->page_type = $request->page_type;
        $page->route_name = $request->page_route ?: null;
        $page->content = $request->details ?: null;
        $page->meta_title = $request->meta_title ?: $page->page_title;
        $page->meta_description = $request->meta_description ?: null;
        $page->meta_keywords = $request->meta_keywords ?: null;
        $page->editedby_id = Auth::id();
        $page->save();

        Cache::forget('frontPages');

        return redirect()
        ->route('admin.editPage',['page'=>$page])
        ->with('success', 'Page Successfully Edited!');
    }

    public function deletePage($page, Request $request)
    {
        if(Auth::user()->isAdmin())
        {
            $page = Page::where('id',$page)->delete();
        }

        Cache::forget('frontPages');

        return redirect()->route('admin.allPages');
    }
    //page


    //success story

    public function allStories(Request $request)
    {
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'website','lsbsm'=>'allStories']);
        $stories = SuccessProfile::orderby('id','desc')->paginate(50);

        return view('admin.successStories.allStories',['stories'=>$stories]);
    }

    public function newStory(Request $request){

        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'website','lsbsm'=>'newStory']);
        return view('admin.successStories.newStory');
    }

    public function newStoryPost(Request $request)
    {
        // dd($request->all());

          

        $validation = Validator::make($request->all(),
        [

            // 'categoryTitleBn' => 'required|min:2|max:200',
          // 'categoryImage'=> 'required|dimensions:ratio=800/350'

          "title" => "required|max:50|string",
          "location" => "string|max:100",
          "marriage_date" => 'date',
          // "bride_username" => 'string|max:50',
          // "groom_username" => 'string|max:50',
          "details" => "required|string|min:4",
          "featureImage" => "required"
          // "featureImage" => "required|dimensions:ratio=800/400"
        ]);
        if($validation->fails())
        {
            return redirect()->route('admin.newStory')
            ->withErrors($validation)
            ->withInput()
            ->with('error', 'Something went wrong.');
        }

        
        $image = $request->file('featureImage');
        $imageName = time().'.'.$image->getClientOriginalExtension();

        Storage::disk('upload')
        ->put('stories/'.$imageName, File::get($image));

        $page = new SuccessProfile;

        $page->title = $request->title;
        $page->location = $request->location;
        $page->bride_username = $request->bride_username;
        $page->groom_username = $request->groom_username;
        $page->marriage_date = $request->marriage_date;
        $page->description = $request->details;
        $page->image_name = $imageName;
        $page->addedby_id = Auth::id();
        $page->save();

        // Cache::flush();

        Cache::forget('frontStories');


        return redirect()->route('admin.newStory')->with('success', 'New Story Uploaded Successfully!');

    }

    public function editStory(Request $request, SuccessProfile $story)
    {
        return view('admin.successStories.editStory',['story'=>$story]);
    }

    public function editStoryPost(Request $request, SuccessProfile $story)
    {
        $validation = Validator::make($request->all(),
        [

            // 'categoryTitleBn' => 'required|min:2|max:200',
          // 'categoryImage'=> 'required|dimensions:ratio=800/350'

          "title" => "required|max:50|string",
          "location" => "string|max:100",
          "marriage_date" => 'date',
          // "bride_username" => 'string|max:50',
          // "groom_username" => 'string|max:50',
          "details" => "required|string|min:4",
        ]);
        if($validation->fails())
        {
            return back()
            ->withErrors($validation)
            ->withInput()
            ->with('error', 'Something went wrong.');
        }

        if($request->hasFile('featureImage'))
        {
            $image = $request->file('featureImage');
            $imageName = time().'.'.$image->getClientOriginalExtension();

            Storage::disk('upload')
            ->put('stories/'.$imageName, File::get($image));

            Storage::disk('upload')->delete('stories/'. $story->image_name);

            $story->image_name = $imageName;

        }
        
        $story->title = $request->title;
        $story->location = $request->location;
        $story->bride_username = $request->bride_username;
        $story->groom_username = $request->groom_username;
        $story->marriage_date = $request->marriage_date;
        $story->description = $request->details;
        $story->editedby_id = Auth::id();
        $story->save();

        // Cache::flush();

        Cache::forget('frontStories');


        return back()->with('success', 'Story Successfully updated.');
    }

    public function deleteStory(Request $request, SuccessProfile $story)
    {
        // Storage::disk('upload')->delete('stories/'. $story->image_name);
        $story->delete();

        Cache::forget('frontStories');

        return back()->with('success', 'Story Successfully Deleted.');

    }

    //success story
    
    //package //membership package
    public function allMembershipPackages(Request $request)
    {
        request()->session()->forget(['lsbm','lsbsm']);
        request()->session()->put(['lsbm'=>'package','lsbsm'=>'allMembershipPackages']);

        $packages = MembershipPackage::paginate(10);

        return view('admin.membership.allMembershipPackages', [
            'packages' => $packages
        ]);
    }

    public function membershipPackageAddNew(Request $request)
    {
        request()->session()->forget(['lsbm','lsbsm']);
        request()->session()->put(['lsbm'=>'package','lsbsm'=>'membershipPackageAddNew']);

        return view('admin.membership.membershipPackageAddNew');
    }

    public function membershipPackageAddNewPost(Request $request)
    {
         $validation = Validator::make($request->all(),
        [ 

          'title' => 'required|unique:membership_packages,package_title',
          // 'description' => 'required',
          'price' => 'required',
          'currency' => 'required',
          'duration' => 'required'

        ]);

        if($validation->fails())
        {
            return back()
            ->withErrors($validation)
            ->withInput()
            ->with('error', 'Something Went Worng!');
        }

        $package = new MembershipPackage;
        $package->package_title = $request->title;
        $package->package_description = $request->description;
        $package->package_amount = $request->price;
        $package->package_currency = $request->currency;
        $package->package_duration = $request->duration;
        $package->save();

        Cache::forget('mPackage1');
        Cache::forget('mPackage2');


        return back()
        ->with('success', 'New Package Successfully Created.');
    }

    public function membershipPackageEdit(Request $request, MembershipPackage $package)
    {
        if(!$package)
        {
            abort(404);
        }
        return view('admin.membership.membershipPackageEdit', [
            'package'=>$package
        ]);
    }

    public function membershipPackageUpdate(Request $request, MembershipPackage $package)
    {

        if(!$package){
            abort(404);
        }

        $package->package_title = $request->title;
        $package->package_description = $request->description;
        $package->package_type = $request->package_type;
        $package->package_amount = $request->price;
        $package->package_currency = $request->currency;
        $package->package_duration = $request->duration;
        $package->proposal_send_daily_limit = $request->proposal_send_daily_limit;
        $package->proposal_send_total_limit = $request->proposal_send_total_limit;

        $package->contact_view_limit = $request->contact_view_limit;

        if ($request->hasFile('image')) 
        {
            
            $file = $request->image;
            $fimgExt = strtolower($file->getClientOriginalExtension());               
            $fimageNewName = str_random(8).time().'.'.$fimgExt;
            $fileOriginalName = strtolower($file->getClientOriginalName());

            Storage::disk('upload')->put('package/'.$fimageNewName, File::get($file));

            $package->image_name = $fimageNewName;
            $package->image_original_name = $fileOriginalName;

        }



        $package->save();

        Cache::forget('mPackage1');
        Cache::forget('mPackage2');

        return back()
        ->with('success', 'Package Successfully Updated.');
    }
    //package //membership package

    //payments start

    public function allPaidPayments(Request $request)
    {
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'payments','lsbsm'=>'allPaidPayments']);
        $payments = UserPayment::where('status', 'paid')->where('paid_amount', '<>', 0)->latest()->paginate(100);
        return view('admin.payments.allPaidPayments', [
            'payments'=> $payments,
        ]);
    }


    public function allFreePayments(Request $request)
    {
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'payments','lsbsm'=>'allFreePayments']);
        $payments = UserPayment::where('status', 'paid')->where('paid_amount', 0)->latest()->paginate(40);
        return view('admin.payments.allPaidPayments', [
            'payments'=> $payments,
        ]);
    }

    public function allPendingPayments(Request $request)
    {
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'payments','lsbsm'=>'allPendingPayments']);
        $payments = UserPayment::where('status', 'pending')->latest()->paginate(100);
        $packages = MembershipPackage::all();
        return view('admin.payments.allPendingPayments', [
            'payments'=> $payments,
            'packages' => $packages
        ]);
    }

    public function pendingPaymentUpdatePost(Request $request, UserPayment $payment)
    {
        $validation = Validator::make($request->all(),
        [
              "package" => "required",
              "paid_amount" => "required|numeric",
              "paid_currency" => "required",
              "payment_method" => "required",
              "payment_details" => "required",
              // 'admin_comment' => 'required'
        ]);
        if($validation->fails())
        {
            return redirect()->back()
            ->withErrors($validation)
            ->withInput()
            ->with('error', 'Something went wrong, please try again.');
        }

        $package = MembershipPackage::where('id', $request->package)
        ->first();
        if($package)
        {
            if($payment)
            {
                $payment->status = 'paid';
                $payment->membership_package_id = $package->id;
                $payment->package_title = $package->package_title;
                $payment->package_description = $package->package_description;
                $payment->package_amount = $package->package_amount;
                $payment->package_currency = $package->package_currency;
                $payment->package_duration = $package->package_duration;
                $payment->paid_amount = $request->paid_amount;
                $payment->paid_currency = $request->paid_currency;
                $payment->payment_method = $request->payment_method;
                $payment->payment_details = $request->payment_details;
                $payment->admin_comment = $request->admin_comment;
                $payment->editedby_id = Auth::id();
                $payment->save();

                $user = $payment->user;
                $user->package = $payment->membership_package_id;
                $expired_at = $user->expired_at;
                if($expired_at > Carbon::now())
                {
                    $user->expired_at = $expired_at->addDays($payment->package_duration);
                }else
                {
                    $user->expired_at = Carbon::now()->addDays($payment->package_duration);
                }

                $user->save();


                $request->user()->updateAdminData();


                if(!(env('APP_ENV') == 'local'))
                {  
                    Mail::send('emails.paymentAcceptedToUser', ['payment'=>$payment], function ($message) use ($payment){
                        $message->from('info@bridegroombd.com', 'bridegroombd Payment Section');
                        $message->to($payment->user->email,  '')
                        ->subject('Payment Accepted at '.url('/'));
                    });


                    Mail::send('emails.newPaidPayment', ['payment'=>$payment], function ($message){
                    $message->from('info@bridegroombd.com', 'bridegroombd  Payment Section');
                    $message->to('info@bridegroombd.com',  '')
                    ->subject('New Payment Order is submitted at '.url('/'));
                });

                    




                }

                ### sms api end here (masking & nonmasking seperate) ###

        $to = bdMobile(env('CONTACT_MOBILE1'));
                    
         
        $msg = 'Hello Admin, New payment details: Amount: ' . $payment->paid_amount . ' ' . $payment->paid_currency . '. Package ID: ' . $payment->membership_package_id . '. User:'. $user->email;

        $url = smsUrl($to,$msg);
        
        // $url = "http://connect.primesoftbd.com/smsapi/non-masking?api_key={$apiKey}&smsType=text&mobileNo={$to}&smsContent={$msg}";



                     $client = new Client();
                     //https://stackoverflow.com/questions/46005027/handling-client-errors-exceptions-on-guzzlehttp            
                    try {
                            $r = $client->request('GET', $url);
                        } catch (\GuzzleHttp\Exception\ConnectException $e) {
                            // This is will catch all connection timeouts
                            // Handle accordinly
                        } catch (\GuzzleHttp\Exception\ClientException $e) {
                            // This will catch all 400 level errors.
                            // return $e->getResponse()->getStatusCode();
                        }
                    ### sms api end here (masking & nonmasking seperate) ###

                return back()->with('success', 'Payment info successfully updated.');
            }            
        }
    }

    public function paymentDelete(Request $request, UserPayment $payment)
    {
        $payment->delete();
        return back()->with('info', 'Payment info deleted successfully.');
    }

    public function paymentAddNew(Request $request)
    {
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'payments','lsbsm'=>'paymentAddNew']);
        $packages = MembershipPackage::all();
        return view('admin.payments.paymentAddNew', [
            'packages' => $packages
        ]);
    }

    public function paymentAddNewPost(Request $request)
    {
         // dd($request->all());
        $validation = Validator::make($request->all(),
        [
              "email" => 'required|email|exists:users,email',
              "package" => "required",
              "paid_amount" => "required|numeric",
              "paid_currency" => "required",
              "payment_method" => "required",
              "payment_details" => "required",
              // 'admin_comment' => 'required'
        ]);
        if($validation->fails())
        {
            return redirect()->back()
            ->withErrors($validation)
            ->withInput()
            ->with('error', 'Something went wrong, please try again.');
        }

        $user = User::withoutGlobalScopes()->where('email', $request->email)->first();
        if(!$user)
        {
            abort(404);
        }

        $package = MembershipPackage::where('id', $request->package)
        ->first();
        if($package)
        {
            $payment = UserPayment::where('user_id', $user->id)
                        ->where('status', 'pending')->first();
            if($payment)
            {
                return back()
                ->with('info', 'Previous payment order of this user is pending');
            }else
            {
                $payment = new UserPayment;
                $payment->status = 'paid';
                $payment->membership_package_id = $package->id;
                $payment->package_title = $package->package_title;
                $payment->package_description = $package->package_description;
                $payment->package_amount = $package->package_amount;
                $payment->package_currency = $package->package_currency;
                $payment->package_duration = $package->package_duration;
                $payment->paid_amount = $request->paid_amount;
                $payment->paid_currency = $request->paid_currency;
                $payment->payment_method = $request->payment_method;
                $payment->payment_details = $request->payment_details;
                $payment->admin_comment = $request->admin_comment;
                $payment->user_id = $user->id;
                $payment->addedby_id = Auth::id();
                $payment->editedby_id= Auth::id();
                $payment->save();

                $user->package = $payment->membership_package_id;
                $expired_at = $user->expired_at;
                if($expired_at > Carbon::now())
                {
                    $user->expired_at = $expired_at->addDays($payment->package_duration);
                }else
                {
                    $user->expired_at = Carbon::now()->addDays($payment->package_duration);
                }

                $user->save();

                if(!(env('APP_ENV') == 'local'))
                {  
                    Mail::send('emails.paymentAcceptedToUser', ['payment'=>$payment], function ($message) use ($payment){
                        $message->from('info@bridegroombd.com', 'bridegroombd Payment Section');
                        $message->to($payment->user->email,  '')
                        ->subject('Payment Processing Completed at '.url('/'));
                    });


                    Mail::send('emails.newPaidPayment', ['payment'=>$payment], function ($message){
                    $message->from('info@bridegroombd.com', 'bridegroombd  Payment Section');
                    $message->to('info@bridegroombd.com',  '')
                    ->subject('New Payment Order is submitted at '.url('/'));
                });

                    
                }






                ### sms api end here (masking & nonmasking seperate) ###

        $to = bdMobile(env('CONTACT_MOBILE1'));
                    
         
        $msg = 'Hello Admin, New payment details: Amount: ' . $payment->paid_amount . ' ' . $payment->paid_currency . '. Package ID: ' . $payment->membership_package_id . '. User:'. $user->email;

        $url = smsUrl($to,$msg);
        
        // $url = "http://connect.primesoftbd.com/smsapi/non-masking?api_key={$apiKey}&smsType=text&mobileNo={$to}&smsContent={$msg}";



                     $client = new Client();
                     //https://stackoverflow.com/questions/46005027/handling-client-errors-exceptions-on-guzzlehttp            
                    try {
                            $r = $client->request('GET', $url);
                        } catch (\GuzzleHttp\Exception\ConnectException $e) {
                            // This is will catch all connection timeouts
                            // Handle accordinly
                        } catch (\GuzzleHttp\Exception\ClientException $e) {
                            // This will catch all 400 level errors.
                            // return $e->getResponse()->getStatusCode();
                        }
                    ### sms api end here (masking & nonmasking seperate) ###





                // ### sms api end here (masking & nonmasking seperate) ###

                //     $masking = smsMaskingCode();
                //     $to = env('CONTACT_MOBILE1');
                //     $username = 'info@matchinglifebd.com';
                //     $pass = '123456';
                //     $apiKey = smsApiKey();
                //     $msg = 'Hello Admin, New payment details: Amount: ' . $payment->paid_amount . ' ' . $payment->paid_currency . '. Package ID: ' . $payment->membership_package_id . '. User:'. $user->email;  
                    
                //     $url = "http://connect.primesoftbd.com/smsapi/masking?api_key={$apiKey}&smsType=text&maskingID={$masking}&mobileNo={$to}&smsContent={$msg}"; 


                //      $client = new Client();
                //      //https://stackoverflow.com/questions/46005027/handling-client-errors-exceptions-on-guzzlehttp            
                //     try {
                //             $r = $client->request('GET', $url);
                //         } catch (\GuzzleHttp\Exception\ConnectException $e) {
                //             // This is will catch all connection timeouts
                //             // Handle accordinly
                //         } catch (\GuzzleHttp\Exception\ClientException $e) {
                //             // This will catch all 400 level errors.
                //             // return $e->getResponse()->getStatusCode();
                //         }
                //     ### sms api end here (masking & nonmasking seperate) ###

                return back()->with('success', 'Payment info successfully saved.');
            }            
        }
    }

    public function __construct()
    {
        $this->middleware('active');
    }

    public function paymentHistoryForUser(Request $request)
    {
        $user = User::withoutGlobalScopes()->find($request->user);

        if(!$user)
        {
            abort(404);
        }
        $payments = UserPayment::where('user_id', $user->id)
                    ->latest()
                    ->paginate(40);

        return view('admin.payments.paymentHistoryForUser', [ 
            'user' => $user,
            'payments' => $payments
        ]);        
    }

    //payments end


    public function userProfilepicChange(Request $request, User $user)
    {
        $validation = Validator::make($request->all(),
            ['profile_picture' => 'required|image|mimes:jpeg,bmp,png,gif,jpg|dimensions:min_width=160,min_height=160,max_width=3000,max_height=3000'
        ]);
        if($validation->fails())
        {
            if($request->ajax())
            {
              return Response()->json(View('admin.users.ajax.userProfilePic', ['user' => $user])
                ->render());
            }

            return redirect()->back()
            ->withErrors($validation)
            ->withInput()
            ->with('error', 'image must be at least 160px width and 160px height');
        }

        if($request->hasFile('profile_picture'))
        {
            $cp = $request->file('profile_picture');
            $cw= (int) $request->change_width;
            $ch = (int) $request->change_height;
            $x = $request->off_x > 0 ? (int) $request->off_x : 0;
            $y = $request->off_y > 0 ? (int) $request->off_y : 0;
            $extension = $cp->getClientOriginalExtension();
            $mime = $cp->getClientMimeType();
            $size =$cp->getSize();

            $randomFileName = $user->id.'_pp_'.date('Y_m_d_his').'_'.rand(11111111,99999999).'.'.$extension;

            list($originalWidth,$originalHeight) = getimagesize($cp);
            // if($originalWidth == '200' && $originalHeight == '200')
            // {
            //     Storage::disk('upload')
            //     ->put('users/pp/'.$randomFileName, File::get($cp));
            //             //pfi = product feature image
            // }
            // else if($originalWidth == '160' && $originalHeight == '160')
            // {
            //     Storage::disk('upload')
            //     ->put('users/pp/'.$randomFileName, File::get($cp));
            //             //pfi = product feature image
            // }
            // else
            // {

                $image = Image::make($cp)
                ->crop($cw, $ch, $x, $y)
                ->resize(160, 160)
                ->save(public_path().'/storage/users/pp/'.$randomFileName, 90);
                // $watermark = Image::make(public_path('/img/tmm5.png'));
                // $image->insert($watermark);
                // $image->insert($watermark, 'bottom-right', 10, 10);
                // $image->mask($watermark, true);
                // $image->fill($watermark, 0, 0);
                // $image->save(public_path().'/storage/users/pp/'.$randomFileName, 90);
                // $image->save();


                $originalWidth = $image->width();
                $originalHeight = $image->height();
                $image->destroy();


            // }

            $oldRows = $user->userPictures()
            ->whereImageType('profilepic')
            ->whereAutoload(true)
            ->update([
                'autoload'=>false, 
                'editedby_id' => Auth::id()
            ]);

            $cp = $user->userPictures()
            ->create([]);
            $cp->autoload = true;
            $cp->checked = true;
            $cp->image_type = 'profilepic';
            $cp->image_name = $randomFileName;
            $cp->image_mime = $mime;
            $cp->image_ext = $extension;
            $cp->image_width = $originalWidth;
            $cp->image_height = $originalHeight;
            $cp->image_size = $size;
            $cp->image_alt = env('APP_NAME_BIG');
            $cp->save();

            $user->img_name = $randomFileName;
            $user->save();



            if($request->ajax())
            {
              return Response()->json(View('admin.users.ajax.userProfilePic', ['user' => $user])
                ->render());
          }
      }
      return back();
    }


    public function updateUsersFeatureImage()
    {
        UserPicture::where('image_type', 'profilepic')
        ->where('autoload', true)
        ->where('checked', true)
        ->orderBy('id')->chunk(200, function($collection){

            foreach ($collection as $value) {
               $u = User::where('id', $value->user_id)->first();
               if($u)
               {
                    $u->img_name = $value->image_name;
                    $u->save();
               }
            }

        });

        return back()->with('success', 'Users successfully updated.');

    }

    public function userProfilepicCheck(Request $request, UserPicture $pic)
    {
        if($request->term == 'edit')
        {
            if($pic->can_edit)
            {
                $pic->can_edit = 0;

            }else
            {
                $pic->can_edit = 1;
            }

        }else
        {
            if($pic->checked)
            {
                $pic->checked = 0;

            }else
            {
                $pic->checked = 1;
            }
        }
        $pic->editedby_id = Auth::id();
        $pic->save();

        if($request->ajax())
        {
              return Response()->json([
                'success' => true
              ]);
        }

        return back();
    }
    public function userCvChecked(Request $request, User $user)
    {

        if($user->cv_checked)
        {
            $user->cv_checked = 0;
            $user->save();
            
        }else
        {
            $user->cv_checked = 1;
            $user->save();
        }
        

        if($request->ajax())
        {
              return Response()->json([
                'success' => true
              ]);
        }

        return back();
    }

    public function uploadNewCv(Request $request)
    {
 

        $user = User::withoutGlobalScopes()->where('id', $request->user)->first();
        if(!$user)
        {
            abort(404);
        }

        if($request->hasFile('cv'))
        {
            $file = $request->cv;
            $ext = $file->getClientOriginalExtension();

        if( $ext ==  'jpg' or
            $ext ==  'jpeg' or
            $ext ==  'png' or
            $ext ==  'bmp' or
            $ext ==  'gif' or
            $ext ==  'pdf' or
            $ext ==  'doc' or
            $ext ==  'docx')
        {

        }else
        {
            return back()->with('error', 'Please, upload a pdf or image or word file');
        }

            $imageNewName = $user->id. '_cv_'. str_random(8).time().'.'.$ext;

            Storage::disk('upload')
            ->put('users/cv/'.$imageNewName, File::get($file));

            if($user->file_name)
            {
                Storage::disk('upload')->delete('users/cv/'.$user->file_name);
            }

            $user->file_name = $imageNewName;
            $user->file_ext = $ext;
            $user->cv_checked = 1;
            $user->save();

            return back()->with('success', 'Cv Successfully Uploaded.');
        }
    }


    public function uploadNewPublicPhotos(Request $request, User $user)
    {

    $validation = Validator::make($request->all(),
        ['photos.*' => 'image|mimes:jpeg,bmp,png,gif'
    ]);
    if($validation->fails())
    {
        return redirect()->back()
        ->withErrors($validation)
        ->withInput()
        ->with('error', 'Upload jpg, png, gif jpeg files.');
    }

        // dd($request->all());
    if($request->hasFile('photos'))
    {
        foreach($request->photos as $file)
        {


            $ext = $file->getClientOriginalExtension();
            $mime = $file->getClientMimeType();
            $size =$file->getSize();
            $originalName =$file->getClientOriginalName();
            list($originalWidth,$originalHeight) = getimagesize($file);



            $imageNewName = str_random(8).time().'.'.$ext;

            Storage::disk('upload')
            ->put('users/photos/'.$imageNewName, File::get($file));

            $image_new_url = 'storage/users/photos/'.$imageNewName;


            $cp = $user->userPhotos()
            ->create([
                'autoload' =>false,
                'img_type' => $request->type == 'private' ? 'private' : 'public',
                'addedby_id' => Auth::id()
            ]);





            $cp->img_name = $imageNewName;
            $cp->img_original_name = $originalName;
            $cp->img_url = $image_new_url;
            $cp->img_size = $size;
            $cp->img_width = $originalWidth;
            $cp->img_height = $originalHeight;
            $cp->img_ext = $ext;
            $cp->img_mime = $mime;
            $cp->save();
        }

        return back()->with('success', 'Public Photos Successfully Uploaded.');
        }

        return back();

    }

    public function userPhotoDelete(UserPhoto $photo)
    {
        if($photo)
        {
            Storage::disk('upload')
            ->delete('users/photos/'.$photo->img_name);
            $photo->delete();
        }

        return back()->with('info', 'Photo Successfully Deleted.');
    }

    public function userPPDelete(UserPicture $picture)
    {
        if($picture)
        {
            Storage::disk('upload')
            ->delete('users/pp/'.$picture->image_name);
            $user = $picture->user;
            $user->img_name = null;
            $user->save();
            $picture->delete();
        }

        return back()->with('info', 'Photo Successfully Deleted.');
    }

    public function newTempPassSendPost(Request $request, User $user)
    {
        // dd($request->all());
        // $validation = Validator::make($request->all(),
        // [ 
        //   'new_password' => 'required|min:6'
        // ]);

        // if($validation->fails())
        // {
        //     return back()
        //     ->withErrors($validation)
        //     ->withInput()
        //     ->with('error', 'Something Went Worng!');
        // }
        
        $newPass = $request->new_password ?: rand(100000,999999);

        // $user->password_temp = $request->new_password;
        $user->password_temp = $newPass;
        $user->password = Hash::make($newPass);
        $user->editedby_id = Auth::id();
        $user->save();

        if($user->mobile)
        {
            if(strlen(bdMobile($user->mobile)) == 13)
                {
                    $user->passwordResetSmsSend();
                }
        }

        return back()->with('success', "New temporary password set for {$user->username}");


    }

    public function userCommentByAdminPost(Request $request, User $user)
    {
        $validation = Validator::make($request->all(),
        [
            "comment" => 'required|min:4',
        ]);

        if($validation->fails())
        {
            if($request->ajax())
            {
                return Response()->json(array(
                    'success' => false,
                    'errors' => $validation->errors()->toArray()
                ));
            }

            return back()
            ->withInput()
            ->withErrors($validation);
        }

        $comment = new UserComment;
        $comment->comment = $request->comment;
        $comment->user_id = $user->id;
        $comment->addedby_id = Auth::id();
        $comment->save();

        if($request->ajax())
        {
            return Response()->json(View("user.ajax.partViews.{$v}", [
                'u'=>Auth::user()
            ])->render());
        }

        return back()->with('success', 'Your Message successfully submitted.');  
    }

    public function upgradeUserForFreePost(Request $request)
    {
        // dd($request->all());


        $validation = Validator::make($request->all(),
        [
              "free_membership_duration" => 'required|numeric',
        ]);
        if($validation->fails())
        {
            return redirect()->back()
            ->withErrors($validation)
            ->withInput()
            ->with('error', 'Something went wrong, please try again.');
        }

        $duration = $request->free_membership_duration;

        $user = User::withoutGlobalScopes()->where('id', $request->user)->first();
        if(!$user)
        {
            abort(404);
        }


            $payment = UserPayment::where('user_id', $user->id)
                        ->where('status', 'pending')->first();
            if($payment)
            {
                return back()
                ->with('info', "Previous payment order of {$user->username} is pending");
            }else
            {
                $payment = new UserPayment;
                $payment->status = 'paid';
                $payment->membership_package_id = null;
                $payment->package_title = 'Free Package';
                $payment->package_description = 'Free Packages offered by admin';
                $payment->package_amount = 0;
                $payment->package_currency = 'BDT';
                $payment->package_duration = $duration;
                $payment->paid_amount = 0;
                $payment->paid_currency = 'BDT';
                $payment->payment_method = null;
                $payment->payment_details = 'This membership package is fully free';
                $payment->admin_comment = "Dear {$user->username}, We offered you {$duration} days free membership access. Stay connected and enjoy.";
                $payment->user_id = $user->id;
                $payment->addedby_id = Auth::id();
                $payment->editedby_id= Auth::id();
                $payment->save();

                $expired_at = $user->expired_at;
                if($expired_at > Carbon::now())
                {
                    $user->expired_at = $expired_at->addDays($duration);
                }else
                {
                    $user->expired_at = Carbon::now()->addDays($duration);
                }
                $user->package = 0;
                $user->save();

                if(!(env('APP_ENV') == 'local'))
                {  
                    Mail::send('emails.paymentAcceptedToUser', ['payment'=>$payment], function ($message) use ($payment){
                        $message->from('info@bridegroombd.com', 'bridegroombd Payment Section');
                        $message->to($payment->user->email,  '')
                        ->subject('Payment Processing Completed at '.url('/'));
                    });
                }

                return back()->with('success', 'Free package processing successfully completed.');
            }            
    }

    //proposal

    public function proposalsGroup(Request $request)
    {
        $type = $request->type;
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'proposal','lsbsm'=>$type]);

        if($type == 'pending_proposals')
        {
            $proposalsAll = UserProposal::has('user')->has('userSecond')->where('accepted', false)->orderBy('checked')->paginate(50);
        }elseif ($type == 'accepted_proposals') 
        {
            $proposalsAll = UserProposal::has('user')->has('userSecond')->where('accepted', true)->orderBy('checked')->paginate(50);
        }else
        {
            $proposalsAll = UserProposal::has('user')->has('userSecond')->orderBy('checked')->paginate(50);
            
        }


        return view('admin.proposals.proposalsGroup', [
            'proposalsAll' => $proposalsAll,
            'type' => $type
        ]);
    }

    public function proposalCheckedByAdmin(Request $request, UserProposal $proposal)
    {
        if($proposal->checked)
        {
            $proposal->checked = 0;

        }else
        {
            $proposal->checked = 1;
        }

        $proposal->editedby_id = Auth::id();
        $proposal->save();

        if($request->ajax())
        {
              return Response()->json([
                'success' => true
              ]);
        }

        return back();


    }

    public function proposalsOfUser(User $user, Request $request)
    {
        $proposals = UserProposal::has('user')
        ->has('userSecond')
        ->where(function($q) use ($user){
            $q->where('user_id', $user->id)
            ->orWhere('user_second_id', $user->id);

        })->orderBy('checked')->paginate(50);

        return view('admin.users.proposals', ['user'=>$user, 'proposalsAll'=>$proposals]);
    }
    //proposal

    //websiteparameter

    public function websiteParameter()
    {
        $request = request();
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'dashboard','lsbsm'=>'websiteParameter']);

        $post = WebsiteParameter::firstOrCreate([]);

        return view('admin.websiteParameter',['post'=>$post]);
    }

    public function websiteParameterUpdate()
    {
        $request = request();
        $post = WebsiteParameter::firstOrCreate([]);

        $post->title = $request->title;
        $post->short_title = $request->short_title;
        $post->h1 = $request->h1;
        $post->google_analytics_code = $request->google_analytics_code;
        $post->facebook_pixel_code = $request->facebook_pixel_code;
        $post->meta_author = $request->meta_author;
        $post->meta_keyword = $request->meta_keyword;
        $post->meta_description = $request->meta_description;
        $post->slogan = $request->slogan;
        $post->footer_address = $request->footer_address;
        $post->footer_copyright = $request->footer_copyright;
        $post->fb_url = $request->fb_url;
        $post->linkedin_url = $request->linkedin_url;
        $post->twitter_url = $request->twitter_url;
        $post->pinterest_url = $request->pinterest_url;
        $post->youtube_url = $request->youtube_url;
        $post->google_plus_url = $request->google_plus_url;
        // $post->google_map_code = $request->google_map_code;
        // $post->addthis_url = $request->addthis_url;
        // $post->main_color = $request->main_color ?: 'default';
        // $post->sub_color = $request->sub_color ?: 'default';
        // $post->header_bg_color = $request->header_bg_color ?: 'default';
        // $post->header_text_color = $request->header_text_color ?: 'default';
        // $post->footer_bg_color = $request->footer_bg_color ?: 'default';
        // $post->footer_text_color = $request->footer_text_color ?: 'default';

        if($request->favicon)
        {
            $file = $request->favicon;
            Storage::disk('upload')->delete('favicon/'.$post->favicon);

            $originalName = $file->getClientOriginalName();
            Storage::disk('upload')->put('favicon/'.$originalName, File::get($file));
            $post->favicon = $originalName;
        }

        if($request->logo)
        {
            $file = $request->logo;
            Storage::disk('upload')->delete('logo/'.$post->logo);

            $originalName = $file->getClientOriginalName();
            Storage::disk('upload')->put('logo/'.$originalName, File::get($file));
            $post->logo = $originalName;
        }

        // if($request->android_apk)
        // {
        //     $apk = $request->android_apk;
        //     Storage::disk('upload')->delete('apk/'.$post->android_apk);

        //     $on = $apk->getClientOriginalName();
        //     Storage::disk('upload')->put('apk/'.$on, File::get($apk));
        //     $post->android_apk = $on;
        // }


        if($request->about_sub_img)
        {
            $file = $request->about_sub_img;
            if ($post->about_sub_img) 
            {
                Storage::disk('upload')->delete('media/image/'.$post->about_sub_img);
            }     
            $newName = time().rand(11111,99999).'.'.strtolower($file->getClientOriginalExtension());
            Storage::disk('upload')->put('media/image/'.$newName, File::get($file));
            $post->about_sub_img = $newName;
        }

        if($request->package_sub_img)
        {
            $file = $request->package_sub_img;
            if ($post->package_sub_img) 
            {
                Storage::disk('upload')->delete('media/image/'.$post->package_sub_img);
            }     
            $newName = time().rand(11111,99999).'.'.strtolower($file->getClientOriginalExtension());
            Storage::disk('upload')->put('media/image/'.$newName, File::get($file));
            $post->package_sub_img = $newName;
        }

        if($request->story_sub_img)
        {
            $file = $request->story_sub_img;
            if ($post->story_sub_img) 
            {
                Storage::disk('upload')->delete('media/image/'.$post->story_sub_img);
            }     
            $newName = time().rand(11111,99999).'.'.strtolower($file->getClientOriginalExtension());
            Storage::disk('upload')->put('media/image/'.$newName, File::get($file));
            $post->story_sub_img = $newName;
        }

        if($request->contact_sub_img)
        {
            $file = $request->contact_sub_img;
            if ($post->contact_sub_img) 
            {
                Storage::disk('upload')->delete('media/image/'.$post->contact_sub_img);
            }     
            $newName = time().rand(11111,99999).'.'.strtolower($file->getClientOriginalExtension());
            Storage::disk('upload')->put('media/image/'.$newName, File::get($file));
            $post->contact_sub_img = $newName;
        }



        $post->save();

        Cache::forget('websiteParameter');

        return back()->with('success', 'Website Parameter Successfully Updated.');
    }
    //websiteparameter



    //sms start
    public function quickSmsDraft()
    {
        $request = request();
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'sms','lsbsm'=>'quickSmsDraft']);
        $ip = $request->ip();


        return view('admin.sms.quickSmsDraft',['ip'=>$ip]);
    }

    public function quickSmsDraftSend(QuickSmsContactBulk $bulk, Request $request)
    {
        if ($request->ajax())
        {
            return Response()->json([
                'page' => View('admin.sms.ajax.quickSmsDraftSend',[
                    'bulk'=> $bulk,
                    'ip'=>$request->ip()
                ])->render(),
                'success' => true
            ]);
        }

        return back();
    }

    public function quickSmsDraftSendPost(QuickSmsContactBulk $bulk, Request $request)
    {
        // dd($bulk);
        $validation = Validator::make($request->all(),
        [
            "recipients" => "required",
            // "sender_number" => "required|numeric",
            "message" => "required|string",
            // 'accept'=>'required'

        ]);

        if($validation->fails())
        {
            return back()
            ->withErrors($validation)
            ->withInput()
            ->with('error', 'Something Went Wrong!');
        }

        if($request->recipients)
        {

            $bulk->contacts()->delete();
            
            $bulk->sent_from = $request->masking ? $request->sender_number : null;
            $bulk->message = $request->message;

 

            $rs = trim($request->recipients);
            $rs = rtrim($rs,',');
            $rs = explode(",",$rs);

            foreach($rs as $number)
            {
                $number = bdMobile($number);
                
                if(strlen($number) == 13)
                {
                    $bulk->status = 'sent'; //temp,draft,sent
                    $bulk->save();

                    $sms = new QuickSmsContact;
                    $sms->quick_sms_contact_bulk_id = $bulk->id;
                    $sms->mobile = $number;
                    $sms->status = 'sent'; //temp,draft,sent
                    $sms->addedby_id = Auth::id();
                    $sms->save();
                }                
            }

            if((!$bulk->id) or (!$bulk->contacts->count()))
            {

                return back()->with('error', 'Sorry, There is no contacts.');
            }



            ### sms api start here (masking & nonmasking seperate) ###

            $contacts = '';
            foreach ($bulk->contacts as $contact) {

                $contacts = $contacts.$contact->mobile.',';
                
            }
            

            // $masking = $request->sender_number;
            // $username = 'info@matchinglifebd.com';
            // $pass = '123456';
            // $apiKey = smsApiKey();
            $to = $contacts;
            $msg = trim($request->message);  
            
            //API URL Non Masking (GET & POST)

            ##   http://connect.primesoftbd.com/smsapi/non-masking?api_key=$2y$10$PT2OlLaCqLcVhqd1P1kl7ePKWg5axIQXjiuFFfYKtrJc03k8ohYYy&smsType=text&mobileNo=(NUMBER)&smsContent=(Message Content)

            //API URL Masking (GET & POST)

            ##  http://connect.primesoftbd.com/smsapi/masking?api_key=$2y$10$PT2OlLaCqLcVhqd1P1kl7ePKWg5axIQXjiuFFfYKtrJc03k8ohYYy&smsType=text&maskingID=(MASKING)&mobileNo=(NUMBER)&smsContent=(Message Content)

            //Credit Balance API
            ##  http://connect.primesoftbd.com/api/balance?api_key=$2y$10$PT2OlLaCqLcVhqd1P1kl7ePKWg5axIQXjiuFFfYKtrJc03k8ohYYy

            //$url = "http://brandsms.mimsms.com/smsapi?api_key={$apiKey}&type=text&contacts={$to}&senderid={$senderid}&msg={$msg}"; 

            if($request->masking)
            {
                // $url = "http://connect.primesoftbd.com/smsapi/masking?api_key={$apiKey}&smsType=text&maskingID={$masking}&mobileNo={$to}&smsContent={$msg}"; 

                $url = smsUrl($to,$msg);
            }else
            {
                // $url = "http://connect.primesoftbd.com/smsapi/non-masking?api_key={$apiKey}&smsType=text&mobileNo={$to}&smsContent={$msg}"; 

                $url = smsUrl($to,$msg);
            }


            

            // dd($url);         
            
            
             $client = new Client();
             # $response = $client->request('GET', $url);

             //https://stackoverflow.com/questions/46005027/handling-client-errors-exceptions-on-guzzlehttp
             
            try {
                    $r = $client->request('GET', $url);

                    
                } catch (\GuzzleHttp\Exception\ConnectException $e) {
                    // This is will catch all connection timeouts
                    // Handle accordinly
                } catch (\GuzzleHttp\Exception\ClientException $e) {
                    // This will catch all 400 level errors.
                    // return $e->getResponse()->getStatusCode();
                }

            ### sms api end here (masking & nonmasking seperate) ###

            return back()->with('success','Your Quick SMS successfully sent.');
        }
    }


    public function quickSmsDraftSave(Request $request)
    {
        // dd();
        $validation = Validator::make($request->all(),
        [
            "recipients" => "required",
            // "sender_number" => "required|numeric",
            "message" => "required|string",
            // 'accept'=>'required'

        ]);

        if($validation->fails())
        {
            return back()
            ->withErrors($validation)
            ->withInput()
            ->with('error', 'Something Went Wrong!');
        }

        if($request->recipients)
        {
            
            $bulk = new QuickSmsContactBulk;
            $bulk->addedby_id = Auth::id();
            $bulk->sent_from = $request->sender_number ?: null;
            $bulk->message = $request->message;


            $rs = trim($request->recipients);
            $rs = rtrim($rs,',');
            $rs = explode(",",$rs);
            // dd($rs);

            foreach($rs as $number)
            {
                $number = bdMobile($number);
                 
                // dd(strlen($number));
                if(strlen($number) == 13)
                {
                    $bulk->status = 'draft'; //temp,draft,sent
                    $bulk->save();

                    $sms = new QuickSmsContact;
                    $sms->quick_sms_contact_bulk_id = $bulk->id;
                    $sms->mobile = $number;
                    $sms->status = 'draft'; //temp,draft,sent
                    $sms->addedby_id = Auth::id();
                    $sms->save();
                }

                
            }

            if((!$bulk->id) or (!$bulk->contacts->count()))
            {

                return back()
                ->withInput()
                ->with('error', 'Sorry, Try again with bangladeshi valid mobile numbers.');
            }

            return back()->with('success','Your Draft Successfully Saved.');
        }
    }

    public function sendSmsToBusiness()
    {
        $request = request();
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'sms','lsbsm'=>'sendSmsToBusiness']);

        return view('admin.sms.sendSmsToBusiness',['ip'=>$request->ip()]);
    }

    public function sendSmsToBusinessPost(Request $request)
    {
        // dd($request->all());
        $validation = Validator::make($request->all(),
        [
            'category' => 'required',
            'sentFrom'=>'required',
            'thana' => 'required',
            'totalSms' => 'required|numeric|min:1|max:100',
            'message' => 'required',
            // 'accept'=>'required'
        ]);

        if($validation->fails())
        {
            return back()
            ->withErrors($validation)
            ->withInput()
            ->with('error', 'Something Went Wrong!');
        }


        // $cost = $request->totalSms * 0.10; //per sms 0.10 TK

        // if(Auth::user()->balance() < $cost)
        // {
        //     return back()->withInput()->with('error', 'Sorry, There is no sufficient balance in your account.');
        // }



        $dirs = WebDirectory::where('thana', $request->thana)
        ->where('category', $request->category)
        ->whereNotNull('verified_phone')
        ->take($request->totalSms)
        ->get();
        if($dirs->count())
        {
            $smsContactBulk = new SmsContactBulk;
            $smsContactBulk->category = $request->category;
            $smsContactBulk->thana = $request->thana;
            $smsContactBulk->sent_from = $request->sentFrom; //sender number
            $smsContactBulk->message = $request->message;
            $smsContactBulk->addedby_id = Auth::id();
            $smsContactBulk->save();

            // $i = 0;
            $c_code =880; //bd country code
            $cc_count = strlen($c_code);

            foreach($dirs as $dir)
            {
                if($dir->verified_phone)
                {
                    $number = $dir->verified_phone;
                    if(substr($number, 0, 2) == '00')
                    {
                        $number = ltrim($number, '0');
                    }
                    if(substr($number, 0, 1) == '+')
                    {
                        $number = ltrim($number, '+');
                    }
                    if(substr($number, 0, $cc_count) == $c_code)
                    {
                        $number = substr($number, $cc_count);
                    }
                    if(substr($c_code, -1) == 0)
                    {
                        $number = ltrim($number, '0');
                    }

                    $number = filter_var($number, FILTER_SANITIZE_NUMBER_INT);

                    $number = $c_code.$number;

                    $smsContact = new SmsContact;
                    $smsContact->sms_contact_bulk_id = $smsContactBulk->id;
                    $smsContact->directory_id = $dir->id;
                    $smsContact->verified_phone = $number;
                    $smsContact->save();

                    // $i++;
                }
                
            }

            // $cost = $i * config('parameter.sms_cost');
            // $service = $smsContactBulk;
            // $serviceType = 'sms';
            // Auth::user()->serviceCost($cost, $service,$serviceType); //cost, service,serviceType


            return back()->with('success','SMS successfully sent to '.$dirs->count().' contacts');
        }

        return back()->with('info','Oops, No contact found');         
    }

    public function quickSms()
    {
        $request = request();
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'sms','lsbsm'=>'quickSms']);
        $ip = $request->ip();

        return view('admin.sms.quickSms',['ip'=>$ip]);
    }

    public function quickSmsSend(Request $request)
    {
        // dd($request->all());
         $validation = Validator::make($request->all(),
        [
            "recipients" => "required",
            // "sender_number" => "required|numeric",
            "message" => "required|string",
            // 'accept'=>'required'


        ]);

        if($validation->fails())
        {
            return back()
            ->withErrors($validation)
            ->withInput()
            ->with('error', 'Something Went Wrong!');
        }

        if($request->recipients)
        {
            $bulk = new QuickSmsContactBulk;
            $bulk->addedby_id = Auth::id();
            $bulk->sent_from = $request->masking ? $request->sender_number : null;
            $bulk->message = $request->message;

 

            $rs = trim($request->recipients);
            $rs = rtrim($rs,',');
            $rs = explode(",",$rs);

            foreach($rs as $number)
            {
                $number = bdMobile($number);
                
                if(strlen($number) == 13)
                {
                    $bulk->status = 'sent'; //temp,draft,sent
                    $bulk->save();

                    $sms = new QuickSmsContact;
                    $sms->quick_sms_contact_bulk_id = $bulk->id;
                    $sms->mobile = $number;
                    $sms->status = 'sent'; //temp,draft,sent
                    $sms->addedby_id = Auth::id();
                    $sms->save();
                }                
            }

            if((!$bulk->id) or (!$bulk->contacts->count()))
            {

                return back()->with('error', 'Sorry, There is no contacts.');
            }



            ### sms api start here (masking & nonmasking seperate) ###

            $contacts = '';
            foreach ($bulk->contacts as $contact) {

                $contacts = $contacts.$contact->mobile.',';
                
            }
            

            // $masking = $request->sender_number;
            // $username = 'info@matchinglifebd.com';
            // $pass = '123456';
            // $apiKey = smsApiKey();
            $to = $contacts;
            $msg = trim($request->message);  
            
            //API URL Non Masking (GET & POST)

            ##   http://connect.primesoftbd.com/smsapi/non-masking?api_key=$2y$10$PT2OlLaCqLcVhqd1P1kl7ePKWg5axIQXjiuFFfYKtrJc03k8ohYYy&smsType=text&mobileNo=(NUMBER)&smsContent=(Message Content)

            //API URL Masking (GET & POST)

            ##  http://connect.primesoftbd.com/smsapi/masking?api_key=$2y$10$PT2OlLaCqLcVhqd1P1kl7ePKWg5axIQXjiuFFfYKtrJc03k8ohYYy&smsType=text&maskingID=(MASKING)&mobileNo=(NUMBER)&smsContent=(Message Content)

            //Credit Balance API
            ##  http://connect.primesoftbd.com/api/balance?api_key=$2y$10$PT2OlLaCqLcVhqd1P1kl7ePKWg5axIQXjiuFFfYKtrJc03k8ohYYy

            //$url = "http://brandsms.mimsms.com/smsapi?api_key={$apiKey}&type=text&contacts={$to}&senderid={$senderid}&msg={$msg}"; 

            if($request->masking)
            {
                // $url = "http://connect.primesoftbd.com/smsapi/masking?api_key={$apiKey}&smsType=text&maskingID={$masking}&mobileNo={$to}&smsContent={$msg}"; 

                $url = smsUrl($to,$msg);
            }else
            {
                // $url = "http://connect.primesoftbd.com/smsapi/non-masking?api_key={$apiKey}&smsType=text&mobileNo={$to}&smsContent={$msg}"; 

                $url = smsUrl($to,$msg);
            }


            

            // dd($url);         
            
            
             $client = new Client();
             # $response = $client->request('GET', $url);

             //https://stackoverflow.com/questions/46005027/handling-client-errors-exceptions-on-guzzlehttp
             
            try {
                    $r = $client->request('GET', $url);

                    
                } catch (\GuzzleHttp\Exception\ConnectException $e) {
                    // This is will catch all connection timeouts
                    // Handle accordinly
                } catch (\GuzzleHttp\Exception\ClientException $e) {
                    // This will catch all 400 level errors.
                    // return $e->getResponse()->getStatusCode();
                }

            ### sms api end here (masking & nonmasking seperate) ###

            return back()->with('success','Your Quick SMS successfully sent.');
        }
    }

    public function sentSmsBulk()
    {
        $request = request();

        if ($request->ajax())
        {
            if($request->type == 'business_sms')
            {
                $page = View('admin.sms.ajax.businessSmsBulks')->render();
            }
            if($request->type == 'quick_sms')
            {
                $page = View('admin.sms.ajax.quickSmsBulks')->render();
            }

            if($request->type == 'uploaded_sms')
            {
                $page = View('admin.sms.ajax.uploadedSmsBulks')->render();
            }

            return Response()->json([
                'page' => $page,
                'success'=>true
            ]);
        }

        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'sms','lsbsm'=>'sentSmsBulk']);

        // $bulks = SmsContactBulk::latest()->paginate(10);
        // $quickBulks = QuickSmsContactBulk::latest()->paginate(1);

        return view('admin.sms.sentSmsBulk');
    }

    public function businessSmsBulkItems(SmsContactBulk $bulk, Request $request)
    {
        $contacts = $bulk->contacts;
        if ($request->ajax())
        {
            return Response()->json([
                'page' => View('admin.sms.ajax.businessSmsBulkItems',['contacts' => $contacts])->render(),
                'success' => true
            ]);
        }

        return back();
    }

    public function quickSmsBulkItems(QuickSmsContactBulk $bulk, Request $request)
    {
        if ($request->ajax())
        {
            return Response()->json([
                'page' => View('admin.sms.ajax.quickSmsBulkItems',['bulk' => $bulk])->render(),
                'success' => true
            ]);
        }

        return back();
    }

    public function uploadedContactDraft()
    {
        $request = request();
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'sms','lsbsm'=>'uploadedContactDraft']);
        $ip = $request->ip();
        
        return view('admin.sms.uploadedContactDraft',['ip'=>$ip]);
    }

    public function uploadExcelContactFilePost(Request $request)
    {
        $validation = Validator::make($request->all(),
        [
          'file'=> 'required',
          'title' => 'required'
        ]);
        if($validation->fails())
        {
            return back()
            ->withErrors($validation)
            ->withInput()
            ->with('error', 'Something Went Worng!');
        }

        if($request->hasFile('file'))
        {
            $file = $request->file;
            $path = $file->getRealPath();
            $ext = $file->getClientOriginalExtension();

            if(!(($ext == "xlsx") or ($ext == "xls")))
            {
                return back()
                ->withInput()
                ->with('error', 'Please, Upload an excel file and try again.');

            }

  

            $data = Excel::selectSheets('Sheet1')->load($path, function($reader) use ($request) 
            {
                //$sheet1 = $reader->get(); 
                $sheet1 = $reader->get(array('name','company','area','mobile'));

                if($sheet1->first())
                {
                    if(!empty($sheet1) && $sheet1->count())
                    {
                        $bulk = new SmsUploadedContactBulk;
                        $bulk->title = trim($request->title);
                        $bulk->addedby_id = Auth::id();
                        $bulk->save();

                        $c_code =880; //bd country code
                        $cc_count = strlen($c_code);
 
                        foreach ($sheet1 as $key => $value) 
                        {
                            if($value->mobile)
                            {
                                $number = $value->mobile;
                                if(substr($number, 0, 2) == '00')
                                {
                                    $number = ltrim($number, '0');
                                }
                                if(substr($number, 0, 1) == '+')
                                {
                                    $number = ltrim($number, '+');
                                }
                                if(substr($number, 0, $cc_count) == $c_code)
                                {
                                    $number = substr($number, $cc_count);
                                }
                                if(substr($c_code, -1) == 0)
                                {
                                    $number = ltrim($number, '0');
                                }

                                $number = filter_var($number, FILTER_SANITIZE_NUMBER_INT);

                                $number = $c_code.$number;

                                // dd(strlen($number));
                                if(strlen($number) == 13)
                                {
                                    $contact = SmsUploadedContact::create([
                                        'sms_uploaded_contact_bulk_id'=>$bulk->id,
                                        'mobile' =>trim($number),
                                        'name' =>trim($value->name) ?: null,
                                        'company'=>trim($value->company) ?: null,
                                        'area'=>trim($value->area) ?: null,
                                        'status'=> 'draft',
                                        'addedby_id'=>Auth::id()
                                    ]);
                                }
                            }
                        }

                        if(SmsUploadedContact::where('sms_uploaded_contact_bulk_id',$bulk->id)->first())
                        {
                            $bulk->status = 'draft';
                            $bulk->save();
                            return back()->with('success', 'Your contact file successfully uploaded.');
                        }
                        else
                        {
                            $bulk->delete();
                            return back()->with('error', 'Your file uploaded faild. Please upload contacts (Mobile) correctly.');
                        }
                    } 
                }
                else
                {
                    return back()->with('error', 'Your file uploaded faild. Please try again with correct information. Confirm that your file has a Sheet named Sheet1');
                }
            })->get();
        }
        return back();         
    }   

    public function smsSendToUploadedContacts(SmsUploadedContactBulk $bulk, Request $request)
    {
        if ($request->ajax())
        {
            return Response()->json([
                'page' => View('admin.sms.ajax.smsSendToUploadedContacts',[
                    'bulk'=> $bulk,
                    'ip'=>$request->ip()
                ])->render(),
                'success' => true
            ]);
        }

        return back();
    } 

    public function allUploadedContacts(SmsUploadedContactBulk $bulk, Request $request)
    {
        if ($request->ajax())
        {
            return Response()->json([
                'page' => View('admin.sms.ajax.allUploadedContacts',[
                    'bulk'=> $bulk,
                    'ip'=>$request->ip()
                ])->render(),
                'success' => true
            ]);
        }

        return back();
    }

    public function uploadedContactDelete(SmsUploadedContact $contact, Request $request)
    {
        if ($request->ajax())
        {
            $bulk = $contact->bulk;
            $contact->delete();
            if($bulk->contacts->count() < 1)
            {
                $b_id = $bulk->id;
                $bulk->delete();

                return Response()->json([
                'success' => true,
                'bulk_deleted'=> true,
                'bulk_id'=>$b_id
                ]); 
            }
            return Response()->json([
                'success' => true,
                'bulk_deleted'=> false
            ]);
        }

        return back();
    }

    public function uploadedContactFileDelete(SmsUploadedContactBulk $bulk, Request $request)
    {
        if ($request->ajax())
        {
            $bulk->contacts()->delete();
            $b_id = $bulk->id;
            $bulk->delete();

            return Response()->json([
            'success' => true,
            'bulk_deleted'=> true,
            'bulk_id'=>$b_id
            ]); 
 
        }

        return back();
    }

    public function uploadedSmsBulkItems(SmsUploadedContactBulk $bulk, Request $request)
    {
        if ($request->ajax())
        {
            return Response()->json([
                'page' => View('admin.sms.ajax.uploadedSmsBulkItems',['bulk' => $bulk])->render(),
                'success' => true
            ]);
        }

        return back();
    }

    public function uploadedContactDraftSendPost(SmsUploadedContactBulk $bulk, Request $request)
    {
        // dd($bulk);
        $validation = Validator::make($request->all(),
        [
            "recipients" => "required",
            "sender_number" => "required|numeric",
            "message" => "required|string",
            // 'accept'=>'required'

        ]);

        if($validation->fails())
        {
            if($request->ajax())
            {
                return Response()->json(array(
                'success' => false,
                'errors' => $validation->errors()->toArray(),
                'js_error' => 'Something went wrong!'
                ));
            }

            return back()
            ->withErrors($validation)
            ->withInput()
            ->with('error', 'Something Went wrong!');
        }

        if($request->recipients)
        {

            // $bulk->contacts()->delete();
            
            $c_code =880; //bd country code
            $cc_count = strlen($c_code);


            $sender = $request->sender_number;
            if(substr($sender, 0, 2) == '00')
            {
                $sender = ltrim($sender, '0');
            }
            if(substr($sender, 0, 1) == '+')
            {
                $sender = ltrim($sender, '+');
            }
            if(substr($sender, 0, $cc_count) == $c_code)
            {
                $sender = substr($sender, $cc_count);
            }
            if(substr($c_code, -1) == 0)
            {
                $sender = ltrim($sender, '0');
            }

            $sender = filter_var($sender, FILTER_SANITIZE_NUMBER_INT);

            $sender = $c_code.$sender;
            if(strlen($sender) == 13)
            {
                $bulk->sent_from = $sender;
                $bulk->message = $request->message;

            }
            else{

                if($request->ajax())
                {
                    return Response()->json(array(
                    'success' => false,
                    'errors' => $validation->errors()->toArray(),
                    'js_error' => 'Your sender number is invalid'
                    ));
                }

                return back()
                ->withInput()
                ->with('error', 'Your sender number is invalid');
            }

            $rs = trim($request->recipients);
            $rs = rtrim($rs,',');
            $rs = explode(",",$rs);

            foreach($rs as $number)
            {
                if(substr($number, 0, 2) == '00')
                {
                    $number = ltrim($number, '0');
                }
                if(substr($number, 0, 1) == '+')
                {
                    $number = ltrim($number, '+');
                }
                if(substr($number, 0, $cc_count) == $c_code)
                {
                    $number = substr($number, $cc_count);
                }
                if(substr($c_code, -1) == 0)
                {
                    $number = ltrim($number, '0');
                }

                $number = filter_var($number, FILTER_SANITIZE_NUMBER_INT);

                $number = $c_code.$number;

                // dd(strlen($number));
                if(strlen($number) == 13)
                {
                    

                    $bulk->status = 'sent'; //temp,draft,sent
                    $bulk->save();

                    $contact = SmsUploadedContact::where('sms_uploaded_contact_bulk_id', $bulk->id)
                    ->where('mobile', $number)->first();
                    if($contact)
                    {
                        $contact->status = 'sent';
                        $contact->save();
                    }
                    else
                    {
                        $newContact = SmsUploadedContact::where([
                                'sms_uploaded_contact_bulk_id'=>$bulk->id,
                                'mobile' =>trim($number),
                                'status'=> 'sent',
                                'addedby_id'=>Auth::id()
                            ]);
                    }

                }                
            }

            if($request->ajax())
            {
                return Response()->json(array(
                'success' => true,
                'bulk_id' => $bulk->id,
                'js_success' => 'Your SMS successfully sent.'
                ));
            }

            return back()->with('success','Your SMS successfully sent.');
        }
    }

    public function quickSmsDraftDelete(QuickSmsContactBulk $bulk, Request $request)
    {
        if ($request->ajax())
        {
            $bulk->contacts()->delete();
            $b_id = $bulk->id;
            $bulk->delete();

            return Response()->json([
            'success' => true,
            'bulk_deleted'=> true,
            'bulk_id'=>$b_id
            ]); 
 
        }

        return back();
    }

    public function businessSmsBulkDelete(SmsContactBulk $bulk, Request $request)
    {
        if ($request->ajax())
        {
            $bulk->contacts()->delete();
            $b_id = $bulk->id;
            $bulk->delete();

            return Response()->json([
            'success' => true,
            'bulk_deleted'=> true,
            'bulk_id'=>$b_id
            ]); 
 
        }

        return back();
    }

    public function quickSmsBulkItemsResend(QuickSmsContactBulk $bulk, Request $request)
    {
        $nb = new QuickSmsContactBulk;
        $nb->addedby_id = Auth::id();
        $nb->sent_from = $bulk->sent_from;
        $nb->message = $bulk->message;
        $nb->save();

        foreach($bulk->contacts as $contact)
        {
            $sms = new QuickSmsContact;
            $sms->quick_sms_contact_bulk_id = $nb->id;
            $sms->mobile = $contact->mobile;
            $sms->status = 'draft'; //temp,draft,sent
            $sms->addedby_id = Auth::id();
            $sms->save();
        }

        if(QuickSmsContact::where('quick_sms_contact_bulk_id',$nb->id)->first())
        {
            $nb->status = 'draft';
            $nb->save();
            return redirect()->route('admin.quickSmsDraft')->with('info', 'See the SMS Draft Bulk list in the left side. Send from here.');
        }
        else
        {
            $nb->delete();
            return back()->with('error', 'Sorry, Some errors occurred.');
        }
    }

    public function uploadedContactFileResend(SmsUploadedContactBulk $bulk, Request $request)
    {
        $nb = new SmsUploadedContactBulk;
        $nb->title = $bulk->title;
        $nb->addedby_id = Auth::id();
        $nb->sent_from = $bulk->sent_from;
        $nb->message = $bulk->message;
        $nb->save();
        foreach($bulk->contacts as $contact)
        {
            $nc = new SmsUploadedContact;
            $nc->sms_uploaded_contact_bulk_id = $nb->id;
            $nc->mobile = $contact->mobile;
            $nc->name = $contact->name;
            $nc->company = $contact->company;
            $nc->area = $contact->area;
            $nc->status = 'draft';
            $nc->addedby_id = Auth::id();
            $nc->save();
        }

        if(SmsUploadedContact::where('sms_uploaded_contact_bulk_id',$nb->id)->first())
        {
            $nb->status = 'draft';
            $nb->save();
            return redirect()->route('admin.uploadedContactDraft')->with('success', 'See the Uploaded Contacts List. Send from there.');
        }
        else
        {
            $nb->delete();
            return back()->with('error', 'Sorry, Some errors occurred.');
        }
    }

    public function quickSmsBalanceCheck(Request $request)
    {
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'sms','lsbsm'=>'quickSmsBalanceCheck']);

        $url = smsBalanceUrl();


        $client = new Client();
             # $response = $client->request('GET', $url);

             //https://stackoverflow.com/questions/46005027/handling-client-errors-exceptions-on-guzzlehttp
             
        try {
                
                $r = $client->request('GET', $url);

                $balance = $r->getBody()->getContents();

                return view('admin.sms.quickSmsBalanceCheck', ['balance' => $balance]);

                // $r->getBody()->getContents()

                
            } catch (\GuzzleHttp\Exception\ConnectException $e) {
                // This is will catch all connection timeouts
                // Handle accordinly
            } catch (\GuzzleHttp\Exception\ClientException $e) {
                // This will catch all 400 level errors.
                // return $e->getResponse()->getStatusCode();
            }

            return back();
    }

    public function smsSendToUser(Request $request)
    {
        $user = User::where('id', $request->user)->first();

        if (!$user)
        {
            if($request->ajax())
            {
                return Response()->json(['success' => false]);
            }    
            abort(404);
        }

        if (env('APP_ENV') == 'production') 
        {    
            // $user->smsSendToUser();
            $user->sendCustomSmsToUser($request->details);
        }

        $user->sms_count = $user->sms_count + 1;
        $user->save();

        if($request->ajax())
        {
            return Response()->json([
                'success' => true,
                'sms_count' => $user->sms_count
            ]);
        } 
        return back()->with('success', 'SMS successfully Sent.');

    }

    //sms end


    // mobile and email numbers
    public function mobileNumbersAll(Request $request)
    {
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'mobileAndEmail','lsbsm'=>'mobileNumbersAll']);
        $users = User::latest()->groupBy('mobile')->paginate(100);
        return view('admin.mobileNumbersAll', ['users'=>$users]);
    }

    public function emailNumbersAll(Request $request)
    {
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'mobileAndEmail','lsbsm'=>'emailNumbersAll']);
        $users = User::latest()->groupBy('email')->paginate(100);
        return view('admin.emailNumbersAll', ['users'=>$users]);
    }
    // mobile and email numbers

    //income report

    public function incomeReportSummary(Request $request)
    {
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'incomeReport','lsbsm'=>'incomeReportSummary']);

        $pending_payments_bd = UserPayment::has('user')->where('status', 'pending')->where('paid_currency', 'BDT')->sum('paid_amount');
        $pending_payments_usa = UserPayment::has('user')->where('status', 'pending')->where('paid_currency', 'USD')->sum('paid_amount');
        $paid_payments_bd = UserPayment::has('user')->where('status', 'paid')->where('paid_currency', 'BDT')->sum('paid_amount');
        $paid_payments_usa = UserPayment::has('user')->where('status', 'paid')->where('paid_currency', 'USD')->sum('paid_amount');


        $all_users = User::withoutGlobalScopes()->count();

        $subscribers = User::where('expired_at', '<=', Carbon::now())
            ->orWhereNull('expired_at')
            ->count();


        $free_package_users = User::where('package', 0)
            ->where('expired_at', '>=', Carbon::now())
            ->where('expired_at', '<', Carbon::now()->addDays(14))->count();
        $active_users = User::where('active', true)->count();
        $deactivate_users = User::withoutGlobalScopes()
            ->where('active', false)->count();

        $golden_users = User::whereIn('package', [1,5])
            ->where('expired_at', '>=', Carbon::now())->count();
        $golden_plus_users = User::whereIn('package', [2,6])
            ->where('expired_at', '>=', Carbon::now())->count();
        $diamond_users = User::whereIn('package', [3,7])
            ->where('expired_at', '>=', Carbon::now())
            ->latest()->paginate(50)->count();
        $diamond_plus_users = User::whereIn('package', [4,8])
            ->where('expired_at', '>=', Carbon::now())->count();
 
  

        return view('admin.report.incomeReportSummary',[

            'pending_payments_bd' => $pending_payments_bd,
            'pending_payments_usa' => $pending_payments_usa,
            'paid_payments_bd' => $paid_payments_bd,
            'paid_payments_usa' => $paid_payments_usa,
            'all_users' => $all_users,
            'subscribers' => $subscribers,
            'free_package_users'  => $free_package_users,
            'active_users' => $active_users,
            'deactivate_users' => $deactivate_users,
            'golden_users' => $golden_users,
            'golden_plus_users' => $golden_plus_users,
            'diamond_users' => $diamond_users,
            'diamond_plus_users' =>$diamond_plus_users

        ]);
    }

    public function incomeReportPayment(Request $request)
    {
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'incomeReport','lsbsm'=>'incomeReportPayment']);
        return view('admin.report.incomeReportPayment');
    }

    public function incomeReportPaymentSearch(Request $request)
    {
        $date = $request->date;
        $type = $request->user_type;



        if($type=='all_payments')
        {
            $payments = UserPayment::with('user')
            ->where(function($q)use ($date){
                if($date == 'today')
                {
                    $q->whereDate('created_at', Carbon::today()->toDateString());
                }elseif($date == 'yesterday')
                {
                    $q->whereDate('created_at', Carbon::yesterday()->toDateString());
                }elseif($date == 7)
                {
                    $q->where('created_at', '>', Carbon::now()->subDays(6)); 
                }
                elseif($date == 30)
                {
                    $q->where('created_at', '>', Carbon::now()->subDays(29)); 
                }
                elseif($date == 'this_month')
                {
                    $q->whereYear('created_at', date('Y'));
                    $q->whereMonth('created_at', date('m'));
                }
                elseif($date == 'last_month')
                {
 
                    $q->whereYear('created_at', date('Y'));
                    $q->whereMonth('created_at', date('m') - 1);
 
                }
            })
            ->latest()->paginate(50);
        }
        elseif ($type == 'golden') {
            $payments = UserPayment::whereHas('user', function($q){
                $q->where('expired_at', '>=', Carbon::now());
            })->whereIn('id', [1,5])
            ->where(function($q)use ($date){
                if($date == 'today')
                {
                    $q->whereDate('created_at', Carbon::today()->toDateString());
                }elseif($date == 'yesterday')
                {
                    $q->whereDate('created_at', Carbon::yesterday()->toDateString());
                }elseif($date == 7)
                {
                    $q->where('created_at', '>', Carbon::now()->subDays(6)); 
                }
                elseif($date == 30)
                {
                    $q->where('created_at', '>', Carbon::now()->subDays(29)); 
                }
                elseif($date == 'this_month')
                {
                    $q->whereYear('created_at', date('Y'));
                    $q->whereMonth('created_at', date('m'));
                }
                elseif($date == 'last_month')
                {
 
                    $q->whereYear('created_at', date('Y'));
                    $q->whereMonth('created_at', date('m') - 1);
 
                }
            })
            ->latest()
            ->paginate(50);
        }elseif ($type == 'golden_plus') {
            $payments = UserPayment::whereHas('user', function($q){
                $q->where('expired_at', '>=', Carbon::now());
            })->whereIn('id', [2,6])
            ->where(function($q)use ($date){
                if($date == 'today')
                {
                    $q->whereDate('created_at', Carbon::today()->toDateString());
                }elseif($date == 'yesterday')
                {
                    $q->whereDate('created_at', Carbon::yesterday()->toDateString());
                }elseif($date == 7)
                {
                    $q->where('created_at', '>', Carbon::now()->subDays(6)); 
                }
                elseif($date == 30)
                {
                    $q->where('created_at', '>', Carbon::now()->subDays(29)); 
                }
                elseif($date == 'this_month')
                {
                    $q->whereYear('created_at', date('Y'));
                    $q->whereMonth('created_at', date('m'));
                }
                elseif($date == 'last_month')
                {
 
                    $q->whereYear('created_at', date('Y'));
                    $q->whereMonth('created_at', date('m') - 1);
 
                }
            })
            ->latest()->paginate(50);
        }elseif ($type == 'diamond') {
            $payments = UserPayment::whereHas('user', function($q){
                $q->where('expired_at', '>=', Carbon::now());
            })->whereIn('id', [3,7])
            ->where(function($q)use ($date){
                if($date == 'today')
                {
                    $q->whereDate('created_at', Carbon::today()->toDateString());
                }elseif($date == 'yesterday')
                {
                    $q->whereDate('created_at', Carbon::yesterday()->toDateString());
                }elseif($date == 7)
                {
                    $q->where('created_at', '>', Carbon::now()->subDays(6)); 
                }
                elseif($date == 30)
                {
                    $q->where('created_at', '>', Carbon::now()->subDays(29)); 
                }
                elseif($date == 'this_month')
                {
                    $q->whereYear('created_at', date('Y'));
                    $q->whereMonth('created_at', date('m'));
                }
                elseif($date == 'last_month')
                {
 
                    $q->whereYear('created_at', date('Y'));
                    $q->whereMonth('created_at', date('m') - 1);
 
                }
            })
            ->latest()->paginate(50);
        }elseif ($type == 'diamond_plus') {
            $payments = UserPayment::whereHas('user', function($q){
                $q->where('expired_at', '>=', Carbon::now());
            })->whereIn('id', [4,8])
            
            ->where(function($q)use ($date){
                if($date == 'today')
                {
                    $q->whereDate('created_at', Carbon::today()->toDateString());
                }elseif($date == 'yesterday')
                {
                    $q->whereDate('created_at', Carbon::yesterday()->toDateString());
                }elseif($date == 7)
                {
                    $q->where('created_at', '>', Carbon::now()->subDays(6)); 
                }
                elseif($date == 30)
                {
                    $q->where('created_at', '>', Carbon::now()->subDays(29)); 
                }
                elseif($date == 'this_month')
                {
                    $q->whereYear('created_at', date('Y'));
                    $q->whereMonth('created_at', date('m'));
                }
                elseif($date == 'last_month')
                {
 
                    $q->whereYear('created_at', date('Y'));
                    $q->whereMonth('created_at', date('m') - 1);
 
                }
            })
            ->latest()->paginate(50);
        }

        if($request->ajax())
        {
            return Response()->json(View('admin.report.ajax.incomeReportPayment',[
                'payments'=>$payments,
                'user_type' => $type
            ])->render());
        }
        return view('admin.report.incomeReportPayment');
    }

    public function incomeReportPaymentSearchByDateInterval(Request $request)
    {
         $start = $request->date_from;
         $end = $request->date_to;
         $type = $request->user_type;

        if($type=='all_payments')
        {
            $payments = UserPayment::whereHas('user', function($q){
                $q->where('expired_at', '>=', Carbon::now());
            })
            ->whereBetween('created_at',[$start,$end])
            ->latest()->paginate(50);
        }
        elseif ($type == 'golden') {
            $payments = UserPayment::whereHas('user', function($q){
                $q->where('expired_at', '>=', Carbon::now());
            })->whereIn('id', [1,5])
            ->whereBetween('created_at',[$start,$end])
            ->latest()
            ->paginate(50);
        }elseif ($type == 'golden_plus') {
            $payments = UserPayment::whereHas('user', function($q){
                $q->where('expired_at', '>=', Carbon::now());
            })->whereIn('id', [2,6])
            ->whereBetween('created_at',[$start,$end])
            ->latest()->paginate(50);
        }elseif ($type == 'diamond') {
            $payments = UserPayment::whereHas('user', function($q){
                $q->where('expired_at', '>=', Carbon::now());
            })->whereIn('id', [3,7])
            ->whereBetween('created_at',[$start,$end])
            ->latest()->paginate(50);
        }elseif ($type == 'diamond_plus') {
            $payments = UserPayment::whereHas('user', function($q){
                $q->where('expired_at', '>=', Carbon::now());
            })->whereIn('id', [4,8])
            ->whereBetween('created_at',[$start,$end])
            ->latest()->paginate(50);
        }

        if($request->ajax())
        {
            return Response()->json(View('admin.report.ajax.incomeReportPayment',[
                'payments'=>$payments,
                'user_type' => $type
            ])->render());
        }
        return view('admin.report.incomeReportUser');
    }

    public function incomeReportUser(Request $request)
    {
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'incomeReport','lsbsm'=>'incomeReportUser']);

        return view('admin.report.incomeReportUser');
    }

    public function incomeReportUserSearch(Request $request)
    {
        $date = $request->date;
        $type = $request->user_type;

        if($type=='all_users')
        {
            $users = User::withoutGlobalScopes()
            ->where(function($q)use ($date){
                if($date == 'today')
                {
                    $q->whereDate('created_at', Carbon::today()->toDateString());
                }elseif($date == 'yesterday')
                {
                    $q->whereDate('created_at', Carbon::yesterday()->toDateString());
                }elseif($date == 7)
                {
                    $q->where('created_at', '>', Carbon::now()->subDays(6)); 
                }
                elseif($date == 30)
                {
                    $q->where('created_at', '>', Carbon::now()->subDays(29)); 
                }
                elseif($date == 'this_month')
                {
                    $q->whereYear('created_at', date('Y'));
                    $q->whereMonth('created_at', date('m'));
                }
                elseif($date == 'last_month')
                {
 
                    $q->whereYear('created_at', date('Y'));
                    $q->whereMonth('created_at', date('m') - 1);
 
                }
            })
            ->latest()->paginate(50);
        }
        elseif ($type == 'golden') {
            $users = User::whereIn('package', [1,5])
            ->where('expired_at', '>=', Carbon::now())
            ->where(function($q)use ($date){
                if($date == 'today')
                {
                    $q->whereDate('created_at', Carbon::today()->toDateString());
                }elseif($date == 'yesterday')
                {
                    $q->whereDate('created_at', Carbon::yesterday()->toDateString());
                }elseif($date == 7)
                {
                    $q->where('created_at', '>', Carbon::now()->subDays(6)); 
                }
                elseif($date == 30)
                {
                    $q->where('created_at', '>', Carbon::now()->subDays(29)); 
                }
                elseif($date == 'this_month')
                {
                    $q->whereYear('created_at', date('Y'));
                    $q->whereMonth('created_at', date('m'));
                }
                elseif($date == 'last_month')
                {
 
                    $q->whereYear('created_at', date('Y'));
                    $q->whereMonth('created_at', date('m') - 1);
 
                }
            })
            ->latest()
            ->paginate(50);
        }elseif ($type == 'golden_plus') {
            $users = User::whereIn('package', [2,6])
            ->where('expired_at', '>=', Carbon::now())
            ->where(function($q)use ($date){
                if($date == 'today')
                {
                    $q->whereDate('created_at', Carbon::today()->toDateString());
                }elseif($date == 'yesterday')
                {
                    $q->whereDate('created_at', Carbon::yesterday()->toDateString());
                }elseif($date == 7)
                {
                    $q->where('created_at', '>', Carbon::now()->subDays(6)); 
                }
                elseif($date == 30)
                {
                    $q->where('created_at', '>', Carbon::now()->subDays(29)); 
                }
                elseif($date == 'this_month')
                {
                    $q->whereYear('created_at', date('Y'));
                    $q->whereMonth('created_at', date('m'));
                }
                elseif($date == 'last_month')
                {
 
                    $q->whereYear('created_at', date('Y'));
                    $q->whereMonth('created_at', date('m') - 1);
 
                }
            })
            ->latest()->paginate(50);
        }elseif ($type == 'diamond') {
            $users = User::whereIn('package', [3,7])
            ->where('expired_at', '>=', Carbon::now())
            ->where(function($q)use ($date){
                if($date == 'today')
                {
                    $q->whereDate('created_at', Carbon::today()->toDateString());
                }elseif($date == 'yesterday')
                {
                    $q->whereDate('created_at', Carbon::yesterday()->toDateString());
                }elseif($date == 7)
                {
                    $q->where('created_at', '>', Carbon::now()->subDays(6)); 
                }
                elseif($date == 30)
                {
                    $q->where('created_at', '>', Carbon::now()->subDays(29)); 
                }
                elseif($date == 'this_month')
                {
                    $q->whereYear('created_at', date('Y'));
                    $q->whereMonth('created_at', date('m'));
                }
                elseif($date == 'last_month')
                {
 
                    $q->whereYear('created_at', date('Y'));
                    $q->whereMonth('created_at', date('m') - 1);
 
                }
            })
            ->latest()->paginate(50);
        }elseif ($type == 'diamond_plus') {
            $users = User::whereIn('package', [4,8])
            ->where('expired_at', '>=', Carbon::now())
            ->where(function($q)use ($date){
                if($date == 'today')
                {
                    $q->whereDate('created_at', Carbon::today()->toDateString());
                }elseif($date == 'yesterday')
                {
                    $q->whereDate('created_at', Carbon::yesterday()->toDateString());
                }elseif($date == 7)
                {
                    $q->where('created_at', '>', Carbon::now()->subDays(6)); 
                }
                elseif($date == 30)
                {
                    $q->where('created_at', '>', Carbon::now()->subDays(29)); 
                }
                elseif($date == 'this_month')
                {
                    $q->whereYear('created_at', date('Y'));
                    $q->whereMonth('created_at', date('m'));
                }
                elseif($date == 'last_month')
                {
 
                    $q->whereYear('created_at', date('Y'));
                    $q->whereMonth('created_at', date('m') - 1);
 
                }
            })
            ->latest()->paginate(50);
        }

        if($request->ajax())
        {
            return Response()->json(View('admin.report.ajax.incomeReportUser',[
                'users'=>$users,
                'user_type' => $type
            ])->render());
        }
        return view('admin.report.incomeReportUser');
    }

    public function incomeReportUserSearchByDateInterval(Request $request)
    {
         $start = $request->date_from;
         $end = $request->date_to;
         $type = $request->user_type;

        if($type=='all_users')
        {
            $users = User::withoutGlobalScopes()
            ->whereBetween('created_at',[$start,$end])
            ->latest()->paginate(50);
        }
        elseif ($type == 'golden') {
            $users = User::whereIn('package', [1,5])
            ->whereBetween('created_at',[$start,$end])
            ->latest()
            ->paginate(50);
        }elseif ($type == 'golden_plus') {
            $users = User::whereIn('package', [2,6])
            ->where('expired_at', '>=', Carbon::now())
            ->whereBetween('created_at',[$start,$end])
            ->latest()->paginate(50);
        }elseif ($type == 'diamond') {
            $users = User::whereIn('package', [3,7])
            ->where('expired_at', '>=', Carbon::now())
            ->whereBetween('created_at',[$start,$end])
            ->latest()->paginate(50);
        }elseif ($type == 'diamond_plus') {
            $users = User::whereIn('package', [4,8])
            ->where('expired_at', '>=', Carbon::now())
            ->whereBetween('created_at',[$start,$end])
            ->latest()->paginate(50);
        }

        if($request->ajax())
        {
            return Response()->json(View('admin.report.ajax.incomeReportUser',[
                'users'=>$users,
                'user_type' => $type
            ])->render());
        }
        return view('admin.report.incomeReportUser');
    }
    //income report


    public function sendEmailSmsToUsers(Request $request)
    {
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'sms','lsbsm'=>'sendEmailSmsToUsers']);

        $post = WebsiteParameter::firstOrCreate([]);


        return view('admin.sms.sendEmailSmsToUsers', [
            'post' => $post
        ]);
    }

    public function sendEmailSmsToUsersPost(Request $request)
    {
        $validation = Validator::make($request->all(),
        [
            'message_to_users' => 'required',
            'send_to' => 'required',
            'send_type' => 'required',
        ]);
        if($validation->fails())
        {
            return back()
            ->withErrors($validation)
            ->withInput()
            ->with('error', 'Something went wrong.');
        }


        $text = $request->message_to_users;
        $type = $request->send_type;
        $to = $request->send_to;


        $post = WebsiteParameter::firstOrCreate([]);
        $post->message_to_users = $text;
        $post->save();


        if($to == 'incomplete_users')
        {
            
            User::where('user_type', 'online')
            ->whereNull('expired_at')
            ->where('final_checked', false)
            ->whereNull('img_name')
            
            ->whereDoesntHave('personalInfo', function ($query) {
                $query->where('checked', true);
              })

            ->whereDoesntHave('personalActivity', function ($query) {
                $query->where('checked', true);
              })

            ->whereDoesntHave('contactInfo', function ($query) {
                $query->where('checked', true);
              })
            ->orderBy('id')->chunk(100, function ($users) use($type, $text) 
            {
                foreach ($users as $user) 
                {

                    if($type == 'email')
                    {
                        $user->sendEmailWithMessage($text);
                    }
                    elseif($type == 'sms')
                    {
                        $user->sendSmsWithMessage($text);
                    }else
                    {
                        $user->sendEmailWithMessage($text);
                        $user->sendSmsWithMessage($text);
                    }
                }
            });
            

        }
        elseif($to == 'all_users')
        {
            


            User::where('user_type', 'online')
            ->orderBy('id')->chunk(100, function ($users) use($type, $text) 
            {
                
                foreach ($users as $user) 
                {

                    if($type == 'email')
                    {
                        $user->sendEmailWithMessage($text);
                    }
                    elseif($type == 'sms')
                    {
                        $user->sendSmsWithMessage($text);
                    }else
                    {
                        $user->sendEmailWithMessage($text);
                        $user->sendSmsWithMessage($text);
                    }

                }

            
            });



        }
        elseif($to == 'completed_users')
        {
            

            User::whereNotNull('img_name')
            ->where('user_type', 'online')
            ->where(function($p){
                $p->orWhere('checked', true);
                $p->orWhere('final_checked', true);

            })

            ->orWhere(function($p){
                $p->whereHas('personalInfo', function ($query) {
                $query->where('checked', true);
              });
            })

            ->orWhere(function($p){
                $p->whereHas('personalActivity', function ($query) {
                $query->where('checked', true);
              });
            })

            ->orWhere(function($p){
                $p->whereHas('contactInfo', function ($query) {
                $query->where('checked', true);
              });
            })
            ->orderBy('id')->chunk(100, function ($users) use($type, $text) 
            {
                foreach ($users as $user) 
                {

                    if($type == 'email')
                    {
                        $user->sendEmailWithMessage($text);
                    }
                    elseif($type == 'sms')
                    {
                        $user->sendSmsWithMessage($text);
                    }else
                    {
                        $user->sendEmailWithMessage($text);
                        $user->sendSmsWithMessage($text);
                    }
                }
            });

        }
        elseif($to == 'no_login_thirty_days')
        {
            

            User::where('loggedin_at', '<', Carbon::now()->subDays(29))
            ->where('user_type', 'online')
            ->orderBy('id')->chunk(100, function ($users) use($type, $text) 
            {

                foreach ($users as $user) 
                {

                    if($type == 'email')
                    {
                        $user->sendEmailWithMessage($text);
                    }
                    elseif($type == 'sms')
                    {
                        $user->sendSmsWithMessage($text);
                    }else
                    {
                        $user->sendEmailWithMessage($text);
                        $user->sendSmsWithMessage($text);
                    }

                }
            });

        }
        elseif($to == 'free_users')
        {
            

            User::where('user_type', 'online')
            ->where(function($q){
                $q->where('expired_at', '<=', Carbon::now());
                $q->orWhereNull('expired_at');               
            })
            ->orderBy('id')->chunk(100, function ($users) use($type, $text) 
            {

                foreach ($users as $user) 
                {

                    if($type == 'email')
                    {
                        $user->sendEmailWithMessage($text);
                    }
                    elseif($type == 'sms')
                    {
                        $user->sendSmsWithMessage($text);
                    }else
                    {
                        $user->sendEmailWithMessage($text);
                        $user->sendSmsWithMessage($text);
                    }


                }
            });

        }elseif($to == 'paid_members')
        {
            

            User::where('user_type', 'online')
            ->where('expired_at', '>=', Carbon::now())
            ->where('package', '>', 0)

            ->orderBy('id')->chunk(100, function ($users) use($type, $text) 
            {

                foreach ($users as $user) 
                {

                    if($type == 'email')
                    {
                        $user->sendEmailWithMessage($text);
                    }
                    elseif($type == 'sms')
                    {
                        $user->sendSmsWithMessage($text);
                    }else
                    {
                        $user->sendEmailWithMessage($text);
                        $user->sendSmsWithMessage($text);
                    }

                }
            });

        }
        elseif($to == 'deactivate_users')
        {
            

            User::where('user_type', 'online')
            ->withoutGlobalScopes()
            ->where('active', false)

            ->orderBy('id')->chunk(100, function ($users) use($type, $text) 
            {

                foreach ($users as $user) 
                {

                    if($type == 'email')
                    {
                        $user->sendEmailWithMessage($text);
                    }
                    elseif($type == 'sms')
                    {
                        $user->sendSmsWithMessage($text);
                    }else
                    {
                        $user->sendEmailWithMessage($text);
                        $user->sendSmsWithMessage($text);
                    }
                }
            });

        }

        
        return back()->with('success', "({$type}) message successfully sent to ({$to})");
    }

    public function sendCvFromUser(Request $request)
    {
        $user = User::withoutGlobalScopes()->find($request->user);

        $mails = User::withoutGlobalScopes()
        ->where('active', 1)
        ->where('id', '<>', $request->user)
        ->where('gender', $user->oltGender())
        
        ->orderBy('id', 'desc')
        ->limit(100)
        ->get();

        $districts = District::select(['name as title'])->orderBy('name')->get();

        return view('admin.users.sendCvFromUser',[
            'user' => $user,
            'emails' => $mails,
            'districts' => $districts
        ]);
    }    

    public function selectMailsUser(Request $request)
    {

         $user = User::withoutGlobalScopes()->find($request->user);

         $mails = User::withoutGlobalScopes()
        ->where('active', 1)
        ->where('id', '<>', $request->user)
        ->where('gender', $user->oltGender())
        ->where(function($q) use ($request){
            if($request->user_type)
            {
                $q->where('user_type', $request->user_type);
            }

            if($request->religion)
            {
                $q->where('religion', $request->religion);
            }

            

            if($request->min_age)
            {
                $now = Carbon::now();
                $minAgeDate = $now->SubYear($request->min_age)->toDateString();
                
                $q->where('dob', '<=', $minAgeDate);
            }

            if($request->max_age)
            {
                $now = Carbon::now();
                $maxAgeDate = $now->SubYear($request->max_age + 1)->toDateString();
                $q->where('dob', '>=', $maxAgeDate);
            }

            if($request->profession or $request->education_level 
                or $request->district or $request->marital_status)
            {
                $q->whereHas('personalInfo', function ($query) use ($request) 
               {
                    if($request->profession)
                    {
                        $query->where('my_profession', $request->profession);
                    }

                    if($request->education_level)
                    {
                        $query->where('education_level', $request->education_level);
                    }

                    if($request->district)
                    {
                        $query->where('district', $request->district);
                    }

                    if($request->marital_status)
                    {
                        $query->where('marital_status', $request->marital_status);
                    }
                    
                });
            }
        })
        ->orderBy('id', $request->order_by)
        ->limit($request->limit)
        ->get();


        if($request->ajax())
        {
            return Response()->json([

                'success' => true,

                'page'=>View('admin.users.ajax.emails',[
                'emails'=>$mails,
                'user'=>$user
                ])->render()

            ]);
        }
    }

    public function sendCvFromUserPost(Request $request)
    {
        $user = User::withoutGlobalScopes()->find($request->user);

        $ids = $request->ids;

        if($ids)
        {
            $ids = array_slice($ids, 0, 20);

            foreach($request->ids as $id)
            {
                $u = User::withoutGlobalScopes()->find($id);

                $mailWithCv = $u->mailWithCv()->where('user_to_id', $u->id)->latest()->first();

                if($mailWithCv)
                {
                    $mailWithCv->sent_count = $mailWithCv->sent_count + 1;
                    $mailWithCv->save();
                }
                else
                {
                    $mailWithCv = new UserMail;
                    $mailWithCv->user_id = $user->id;
                    $mailWithCv->user_to_id = $u->id;
                    $mailWithCv->sent_count = 1;
                    $mailWithCv->addedby_id = Auth::id();
                    $mailWithCv->save();
                }            

                $u->getCvEmailFromUser($user);
            }
        }

        
            if($request->ajax())
            {
                return Response()->json([

                'success' => true,

                ]);
            }

    }

    public function sendCvToUser(Request $request)
    {
        $user = User::withoutGlobalScopes()->find($request->user);

        

        $districts = District::select(['name as title'])->orderBy('name')->get();
        $mails = [];
        
        $user = User::withoutGlobalScopes()->find($request->user);
        return view('admin.users.sendCvToUser',[
            'user'=> $user,
            'districts'=>$districts,
            'emails' =>$mails
        ]);
    }


    public function sendCvToGivenEmail(Request $request)
    {

        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'sms','lsbsm'=>'sendCvToGivenEmail']);

        // $mails = User::withoutGlobalScopes()
        // ->where('active', 1)        
        // ->orderBy('id', 'desc')
        // ->limit(100)
        // ->get();

        $mails = [];

        $districts = District::select(['name as title'])->orderBy('name')->get();

        return view('admin.users.sendCvToGivenEmail',[
            'emails' => $mails,
            'districts' => $districts
        ]);
    }

    public function sendProfileToGivenEmail(Request $request)
    {

        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'sms','lsbsm'=>'sendProfileToGivenEmail']);

        // $mails = User::withoutGlobalScopes()
        // ->where('active', 1)        
        // ->orderBy('id', 'desc')
        // ->limit(100)
        // ->get();

        $mails = [];

        $districts = District::select(['name as title'])->orderBy('name')->get();

        return view('admin.users.sendProfileToGivenEmail',[
            'emails' => $mails,
            'districts' => $districts
        ]);
    }


    public function selectCvUsers(Request $request)
    {
        // dd($request->all());

        $mails = User::withoutGlobalScopes()
        ->where('active', 1)
        ->whereNotNull('file_name')
        ->where('cv_checked', 1)
        ->where(function($q) use ($request){
            if($request->user_type)
            {
                $q->where('user_type', $request->user_type);
            }

            if($request->religion)
            {
                $q->where('religion', $request->religion);
            }

            if($request->gender)
            {
                $q->where('gender', $request->gender);
            }

            if($request->min_age)
            {
                $now = Carbon::now();
                $minAgeDate = $now->SubYear($request->min_age)->toDateString();
                
                $q->where('dob', '<=', $minAgeDate);
            }

            if($request->max_age)
            {
                $now = Carbon::now();
                $maxAgeDate = $now->SubYear($request->max_age + 1)->toDateString();
                $q->where('dob', '>=', $maxAgeDate);
            }

            if($request->profession or $request->education_level 
                or $request->district or $request->marital_status)
            {
                $q->whereHas('personalInfo', function ($query) use ($request) 
               {
                    if($request->profession)
                    {
                        $query->where('my_profession', $request->profession);
                    }

                    if($request->education_level)
                    {
                        $query->where('education_level', $request->education_level);
                    }

                    if($request->district)
                    {
                        $query->where('district', $request->district);
                    }

                    if($request->marital_status)
                    {
                        $query->where('marital_status', $request->marital_status);
                    }
                    
                });
            }
        })
        ->orderBy('id', $request->order_by)
        ->limit($request->limit)
        ->get();

        if($request->ajax())
        {
            return Response()->json([

                'success' => true,

                'page'=>View('admin.users.ajax.emails',[
                'emails'=>$mails,
                ])->render()

            ]);
        }
    }
    
    public function selectCvUsersForUser(Request $request)
    {
        $user = User::withoutGlobalScopes()->find($request->user);

        $mails = User::withoutGlobalScopes()
        ->where('active', 1)
        ->whereNotNull('file_name')
        ->where('cv_checked', 1)
        ->where('id', '<>', $request->user)
        ->where('gender', $user->oltGender())
        ->where(function($q) use ($request){
            if($request->user_type)
            {
                $q->where('user_type', $request->user_type);
            }

            if($request->religion)
            {
                $q->where('religion', $request->religion);
            }

            if($request->min_age)
            {
                $now = Carbon::now();
                $minAgeDate = $now->SubYear($request->min_age)->toDateString();
                
                $q->where('dob', '<=', $minAgeDate);
            }

            if($request->max_age)
            {
                $now = Carbon::now();
                $maxAgeDate = $now->SubYear($request->max_age + 1)->toDateString();
                $q->where('dob', '>=', $maxAgeDate);
            }

            if($request->profession or $request->education_level 
                or $request->district or $request->marital_status)
            {
                $q->whereHas('personalInfo', function ($query) use ($request) 
               {
                    if($request->profession)
                    {
                        $query->where('my_profession', $request->profession);
                    }

                    if($request->education_level)
                    {
                        $query->where('education_level', $request->education_level);
                    }

                    if($request->district)
                    {
                        $query->where('district', $request->district);
                    }

                    if($request->marital_status)
                    {
                        $query->where('marital_status', $request->marital_status);
                    }
                    
                });
            }
        })
        ->orderBy('id', $request->order_by)
        ->limit($request->limit)
        ->get();

        if($request->ajax())
        {
            return Response()->json([

                'success' => true,

                'page'=>View('admin.users.ajax.emails',[
                'emails'=>$mails,
                ])->render()

            ]);
        }
    }



    public function selectProfileUsers(Request $request)
    {
        // dd($request->all());

        $mails = User::withoutGlobalScopes()
        ->where('active', 1)
        ->whereNotNull('img_name')
        ->where(function($q) use ($request){
            if($request->user_type)
            {
                $q->where('user_type', $request->user_type);
            }

            if($request->religion)
            {
                $q->where('religion', $request->religion);
            }

            if($request->gender)
            {
                $q->where('gender', $request->gender);
            }

            if($request->min_age)
            {
                $now = Carbon::now();
                $minAgeDate = $now->SubYear($request->min_age)->toDateString();
                
                $q->where('dob', '<=', $minAgeDate);
            }

            if($request->max_age)
            {
                $now = Carbon::now();
                $maxAgeDate = $now->SubYear($request->max_age + 1)->toDateString();
                $q->where('dob', '>=', $maxAgeDate);
            }

            if($request->profession or $request->education_level 
                or $request->district or $request->marital_status)
            {
                $q->whereHas('personalInfo', function ($query) use ($request) 
               {
                    if($request->profession)
                    {
                        $query->where('my_profession', $request->profession);
                    }

                    if($request->education_level)
                    {
                        $query->where('education_level', $request->education_level);
                    }

                    if($request->district)
                    {
                        $query->where('district', $request->district);
                    }

                    if($request->marital_status)
                    {
                        $query->where('marital_status', $request->marital_status);
                    }
                    
                });
            }
        })
        ->orderBy('id', $request->order_by)
        ->limit($request->limit)
        ->get();

        if($request->ajax())
        {
            return Response()->json([

                'success' => true,

                'page'=>View('admin.users.ajax.emailsOfProfile',[
                'emails'=>$mails,
                ])->render()

            ]);
        }
    }
    

    public function sendCvToGivenEmailPost(Request $request)
    {
        $email = $request->email;
        

        $ids = $request->ids;
        if($ids)
        {
            $ids = array_slice($ids, 0, 20);

            $users = User::withoutGlobalScopes()->whereIn('id', $ids)->get();


            Auth::user()->sendUserCvToEmail($email,$users);

        }

        


        // foreach($request->ids as $id)
        // {
        //     $u = User::withoutGlobalScopes()->find($id);

        //     if($u)
        //     {
        //         $u->sendUserCvToEmail($email);
        //         // $u->getCvEmailFromUser($user);
        //     }

        // }

            if($request->ajax())
            {
                return Response()->json([

                'success' => true,

                ]);
            }


            return back();


    }
    public function sendProfileToGivenEmailPost(Request $request)
    {
        $email = $request->email;
        

        $ids = $request->ids;

        if($ids)
        {
            $ids = array_slice($ids, 0, 20);

            $users = User::withoutGlobalScopes()->whereIn('id', $ids)->get();


            Auth::user()->sendUserProfileToEmail($email,$users);

        }

        


        // foreach($request->ids as $id)
        // {
        //     $u = User::withoutGlobalScopes()->find($id);

        //     if($u)
        //     {
        //         $u->sendUserCvToEmail($email);
        //         // $u->getCvEmailFromUser($user);
        //     }

        // }

            if($request->ajax())
            {
                return Response()->json([

                'success' => true,

                ]);
            }


            return back();


    }

    public function userLogs(Request $request)
    {
        $user = User::withoutGlobalScopes()->where('id', $request->user)->first();
        
        if($user)
        {
            return view('admin.users.userLogs', ['user'=>$user]);
        }

        return back();
    }

    public function userLogsPost(Request $request)
    {
        $user = User::withoutGlobalScopes()->where('id', $request->user)->first();
        if($user)
        {
            $log = new UserLog;
            $log->user_id = $user->id;
            $log->note = $request->note ?: null;
            $log->status = $request->status ?: null;
            $log->completed = $request->completed ? 1 : 0;
            $log->addedby_id = Auth::id();
            $log->save();
            return back()->with('success', 'Log successfully submitted');
        }
        return back();
    }

    public function userLogComplete(UserLog $log, Request $request)
    {
        $log->completed = 1;
        $log->addedby_id = Auth::id();
        $log->save();
        return back()->with('success', 'Log successfully completed.');
    }

    public function userSms(Request $request)
    {
        $user = User::withoutGlobalScopes()->where('id', $request->user)->first();
        
        if($user)
        {
            return view('admin.users.userSms', ['user'=>$user]);
        }

        return back();
    }

    public function logsAll()
    {
        $logs = UserLog::with('user')
        ->latest()
        ->paginate(50);
        return view('admin.logsAll', ['logs'=>$logs]);
    }
}
