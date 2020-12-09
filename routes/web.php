<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/ajax/product',function(){
//     $grooms User::where('gender', 'Male')->paginate(3);
//     // $products = Product::paginate(10);
//     return View::make('welcome.parts.welcomeNewPart',compact($grooms))->render();
// });


Route::get('welcome/fetch_data', 'WelcomeController@fetch_data');

// bridgroombd

Route::get('/profile/{user}',[
    'uses' => 'WelcomeController@featureDetails',
    'as' => 'welcome.featureDetails'
]);

Route::get('/feature-profile', [
    'uses'=> 'WelcomeController@feature_profile',
    'as'=> 'welcome.feature_profile'
]);


Route::get('/second-marrige',[
    'uses' => 'WelcomeController@secondMarrige',
    'as' => 'second-marrige'
]);

Route::get('/about-us', [
    'uses' => 'WelcomeController@aboutus',
    'as' => 'about-us'
]);

// Route::post('/contacts', 'RequestCallController@store')->name('contacts'); 

Route::get('/wedding-service', [
    'uses' =>'WelcomeController@weddingservice',
    'as' => 'wedding-service'
]);

Route::post('/contacts', 'RequestCallController@store')->name('contacts'); 

Route::get('/contact-us', [
    'uses' => 'WelcomeController@contactus',
    'as' => 'contact-us'
]);


Route::get('/request',[
    'uses' => 'WelcomeController@request',
    'as' => 'request'
]);


// Route::get('/', function () {
//     return view('welcome');
// });

####### for auth #########
// Auth::routes();

Route::get('login', [
    'uses' =>'Auth\LoginController@showLoginForm',
    'as' => 'login'
]);



Route::post('login', [
    'uses' =>'Auth\LoginController@login',
]);

Route::post('logout', [
    'uses' =>'Auth\LoginController@logout',
    'as' => 'logout'
]);


// Route::get('copy/users/94766', [
//     'uses' =>'WelcomeController@copyUsers',
//     'as' => 'copyUsers'
// ]);

// Route::get('user/automail/list/create/94766', [
//     'uses' =>'WelcomeController@userAutomailListCreate',
//     'as' => 'userAutomailListCreate'
// ]);




// Route::get('copy/regions/94766', [
//     'uses' =>'WelcomeController@copyRegions',
//     'as' => 'copyRegions'
// ]);

// Route::get('copy/dist/94766', [
//     'uses' =>'WelcomeController@copyDist',
//     'as' => 'copyDist'
// ]);

// Route::get('copy/thana/94766', [
//     'uses' =>'WelcomeController@copyThana',
//     'as' => 'copyThana'
// ]);

// Route::get('copy/posts/94766', [
//     'uses' =>'WelcomeController@copyPosts',
//     'as' => 'copyPosts'
// ]);




Route::get('welcome/automail', [
    'uses' =>'WelcomeController@automail',
    'as' => 'welcome.automail'
])->middleware('auth');


Route::get('test/mail', [
    'uses' =>'WelcomeController@testMail',
    'as' => 'welcome.testMail'
]);



// Route::get('welcome/new', [
//     'uses' =>'WelcomeController@welcomeNew',
//     'as'=> 'welcome.welcomeNew'
// ]);


Route::post('password/email', [
    'uses' =>'Auth\ForgotPasswordController@sendResetLinkEmail',
    'as' => 'password.email'
]);


Route::get('password/reset', [
    'uses' =>'Auth\ForgotPasswordController@showLinkRequestForm',
    'as' => 'password.request'
]);

Route::post('password/reset', [
    'uses' =>'Auth\ResetPasswordController@reset',
    'as' => 'password.update'
]);

Route::get('password/reset/{token}', [
    'uses' =>'Auth\ResetPasswordController@showResetForm',
    'as' => 'password.reset'
]);

// Route::get('register', [
//     'uses' =>'Auth\RegisterController@showRegistrationForm',
//     'as' => 'register'
// ]);

// Route::post('register', [
//     'uses' =>'Auth\RegisterController@register',
// ]);


Route::any('signup', [
    'uses' =>'Auth\SignupController@signup',
    'as' => 'signup'
]);

Route::any('signup/post', [
    'uses' =>'Auth\SignupController@signupPost',
    'as' => 'signupPost'
]);

//page
Route::get('page/{page}', [
    'uses' => 'WelcomeController@page',
    'as' => 'page' 
]);
//page

########## welcome #############

Route::get('/{username}', [
    'uses' =>'WelcomeController@username',
    'as' => 'welcome.username'
])->middleware('auth');

Route::get('success/story/{story}/{title?}', [
    'uses' =>'WelcomeController@successStory',
    'as' => 'welcome.successStory'
]);

Route::get('success/profiles', [
    'uses' =>'WelcomeController@successProfiles',
    'as' => 'welcome.successProfiles'
]);

Route::any('payto/payment/gateway/callback', [
        'uses' =>'WalletMixController@paytoPaymentGatewayCallback',
        'as' => 'welcome.paytoPaymentGatewayCallback'
    ]);


//search
// Route::get('user/search/{view?}', [
//     'uses' =>'WelcomeController@search',
//     'as' => 'welcome.search'
// ]);

// Route::get('user/search-zone/{partView}', [
//     'uses' =>'WelcomeController@searchZone',
//     'as' => 'welcome.searchZone'
// ]);

// Route::get('user/search-by-profession/ajax', [
//     'uses' =>'WelcomeController@userSearchByProfessionAjax',
//     'as' => 'welcome.userSearchByProfessionAjax'
// ]);
//search end



########## welcome #############

####### for auth #########



Route::get('/home/index', 'HomeController@index')->name('home');


Route::get('/', [
    'uses' =>'WelcomeController@welcome',
    'as' => 'welcome.welcome'
]);


Route::get('pages/{page_view}', [
    'uses' =>'WelcomeController@pages',
    'as' => 'welcome.pages'
]);

// Route::get('test/{view}', [
//     'uses' =>'WelcomeController@test',
//     'as' => 'welcome.test'
// ]);

Route::get('select/tags/or/add/new', [
'uses' =>'WelcomeController@selectTagsOrAddNew',
'as' => 'welcome.selectTagsOrAddNew'
]);

Route::get('select/district/for/post', [
'uses' =>'WelcomeController@selectDistrictForPost',
'as' => 'welcome.selectDistrictForPost'
]);

Route::get('select/thana/for/post', [
'uses' =>'WelcomeController@selectThanaForPost',
'as' => 'welcome.selectThanaForPost'
]);

Route::any('membership/packages', [
    'uses' =>'WelcomeController@membershipPackages',
    'as' => 'welcome.membershipPackages'
]);

