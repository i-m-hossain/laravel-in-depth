<?php
use App\Events\ChatMessageEvent;
use App\Mail\WelcomeMail;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Laravel\Fortify\RoutePath;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
// signed route
Route::get('/shared/posts/{post}', function(Request $request, Post $post){
    return "Specially made just for you <3 ;) Post id :".$post->id;
})->name('shared.post')->middleware('signed');
if (App::environment('local')) {
    /**
     * I18N
     */
    //setting current locale
    // App::setLocale('en');
    //getting current locale
    // $currentLocale = App::getLocale();

    // $trans = Lang::get('auth.failed');
    // $trans = __('auth.password');
    // $trans = __('auth.throttle', ['seconds' => 5]);
    // $trans= trans_choice('auth.pants', 10, ["shorts"=>2]);
    // dd($trans);

    /**
     * Email sending
     * 
     * */
    Route::get('/playground', function () {
        /**
         * Email sending
         */
        $user = User::factory()->make();
        Mail::to($user)
            ->send(new WelcomeMail($user));
        return null;
    });

    /**
     * web socket route
     */
    Route::post('/chat-message', function(Request $request){
        event(new ChatMessageEvent($request->message));
        return null;
    });
    Route::get('/ws', function(){
        return view("websocket");
    });
    /** 
     * Temporary route link generation
     * */
    Route::get('/shared/videos/{video}', function (Request $request, string $video) {
        
        return "download the video with id " . $video;
    })->name('share-video')->middleware('signed');
    Route::get('/dummy', function () {
        $url = URL::temporarySignedRoute('share-video', now()->addSeconds(30), [
            "video" => 23
        ]);
        return $url;
    });
}
;
Route::get(RoutePath::for('password.reset', '/reset-password/{token}'), function ($token) {
    return view('auth.password-reset', [
        'token' => $token
    ]);
})
    ->middleware(['guest:' . config('fortify.guard')])
    ->name('password.reset');