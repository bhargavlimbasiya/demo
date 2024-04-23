<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;

use Laravel\Fortify\Fortify;
use Laravel\Jetstream\Jetstream;

use App\Actions\Jetstream\DeleteUser;

use App\Models\User;
use Carbon\Carbon;
use Laravel\Fortify\Http\Responses\SimpleViewResponse;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configurePermissions();

        Fortify::authenticateUsing(function (Request $request) {

            $user = User::where('email', $request->email)
                        ->orWhere('phone_number', $request->email)
                        ->first();

            $currentDate = Carbon::now();
            $joiningDate =  $currentDate->toDateTimeString();

            if (($user && $user->status == 1 ) && Hash::check($request->password, $user->password)) {
                if($user->joining_date == ''){
                    $input = array('joining_date'=>$joiningDate);
                    $user->update($input);
                }
                session()->flash('success', trans(
                    'messages.custom.login_messages'));

                return $user;
            }
        });



        Jetstream::deleteUsersUsing(DeleteUser::class);
    }

    /**
     * Specify which view should be used as the request password reset link view.
     *
     * @param  callable|string  $view
     * @return void
     */
    public static function requestPasswordResetLinkView($view)
    {
        app()->singleton(RequestPasswordResetLinkViewResponse::class, function () use ($view) {

            return new SimpleViewResponse($view);
        });
    }

    /**
     * Configure the permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }
}