Route::group(['middleware' => ['auth'], 'prefix' => 'userpanel'], function () {



###### new site start taslima marriage media  ########


    ## auth search start

    Route::get('user/search/{view?}', [
        'uses' =>'UserController@userSearch',
        'as' => 'user.userSearch'
    ]);


    Route::get('user/search-username', [
        'uses' =>'UserController@userSearchByUsernameAjax',
        'as' => 'user.userSearchByUsernameAjax'
    ]);

    Route::get('lazy-load/user', [
        'uses' =>'UserController@lazyLoadUser',
        'as' => 'user.lazyLoadUser'
    ]);

    Route::any('user/search-profession/ajax', [
        'uses' =>'UserController@userSearchByProfessionAjax',
        'as' => 'user.userSearchByProfessionAjax'
    ]);

    Route::any('user/search-education/ajax', [
        'uses' =>'UserController@userSearchByEducationAjax',
        'as' => 'user.userSearchByEducationAjax'
    ]);

    Route::any('user/search-community/ajax', [
        'uses' =>'UserController@userSearchByCommunityAjax',
        'as' => 'user.userSearchByCommunityAjax'
    ]);

    Route::any('user/search-marital-status/ajax', [
        'uses' =>'UserController@userSearchByMaritalStatusAjax',
        'as' => 'user.userSearchByMaritalStatusAjax'
    ]);

    Route::any('user/search-country/ajax', [
        'uses' =>'UserController@userSearchByCountryAjax',
        'as' => 'user.userSearchByCountryAjax'
    ]);

    Route::any('user/search-zodiac/ajax', [
        'uses' =>'UserController@userSearchByZodiacAjax',
        'as' => 'user.userSearchByZodiacAjax'
    ]);

    Route::any('user/search-district/ajax', [
        'uses' =>'UserController@userSearchByDistrictAjax',
        'as' => 'user.userSearchByDistrictAjax'
    ]);
    ## auth search end


    Route::get('my/notifications', [
        //private, public
        'uses' =>'UserController@myNotifications',
        'as' => 'user.myNotifications',
    ]);


    Route::get('my/asset/{partView}', [
        //private, public
        'uses' =>'UserController@myAsset',
        'as' => 'user.myAsset',
    ]);
    
    // advance search
    Route::get('user/advance/search', [
        'uses' =>'UserController@userAdvanceSearch',
        'as' => 'welcome.userAdvanceSearch'
    ]);

    Route::post('/update/basic/user-info/post', [
        'uses' =>'UserController@userBasicInfoPost',
        'as' => 'user.userBasicInfoPost'
    ]);

    Route::post('/setting/basic-info/post', [
    'uses' =>'UserController@settingBasicInfoPost',
    'as' => 'user.settingBasicInfoPost'
    ]);


    Route::post('/setting/contact-info/post', [
    'uses' =>'UserController@settingContactInfoPost',
    'as' => 'user.settingContactInfoPost'
    ]);

    Route::post('/setting/personal-activities/post', [
    'uses' =>'UserController@settingPersonalActivitiesPost',
    'as' => 'user.settingPersonalActivitiesPost'
    ]);

    Route::post('/setting/personal-info/post', [
    'uses' =>'UserController@settingPersonalInfoPost',
    'as' => 'user.settingPersonalInfoPost'
    ]);


    Route::get('send/proposal/{user}', [
        'uses' =>'UserController@sendProposal',
        'as' => 'user.sendProposal',
    ]);

    Route::post('send/proposal/post/{user}', [
        'uses' =>'UserController@sendProposalPost',
        'as' => 'user.sendProposalPost',
    ]);

    Route::get('accept/proposal/{proposal}', [
        'uses' =>'UserController@acceptProposal',
        'as' => 'user.acceptProposal',
    ]);

    Route::get('cancel/proposal/{proposal}', [
        'uses' =>'UserController@cancelProposal',
        'as' => 'user.cancelProposal',
    ]);

    // Route::get('my/contact/information', [
    //     'uses' =>'UserController@myBasicContactInfo',
    //     'as' => 'user.myBasicContactInfo',
    // ]);

    Route::get('my/photo/upload', [
        'uses' =>'UserController@myPhotoUpload',
        'as' => 'user.myPhotoUpload',
    ]);

    Route::get('my/cv/upload', [
        'uses' =>'UserController@myCvUpload',
        'as' => 'user.myCvUpload',
    ]);



    Route::get('my/comments', [
        'uses' =>'UserController@myComments',
        'as' => 'user.myComments',
    ]);

    Route::post('my/comment/post', [
        'uses' =>'UserController@myCommentPost',
        'as' => 'user.myCommentPost',
    ]);

    Route::get('user/details/print/{user}', [
        'uses' =>'UserController@userDetailsPrint',
        'as' => 'user.userDetailsPrint',
    ]);

###### new site start taslima marriage media  ########




































    Route::get('all/users/{type}', [
        //favourite, block, visitor
        'uses' =>'UserController@allRelatedUsers',
        'as' => 'user.allRelatedUsers',
    ]);

    Route::get('my/all/photos/{type}', [
        //private, public
        'uses' =>'UserController@myAllPhotos',
        'as' => 'user.myAllPhotos',
    ]);

    Route::get('my/payment/history', [
        //private, public
        'uses' =>'UserController@myPaymentHistory',
        'as' => 'user.myPaymentHistory',
    ]);

    Route::post('upload/new/photos/{type}', [
        //private, public
        'uses' =>'UserController@uploadNewPhotos',
        'as' => 'user.uploadNewPhotos',
    ]);

    Route::get('photo/delete/{photo}', [
        //private, public
        'uses' =>'UserController@photoDelete',
        'as' => 'user.photoDelete',
    ]);


    Route::get('pay/now', [
        'uses' =>'UserController@payNow',
        'as' => 'user.payNow',
    ]);

    Route::post('pay/now/post', [
        'uses' =>'UserController@payNowPost',
        'as' => 'user.payNowPost',
    ]);

    Route::get('pay/now/edit/{payment}', [
        'uses' =>'UserController@payNowEdit',
        'as' => 'user.payNowEdit',
    ]);

    Route::post('pay/now/edit/post/{payment}', [
        'uses' =>'UserController@payNowEditPost',
        'as' => 'user.payNowEditPost',
    ]);

    Route::any('payto/payment/gateway/{payment}', [
    'uses' =>'WalletMixController@paytoPaymentGateway',
    'as' => 'user.paytoPaymentGateway'
    ]);



    

    //profile //user profile
    Route::get('my/profile', [
        'uses' =>'UserController@myProfile',
        'as' => 'user.myProfile',
    ]);

    Route::post('my/profile/coverpic/Change', [
        'uses' =>'UserController@profileCoverPicChange',
        'as' => 'user.profileCoverPicChange',
    ]);

    Route::post('my/profilepic/Change', [
        'uses' =>'UserController@profilepicChange',
        'as' => 'user.profilepicChange',
    ]);

    Route::post('my/profilepic/Change/post', [
        'uses' =>'UserController@profilepicChangePost',
        'as' => 'user.profilepicChangePost',
    ]);

    Route::post('my/cv/change/post', [
        'uses' =>'UserController@myCvChangePost',
        'as' => 'user.myCvChangePost',
    ]);





    Route::get('/my/dashboard', [
    'uses' =>'UserController@dashboard',
    'as' => 'user.dashboard'
    ]);

    Route::post('/report/post/{user}', [
    'uses' =>'UserController@reportPost',
    'as' => 'user.reportPost'
    ]);



    Route::get('/settings/{view?}', [
    'uses' =>'UserController@settings',
    'as' => 'user.settings'
    ]);

    Route::get('/setting-zone/{partView}', [
    'uses' =>'UserController@settingZone',
    'as' => 'user.settingZone'
    ]);

    Route::post('/setting/about-me/post', [
    'uses' =>'UserController@settingAboutMePost',
    'as' => 'user.settingAboutMePost'
    ]);

    Route::post('/setting/education-work/post', [
    'uses' =>'UserController@settingEducationWorkPost',
    'as' => 'user.settingEducationWorkPost'
    ]);

    Route::post('/setting/religion/post', [
    'uses' =>'UserController@settingReligion',
    'as' => 'user.settingReligion'
    ]);

    Route::post('/setting/personal-info-for-office/post', [
    'uses' =>'UserController@settingPersonalInfoForOfficePost',
    'as' => 'user.settingPersonalInfoForOfficePost'
    ]);
    
    Route::post('/change/username', [
    'uses' =>'UserController@changeUsername',
    'as' => 'user.changeUsername'
    ]);

    Route::post('/change/mobile', [
    'uses' =>'UserController@changeMobile',
    'as' => 'user.changeMobile'
    ]);



    Route::post('/change/password', [
    'uses' =>'UserController@changePassword',
    'as' => 'user.changePassword'
    ]); 

    Route::post('/change/email', [
    'uses' =>'UserController@changeEmail',
    'as' => 'user.changeEmail'
    ]); 

    Route::post('/change/contact', [
    'uses' =>'UserController@changeContact',
    'as' => 'user.changeContact'
    ]);

    Route::post('setting/search/term/post', [
    'uses' =>'UserController@settingSearchTermPost',
    'as' => 'user.settingSearchTermPost'
    ]);  

    Route::post('setting/search/term/edu/work/post', [
    'uses' =>'UserController@settingSearchTermEduWorkPost',
    'as' => 'user.settingSearchTermEduWorkPost'
    ]);  

    Route::post('setting/search/term/personal/info/post', [
    'uses' =>'UserController@settingSearchTermPersonalInfoPost',
    'as' => 'user.settingSearchTermPersonalInfoPost'
    ]); 

    Route::post('setting/search/term/religion/post', [
    'uses' =>'UserController@settingSearchTermReligionPost',
    'as' => 'user.settingSearchTermReligionPost'
    ]);   

    //favourite
    Route::any('make/favourite/{user}', [
    'uses' =>'UserController@makeFavourite',
    'as' => 'user.makeFavourite'
    ]);
    //favourite

    //contact
    Route::any('make/contact/{user}', [
    'uses' =>'UserController@makeContact',
    'as' => 'user.makeContact'
    ]);
    //contact
    

    //block
    Route::any('block/this/user/{user}', [
    'uses' =>'UserController@blockThisUser',
    'as' => 'user.blockThisUser'
    ]);
    //block
    

    
});

