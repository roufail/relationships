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

Route::get('/', function () {
    return view('welcome');
});

// one to one relationship
Route::get('/user/{id}',function($id){
    $user = \App\User::findOrFail($id);
    if($user->profile) {
        dd($user->profile);
    }

    $user->profile()->updateOrCreate(['user_id' => $user->id],['mobile' => '0123456']);

});

Route::get('/profile/{id}',function($id){
    $profile = \App\Profile::findOrFail($id);
    dd($profile->user);
});


Route::get('/users',function(){
    $users = \App\User::with('profile')->get();
    Debugbar::info($users);
    foreach ($users as $user) {
        Debugbar::info($user->profile);
    }
    return view('welcome');
});

Route::get('/user/{id}/posts',function($id){
    $user = \App\User::findOrFail($id);
    foreach ($user->posts as $post) {
        Debugbar::info($post->title);
    }
    return view('welcome');
});


Route::get('post/{id}/user',function($id){
    $post = \App\Post::findOrFail($id);
    Debugbar::info($post->user->name);
    return view('welcome');
});

Route::get('posts',function(){
    $posts = \App\Post::with('categories')->get();
    foreach ($posts as $post) {
        Debugbar::info($post->categories);
    }
    return view('welcome');
});


Route::get('categories',function(){
    $categories = \App\Category::with('posts')->get();
    foreach ($categories as $category) {
        $category->posts()->sync([1,2,3]);
        Debugbar::info($category->posts);
    }
    return view('welcome');
});


Route::get('postphotos/{id}',function($id){
    $post = \App\Post::findOrFail($id);
    Debugbar::info($post->cover);
    // $postsWithPhotos = \DB::select('SELECT * FROM `posts` po right join photos ph on po.id = ph.photoable_id  where  ph.type = "cover" and ph.photoable_type = "App\\\Post"');
    // Debugbar::info($postsWithPhotos);
    // $postsWithPhotos = \App\Post::rightjoin('photos','posts.id','=','photos.photoable_id')->where('photos.type','cover')->where('photos.photoable_type','App\\Post')->first();
    // Debugbar::info($postsWithPhotos->src);

    return view('welcome');
});


Route::get('userphotos/{id}',function($id){
    $user = \App\User::findOrFail($id);
    Debugbar::info($user->photos);
    return view('welcome');
});

Route::get('userphotosadd/{id}',function($id){
    $user = \App\User::findOrFail($id);
    $user->photos()->create([
        'src' => 'user srcv',
        'type' => 'photo'
    ]);

    $user->photos()->create([
        'src' => 'user srcv',
        'type' => 'cover'
    ]);
    return view('welcome');
});


Route::get('postcover/{id}',function($id){
    $post = \App\Post::findOrFail($id);
    Debugbar::info($post->photos);
    return view('welcome');
});




Route::get('country/{id}/posts',function($id){
    $country = \App\Country::findOrFail($id);
    Debugbar::info($country->posts);
    return view('welcome');
});


Route::get('country/{id}/createpost',function($id){
    $country = \App\Country::findOrFail($id);
    $country->posts()->create([
        'user_id' => 3,
        'title' => 'this is relational post title',
        'content' => 'this is relational post content'
    ]);

});


Route::get('withposts',function(){
    //$users = \App\User::doesnthave('posts')->get();
    // $users = \App\User::whereHas('posts',function($query){
    //     $query->whereIn('id',[3]);
    // })->get();

    //$users = \App\User::has('posts')->orhas('photos')->get();
    $posts = true;
    $photo = true;
    $users = \App\User::where(function($query) use ($posts,$photo){
        if($posts) {
            $query->orwhereHas('posts');
        }
        if($photo) {
            $query->orwhereHas('photos',function($q){
                $q->where('type','photo');
            });
        }

    })->get();
    Debugbar::info($users);
    return view('welcome');

});
