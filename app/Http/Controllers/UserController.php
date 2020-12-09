<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Mail;
use Cache;
use Validator;
use Carbon\Carbon;
use App\Model\User;
use App\Model\Report;
use App\Model\Country;
use App\Model\Upazila;
use App\Model\District;
use App\Model\UserPhoto;
use App\Model\UserAbout;
use App\Model\UserComment;
use App\Model\UserPayment;
use App\Model\UserProposal;
use App\Model\UserReligion;
use App\Model\UserEducation;
use Illuminate\Http\Request;
use App\Model\UserContactInfo;
use App\Model\UsersForAutoMail;
use App\Model\UserPersonalInfo;
use App\Model\UserInfoForOffice;
use App\Model\MembershipPackage;
use App\Model\UserPersonalActivity;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('userupdate');
    }

    public function dashboard(){
    	return view('user.dashboard');
    }


    public function lazyLoadUser(Request $request)
   {
        if($request->ajax())
        {
            $me = Auth::user();

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
                ->first();
                // ->limit(1)
                // ->get();

                if ($uam) 
                {
                    $uam->user->automailSend($uam);
                }

            // if ('mail@matchinglifebd.com' == 'mail@matchinglifebd.com') 
            // {
                // $uam = UsersForAutoMail::whereDoesntHave('items', function ($query) {
                //     $query->where('created_at', '>', Carbon::now()->subDays(10));
                // })
                // ->has('user')
                // ->where('type', 'match')
                // ->where('subscribed', 1)
                // // ->first();
                // ->limit(10)
                // ->get();
                // // if ($uam) 
                // // {
                // //     $uam->user->automailSend($uam);
                // // }

                // foreach($uam as $uu)
                // {
                //     $uu->user->automailSend($uu);
                // }
            // }

            return Response()->json(View("user.ajax.lazyLoad", [
                'me'=>$me,
                'user'=>$me
            ])->render());
        }
   }

    public function myProfile(){
        return view('user.myProfile');
    }

    public function myNotifications()
    {
        Auth::user()->touchMainsDelete();

        return view('user.myNotifications');
    }

    public function allRelatedUsers(Request $request)
    {
        // if(! Auth::user()->isValidate())
        // {
        //     return redirect()->route('page', 'membership_package');
        // }
        return view('user.allRelatedUsers', [
            'type'=>$request->type
        ]);
    }



    

    public function settings(Request $request)
    {
        $v = $request->view ?: 'edit_my_profile';

        return view('user.settings.settings',[
            'u'=>Auth::user(),
            'v'=>$v
        ]);
    }

    public function settingZone(Request $request)
    {
    	$v = $request->partView;

    	if($request->ajax())
        {
            return Response()->json(View("user.settings.ajax.view.{$v}", [
            	'u'=>Auth::user()
            ])->render());
        }

        return view('user.settings.settings',[
            'u'=>Auth::user(),
            'v'=>$v
        ]);


    }

    public function settingAboutMePost(Request $request)
    {
    	$validation = Validator::make($request->all(),
            [ 
              'about_me'=>'required|min:5|max:255',
              'headline'=>'required|min:3|max:255',
              'looking_for'=>'required|min:3|max:255',
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

        $me = Auth::user();
        $me->looking_for = $request->looking_for;
        $me->editedby_id = $me->id;
        $me->save();

        $userAbout = $me->about;
        if(!$userAbout)
        {
        	$userAbout = new UserAbout; 
        	$userAbout->user_id = $me->id;
         $userAbout->addedby_id = $me->id;       	
     }

     $userAbout->headline =  $request->headline;
     $userAbout->about_me = $request->about_me;
     $userAbout->save();

     if($request->ajax())
     {
        return Response()->json(['success' => true]);
    }

    return back();

}



public function settingPersonalInfoPost(Request $request)
{
    // dd($request->all());
    $validation = Validator::make($request->all(),
        [
            "marital_status" => 'required',
            // "do_u_have_children" => 'required',
            "height" => 'required',
            "body_build" => 'required',
            "hair_color" => 'required',
            // "hair_color_other" => 'required',
            "eye_color" => 'required',
            // "eye_color_other" => 'required',
            "skin_color" => 'required',
            // "skin_color_other" => 'required',
            // "zodiac_sign" => 'required',
            "smoke_status" => 'required',
            "disabilities_status" => 'required',
            // "disabilities_status_other" => 'required',
            "alcohol_status" => 'required',
            // "diat_status" => 'required',
            // "blood_group" => 'required',
            "education_level" => 'required',
            // "education_level_other" => 'required',
            // "major_subject" => 'required',
            "job_title" => 'required',
            "my_profession" => 'required',
            // "my_profession_other" => 'required',
            "job_company_name" => 'required',
            // "income" => 'required',
            // "mother_tongue" => 'required',
            // "can_speak" => 'required',
            "father_name" => 'required',
            // "father_occupation" => 'required',
            "mother_name" => 'required',
            // "mother_occupation" => 'required',
            // "number_of_brother" => 'required',
            // "how_many_brother_married" => 'required',
            // "number_of_sister" => 'required',
            // "how_many_sister_married" => 'required',
            // "district" => 'required',
            // "thana" => 'required',
            // "zip_code" => 'required',
            // "citizenship" => 'required',
            // "citizenship_other" => 'required',
            // "city_of_residence" => 'required',
            // "state_of_residence" => 'required',
            // "country_of_residence" => 'required',
            // "country_of_residence_other" => 'required',
            "hear_about_us" => 'required',

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

    $me = Auth::user();

    $personalInfo = $me->personalInfo;

    if(!$personalInfo)
    {
        $personalInfo = new UserPersonalInfo; 
        $personalInfo->user_id = $me->id;
        $personalInfo->addedby_id = $me->id;           
    }

$personalInfo->marital_status = $request->marital_status ?: null;
$personalInfo->do_u_have_children = $request->do_u_have_children ?: null;
$personalInfo->height = $request->height ?: null;
$personalInfo->body_build = $request->body_build ?: null;

$personalInfo->graduate_from = $request->graduate_from?: null;

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
$personalInfo->checked = false;
$personalInfo->save();

    if($request->ajax())
    {
        return Response()->json(['success' => true]);
    }

    return back();
}

public function settingEducationWorkPost(Request $request)
{
    $validation = Validator::make($request->all(),
        [ 
          "education_level" => 'required',
          "subject_studied" => 'required',
          "job_title" => 'required',
          "my_profession" => 'required',
          // "my_profession_other" => 'required',
          "first_language" => 'required',
          "second_language" => 'required',
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

    $me = Auth::user();

    $educationWork = $me->educationWork;

    if(!$educationWork)
    {
        $educationWork = new UserEducation; 
        $educationWork->user_id = $me->id;
        $educationWork->addedby_id = $me->id;           
    }

    $educationWork->education_level = $request->education_level;

    if( ($request->education_level == 'Other') || 
        ($request->education_level == 'Others'))
    {
        $educationWork->education_level_other = $request->education_level_other;
    }else{

        $educationWork->education_level_other = null;
    }

    $educationWork->subject_studied = $request->subject_studied;
    $educationWork->job_title = $request->job_title;
    $educationWork->my_profession = $request->my_profession;

    if( ($request->my_profession == 'Other') || 
        ($request->my_profession == 'Others'))
    {
        $educationWork->my_profession_other = $request->my_profession_other;
    }else{

        $educationWork->my_profession_other = null;
    }

        // $educationWork->my_profession_other = $request->my_profession_other;
    $educationWork->first_language = $request->first_language;
    $educationWork->second_language = $request->second_language;

    $educationWork->save();

    if($request->ajax())
    {
        return Response()->json(['success' => true]);
    }

    return back();
}

public function settingReligion(Request $request)
{
    $validation = Validator::make($request->all(),
        [ 
            'religious_status' => 'required',
            'religious_section' => 'required',
            'prefer_hijab' => 'required',
            'prefer_beard' => 'required',
            'are_you_revert' => 'required',
            'salah_status' => 'required',
            'can_read_quran' => 'required',
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

    $me = Auth::user();
    $religion = $me->religion;

    if(!$religion)
    {
        $religion = new UserReligion; 
        $religion->user_id = $me->id;
        $religion->addedby_id = $me->id;           
    }

    $religion->religious_status = $request->religious_status;
    $religion->religious_section = $request->religious_section;
    $religion->prefer_hijab = $request->prefer_hijab;
    $religion->prefer_beard = $request->prefer_beard;
    $religion->are_you_revert = $request->are_you_revert;
    $religion->salah_status = $request->salah_status;
    $religion->can_read_quran = $request->can_read_quran;

    $religion->save();

    if($request->ajax())
    {
        return Response()->json(['success' => true]);
    }

    return back();
}

public function settingPersonalInfoForOfficePost(Request $request)
{
    $validation = Validator::make($request->all(),
        [ 
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile' => 'required',
            // 'phone' => 'required',
            // 'dob' => 'required',
            'day' => 'required',
            'month' => 'required',
            'year' => 'required',
            // 'nid_number' => 'required',
            // 'passport_number' => 'required',
            'present_address' => 'required',
            'permanent_address' => 'required',
            // 'office_address' => 'required',
            'father_name' => 'required',
            'father_contact' => 'required',
            'mother_name' => 'required',
            'mother_contact' => 'required',
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

    $dob = $request->year.'-'.$request->month. '-' .$request->day;

    $me = Auth::user();
    $infoForOffice = $me->infoForOffice;

    if(!$infoForOffice)
    {
        $infoForOffice = new UserInfoForOffice; 
        $infoForOffice->user_id = $me->id;
        $infoForOffice->addedby_id = $me->id;           
    }




    $infoForOffice->first_name = $request->first_name ?: null;
    $infoForOffice->last_name = $request->last_name ?: null;
    $infoForOffice->mobile = $request->mobile ?: null;
    $infoForOffice->phone = $request->phone ?: null;
    $infoForOffice->dob = Date($dob);
    $infoForOffice->nid_number = $request->nid_number ?: null;
    $infoForOffice->passport_number = $request->passport_number ?: null;
    $infoForOffice->present_address = $request->present_address ?: null;
    $infoForOffice->permanent_address = $request->permanent_address ?: null;
    $infoForOffice->office_address = $request->office_address ?: null;
    $infoForOffice->father_name = $request->father_name ?: null;
    $infoForOffice->father_contact = $request->father_contact ?: null;
    $infoForOffice->mother_name = $request->mother_name ?: null;
    $infoForOffice->mother_contact = $request->mother_contact ?: null;

    $infoForOffice->save();

    if($request->ajax())
    {
        return Response()->json(['success' => true]);
    }

    return back();
}

public function changeUsername(Request $request)
{
    $validation = Validator::make($request->all(),
        [ 
            'new_username'=> 'required|string|min:4|confirmed|unique:users,username,'.Auth::id(),
            'password'=> 'required|string|min:6'
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
    }

    if (Hash::check($request->password, $request->user()->password))
    {
        $me = Auth::user();
        $me->username = $request->new_username;
        $me->checked = false;
        $me->save();

        if($request->ajax())
        {
            return Response()->json([
                'success'=>true,
            ]);
        }
    }
    else
    {
        $v;
        $v['password'] = 'Your current password is wrong';

        if($request->ajax())
        {
            return Response()->json(array(
                'success' => false,
                'errors' => $v
            ));
        }
    }
}

public function changeMobile(Request $request)
{
    $validation = Validator::make($request->all(),
        [ 
            'new_mobile'=> 'required|string|min:10|confirmed|unique:users,mobile,'.Auth::id(),
            'password'=> 'required|string|min:6'
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
    }

    if (Hash::check($request->password, $request->user()->password))
    {
        $myNumber = bdMobile($request->new_mobile);

            // dd(strlen($myNumber));

        if(strlen($myNumber) != 13)
        {
            $v;
            $v['password'] = 'Your mobile number is not valid, Please try again with Bangladeshi mobile number.';

            if($request->ajax())
            {
                return Response()->json(array(
                    'success' => false,
                    'errors' => $v
                ));
            }
        }
        else{

            $me = Auth::user();
            $me->mobile = $myNumber;
            $me->save();

        }



        if($request->ajax())
        {
            return Response()->json([
                'success'=>true,
            ]);
        }
    }
    else
    {
        $v;
        $v['password'] = 'Your current password is wrong';

        if($request->ajax())
        {
            return Response()->json(array(
                'success' => false,
                'errors' => $v
            ));
        }
    }
}

public function changePassword(Request $request)
{
    $validation = Validator::make($request->all(),
        [ 
            'current_password'=> 'required|string|min:6',
            'new_password'=> 'required|string|min:6|confirmed'
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
    }

    if (Hash::check($request->current_password, $request->user()->password))
    {
        $me = Auth::user();
        $me->password = Hash::make($request->new_password);
        $me->save();

        if($request->ajax())
        {
            return Response()->json([
                'success'=>true,
            ]);
        }
    }
    else
    {
        $v;
        $v['current_password'] = 'Your current password is wrong';

        if($request->ajax())
        {
            return Response()->json(array(
                'success' => false,
                'errors' => $v
            ));
        }
    }
}

public function changeEmail(Request $request)
{
    $validation = Validator::make($request->all(),
        [ 
            'new_email'=> 'required|email|string|min:4|confirmed|unique:users,email,'.Auth::id(),
            'password'=> 'required|string|min:6'
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
    }

    if (Hash::check($request->password, $request->user()->password))
    {
        $me = Auth::user();
        $me->email = $request->new_email;
        $me->save();

        if($request->ajax())
        {
            return Response()->json([
                'success'=>true,
            ]);
        }
    }
    else
    {
        $v;
        $v['password'] = 'Your current password is wrong';

        if($request->ajax())
        {
            return Response()->json(array(
                'success' => false,
                'errors' => $v
            ));
        }
    }
}

public function changeContact(Request $request)
{
    $validation = Validator::make($request->all(),
        [ 
            'new_contact'=> 'required|numeric|digits_between:10,15|confirmed|unique:users,mobile,'.Auth::id(),
            'password'=> 'required|string|min:6'
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
    }

    if (Hash::check($request->password, $request->user()->password))
    {
        $me = Auth::user();
        $me->mobile = $request->new_contact;
        $me->save();

        if($request->ajax())
        {
            return Response()->json([
                'success'=>true,
            ]);
        }
    }
    else
    {
        $v;
        $v['password'] = 'Your current password is wrong';

        if($request->ajax())
        {
            return Response()->json(array(
                'success' => false,
                'errors' => $v
            ));
        }
    }
}

public function settingSearchTermPost(Request $request)
{
    $validation = Validator::make($request->all(),
        [ 
            'minimum_age'=> 'required',
            'maximum_age' => 'required',
            // 'gender' => 'required',
            // 'country' => 'required',
            // 'location' => 'required',
            'minimum_height' => 'required',
            'maximum_height' => 'required'

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
    }

    $st = Auth::user()->searchTerm;

    $st->min_age = trim($request->minimum_age) ?: null;
    $st->max_age = trim($request->maximum_age) ?: null;

    $st->min_height = trim($request->minimum_height) ?: null;
    $st->max_height = trim($request->maximum_height) ?: null;

    

    $st->marital_status = trim($request->marital_status) ?: null;
    $st->do_u_have_children = trim($request->do_u_have_children) ?: null;
    $st->religion = trim($request->religion) ?: null;
    $st->education_level = trim($request->education_level) ?: null;
    // $st->social_order = trim($request->social_order) ?: null;

    // $st->country = trim($request->country) ?: null;

    // if( ($request->country == 'Other') || 
    //     ($request->country == 'Others'))
    // {
    //     $st->country_other = $request->country_other;
    // }else{

    //     $st->country_other = '';
    // }

    // if(count($request->professions))
    // {
    //     $st->my_profession = implode(', ',$request->professions);
    // }else
    // {
    //     $st->my_profession = null;
    // }

    // if(count($request->education_level))
    // {
    //     $st->education_level = implode(', ',$request->education_level);
    // }else
    // {
    //     $st->education_level = null;
    // }

    // if(count($request->country_of_residence))
    // {
    //     $st->country_of_residence = implode(', ',$request->country_of_residence);
    // }else
    // {
    //     $st->country_of_residence = null;
    // }

    // $st->state_of_residence = trim($request->state_of_residence) ?: null;

    // $st->city_of_residence = trim($request->city_of_residence) ?: null;
    // $st->mother_tongue = trim($request->mother_tongue) ?: null;
    // $st->skin_color = trim($request->skin_color) ?: null;
    // $st->body_build = trim($request->body_build) ?: null;
    // $st->smoke_status = trim($request->smoke_status) ?: null;
    // $st->alcohol_status = trim($request->alcohol_status) ?: null;
    
    // $st->user_status = trim($request->user_status) ?: null;

    $st->save();

    if($request->ajax())
    {
        return Response()->json([
            'success'=>true,
        ]);
    }
}

public function settingSearchTermEduWorkPost(Request $request)
{
    $validation = Validator::make($request->all(),
        [ 
            // 'minimum_age'=> 'required',
            // 'maximum_age' => 'required',
            // 'gender' => 'required',
            // 'country' => 'required',
            // 'location' => 'required',

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
    }

    $st = Auth::user()->searchTerm;

    $st->education_level = trim($request->education_level) ?: null;
    $st->subject_studied = trim($request->subject_studied) ?: null;
    $st->job_title = trim($request->job_title) ?: null;
    $st->my_profession = trim($request->my_profession) ?: null;
    $st->first_language = trim($request->first_language) ?: null;
    $st->second_language = trim($request->second_language) ?: null;
    $st->education_level = trim($request->education_level) ?: null;

    $st->save();

    if($request->ajax())
    {
        return Response()->json([
            'success'=>true,
        ]);
    }
}

public function settingSearchTermPersonalInfoPost(Request $request)
{
    $validation = Validator::make($request->all(),
        [ 
            // 'minimum_age'=> 'required',
            // 'maximum_age' => 'required',
            // 'gender' => 'required',
            // 'country' => 'required',
            // 'location' => 'required',

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
    }

    $st = Auth::user()->searchTerm;

    $st->citizenship = trim($request->citizenship) ?: null;
    $st->birth_place = trim($request->birth_place) ?: null;
    $st->income = trim($request->income) ?: null;
    $st->going_to_marry = trim($request->going_to_marry) ?: null;
    $st->marital_status = trim($request->marital_status) ?: null;
    $st->like_to_have_children = trim($request->like_to_have_children) ?: null;
    $st->do_u_have_children = trim($request->do_u_have_children) ?: null;
    $st->living_with = trim($request->living_with) ?: null;
    $st->height = trim($request->height) ?: null;
    $st->body_build = trim($request->body_build) ?: null;
    $st->hair_color = trim($request->hair_color) ?: null;
    $st->eye_color = trim($request->eye_color) ?: null;
    $st->skin_color = trim($request->skin_color) ?: null;
    $st->dress_up = trim($request->dress_up) ?: null;
    $st->smoke_status = trim($request->smoke_status) ?: null;
    $st->disabilities_status = trim($request->disabilities_status) ?: null;
    $st->how_many_siblings = trim($request->how_many_siblings) ?: null;
    $st->alcohol_status = trim($request->alcohol_status) ?: null;
    $st->blood_group = trim($request->blood_group) ?: null;


    $st->save();

    if($request->ajax())
    {
        return Response()->json([
            'success'=>true,
        ]);
    }
}

public function settingSearchTermReligionPost(Request $request)
{
    $validation = Validator::make($request->all(),
        [ 
            // 'minimum_age'=> 'required',
            // 'maximum_age' => 'required',
            // 'gender' => 'required',
            // 'country' => 'required',
            // 'location' => 'required',

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
    }

    $st = Auth::user()->searchTerm;

    $st->religious_status = trim($request->religious_status) ?: null;
    $st->religious_section = trim($request->religious_section) ?: null;
    $st->prefer_hijab = trim($request->prefer_hijab) ?: null;
    $st->prefer_beard = trim($request->prefer_beard) ?: null;
    $st->are_you_revert = trim($request->are_you_revert) ?: null;
    $st->salah_status = trim($request->salah_status) ?: null;
    $st->can_read_quran = trim($request->can_read_quran) ?: null;

    $st->save();

    if($request->ajax())
    {
        return Response()->json([
            'success'=>true,
        ]);
    }
}

public function profileCoverPicChange( Request $request)
{
    $validation = Validator::make($request->all(),
        ['cover_picture' => 'required|image|mimes:jpeg,bmp,png,gif|dimensions:min_width=810,min_height=214'
    ]);
    if($validation->fails())
    {
        return redirect()->back()
        ->withErrors($validation)
        ->withInput()
        ->with('error', 'image must be at least 810px width and 214px height');
    }

    if($request->hasFile('cover_picture'))
    {
        $cp = $request->file('cover_picture');
        $nw= (int) $request->new_width;
        $nh = (int) $request->new_height;
        $x = $request->offset_x > 0 ? (int) $request->offset_x : 0;
        $y = $request->offset_y > 0 ? (int) $request->offset_y : 0;
        $extension = $cp->getClientOriginalExtension();
        $mime = $cp->getClientMimeType();
        $size =$cp->getSize();

        $randomFileName = $request->user()->id.'_cp_'.date('Y_m_d_his').'_'.rand(11111111,99999999).'.'.$extension;

            // Storage::disk('public')
            //     ->put($randomFileName, File::get($cp));
            // $file = Storage::disk('local')->get('shop/sl/'.$randomFileName);

        // $f =  (new Response($file, 200))
        //       ->header('Content-Type', $mime);

        list($originalWidth,$originalHeight) = getimagesize($cp);
        if($originalWidth == '810' && $originalHeight == '214')
        {
            Storage::disk('upload')
            ->put('users/cp/'.$randomFileName, File::get($cp));
                    //pfi = product feature image
        }

        else
        {


            $image = Image::make($cp)
            ->crop($nw, $nh, $x, $y)
            ->resize(810, 214)
            ->save(public_path().'/storage/users/cp/'.$randomFileName, 90);
            $originalWidth = $image->width();
            $originalHeight = $image->height();
            $image->destroy();
        }



        $cp = $request->user()->userPictures()
        ->create([]);
        $cp->autoload = true;
        $cp->image_type = 'coverpic';
        $cp->image_name = $randomFileName;
        $cp->image_mime = $mime;
        $cp->image_ext = $extension;
        $cp->image_width = $originalWidth;
        $cp->image_height = $originalHeight;
        $cp->image_size = $size;
        $cp->image_alt = 'bengali muslim marriage';
        $cp->save();

        $oldRow = $request->user()->userPictures()
        ->whereImageType('coverpic')->whereAutoload(true)
        ->orderBy('id','desc')->offset(1)->first();
        if(!empty($oldRow))
        {
            $oldRow->autoload = false;
            $oldRow->editedby_id = Auth::user()->id;
            $oldRow->save();
        }

        if($request->ajax())
        {
          return Response()->json(View('user.ajax.profileCoverPic', ['u' => $request->user()])
            ->render());
      }
  }
  return back();
}


public function profilepicChange(Request $request)
{
    $validation = Validator::make($request->all(),
        ['profile_picture' => 'required|image|mimes:jpeg,bmp,png,gif|dimensions:min_width=160,min_height=160'
    ]);
    if($validation->fails())
    {
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

        $randomFileName = $request->user()->id.'_pp_'.date('Y_m_d_his').'_'.rand(11111111,99999999).'.'.$extension;

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
            $image->insert($watermark);
            $image->save();
            $originalWidth = $image->width();
            $originalHeight = $image->height();
            $image->destroy();
        // }







        $cp = $request->user()->userPictures()
        ->create([]);
        $cp->autoload = true;
        $cp->image_type = 'profilepic';
        $cp->image_name = $randomFileName;
        $cp->image_mime = $mime;
        $cp->image_ext = $extension;
        $cp->image_width = $originalWidth;
        $cp->image_height = $originalHeight;
        $cp->image_size = $size;
        $cp->image_alt = env('APP_NAME_BIG');

        if(servTru())
        { $cp->save(); } else{}
        

        $oldRow = $request->user()->userPictures()
        ->whereImageType('profilepic')->whereAutoload(true)
        ->orderBy('id','desc')->offset(1)->first();
        if(!empty($oldRow))
        {
            $oldRow->autoload = false;
            $oldRow->editedby_id = Auth::user()->id;
            $oldRow->save();
        }

        if($request->ajax())
        {
          return Response()->json(View('user.ajax.profilePic', ['u' => $request->user()])
            ->render());
      }
  }
  return back();
}



public function profilepicChangePost(Request $request)
{
    $validation = Validator::make($request->all(),
        ['profile_picture' => 'required|image|mimes:jpeg,bmp,png,gif|dimensions:min_width=160,min_height=160'
        // ['profile_picture' => 'required|image|mimes:jpeg,bmp,png,gif|dimensions:min_width=160,min_height=160,max_width=2000,max_height=2000'
    ]);
    if($validation->fails())
    {
        return redirect()->back()
        ->withErrors($validation)
        ->withInput()
        ->with('error', 'Image Size: minimum 160px');
    }

    if($request->hasFile('profile_picture'))
    {
        $cp = $request->file('profile_picture');
        
        $extension = strtolower($cp->getClientOriginalExtension());
        $mime = $cp->getClientMimeType();
        $size =$cp->getSize();

        $randomFileName = $request->user()->id.'_pp_'.date('Y_m_d_his').'_'.rand(11111111,99999999).'.'.$extension;

        list($originalWidth,$originalHeight) = getimagesize($cp);

            $image = Image::make($cp)
            // ->crop($cw, $ch, $x, $y)
            // ->resize(160, 160)
            ->save(public_path().'/storage/users/pp/'.$randomFileName, 90);
            // $watermark = Image::make(public_path('/img/tmm5.png'));
            // $image->insert($watermark);
            // $image->save();
            $originalWidth = $image->width();
            $originalHeight = $image->height();
            $image->destroy();
        // }







        $cp = $request->user()->userPictures()
        ->create([]);
        $cp->autoload = true;
        $cp->image_type = 'profilepic';
        $cp->image_name = $randomFileName;
        $cp->image_mime = $mime;
        $cp->image_ext = $extension;
        $cp->image_width = $originalWidth;
        $cp->image_height = $originalHeight;
        $cp->image_size = $size;
        $cp->image_alt = env('APP_NAME_BIG');

        // if(servTru())
        // { $cp->save(); } else{}
        $cp->save();

        $user = $request->user();
        $user->img_name = null;
        $user->save();
        

        $oldRow = $request->user()->userPictures()
        ->whereImageType('profilepic')->whereAutoload(true)
        ->orderBy('id','desc')->offset(1)->first();
        if(!empty($oldRow))
        {
            $oldRow->autoload = false;
            $oldRow->editedby_id = Auth::user()->id;
            $oldRow->save();
        }


        $ad = Auth::user()->adminData();
        $ad->image_pending = Auth::user()->ppPendingCount();
        $ad->updated_at = $ad->updated_at;
        $ad->save();



        if($request->ajax())
        {
          return Response()->json(View('user.ajax.profilePic', ['u' => $request->user()])
            ->render());
      }
  }
  return back()->with('success', 'Your Profile Picture Successfully Uploaded. Please wait for verify.');
}

public function makeFavourite(User $user, Request $request)
{
    if (Auth::user()->isMyFavourite($user)) {

        Auth::user()->makeUnfavourite($user);
    }
    else{

        $f = Auth::user()->makeFavourite($user);
        $user->touchMainsIncrement();
        $ntfy = $f->notifications()->create([
            'userto_id'=>$user->id,
            'userby_id'=> Auth::id(),
            'description'=> 'created',
            
        ]);
    }

    if($request->ajax())
    {
        return Response()->json([
            'success'=>true,
            'page' => View("user.ajax.favouriteBtnArea", [
                'user'=>$user
            ])->render()
        ]);
    }

    return back();
}

public function makeContact(User $user, Request $request)
{
    if(Auth::user()->contactLimit() <= 0)
    {
        if($request->ajax())
        {
            return Response()->json([
                'success'=>false,
                'sessionMessage' => 'You have no contact limit for your current package.'
            ]);
        }
        return back();
    }
    
    if (Auth::user()->isMyContact($user)) {

        // Auth::user()->makeUncontact($user);

        if($request->ajax())
        {
            return Response()->json([
                'success'=>false,
                'sessionMessage' => 'This contact already in your contact list.'
            ]);
        }
    }
    else{

        //with touch and notification
       $c = Auth::user()->makeContact($user);
        
        $user->touchMainsIncrement();
        $ntfy = $c->notifications()->create([
            'userto_id'=>$user->id,
            'userby_id'=> Auth::id(),
            'description'=> 'created',
            
        ]);
    }

    if($request->ajax())
    {
        return Response()->json([
            'success'=>true,
            'sessionMessage' => 'This contact successfully added in your contact list.',
            'page' => View("user.ajax.contactBtnArea", [
                'user'=>$user
            ])->render()
        ]);
    }

    return back();
}

public function blockThisUser(User $user, Request $request)
{
   if (Auth::user()->isBlockedByMe($user)) {

    Auth::user()->unblockThisUser($user);
}
else{

    Auth::user()->blockThisUser($user);

    // return redirect()->intended('/');
}

if($request->ajax())
{
    return Response()->json([
        'success'=>true,
        'page' => View("user.ajax.blockBtnArea", [
            'user'=>$user
        ])->render()
    ]);
}

return back();
}

public function reportPost(User $user, Request $request)
{
    $validation = Validator::make($request->all(),
        [ 
          'comment'=>'required|min:10',
      ]);

    if($validation->fails())
    {
        return redirect()->back()
        ->withErrors($validation)
        ->withInput()
        ->with('error', 'Please Try again');
    }



    $report = new Report;

    $report->user_id = Auth::id();
    $report->user_second_id = $user->id;
    $report->comment = $request->comment;
    $report->save();

    return back()->with('success', 'Your report successfully submited, Thank you .');
}

public function uploadNewPhotos(Request $request)
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


            $cp = $request->user()->userPhotos()
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

        return back()->with('success', 'Your Photos Successfully Uploaded.');
    }

    return back();

}

public function myAllPhotos(Request $request)
{
    return view('user.photos.myAllPhotos', [
        'type'=>$request->type,
        'u'=>Auth::user()
    ]);
}

public function photoDelete(UserPhoto $photo)
{
    if($photo)
    {
        if($photo->user_id == Auth::id())
        {
            Storage::disk('upload')
            ->delete('users/photos/'.$photo->img_name);
            $photo->delete();
        }
        
    }

    return back()->with('info', 'Your Photo Successfully Deleted.');
}

    //payment start
public function payNow(Request $request)
{
    $packages = MembershipPackage::all();
    $mPackage1 = Cache::remember('mPackage1', 518400, function () {
            return MembershipPackage::whereIn('id', ['1','2','3','4'])->get();
            });

    $mPackage2 = Cache::remember('mPackage2', 518400, function () {
        return MembershipPackage::whereIn('id', ['5','6','7','8'])->get();
    });

    return view('user.payments.payNow', [
        'packages' => $packages,
        'mPackage1' => $mPackage1,
        'mPackage2' => $mPackage2,
    ]);
}

public function payNowEdit(Request $request, UserPayment $payment)
{
    $packages = MembershipPackage::all();

    $mPackage1 = Cache::remember('mPackage1', 518400, function () {
            return MembershipPackage::whereIn('id', ['1','2','3','4'])->get();
            });

    $mPackage2 = Cache::remember('mPackage2', 518400, function () {
        return MembershipPackage::whereIn('id', ['5','6','7','8'])->get();
    });

    $me = Auth::user();

    if($request->ajax())
    {
        $v = 'pay_now_edit';

        return Response()->json(View("user.ajax.partViews.{$v}", [
            'me'=> $me,
            'payment' =>$payment,
            'packages' => $packages,
            'mPackage1' => $mPackage1,
            'mPackage2' => $mPackage2,
        ])->render());
    }

    return view('user.payments.payNowEdit', [
        'packages' => $packages,
        'mPackage1' => $mPackage1,
        'mPackage2' => $mPackage2,
        'payment' => $payment,
        'me' => $me
    ]);
}

public function payNowPost (Request $request)
{
        // dd($request->all());
    $validation = Validator::make($request->all(),
        [
          "package" => "required",
          // "paid_amount" => "required|numeric",
          // "paid_currency" => "required",
          // "payment_method" => "required",
          // "payment_details" => "required"
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

        return redirect()->route('user.payNow')
        ->withErrors($validation)
        ->withInput()
        ->with('error', 'Something went wrong, please try again.');
    }

    $package = MembershipPackage::where('id', $request->package)
    ->first();
    if($package)
    {
        $payment = UserPayment::where('user_id', Auth::id())
        ->where('status', 'pending')->first();
        if($payment)
        {
            // if($request->ajax())
            // {
            //     return Response()->json(array(
            //         'success' => false,
            //         'sessionMessage' => 'Your previous payment order is pending',
            //     ));
            // }

            // return back()
            // ->with('info', 'Your previous payment order is pending');


        }else
        {
            $payment = new UserPayment;
        }
        
        $payment->status = 'pending';
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
        $payment->admin_comment = null;
        $payment->user_id = Auth::id();
        $payment->addedby_id = Auth::id();
        $payment->save();

        if($request->payment_process == 'online')
        {
            
 
            $request->session()->forget(['amount', 'wmx_token']);
            $request->session()->put(['wmx_token'=>'hello', 'amount'=>$payment->package_amount]);

            return redirect()->route('user.paytoPaymentGateway', $payment);
        }    
        else
        {
            if(env('APP_ENV') != 'local')
            {  
                Mail::send('emails.newPendingPayment', ['payment'=>$payment], function ($message){
                    $message->from('info@matchinglifebd.com', 'Matching Life Payment Section');
                    $message->to('info@matchinglifebd.com',  '')
                    ->subject('New Payment Order is submitted at '.url('/'));
                });
            }

            return back()->with('success', 'Your Payment order successfully submitted.');
        }        
    }

    return back();
}

public function payNowEditPost (UserPayment $payment, Request $request)
{
        // dd($request->all());
    $validation = Validator::make($request->all(),
        [
          "package" => "required",
          // "paid_amount" => "required|numeric",
          // "paid_currency" => "required",
          // "payment_method" => "required",
          // "payment_details" => "required"
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

        return redirect()->route('user.payNowEdit', $payment)
        ->withErrors($validation)
        ->withInput()
        ->with('error', 'Something went wrong, please try again.');
    }

    if($payment->status != 'pending')
    {
        if($request->ajax())
        {
            return Response()->json(array(
                'success' => false,
                'sessionMessage' => 'Sorry, This payment status is not pending.',
            ));
        }

        return back()
        ->with('info', 'Sorry, This payment status is not pending');
    }


    $package = MembershipPackage::where('id', $request->package)
    ->first();
    if($package)
    {
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
        $payment->admin_comment = null;
        $payment->editedby_id = Auth::id();
        $payment->updated_at = Carbon::now();
        $payment->save();

        if($request->payment_process == 'manual')
        {
            return back()->with('success', 'Your Payment order successfully updated.');
        }else
        {
            return redirect()->route('user.paytoPaymentGateway', $payment);   
        }
        


                 
    }
}

public function myPaymentHistory(Request $request)
{
    $payments = UserPayment::where('user_id', Auth::id())->latest()->paginate(40);
    return view('user.payments.myPaymentHistory', [
        'payments'=>$payments,
        'u'=>Auth::user()
    ]);
}
    //payment end



    ###### new site start taslima marriage media  ########

public function myAsset(Request $request)
{ 
    $me = Auth::user();
    $v = $request->partView;

    $frontPages = Cache::remember('frontPages', 518400, function () {
                return Page::where('active', true)->get();
            });

    if($v == 'setting_personal_info' or $v == 'search_district')
    {
        $allUpazilas =  Upazila::orderBy('name')->get(); 

        $allDistricts = District::orderBy('name')->get();
    }else{ $allUpazilas = []; $allDistricts = []; }

    if(($v == 'setting_basic_info') or 
        ($v == 'setting_contact_info') or 
        ($v == 'setting_personal_info') or 
        ($v == 'setting_personal_activity') or
        ($v == 'membership_packages') or 
        ($v == 'my_payments') or 
        ($v == 'setting_password') or 
        ($v == 'search_setting') or
        ($v == 'pay_now') )
        // ($v == 'proposal_by_me') or 
        // ($v == 'proposal_to_me') or 
        // ($v == 'proposal_pending') or
        // ($v == 'my_favourite_users') or
        // ($v == 'my_blocked_users') or
        // ($v == 'my_visitor_users') or
        // ($v == 'search_all') or
        // ($v == 'search_username') or
        // ($v == 'search_district') or
        // ($v == 'search_country') or
        // ($v == 'search_zodiac') or
        // ($v == 'search_education') or
        // ($v == 'search_community') or
        // ($v == 'search_marital_status') or
        // ($v == 'search_photo') or
        // ($v == 'search_preference') or
        // ($v == 'search_profession'))
    {}
    else
    {
        if($request->ajax())
        {
            if (!$me->atLeastOneCheckedPP()) 
            {
                if(!$me->uploadedPP())
                {
                    $v = 'pendingNotice';
                    return Response()->json(View("user.ajax.partViews.{$v}", [
                    'me'=> $me,
                    'noticeMessageFor' => "uploadPP",
                    'frontPages'=>$frontPages
                    ])->render());
                }
                elseif(!$me->ppChecked())
                {
                    $v = 'pendingNotice';
                    return Response()->json(View("user.ajax.partViews.{$v}", [
                    'me'=> $me,
                    'noticeMessageFor' => "ppPending",
                    'frontPages'=>$frontPages
                    ])->render());
                }
                
            }
            
            elseif(!$me->isValidate())
            {
                $v = 'pendingNotice';
                return Response()->json(View("user.ajax.partViews.{$v}", [
                'me'=> $me,
                'noticeMessageFor' => "freeAccount",
                'frontPages'=>$frontPages
                ])->render());
            }
        }

    }

    

    

    if($request->ajax())
    {
        if(($v == 'membership_packages') or ($v == 'pay_now'))
        {
            $mPackage1 = Cache::remember('mPackage1', 518400, function () {
            return MembershipPackage::whereIn('id', ['1','2','3','4'])->get();
            });

            $mPackage2 = Cache::remember('mPackage2', 518400, function () {
                return MembershipPackage::whereIn('id', ['5','6','7','8'])->get();
            });

            return Response()->json(View("user.ajax.partViews.{$v}", [
            'me'=> $me,
            'mPackage1'=>$mPackage1,
            'mPackage2'=>$mPackage2,
            'frontPages'=>$frontPages,
            'v' => $v,
            ])->render());
        }
        


        return Response()->json(View("user.ajax.partViews.{$v}", [
            'me'=> $me,
            'frontPages'=>$frontPages,
            'allUpazilas'=>$allUpazilas,
            'allDistricts'=>$allDistricts,
            'v' => $v,
        ])->render());
    }

    return back();
}

public function userAdvanceSearch(Request $request)
  {
    // dd($request->all());
    $frontPages = Cache::remember('frontPages', 518400, function () {
        return Page::where('active', true)->get();
    });
    $me = Auth::user();
    $minimum_age = $request->minimum_age;
    $maximum_age = $request->maximum_age;

    
      // $minAgeDate = $now->SubYear($minimum_age)->toDateString();
      // $maxAgeDate = $now->SubYear($maximum_age)->toDateString();



         $users = User::withoutGlobalScopes()
        ->where('active', 1)
        // ->where('gender', $user->oltGender())
        ->where(function($q) use ($request){
            if($request->gender)
            {
                $q->where('gender', $request->gender);
            }

            // if($request->location)
            // {
            //     $q->where('location', $request->location);
            // }

            if($request->minimum_age and $request->maximum_age)
            {
              $start = Carbon::now()->SubYear($request->minimum_age)->toDateString();

              // dd($start);

              // dd($request->maximum_age);

              $end = Carbon::now()->SubYear($request->maximum_age)->toDateString();

              // dd($end); 
              
                // $q->whereDate('dob', '<');
                $q->whereBetween('dob',[$end,$start]);
              // $q->where('dob', '<', $start);
              // $q->where('dob', '<', $end);
            }
            elseif($request->minimum_age)
            {
                $minAgeDate = Carbon::now()->SubYear($request->minimum_age)->toDateString();

                // dd($minAgeDate);
                
                $q->where('dob', '<=', $minAgeDate);
                // $q->whereDate('dob','<', $minAgeDate);




            }

            elseif($request->maximum_age)
            {
                $maxAgeDate = Carbon::now()->SubYear($request->maximum_age + 1)->toDateString();
                $q->where('dob', '>=', $maxAgeDate);
                // $q->whereDate('dob','>', $maxAgeDate);

                // dd($maxAgeDate);
            }

            if( 
              $request->marital_status 
              or $request->religion 
              or $request->minimum_height 
              or $request->maximum_height 
              )
            {
                $q->whereHas('personalInfo', function ($query) use ($request) 
               {
                    if($request->religion)
                    {
                        $query->where('religion', $request->religion);
                    }

                    if($request->location)
                    {
                      $query->where('country_of_residence', $request->location);
                    }

                    if($request->marital_status)
                    {
                      // dd($request->marital_status);
                        $query->where('marital_status', $request->marital_status);
                    }

                    // if($request->minimum_height)
                    // {
                    //   $
                    //   // dd($request->minimum_height);
                    //     $query->where('height', '>=', $request->minimum_height);
                    // }

                    // if($request->maximum_height)
                    // {
                    //   // dd($request->maximum_height);
                    //     $query->where('height', '<=', $request->maximum_height);
                    // }
                    
                });
            }

            if( 
              
              $request->education_level 
              or $request->profession
              
              )
            {
                $q->whereHas('educationWork', function ($query) use ($request) 
               {
                   
                    if($request->education_level)
                    {
                        $query->where('education_level', $request->education_level);
                    } 

                    if($request->profession)
                    {
                        $query->where('my_profession', $request->profession);
                    }                    
                });


            }
        })
        // ->orderBy('id', $request->order_by)
        // ->limit($request->limit)
        // ->get();
        ->latest()
        ->paginate(24);



      
    return view('user.search_advance', [
      'v' => 'userAdvanceSearch',
      'users'=> $users,
      'minimum_age' => $minimum_age,
      'maximum_age' => $maximum_age,
      'gender' => $request->gender,
      'token' => $request->_token,
      'religion' => $request->religion,
      'marital_status' => $request->marital_status,
      'location' => $request->location,
      'education_level' => $request->education_level,
      'profession'=> $request->profession,
      'minimum_height' => $request->minimum_height,
      'maximum_height' => $request->maximum_height,
      'frontPages'=>$frontPages,
      'me' => $me
    ]);
  }

public function userBasicInfoPost(Request $request)
{
    
    // $dis = '';
    //     $div = '';

    //     if ($request->district) {
    //         $dis = District::where('name', $request->district)->first();
    //         if($dis)
    //         {
    //             $div = $dis->division->name;
    //         }
    //     }
        $userId = Auth::id();
        $user = User::find($userId);
        $user->name = $request->full_name;

        $user->save();
        $personalInfo = new UserPersonalInfo; 
        // $personalInfo->user_id = $user->id;
        $personalInfo->user_id = $userId;

        // $personalInfo->addedby_id = $user->id;
        $personalInfo->addedby_id = $userId;

        // $personalInfo->division = $div;
        // $personalInfo->district = $dis->name;
        $personalInfo->marital_status = $request->marital_status ?: null;
        $personalInfo->height = $request->height; 
        $personalInfo->skin_color = $request->skin_color;

        if( ($request->skin_color == 'Other') || 
            ($request->skin_color == 'Others'))
        {
            $personalInfo->skin_color_other = $request->skin_color_other;
        }else{
            
            $personalInfo->skin_color_other = null;
        }

        $personalInfo->education_level = $request->education_level;

        if( ($request->education_level == 'Other') || 
            ($request->education_level == 'Others'))
        {
            $personalInfo->education_level_other = $request->education_level_other;
        }else{
            
            $personalInfo->education_level_other = null;
        }


        $personalInfo->my_profession = $request->profession;

        if( ($request->profession == 'Other') || 
            ($request->profession == 'Others'))
        {
            $personalInfo->my_profession_other = $request->profession_other;
        }else{
            
            $personalInfo->my_profession_other = null;
        }


        $personalInfo->major_subject = $request->mejor_subject ?: null;



        $personalInfo->save();

        $user->listForAutoMail()->firstOrCreate([]);

        // if($request->hasFile('file'))
        // {
        //     $cp = $request->file('file');
            
        //     $extension = strtolower($cp->getClientOriginalExtension());
        //     $mime = $cp->getClientMimeType();
        //     $size =$cp->getSize();

        //     $randomFileName = $user->id.'_pp_'.date('Y_m_d_his').'_'.rand(11111111,99999999).'.'.$extension;

        //     list($originalWidth,$originalHeight) = getimagesize($cp);

        //         $image = Image::make($cp)
        //         // ->crop($cw, $ch, $x, $y)
        //         // ->resize(160, 160)
        //         ->save(public_path().'/storage/users/pp/'.$randomFileName, 90);
        //         // $watermark = Image::make(public_path('/img/tmm5.png'));
        //         // $image->insert($watermark);
        //         // $image->save();
        //         $originalWidth = $image->width();
        //         $originalHeight = $image->height();
        //         $image->destroy();
        //     // }


        //     $cp = $user->userPictures()
        //     ->create([]);
        //     $cp->autoload = true;
        //     $cp->image_type = 'profilepic';
        //     $cp->image_name = $randomFileName;
        //     $cp->image_mime = $mime;
        //     $cp->image_ext = $extension;
        //     $cp->image_width = $originalWidth;
        //     $cp->image_height = $originalHeight;
        //     $cp->image_size = $size;
        //     $cp->image_alt = env('APP_NAME_BIG');

        //     // if(servTru())
        //     // { $cp->save(); } else{}
        //     $cp->save();
            

        //     // $oldRow = $user->userPictures()
        //     // ->whereImageType('profilepic')
        //     // ->whereAutoload(true)
        //     // ->orderBy('id','desc')
        //     // ->offset(1)
        //     // ->update(['autoload'=>false, 'editedby_id'=>$user->id]);
        // }

        $st = $user->searchTerm()->create(['addedby_id'=>$userId]);

        $st->min_age = $request->minimum_age;
        $st->max_age = $request->maximum_age;
        // $st->country = $request->partner_country;
        // $st->country_other = $request->partner_country_other ?: null;
        $st->my_profession = $request->partner_profession;
        $st->my_profession_other = $request->partner_profession_other ?: null;
        $st->marital_status = $request->partner_marital_status;
        $st->min_height = $request->height_minimum;
        $st->max_height = $request->height_maximum;
        $st->religion = $request->partner_religion;

        $st->save();
        return redirect()->route('user.myPhotoUpload')->with('success','Thanks for Submition your data');
}

public function settingBasicInfoPost(Request $request)
{

    $validation = Validator::make($request->all(),
        [ 
            "full_name" => 'required',
            "guardian_mobile" => 'required',
            "country" => 'required',
            // "country_other" => 'required',
            "profile_created_by" => 'required',
            // "profile_created_by_other" => 'required',
            "religion" => 'required',
            "social_order" => 'required',
            "looking_for" => 'required',
            "gender" => 'required'
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

    $me = Auth::user();
    $me->name = $request->full_name;
    $gNumber = bdMobile($request->guardian_mobile);
    if(strlen($gNumber) != 13)
    {
        $v;
        $v['guardian_mobile'] = 'The Guardian mobile number is not valid, Please try again with Bangladeshi mobile number.';
        if($request->ajax())
        {
            return Response()->json(array(
                'success' => false,
                'errors' => $v
            ));
        }
    }

    $me->guardian_mobile = $gNumber;
    $me->profile_created_by = $request->profile_created_by;
    if( ($request->profile_created_by == 'Other') || 
        ($request->profile_created_by == 'Others'))
    {
        $me->profile_created_by_other = $request->profile_created_by_other;
    }else
    {

        $me->profile_created_by_other = null;
    }

    $me->country = $request->country;
    if( ($request->country == 'Other') || 
        ($request->country == 'Others'))
    {
        $me->country_other = $request->country_other;
    }else{

        $me->country_other = null;
    }
    $me->religion = $request->religion;
    $me->social_order = $request->social_order;
    $me->looking_for = $request->looking_for;
    $me->gender = $request->gender;
    $me->editedby_id = $me->id;
    $me->checked = false;
    $me->save();



    if($request->ajax())
    {
        return Response()->json(['success' => true]);
    }

    return back();

}

public function settingContactInfoPost(Request $request)
{

    $validation = Validator::make($request->all(),
        [ 
            // "alternative_email" => 'required|email',
            // "alternative_mobile" => 'required',
            "convenient_time_to_call" => 'required',
            "name_of_contact_person" => 'required',
            "relation_with_contact_person" => 'required',
            "present_address" => 'required',
            "permanent_address" => 'required',
            // "about_me" => 'required',
            // 'about_family' => 'required',
            // 'nid' => 'required',
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

    $me = Auth::user();

    $contactInfo = $me->contactInfo;

    if(!$contactInfo)
    {
        $contactInfo = new UserContactInfo; 
        $contactInfo->user_id = $me->id;
        $contactInfo->addedby_id = $me->id;           
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

$contactInfo->checked = false;
$contactInfo->save();



    if($request->ajax())
    {
        return Response()->json(['success' => true]);
    }

    return back();

}

    public function settingPersonalActivitiesPost(Request $request)
    {
        // dd($request->all());
        $validation = Validator::make($request->all(),
            [ 
                "my_interests" => 'required',
                "favourite_music" => 'required',
                "favourite_reads" => 'required',
                "favourite_movies" => 'required',
                "favourite_cooking" => 'required',
                "favourite_dresses" => 'required',
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

        $me = Auth::user();

        $perAct = $me->personalActivity;

        if(!$perAct)
        {
            $perAct = new UserPersonalActivity; 
            $perAct->user_id = $me->id;
            $perAct->addedby_id = $me->id; 
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

        $perAct->checked = false;
        $perAct->save();

        if($request->ajax())
        {
            return Response()->json(['success' => true]);
        }

        return back();
    }

    public function sendProposal(Request $request, User $user)
    {
 

        if($request->ajax())
        {
            return Response()->json(View('user.includes.modal.sendProposalModal',[
                'user'=> $user
            ])->render());
        }
    }

    public function sendProposalPost(Request $request, User $user)
    {
        // dd($request->all());
        // $validation = Validator::make($request->all(),
        //     [ 
        //       'comment'=>'required|min:20|max:255',
        //   ]);

        // if($validation->fails())
        // {
        //     if($request->ajax())
        //     {
        //         return Response()->json(array(
        //             'success' => false,
        //             'errors' => $validation->errors()->toArray()
        //         ));
        //     }

        //     return back()
        //     ->withInput()
        //     ->withErrors($validation);
        // }

        $me = Auth::user();

        if ($me->sentProposalTo($user) or $user->sentProposalTo($me)) {

            if($request->ajax())
            {
                return Response()->json([
                    'success' => false,
                    'sessionMessage' => "A Proposal already transferred between you."
                ]);
            }
            
        }
        elseif($me->dailyProposalLimitCompleted())
        {
            if($request->ajax())
            {
                return Response()->json([
                    'success' => false,
                    'sessionMessage' => "Daily sending limit completed for your current package."
                ]);
            }
        }
        elseif ($me->totalProposalLimitCompleted()) 
        {
            if($request->ajax())
            {
                return Response()->json([
                    'success' => false,
                    'sessionMessage' => "Total sending limit completed for your current package."
                ]);
            }
        }

        else
        {
            $proposal = new UserProposal;
            $proposal->user_id = $me->id;
            $proposal->user_second_id = $user->id;
            // $proposal->message = preg_replace('/\d+/u', '', $request->comment);
            $proposal->message = $request->comment;

            $proposal->save();

            $user->touchMainsIncrement();
            $ntfy = $proposal->notifications()->create([
                'userto_id'=>$user->id,
                'userby_id'=> $me->id,
                'description'=> 'created',                
            ]);

            $me->proposalSentSms($proposal);
            $me->proposalSentEmail($proposal);
        }


        if($request->ajax())
        {
            return Response()->json([
                'success' => true,
                'sessionMessage' => "Your proposal successfully sent to {$user->username}"
            ]);
        }

        return back();

    }

    public function acceptProposal(Request $request, UserProposal $proposal)
    {
        if ($proposal->user_second_id == Auth::id()) 
        {
            $proposal->accepted = true;
            $proposal->editedby_id = Auth::id();
            $proposal->save();   

            $proposal->user->touchMainsIncrement();
            $ntfy = $proposal->notifications()->create([
                'userto_id'=>$proposal->user_id,
                'userby_id'=> Auth::id(),
                'description'=> 'created',                
            ]);
        }

        if($request->ajax())
        {
            return Response()->json([
                'success' => true,
                'page' => View('user.includes.cards.proposalCard',[
                'proposal'=> $proposal
            ])->render(),
            ]);
        }


    }

    public function cancelProposal(Request $request, UserProposal $proposal)
    {
        if (($proposal->user_second_id == Auth::id()) or ($proposal->user_id == Auth::id())) 
        {
            $proposal->userSecond->touchMainsDecrement();
            $proposal->notifications()->delete();
            $proposal->editedby_id = Auth::id();
            $proposal->save();
            $proposal->delete();   
        }

        if($request->ajax())
        {
            return Response()->json([
                'success' => true,
                'page' => false
            ]);
        }


    }

    public function myPhotoUpload()
    {
        $frontPages = Cache::remember('frontPages', 518400, function () {
                return Page::where('active', true)->get();
            });
        
            $allDistricts = Cache::remember('allDistricts', 518400, function () {
                return District::all();
            });
            $allUpazilas =  Upazila::orderBy('name')->get();

        return view('user.myPhotoUpload', ['frontPages'=>$frontPages,
        'allDistricts'=>$allDistricts,
        'allUpazilas'=>$allUpazilas
        ]);
    }

    public function myCvUpload()
    {
        $frontPages = Cache::remember('frontPages', 518400, function () {
                return Page::where('active', true)->get();
            });

        return view('user.myCvUpload', ['frontPages'=>$frontPages]);
    }

    public function myCvChangePost(Request $request)
    {
        $user = Auth::user();

        if($user->cv_checked)
        {
            
                return back()->with('error', 'Sorry, Your cv already uploaded. Thank you.');    

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
            $user->cv_checked = 0;
            $user->save();

            return back()->with('success', 'Your Cv Successfully Uploaded. Please wait for review');
        }
  
    }

    public function myComments()
    {
        $frontPages = Cache::remember('frontPages', 518400, function () {
                return Page::where('active', true)->get();
            });
        return view('user.myComments', ['frontPages'=>$frontPages]);
    }

    public function myCommentPost(Request $request)
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

        $me = Auth::user();
        $comment = new UserComment;
        $comment->comment = $request->comment;
        $comment->user_id = $me->id;
        $comment->addedby_id = $me->id;
        $comment->save();

        if($request->ajax())
        {
            return Response()->json(View("user.ajax.partViews.{$v}", [
                'u'=>Auth::user()
            ])->render());
        }

        return back()->with('success', 'Your Message successfully submitted.');  
    }

    #search start

    public function userSearchByUsernameAjax(Request $request)
    {
        // dd($request->all());

          $users = User::where(function($qqq) use ($request){
            $qqq->orWhere('username', 'like', "{$request->q}");
            $qqq->orWhere('id', 'like', "{$request->q}");
          })
          ->whereDoesntHave('blockerOf',function($query){
                $query->where('user_id', Auth::id());
            })
        ->whereDoesntHave('blockss', function($qq){
            $qq->where('user_second_id', Auth::id());
        })

        // ->whereHas('userPictures', function ($query) {
        //     $query->where('image_type', 'profilepic');
        //     $query->where('checked', true);
        //   })
        ->where('img_name', '<>', null)
          ->where('gender', Auth::user()->oltGender())
        // ->where('gender', Auth::user()->lookingFor())
          ->orderBy('updated_at', 'desc')->paginate(24);
 

        $v = 'search_username';
        // $users->withPath('/user/search-zone/searchProfession');

        if($request->ajax())
        {
            
            return Response()->json(View("user.ajax.myUsernameUsers", [
              'me'=>Auth::user(),
              'users' => $users,
              'q' => $request->q
            ])->render());
        }
    }



    public function userSearchByProfessionAjax(Request $request)
    {
        // dd($request->all());

        $users = User::whereHas('personalInfo', function ($query) use ($request) 
          {
            $query->where(function($q) use ($request){
                if($request->professions)
                {
                    foreach ($request->professions as $profession) 
                    {
                  
                      $q->orWhere('my_profession', 'like', "%".$profession."%");
                    }
                }
            });

          })
          ->whereDoesntHave('blockerOf',function($query){
                $query->where('user_id', Auth::id());
            })
        ->whereDoesntHave('blockss', function($qq){
            $qq->where('user_second_id', Auth::id());
        })

          ->where('gender', Auth::user()->oltGender())
        // ->where('gender', Auth::user()->lookingFor())
        
        /*->where(function($query) use ($request){
            if($request->genders)
            {
                foreach ($request->genders as $gender) {

                    if($gender == "Bride (Female)")
                    {
                        $gender = 'Female';
                    }
                    else
                    {
                        $gender = 'Male';                        
                    }
                      $query->orWhere('gender', $gender);
                }
            }
        })*/

        // ->whereHas('userPictures', function ($query) {
        //     $query->where('image_type', 'profilepic');
        //     $query->where('checked', true);
        //   })
        ->where('img_name', '<>', null)
          ->orderBy('updated_at', 'desc')->paginate(24);

          // $users->withPath('/userpanel/user/search-profession/ajax');
        

        if($request->ajax())
        {
            return Response()->json(View("user.ajax.myProfessionUsers", [
              'me'=>Auth::user(),
              'users' => $users,
              'professions' => $request->professions,
              // 'genders' => $request->genders
            ])->render());
        }
        
    }

    public function userSearchByEducationAjax(Request $request)
    {
        // dd($request->all());

        $users = User::whereHas('personalInfo', function ($query) use ($request) 
          {
            $query->where(function($q) use ($request){
                if($request->educations)
                {
                    foreach ($request->educations as $education) 
                    {
                  
                      $q->orWhere('education_level', 'like', "%".$education."%");
                      $q->orWhere('education_level_other', 'like', "%".$education."%");
                    }
                }
            });

          })
          ->whereDoesntHave('blockerOf',function($query){
                $query->where('user_id', Auth::id());
            })
        ->whereDoesntHave('blockss', function($qq){
            $qq->where('user_second_id', Auth::id());
        })

          ->where('gender', Auth::user()->oltGender())
        // ->where('gender', Auth::user()->lookingFor())
        
        /*->where(function($query) use ($request){
            if($request->genders)
            {
                foreach ($request->genders as $gender) {

                    if($gender == "Bride (Female)")
                    {
                        $gender = 'Female';
                    }
                    else
                    {
                        $gender = 'Male';                        
                    }
                      $query->orWhere('gender', $gender);
                }
            }
        })*/

        // ->whereHas('userPictures', function ($query) {
        //     $query->where('image_type', 'profilepic');
        //     $query->where('checked', true);
        //   })
        ->where('img_name', '<>', null)
          ->orderBy('updated_at', 'desc')->paginate(24);

          // $users->withPath('/userpanel/user/search-profession/ajax');
        

        if($request->ajax())
        {
            return Response()->json(View("user.ajax.myEducationUsers", [
              'me'=>Auth::user(),
              'users' => $users,
              'educations' => $request->educations,
              // 'genders' => $request->genders
            ])->render());
        }
        
    }

    public function userSearchByDistrictAjax(Request $request)
    {
        // dd($request->all());
        if(!$request->district && !$request->thana)
        {
            if($request->ajax())
            {
                return Response()->json(View("user.ajax.myDistrictUsers", [
                  'me'=>Auth::user(),
                  'users' => User::where('id',0)->paginate(24),
                  'distId' => $request->district,
                  'thanaId' => $request->thana
                ])->render());
            }
        }

        

        $users = User::whereHas('personalInfo', function ($query) use ($request) 
          {
            $query->where(function($q) use ($request){
                
                if($request->thana)
                {
                    $thana = Upazila::where('id', $request->thana)->first();
                    if($thana)
                    {



                        $district = $thana->district;

                        $q->where('district', $district->name);

                        $q->where('thana', $thana->name);
                    }
                }elseif($request->district)
                {
                    $district = District::where('id', $request->district)->first();
                    if($district)
                    {

                        $q->where('district',$district->name);
                    }
                }



            });

          })
          ->whereDoesntHave('blockerOf',function($query){
                $query->where('user_id', Auth::id());
            })
        ->whereDoesntHave('blockss', function($qq){
            $qq->where('user_second_id', Auth::id());
        })

          ->where('gender', Auth::user()->oltGender())
        // ->where('gender', Auth::user()->lookingFor())
        
        
        ->where('img_name', '<>', null)
          ->orderBy('updated_at', 'desc')->paginate(24);

          // $users->withPath('/userpanel/user/search-profession/ajax');
        

        if($request->ajax())
        {
            return Response()->json(View("user.ajax.myDistrictUsers", [
              'me'=>Auth::user(),
              'users' => $users,
              'distId' => $request->district,
              'thanaId' => $request->thana
            ])->render());
        }
        
    }

    public function userSearchByCountryAjax(Request $request)
    {
         // $users = User::whereHas('personalInfo', function ($query) use ($request) 
         //  {
         //    $query->where(function($q) use ($request){
                
                
         //    });

         //  })
        $users = User::where(function ($query) use ($request) 
          {
            $query->where('country', $request->country);
            $query->orWhere('country_other', $request->country);

          })


          ->whereDoesntHave('blockerOf',function($query){
                $query->where('user_id', Auth::id());
            })
        ->whereDoesntHave('blockss', function($qq){
            $qq->where('user_second_id', Auth::id());
        })

          ->where('gender', Auth::user()->oltGender())
        // ->where('gender', Auth::user()->lookingFor())
        
        
        ->where('img_name', '<>', null)
          ->orderBy('updated_at', 'desc')->paginate(24);

          // $users->withPath('/userpanel/user/search-profession/ajax');
        

        if($request->ajax())
        {
            return Response()->json(View("user.ajax.myCountryUsers", [
              'me'=>Auth::user(),
              'users' => $users,
              'country' => $request->country,
            ])->render());
        }
        
    }

    

    public function userSearchByCommunityAjax(Request $request)
    {
         // $users = User::whereHas('personalInfo', function ($query) use ($request) 
         //  {
         //    $query->where(function($q) use ($request){
                
                
         //    });

         //  })
        $users = User::where(function ($query) use ($request) 
          {
            $query->where('religion', $request->community);

          })


          ->whereDoesntHave('blockerOf',function($query){
                $query->where('user_id', Auth::id());
            })
        ->whereDoesntHave('blockss', function($qq){
            $qq->where('user_second_id', Auth::id());
        })

          ->where('gender', Auth::user()->oltGender())
        // ->where('gender', Auth::user()->lookingFor())
        
        
        ->where('img_name', '<>', null)
          ->orderBy('updated_at', 'desc')->paginate(24);

          // $users->withPath('/userpanel/user/search-profession/ajax');
        

        if($request->ajax())
        {
            return Response()->json(View("user.ajax.myCommunityUsers", [
              'me'=>Auth::user(),
              'users' => $users,
              'community' => $request->community,
            ])->render());
        }
        
    }

    public function userSearchByMaritalStatusAjax(Request $request)
    {
         $users = User::whereHas('personalInfo', function ($query) use ($request) 
          {
            $query->where(function($q) use ($request){
                
                $q->where('marital_status', $request->marital_status);
                $q->whereNotNull('marital_status');
            });

          })

          ->whereDoesntHave('blockerOf',function($query){
                $query->where('user_id', Auth::id());
            })
        ->whereDoesntHave('blockss', function($qq){
            $qq->where('user_second_id', Auth::id());
        })

          ->where('gender', Auth::user()->oltGender())
        // ->where('gender', Auth::user()->lookingFor())
        
        
        ->where('img_name', '<>', null)
          ->orderBy('updated_at', 'desc')->paginate(24);

          // $users->withPath('/userpanel/user/search-profession/ajax');
        

        if($request->ajax())
        {
            return Response()->json(View("user.ajax.myMaritalStatusUsers", [
              'me'=>Auth::user(),
              'users' => $users,
              'marital_status' => $request->marital_status,
            ])->render());
        }
        
    }

    
    public function userSearchByZodiacAjax(Request $request)
    {
        // dd($request->all());

        $users = User::whereHas('personalInfo', function ($query) use ($request) 
          {
            $query->where('zodiac_sign', 'like', "{$request->q}%")->where('zodiac_sign','<>', 'Not Interested');

          })

        ->whereDoesntHave('blockerOf',function($query){
                $query->where('user_id', Auth::id());
            })
        ->whereDoesntHave('blockss', function($qq){
            $qq->where('user_second_id', Auth::id());
        })

        // ->whereHas('userPictures', function ($query) {
        //     $query->where('image_type', 'profilepic');
        //     $query->where('checked', true);
        //   })
        ->where('img_name', '<>', null)
          ->where('gender', Auth::user()->oltGender())
        // ->where('gender', Auth::user()->lookingFor())
          ->orderBy('updated_at', 'desc')->paginate(24);
 

        // $v = 'search_username';
        // $users->withPath('/user/search-zone/searchProfession');

        if($request->ajax())
        {
            
            return Response()->json(View("user.ajax.myUsernameUsers", [
              'me'=>Auth::user(),
              'users' => $users,
              'q' => $request->q
            ])->render());
        }
    }


    #search end

    #print start

    public function userDetailsPrint(Request $request)
    {
        if (Auth::check()) {
            if (Auth::user()->isAdmin()) {
                
                $user = User::withoutGlobalScopes()
                // ->with(['about'])
                ->find($request->user);
            }
        }

        $user = User::find($request->user);
        

        if(!$user)
        {
            abort(404);
        }

        return view('welcome.userDetailsPrint', [ 'user' => $user ]);
    }
    #print end
 

    ###### new site end taslima marriage media ########
}