#admin start //admin
Route::group(['middleware' => ['role:admin','auth'] ,'prefix' => 'admin'], function () {



    Route::post('user/comment/by-admin-post/{user}', [
        'uses' =>'AdminController@userCommentByAdminPost',
        'as' => 'admin.userCommentByAdminPost',
    ]);



    Route::post('user/profilepic/Change/{user}', [
        'uses' =>'AdminController@userProfilepicChange',
        'as' => 'admin.userProfilepicChange',
    ]);


    Route::get('user/profilepic/checked/{pic}/{term}', [
    'uses' =>'AdminController@userProfilepicCheck',
    'as' => 'admin.userProfilepicCheck'
    ]);

    Route::get('user/cv/checked/{user}', [
    'uses' =>'AdminController@userCvChecked',
    'as' => 'admin.userCvChecked'
    ]);

    Route::any('sms/send/to-user/{user}', [
    'uses' =>'AdminController@smsSendToUser',
    'as' => 'admin.smsSendToUser'
    ]);


    Route::post('new/temp/password/send/post/{user}', [
    'uses' =>'AdminController@newTempPassSendPost',
    'as' => 'admin.newTempPassSendPost'
    ]);

    Route::post('upgrade/user/for/free/post/{user}', [
    'uses' =>'AdminController@upgradeUserForFreePost',
    'as' => 'admin.upgradeUserForFreePost'
    ]);


    Route::get('/dashboard', [
    'uses' =>'AdminController@dashboard',
    'as' => 'admin.dashboard'
    ]);

    Route::get('/website/parameter', [
    'uses' =>'AdminController@websiteParameter',
    'as' => 'admin.websiteParameter'
    ]);

    Route::post('website/parameter/update', [
    'uses' =>'AdminController@websiteParameterUpdate',
    'as' => 'admin.websiteParameterUpdate'
    ]);

    Route::get('/call',[
        'uses' => 'RequestCallController@callback',
        'as' => 'admin.callback'
    ]); 
    Route::get('/contacts/{id}', [
        'uses' => 'RequestCallController@updateComplete',
        'as' => 'admin.seen'
    ]);

    Route::get('/calldelete/id/{id}',[
        'uses' => 'RequestCallController@calldelete',
        'as' => 'admin.calldelete'
    ]);


       //user //admin start

    Route::get('select/new/role', [
        'as' => 'admin.selectNewRole',
        'uses' => 'AdminController@selectNewRole'
    ]);
    Route::post('admin/add/new/post', [
    'uses' =>'AdminController@adminAddNewPost',
    'as' => 'admin.adminAddNewPost'
    ]);

    Route::post('blogadmin/add/new/post', [
    'uses' =>'AdminController@blogAdminAddNewPost',
    'as' => 'admin.blogAdminAddNewPost'
    ]);

    Route::get('admins/all/', [
    'uses' =>'AdminController@adminsAll',
    'as' => 'admin.adminsAll'
    ]);

    Route::get('blogadmins/all/', [
    'uses' =>'AdminController@blogAdminsAll',
    'as' => 'admin.blogAdminsAll'
    ]);

    Route::post('admin/delete/{role}', [
    'uses' =>'AdminController@adminDelete',
    'as' => 'admin.adminDelete'  
    ]);

    Route::post('blogadmin/delete/{role}', [
    'uses' =>'AdminController@blogAdminDelete',
    'as' => 'admin.blogAdminDelete'  
    ]);

    Route::get('/user/search/ajax', [
    'uses' =>'AdminController@userSearchAjax',
    'as' => 'admin.userSearchAjax'
    ]);


    

    Route::get('user/setting/list', [
    'uses' =>'AdminController@userSettingList',
    'as' => 'admin.userSettingList'
    ]);

    Route::post('user/setting/field/add', [
    'uses' =>'AdminController@userSettingFieldAdd',
    'as' => 'admin.userSettingFieldAdd'
    ]);

    Route::get('user/setting/field/value', [
    'uses' =>'AdminController@userSettingFieldValue',
    'as' => 'admin.userSettingFieldValue'
    ]);

    Route::post('user/setting/field/value/add/post', [
    'uses' =>'AdminController@userSettingFieldValueAddPost',
    'as' => 'admin.userSettingFieldValueAddPost'
    ]);

    Route::any('user/setting/value/edit/{value}/{i}', [
    'uses' =>'AdminController@userSettingValueEdit',
    'as' => 'admin.userSettingValueEdit'
    ]);

    Route::any('user/setting/value/delete/{value}', [
    'uses' =>'AdminController@userSettingValueDelete',
    'as' => 'admin.userSettingValueDelete'
    ]);

    Route::any('user/setting/value/update/{value}/{i}', [
    'uses' =>'AdminController@userSettingValueUpdate',
    'as' => 'admin.userSettingValueUpdate'
    ]);


    Route::get('user/details/edit/{user}', [
    'uses' =>'AdminController@userDetailsEdit',
    'as' => 'admin.userDetailsEdit'
    ]);

    Route::any('user/details/update/post/{user}', [
    'uses' =>'AdminController@userDetailsUpdatePost',
    'as' => 'admin.userDetailsUpdatePost'
    ]);

    Route::get('user/details/print/{user}', [
    'uses' =>'AdminController@userDetailsPrint',
    'as' => 'admin.userDetailsPrint'
    ]);


    //user //admin end


    //report
    Route::get('reports/all', [
    'uses' =>'AdminController@reportsAll',
    'as' => 'admin.reportsAll'
    ]);

    Route::get('report/delete/{report}', [
    'uses' =>'AdminController@reportDelete',
    'as' => 'admin.reportDelete'
    ]);

    Route::get('report/checked/{report}', [
    'uses' =>'AdminController@reportChecked',
    'as' => 'admin.reportChecked'
    ]);
    //report
    
    //front slider //slider
    Route::get('front/sliders/all', [
    'uses' =>'AdminController@frontSlidersAll',
    'as' => 'admin.frontSlidersAll'
    ]);

    Route::post('front/slider/add/new', [
    'uses' =>'AdminController@frontSliderAddNew',
    'as' => 'admin.frontSliderAddNew'
    ]);

    Route::get('front/slider/delete/{slider}', [
    'uses' =>'AdminController@frontSliderDelete',
    'as' => 'admin.frontSliderDelete'
    ]);
    //front slider //slider
    

    //all users
    Route::get('new/user', [
    'uses' =>'AdminController@newUser',
    'as' => 'admin.newUser'
    ]);

    Route::post('new/user/post', [
    'uses' =>'AdminController@newUserPost',
    'as' => 'admin.newUserPost'
    ]);




    Route::get('all/users', [
    'uses' =>'AdminController@usersAll',
    'as' => 'admin.usersAll'
    ]);

    Route::get('make/user/active/{user}', [
    'uses' =>'AdminController@makeUserActive',
    'as' => 'admin.makeUserActive'
    ]);


    Route::get('users/group/{type}', [
    'uses' =>'AdminController@usersGroup',
    'as' => 'admin.usersGroup'
    ]);


    Route::get('logs/all', [
    'uses' =>'AdminController@logsAll',
    'as' => 'admin.logsAll'
    ]);



    //all users
    

    //success profiles
    Route::get('all/success/profiles', [
    'uses' =>'AdminController@allSuccessProfiles',
    'as' => 'admin.allSuccessProfiles'
    ]);

    //success profiles

    //page
    Route::get('all/pages', [
    'uses' =>'AdminController@allPages',
    'as' => 'admin.allPages'
    ]);

    Route::get('new/page', [
    'uses' =>'AdminController@newPage',
    'as' => 'admin.newPage'
    ]);

    Route::post('new/page/post', [
    'uses' =>'AdminController@newPagePost',
    'as' => 'admin.newPagePost'
    ]);

    Route::get('edit/page/{page}', [
    'uses' =>'AdminController@editPage',
    'as' => 'admin.editPage'
    ]);

    Route::post('edit/page/post/{page}', [
    'uses' =>'AdminController@editPagePost',
    'as' => 'admin.editPagePost'
    ]);

    Route::any('delete/page/{page}', [
    'uses' =>'AdminController@deletePage',
    'as' => 'admin.deletePage'
    ]);

    //page








    //pages
    Route::get('/pages/all', [
    'uses' =>'AdminController@pagesAll',
    'as' => 'admin.pagesAll'
    ]);

    Route::post('/page/add/new/post', [
    'uses' =>'AdminController@pageAddNewPost',
    'as' => 'admin.pageAddNewPost'
    ]);

    Route::get('page/edit/{page}', [
    'uses' =>'AdminController@pageEdit',
    'as' => 'admin.pageEdit'
    ]);

    Route::post('page/edit/post/{page}', [
    'uses' =>'AdminController@pageEditPost',
    'as' => 'admin.pageEditPost'
    ]);

    Route::get('page/delete/{page}', [
    'uses' =>'AdminController@pageDelete',
    'as' => 'admin.pageDelete'
    ]);

    Route::get('page/items/{page}', [
    'uses' =>'AdminController@pageItems',
    'as' => 'admin.pageItems'
    ]);


    Route::post('page-item/add/post/{page}', [
    'uses' =>'AdminController@pageItemAddPost',
    'as' => 'admin.pageItemAddPost'
    ]);

    Route::get('page-item/delete/{item}', [
    'uses' =>'AdminController@pageItemDelete',
    'as' => 'admin.pageItemDelete'
    ]);


    Route::get('page-item/edit/{item}', [
    'uses' =>'AdminController@pageItemEdit',
    'as' => 'admin.pageItemEdit'
    ]);

    Route::post('page-item/update/post/{item}', [
    'uses' =>'AdminController@pageItemUpdate',
    'as' => 'admin.pageItemUpdate'
    ]);

    Route::get('page-item/edit-editor/{item}', [
    'uses' =>'AdminController@pageItemEditEditor',
    'as' => 'admin.pageItemEditEditor'
    ]);


    //pages

















    //success story
    Route::get('all/stories', [
    'uses' =>'AdminController@allStories',
    'as' => 'admin.allStories'
    ]);

    Route::get('new/story', [
    'uses' =>'AdminController@newStory',
    'as' => 'admin.newStory'
    ]);

    Route::post('new/story/post', [
    'uses' =>'AdminController@newStoryPost',
    'as' => 'admin.newStoryPost'
    ]);

    Route::get('edit/story/{story}', [
    'uses' =>'AdminController@editStory',
    'as' => 'admin.editStory'
    ]);

    Route::post('edit/story/post/{story}', [
    'uses' =>'AdminController@editStoryPost',
    'as' => 'admin.editStoryPost'
    ]);

    Route::any('delete/story/{story}', [
    'uses' =>'AdminController@deleteStory',
    'as' => 'admin.deleteStory'
    ]);

    //success story
    
    //package
    Route::get('all/membership/packages', [
    'uses' =>'AdminController@allMembershipPackages',
    'as' => 'admin.allMembershipPackages'
    ]);

    Route::get('membership/package/add/new', [
    'uses' =>'AdminController@membershipPackageAddNew',
    'as' => 'admin.membershipPackageAddNew'
    ]);

    Route::post('membership/package/add/new/post', [
    'uses' =>'AdminController@membershipPackageAddNewPost',
    'as' => 'admin.membershipPackageAddNewPost'
    ]);

    Route::get('membership/package/edit/{package}', [
    'uses' =>'AdminController@membershipPackageEdit',
    'as' => 'admin.membershipPackageEdit'
    ]);

    Route::post('membership/package/update/{package}', [
    'uses' =>'AdminController@membershipPackageUpdate',
    'as' => 'admin.membershipPackageUpdate'
    ]);

    // Route::any('membership/package/delete/{package}', [
    // 'uses' =>'AdminController@membershipPackageDelete',
    // 'as' => 'admin.membershipPackageDelete'
    // ]);

    //package
    
    //payment
     Route::get('all/pending/payments', [
        'uses' =>'AdminController@allPendingPayments',
        'as' => 'admin.allPendingPayments'
    ]);

     Route::get('all/paid/payments', [
        'uses' =>'AdminController@allPaidPayments',
        'as' => 'admin.allPaidPayments'
    ]);

    Route::get('all/free/payments', [
        'uses' =>'AdminController@allFreePayments',
        'as' => 'admin.allFreePayments'
    ]);

     Route::get('payment/add/new', [
        'uses' =>'AdminController@paymentAddNew',
        'as' => 'admin.paymentAddNew'
    ]);

    Route::post('payment/add/new/post', [
        'uses' =>'AdminController@paymentAddNewPost',
        'as' => 'admin.paymentAddNewPost'
    ]);

     Route::post('pending/payment/update/post/{payment}', [
        'uses' =>'AdminController@pendingPaymentUpdatePost',
        'as' => 'admin.pendingPaymentUpdatePost'
    ]);

    Route::get('payment/delete/{payment}', [
        'uses' =>'AdminController@paymentDelete',
        'as' => 'admin.paymentDelete'
    ]);

    Route::get('payment/history/for/user/{user}', [
        'uses' =>'AdminController@paymentHistoryForUser',
        'as' => 'admin.paymentHistoryForUser'
    ]);
    //payment


    Route::post('upload/new/public/photos/{user}/{type}', [
        //private, public
        'uses' =>'AdminController@uploadNewPublicPhotos',
        'as' => 'admin.uploadNewPublicPhotos',
    ]);

    Route::get('user/photo/delete/{photo}', [
        //private, public
        'uses' =>'AdminController@userPhotoDelete',
        'as' => 'admin.userPhotoDelete',
    ]);

    Route::get('user/pp/delete/{picture}', [
        //private, public
        'uses' =>'AdminController@userPPDelete',
        'as' => 'admin.userPPDelete',
    ]);


    Route::post('upload/new/cv/{user}', [
        //private, public
        'uses' =>'AdminController@uploadNewCv',
        'as' => 'admin.uploadNewCv',
    ]);




    //proposal

    Route::get('proposals/group/{type}', [
        //private, public
        'uses' =>'AdminController@proposalsGroup',
        'as' => 'admin.proposalsGroup',
    ]);

    Route::get('proposal/checked/by/admin/{proposal}', [
    'uses' =>'AdminController@proposalCheckedByAdmin',
    'as' => 'admin.proposalCheckedByAdmin'
    ]);

    Route::get('proposals/of/user/{user}', [
    'uses' =>'AdminController@proposalsOfUser',
    'as' => 'admin.proposalsOfUser'
    ]);

    //proposal



     //sms

    Route::get('quick/sms/balance/check', [
    'uses' =>'AdminController@quickSmsBalanceCheck',
    'as' => 'admin.quickSmsBalanceCheck'
    ]);

    // Route::get('quick/sms/draft', [
    // 'uses' =>'CustomerController2@quickSmsDraft',
    // 'as' => 'customer.quickSmsDraft'
    // ]);

    Route::get('quick/sms/draft', [
    'uses' =>'AdminController@quickSmsDraft',
    'as' => 'admin.quickSmsDraft'
    ]);

    // Route::get('quick/sms/draft/send/{bulk}', [
    // 'uses' =>'CustomerController2@quickSmsDraftSend',
    // 'as' => 'customer.quickSmsDraftSend'
    // ]);

    Route::get('quick/sms/draft/send/{bulk}', [
    'uses' =>'AdminController@quickSmsDraftSend',
    'as' => 'admin.quickSmsDraftSend'
    ]);

    // Route::post('quick/sms/draft/send/post/{bulk}', [
    // 'uses' =>'CustomerController2@quickSmsDraftSendPost',
    // 'as' => 'customer.quickSmsDraftSendPost'
    // ]);

    Route::post('quick/sms/draft/send/post/{bulk}', [
    'uses' =>'AdminController@quickSmsDraftSendPost',
    'as' => 'admin.quickSmsDraftSendPost'
    ]);

    // Route::post('quick/sms/draft/save', [
    // 'uses' =>'CustomerController2@quickSmsDraftSave',
    // 'as' => 'customer.quickSmsDraftSave'
    // ]);

    Route::post('quick/sms/draft/save', [
    'uses' =>'AdminController@quickSmsDraftSave',
    'as' => 'admin.quickSmsDraftSave'
    ]);

    // Route::get('send/sms-to-business', [
    // 'uses' =>'CustomerController2@sendSmsToBusiness',
    // 'as' => 'customer.sendSmsToBusiness'
    // ]);

    Route::get('send/sms-to-business', [
    'uses' =>'AdminController@sendSmsToBusiness',
    'as' => 'admin.sendSmsToBusiness'
    ]);

    // Route::post('send/sms-to-business/post', [
    // 'uses' =>'CustomerController2@sendSmsToBusinessPost',
    // 'as' => 'customer.sendSmsToBusinessPost'
    // ]);

    Route::post('send/sms-to-business/post', [
    'uses' =>'AdminController@sendSmsToBusinessPost',
    'as' => 'admin.sendSmsToBusinessPost'
    ]);

    // Route::get('quick/sms', [
    // 'uses' =>'CustomerController2@quickSms',
    // 'as' => 'customer.quickSms'
    // ]);

    Route::get('quick/sms', [
    'uses' =>'AdminController@quickSms',
    'as' => 'admin.quickSms'
    ]);

    // Route::post('quick/sms/send', [
    // 'uses' =>'CustomerController2@quickSmsSend',
    // 'as' => 'customer.quickSmsSend'
    // ]);

    Route::post('quick/sms/send', [
    'uses' =>'AdminController@quickSmsSend',
    'as' => 'admin.quickSmsSend'
    ]);

    // Route::get('sent/sms/bulk', [
    // 'uses' =>'CustomerController2@sentSmsBulk',
    // 'as' => 'customer.sentSmsBulk'
    // ]);

    Route::get('sent/sms/bulk', [
    'uses' =>'AdminController@sentSmsBulk',
    'as' => 'admin.sentSmsBulk'
    ]);

    // Route::get('business/sms/bulk/items/{bulk}', [
    // 'uses' =>'CustomerController2@businessSmsBulkItems',
    // 'as' => 'customer.businessSmsBulkItems'
    // ]);

    Route::get('business/sms/bulk/items/{bulk}', [
    'uses' =>'AdminController@businessSmsBulkItems',
    'as' => 'admin.businessSmsBulkItems'
    ]);

    // Route::get('quick/sms/bulk/items/{bulk}', [
    // 'uses' =>'CustomerController2@quickSmsBulkItems',
    // 'as' => 'customer.quickSmsBulkItems'
    // ]);

    Route::get('quick/sms/bulk/items/{bulk}', [
    'uses' =>'AdminController@quickSmsBulkItems',
    'as' => 'admin.quickSmsBulkItems'
    ]);

    // Route::get('uploaded/contact/drafts', [
    // 'uses' =>'CustomerController2@uploadedContactDraft',
    // 'as' => 'customer.uploadedContactDraft'
    // ]);

    Route::get('uploaded/contact/drafts', [
    'uses' =>'AdminController@uploadedContactDraft',
    'as' => 'admin.uploadedContactDraft'
    ]);


    // Route::post('upload/excel/contact/file/post', [
    // 'uses' =>'CustomerController3@uploadExcelContactFilePost',
    // 'as' => 'customer.uploadExcelContactFilePost'
    // ]);

    Route::post('upload/excel/contact/file/post', [
    'uses' =>'AdminController@uploadExcelContactFilePost',
    'as' => 'admin.uploadExcelContactFilePost'
    ]);

    // Route::get('sms/send/to-uploaded/contacts/{bulk}', [
    // 'uses' =>'CustomerController4@smsSendToUploadedContacts',
    // 'as' => 'customer.smsSendToUploadedContacts'
    // ]);

    Route::get('sms/send/to-uploaded/contacts/{bulk}', [
    'uses' =>'AdminController@smsSendToUploadedContacts',
    'as' => 'admin.smsSendToUploadedContacts'
    ]);

    // Route::get('all/uploaded/contacts/{bulk}', [
    // 'uses' =>'CustomerController4@allUploadedContacts',
    // 'as' => 'customer.allUploadedContacts'
    // ]);

    Route::get('all/uploaded/contacts/{bulk}', [
    'uses' =>'AdminController@allUploadedContacts',
    'as' => 'admin.allUploadedContacts'
    ]);

    // Route::get('uploaded/contact/delete/{contact}', [
    // 'uses' =>'CustomerController4@uploadedContactDelete',
    // 'as' => 'customer.uploadedContactDelete'
    // ]);

    Route::get('uploaded/contact/delete/{contact}', [
    'uses' =>'AdminController@uploadedContactDelete',
    'as' => 'admin.uploadedContactDelete'
    ]);

    // Route::get('uploaded/contact/file/delete/{bulk}', [
    // 'uses' =>'CustomerController4@uploadedContactFileDelete',
    // 'as' => 'customer.uploadedContactFileDelete'
    // ]);

    Route::get('uploaded/contact/file/delete/{bulk}', [
    'uses' =>'AdminController@uploadedContactFileDelete',
    'as' => 'admin.uploadedContactFileDelete'
    ]);

    // Route::get('uploaded/sms/bulk/items/{bulk}', [
    // 'uses' =>'CustomerController4@uploadedSmsBulkItems',
    // 'as' => 'customer.uploadedSmsBulkItems'
    // ]);

    Route::get('uploaded/sms/bulk/items/{bulk}', [
    'uses' =>'AdminController@uploadedSmsBulkItems',
    'as' => 'admin.uploadedSmsBulkItems'
    ]);

    // Route::post('uploaded/contact/draft/send/post/{bulk}', [
    // 'uses' =>'CustomerController4@uploadedContactDraftSendPost',
    // 'as' => 'customer.uploadedContactDraftSendPost'
    // ]);

    Route::post('uploaded/contact/draft/send/post/{bulk}', [
    'uses' =>'AdminController@uploadedContactDraftSendPost',
    'as' => 'admin.uploadedContactDraftSendPost'
    ]);

    // Route::get('quick/sms/draft/delete/{bulk}', [
    // 'uses' =>'CustomerController4@quickSmsDraftDelete',
    // 'as' => 'customer.quickSmsDraftDelete'
    // ]);

    Route::get('quick/sms/draft/delete/{bulk}', [
    'uses' =>'AdminController@quickSmsDraftDelete',
    'as' => 'admin.quickSmsDraftDelete'
    ]);

    // Route::get('business/sms/bulk/delete/{bulk}', [
    // 'uses' =>'CustomerController4@businessSmsBulkDelete',
    // 'as' => 'customer.businessSmsBulkDelete'
    // ]);

    Route::get('business/sms/bulk/delete/{bulk}', [
    'uses' =>'AdminController@businessSmsBulkDelete',
    'as' => 'admin.businessSmsBulkDelete'
    ]);

    // Route::get('quick/sms/bulk/items/resend/{bulk}', [
    // 'uses' =>'CustomerController4@quickSmsBulkItemsResend',
    // 'as' => 'customer.quickSmsBulkItemsResend'
    // ]);

    Route::get('quick/sms/bulk/items/resend/{bulk}', [
    'uses' =>'AdminController@quickSmsBulkItemsResend',
    'as' => 'admin.quickSmsBulkItemsResend'
    ]);

    // Route::get('uploaded/contact/file/resend/{bulk}', [
    // 'uses' =>'CustomerController4@uploadedContactFileResend',
    // 'as' => 'customer.uploadedContactFileResend'
    // ]);

    Route::get('uploaded/contact/file/resend/{bulk}', [
    'uses' =>'AdminController@uploadedContactFileResend',
    'as' => 'admin.uploadedContactFileResend'
    ]);

    //sms



    //mobile & email number for 3rd party sale
    Route::get('mobile/numbers/all', [
    'uses' =>'AdminController@mobileNumbersAll',
    'as' => 'admin.mobileNumbersAll'
    ]);

    Route::get('email/numbers/all', [
    'uses' =>'AdminController@emailNumbersAll',
    'as' => 'admin.emailNumbersAll'
    ]);
    //mobile & email number for 3rd party sale


    //income report
    Route::get('income/report/summary', [
    'uses' =>'AdminController@incomeReportSummary',
    'as' => 'admin.incomeReportSummary'
    ]);

    Route::get('income/report/payment', [
    'uses' =>'AdminController@incomeReportPayment',
    'as' => 'admin.incomeReportPayment'
    ]);

    Route::get('income/report/payment/search/{date}', [
    'uses' =>'AdminController@incomeReportPaymentSearch',
    'as' => 'admin.incomeReportPaymentSearch'
    ]);

    Route::get('income/report/payment/search/by/date/interval', [
    'uses' =>'AdminController@incomeReportPaymentSearchByDateInterval',
    'as' => 'admin.incomeReportPaymentSearchByDateInterval'
    ]);

    Route::get('income/report/user', [
    'uses' =>'AdminController@incomeReportUser',
    'as' => 'admin.incomeReportUser'
    ]);

    Route::get('income/report/user/search/{date}', [
    'uses' =>'AdminController@incomeReportUserSearch',
    'as' => 'admin.incomeReportUserSearch'
    ]);

    Route::get('income/report/user/search/by/date/interval', [
    'uses' =>'AdminController@incomeReportUserSearchByDateInterval',
    'as' => 'admin.incomeReportUserSearchByDateInterval'
    ]);


    //income report


    //email for offline online
    Route::get('send/cv/from/user/{user}', [
    'uses' =>'AdminController@sendCvFromUser',
    'as' => 'admin.sendCvFromUser'
    ]);

    Route::post('select/mails/user/{user}', [
    'uses' =>'AdminController@selectMailsUser',
    'as' => 'admin.selectMailsUser'
    ]);

    Route::post('send/cv-from-user-post/user/{user}', [
    'uses' =>'AdminController@sendCvFromUserPost',
    'as' => 'admin.sendCvFromUserPost'
    ]);

    

    Route::get('send/cv/to/user/{user}', [
    'uses' =>'AdminController@sendCvToUser',
    'as' => 'admin.sendCvToUser'
    ]);


    Route::get('send/cv/to/given/email', [
    'uses' =>'AdminController@sendCvToGivenEmail',
    'as' => 'admin.sendCvToGivenEmail'
    ]);

    Route::get('send/profile/to/given/email', [
    'uses' =>'AdminController@sendProfileToGivenEmail',
    'as' => 'admin.sendProfileToGivenEmail'
    ]);

    Route::post('select/cv/users', [
    'uses' =>'AdminController@selectCvUsers',
    'as' => 'admin.selectCvUsers'
    ]);

    Route::post('select/cv/users/for/user/{user}', [
    'uses' =>'AdminController@selectCvUsersForUser',
    'as' => 'admin.selectCvUsersForUser'
    ]);

    Route::post('select/profile/users', [
    'uses' =>'AdminController@selectProfileUsers',
    'as' => 'admin.selectProfileUsers'
    ]);

    Route::any('send/cv/to/given/email/post', [
    'uses' =>'AdminController@sendCvToGivenEmailPost',
    'as' => 'admin.sendCvToGivenEmailPost'
    ]);

    Route::any('send/profile/to/given/email/post', [
    'uses' =>'AdminController@sendProfileToGivenEmailPost',
    'as' => 'admin.sendProfileToGivenEmailPost'
    ]);











    //bdropjuicery url
    Route::get('report/area', [
    'uses' =>'AdminController@reportArea',
    'as' => 'admin.reportArea'
    ]);

    Route::get('sales/by/time', [
    'uses'=> 'AdminController@salesByTime',
    'as'=> 'admin.salesByTime'
    ]);

    Route::get('sales/by/product', [
    'uses'=> 'AdminController@salesByProduct',
    'as'=> 'admin.salesByProduct'
    ]);

    Route::get('sales/account', [
    'uses'=> 'AdminController@salesAccount',
    'as'=> 'admin.salesAccount'
    ]);

    Route::get('sales/account/get/by/date/{date}', [
    'uses'=> 'AdminController@salesAccountGetByDate',
    'as'=> 'admin.salesAccountGetByDate'
    ]);

    Route::get('sales/account/get/by/time/interval', [
    'uses'=> 'AdminController@salesAccountGetByDateInterval',
    'as'=> 'admin.salesAccountGetByDateInterval'
    ]);

    Route::get('product/stock/report', [
    'uses'=> 'AdminController@productStockReport',
    'as'=> 'admin.productStockReport'
    ]);

    Route::get('product/stock/report/search/{type}', [
    'uses'=> 'AdminController@productStockReportSearch',
    'as'=> 'admin.productStockReportSearch'
    ]);

    Route::get('product/stock/report/search/by/cat', [
    'uses'=> 'AdminController@productStockReportSearchByCat',
    'as'=> 'admin.productStockReportSearchByCat'
    ]);

    Route::get('product/stock/report/search/by/subcat', [
    'uses'=> 'AdminController@productStockReportSearchBySubcat',
    'as'=> 'admin.productStockReportSearchBySubcat'
    ]);

    //bdropjuicery url

    Route::get('update/users/featureimage', [
    'uses' =>'AdminController@updateUsersFeatureImage',
    'as' => 'admin.updateUsersFeatureImage'
    ]);



    //about-post
    Route::get('about-post/add/new', [
    'uses' =>'AdminController@aboutPostAddNew',
    'as' => 'admin.aboutPostAddNew'
    ]);

    Route::get('about-post/all', [
    'uses' =>'AdminController@aboutPostAll',
    'as' => 'admin.aboutPostAll'
    ]);

    Route::post('about-post/new/post', [
    'uses' =>'AdminController@aboutPostNewPost',
    'as' => 'admin.aboutPostNewPost'
    ]);

    Route::get('about-post/delete/{post}', [
    'uses' =>'AdminController@aboutPostDelete',
    'as' => 'admin.aboutPostDelete'
    ]);

    Route::get('about-post/edit/{post}', [
    'uses' =>'AdminController@aboutPostEdit',
    'as' => 'admin.aboutPostEdit'
    ]);

    Route::post('about-post/edit/post/{post}', [
    'uses' =>'AdminController@aboutPostEditPost',
    'as' => 'admin.aboutPostEditPost'
    ]);


    //about-post


    //service-post
    Route::get('service-post/add/new', [
    'uses' =>'AdminController@servicePostAddNew',
    'as' => 'admin.servicePostAddNew'
    ]);

    Route::get('service-post/all', [
    'uses' =>'AdminController@servicePostAll',
    'as' => 'admin.servicePostAll'
    ]);

    Route::post('service-post/new/post', [
    'uses' =>'AdminController@servicePostNewPost',
    'as' => 'admin.servicePostNewPost'
    ]);

    Route::get('service-post/delete/{post}', [
    'uses' =>'AdminController@servicePostDelete',
    'as' => 'admin.servicePostDelete'
    ]);

    Route::get('service-post/edit/{post}', [
    'uses' =>'AdminController@servicePostEdit',
    'as' => 'admin.servicePostEdit'
    ]);

    Route::post('service-post/edit/post/{post}', [
    'uses' =>'AdminController@servicePostEditPost',
    'as' => 'admin.servicePostEditPost'
    ]);
    //service-post

    //author-post
    Route::get('author-post/add/new', [
    'uses' =>'AdminController@authorPostAddNew',
    'as' => 'admin.authorPostAddNew'
    ]);

    Route::get('author-post/all', [
    'uses' =>'AdminController@authorPostAll',
    'as' => 'admin.authorPostAll'
    ]);

    Route::post('author-post/new/post', [
    'uses' =>'AdminController@authorPostNewPost',
    'as' => 'admin.authorPostNewPost'
    ]);

    Route::get('author-post/delete/{post}', [
    'uses' =>'AdminController@authorPostDelete',
    'as' => 'admin.authorPostDelete'
    ]);

    Route::get('author-post/edit/{post}', [
    'uses' =>'AdminController@authorPostEdit',
    'as' => 'admin.authorPostEdit'
    ]);

    Route::post('author-post/edit/post/{post}', [
    'uses' =>'AdminController@authorPostEditPost',
    'as' => 'admin.authorPostEditPost'
    ]);


    //author-post




    
    Route::get('send/email/sms/to/users', [
    'uses' =>'AdminController@sendEmailSmsToUsers',
    'as' => 'admin.sendEmailSmsToUsers'
    ]);

    Route::post('send/email/sms/to/users/post', [
    'uses' =>'AdminController@sendEmailSmsToUsersPost',
    'as' => 'admin.sendEmailSmsToUsersPost'
    ]);


    //logs
    Route::get('user/logs/user/{user}', [
    'uses' =>'AdminController@userLogs',
    'as' => 'admin.userLogs'
    ]);



    Route::post('user/logs/post/user/{user}', [
    'uses' =>'AdminController@userLogsPost',
    'as' => 'admin.userLogsPost'
    ]);

    Route::get('user/log/complete/log/{log}', [
    'uses' =>'AdminController@userLogComplete',
    'as' => 'admin.userLogComplete'
    ]);


    Route::get('user/sms/user/{user}', [
    'uses' =>'AdminController@userSms',
    'as' => 'admin.userSms'
    ]);

    // Route::post('user/sms/send/user/{user}', [
    // 'uses' =>'AdminController@smsSendToUser',
    // 'as' => 'admin.smsSendToUser'
    // ]);

});

