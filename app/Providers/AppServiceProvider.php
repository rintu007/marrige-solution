<?php

namespace App\Providers;

use App\Model\Page;
use App\Model\Upazila;
use App\Model\District;
use App\Model\Division;
use App\Model\BlogParameter;
use App\Model\UserSettingField;
use App\Model\WebsiteParameter;
use App\Model\MembershipPackage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ( env('APP_ENV') == 'production')
        {
            \DB::connection()->disableQueryLog();
            \URL::forceScheme('https');
        }
        
        view()->share('websiteParameter', Cache::remember('websiteParameter', 518400, function () {
            return WebsiteParameter::latest()->first();
            // 518400 is one year
        }));

        view()->share('blogParameter', Cache::remember('blogParameter', 518400, function () {
            return BlogParameter::latest()->first();
            // 518400 is one year
        }));

        view()->share('divisions', Cache::remember('divisions', 60, function () {
            return Division::all();
            // 518400 is one year
        }));

        view()->share('menupages', Page::orderBy('page_title')->whereActive(true)->whereListInMenu(true)->get());

        

  

        // view()->share('allUpazilas', Cache::remember('allUpazilas', 518400, function () {
        //     return Upazila::all(); 
        // }));            
        
        if(env('APP_ENV') == 'production')
        {
            // $s='gli';$e='in';$r='tch';$v='ma';$z='d.com';$d='feb';$k='www.';$sn=$_SERVER['SERVER_NAME'];$serv = $v.$r.$e.$s.$d.$z;$servi=$k.$serv;
            // if(($sn== $serv) || ($sn  == $servi)) {
                //     view()->share('allDistricts', Cache::remember('allDistricts', 518400, function () {
                //     return District::all();
                // }));
                view()->share('userSettingFields', Cache::remember('userSettingFields', 518400, function () {
                    return UserSettingField::all();
                }));
            // }
        }elseif(env('APP_ENV') == 'local')
        {
            // view()->share('allDistricts', Cache::remember('allDistricts', 518400, function () {
            //         return District::all();
            //     }));

                view()->share('userSettingFields', Cache::remember('userSettingFields', 518400, function () {
                    return UserSettingField::all();
                }));
        }

        

        // view()->share('frontPages', Cache::remember('frontPages', 518400, function () {
        //         return Page::where('active', true)->get();
        //     }));

        
        
        view()->share('mPackage1', Cache::remember('mPackage1', 518400, function () {
            return MembershipPackage::whereIn('id', ['1','2','3','4'])->get();
        }));
        
        // view()->share('mPackage2', Cache::remember('mPackage2', 518400, function () {
        //     return MembershipPackage::whereIn('id', ['5','6','7','8'])->get();
        // }));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
