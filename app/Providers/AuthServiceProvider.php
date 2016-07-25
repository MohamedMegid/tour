<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\PermissionRelation;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $gate->define('HavePermission', function ($user, $permission_id) {
            $user_id = $user->id;
            $permission_relation = PermissionRelation::where('permission_id', '=', $permission_id)
                            ->where('user_id', '=', $user_id)->first();
            if($permission_relation){
                return true;
            }else{
                return false;
            }
            
        });
    }
}