#admin end //admin


#blog admin start //blog admin
Route::group(['middleware' => ['role:blogAdmin','auth'] ,'prefix' => 'blogadmin'], function () {

Route::get('/dashboard', [
'uses' =>'BlogAdminController@dashboard',
'as' => 'blogAdmin.dashboard'
]);

//posts
    Route::get('/posts/all', [
    'uses' =>'BlogAdminController@postsAll',
    'as' => 'admin.postsAll'
    ]);

    Route::get('/post/add/new', [
    'uses' =>'BlogAdminController@postAddNew',
    'as' => 'admin.postAddNew'
    ]);

    Route::post('/post/add/new/post', [
    'uses' =>'BlogAdminController@postAddNewPost',
    'as' => 'admin.postAddNewPost'
    ]);

    Route::get('/post/edit/{post}', [
    'uses' =>'BlogAdminController@postEdit',
    'as' => 'admin.postEdit'
    ]);

    Route::post('/post/update/{post}', [
    'uses' =>'BlogAdminController@postUpdate',
    'as' => 'admin.postUpdate'
    ]);


    Route::get('/feature/image/delete/{post}', [
    'uses' =>'BlogAdminController@featureImageDelete',
    'as' => 'admin.featureImageDelete'
    ]);

    Route::get('post/delete/{post}', [
    'uses' =>'BlogAdminController@postDelete',
    'as' => 'admin.postDelete'
    ]);

    
    //posts

    //media start

    //media
    Route::get('media/all', [
    'uses' =>'BlogAdminController@mediaAll',
    'as' => 'admin.mediaAll'
    ]);

    Route::post('media/upload/post', [
    'uses' =>'BlogAdminController@mediaUploadPost',
    'as' => 'admin.mediaUploadPost'
    ]);

    Route::get('media/delete/{media}', [
    'uses' =>'BlogAdminController@mediaDelete',
    'as' => 'admin.mediaDelete'
    ]);

    //media
    //media end


    //category
    Route::get('categories/all', [
    'uses' =>'BlogAdminController@categoriesAll',
    'as' => 'admin.categoriesAll'
    ]);

    Route::get('category/add/new', [
    'uses' =>'BlogAdminController@categoryAddNew',
    'as' => 'admin.categoryAddNew'
    ]);

    Route::post('category/add/new/post', [
    'uses' =>'BlogAdminController@categoryAddNewPost',
    'as' => 'admin.categoryAddNewPost'
    ]);

    Route::any('category/edit/{cat}', [
    'uses' =>'BlogAdminController@categoryEdit',
    'as' => 'admin.categoryEdit'
    ]);

    Route::any('category/update/{cat}', [
    'uses' =>'BlogAdminController@categoryUpdate',
    'as' => 'admin.categoryUpdate'
    ]);

    Route::any('category/delete/{cat}', [
    'uses' =>'BlogAdminController@categoryDelete',
    'as' => 'admin.categoryDelete'
    ]);   

    //category

    Route::get('/blog/parameter', [
    'uses' =>'BlogAdminController@blogParameter',
    'as' => 'admin.blogParameter'
    ]);

    Route::any('/blog/parameter/update', [
    'uses' =>'BlogAdminController@blogParameterUpdate',
    'as' => 'admin.blogParameterUpdate'
    ]);


    //ad space
    Route::get('new/ad', [
    'uses' =>'BlogAdminController@newAd',
    'as' => 'admin.newAd'
    ]);

    Route::post('new/ad/post', [
    'uses' =>'BlogAdminController@newAdPost',
    'as' => 'admin.newAdPost'
    ]);

    Route::get('all/ads', [
    'uses' =>'BlogAdminController@allAds',
    'as' => 'admin.allAds'
    ]);

    Route::get('edit/ad/{ad}', [
    'uses' =>'BlogAdminController@editAd',
    'as' => 'admin.editAd'
    ]);

    Route::post('update/ad/{ad}', [
    'uses' =>'BlogAdminController@updateAd',
    'as' => 'admin.updateAd'
    ]);


    //ad space



    //division //district //thana
    Route::get('divisions/all', [
    'uses' =>'BlogAdminController@divisionsAll',
    'as' => 'admin.divisionsAll'
    ]);

    Route::get('division/add/new', [
    'uses' =>'BlogAdminController@divisionAddNew',
    'as' => 'admin.divisionAddNew'
    ]);

    Route::post('division/add/new/post', [
    'uses' =>'BlogAdminController@divisionAddNewPost',
    'as' => 'admin.divisionAddNewPost'
    ]);

    Route::any('division/edit/{div}', [
    'uses' =>'BlogAdminController@divisionEdit',
    'as' => 'admin.divisionEdit'
    ]);

    Route::any('division/update/{div}', [
    'uses' =>'BlogAdminController@divisionUpdate',
    'as' => 'admin.divisionUpdate'
    ]);

    Route::any('division/delete/{div}', [
    'uses' =>'BlogAdminController@divisionDelete',
    'as' => 'admin.divisionDelete'
    ]);  

    #district
    Route::get('districts/all', [
    'uses' =>'BlogAdminController@districtsAll',
    'as' => 'admin.districtsAll'
    ]);

    Route::post('district/add/new/post', [
    'uses' =>'BlogAdminController@districtAddNewPost',
    'as' => 'admin.districtAddNewPost'
    ]);

    Route::any('district/delete/{district}', [
    'uses' =>'BlogAdminController@districtDelete',
    'as' => 'admin.districtDelete'
    ]); 

    Route::any('district/edit/{district}', [
    'uses' =>'BlogAdminController@districtEdit',
    'as' => 'admin.districtEdit'
    ]);

    Route::any('district/update/{district}', [
    'uses' =>'BlogAdminController@districtUpdate',
    'as' => 'admin.districtUpdate'
    ]);

    #thana
    Route::get('thana/all', [
    'uses' =>'BlogAdminController@thanaAll',
    'as' => 'admin.thanaAll'
    ]);

    Route::post('thana/add/new/post', [
    'uses' =>'BlogAdminController@thanaAddNewPost',
    'as' => 'admin.thanaAddNewPost'
    ]);

    Route::any('thana/delete/{thana}', [
    'uses' =>'BlogAdminController@thanaDelete',
    'as' => 'admin.thanaDelete'
    ]); 

    Route::any('thana/edit/{thana}', [
    'uses' =>'BlogAdminController@thanaEdit',
    'as' => 'admin.thanaEdit'
    ]);

    Route::any('thana/update/{thana}', [
    'uses' =>'BlogAdminController@thanaUpdate',
    'as' => 'admin.thanaUpdate'
    ]);


    //division //district //thana    

});

#blog admin end //blog admin


#blog start #blog welcome start
Route::group(['prefix' => 'blog'], function () {

    Route::get('/index', [
    'uses' =>'WelcomeController@blog',
    'as' => 'welcome.blog'
    ]);

    Route::get('details/check/{post}/{excerpt?}', [
    'uses' =>'WelcomeController@postDetailsCheck',
    'as' => 'welcome.postDetailsCheck'
    ]);

    Route::get('post/details/{post}/{excerpt?}', [
    'uses' =>'WelcomeController@postDetails',
    'as' => 'welcome.postDetails'
    ]);



    Route::get('{title?}/{post}', [
    'uses' =>'WelcomeController@postDetailsWithTitle',
    'as' => 'welcome.postDetailsWithTitle'
    ]);

    Route::get('/category/{cat}/{title?}', [
    'uses' =>'WelcomeController@postCategory',
    'as' => 'welcome.postCategory'
    ]);

    Route::get('/division/{div}/{title?}', [
    'uses' =>'WelcomeController@postDivision',
    'as' => 'welcome.postDivision'
    ]);

    Route::get('/division-search/', [
    'uses' =>'WelcomeController@postDivision',
    'as' => 'welcome.postDivisionSearch'
    ]);

    Route::get('/div-selected/', [
    'uses' =>'WelcomeController@divSelected',
    'as' => 'welcome.divSelected'
    ]);

    Route::get('/dist-selected/', [
        'uses' =>'WelcomeController@distSelected',
        'as' => 'welcome.distSelected'
    ]);

    Route::get('/top-search/', [
    'uses' =>'WelcomeController@topSearch',
    'as' => 'welcome.topSearch'
]);

});
#blog end #blog welcome end


