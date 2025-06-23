<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Micropost;
use App\Models\User;

class UsersController extends Controller
{

    public function index() {

        $users = User::orderby('id','desc')->paginate(10);

        return view('users.index',[
            'users' => $users,
        ]);
    }

    public function show($id)
    {
        // idの値でユーザーを検索して取得
        $user = User::findOrFail($id);

        // 関係するモデルの件数をロード
        $user->loadRelationshipCounts();

        // ユーザーの投稿一覧を作成日時の降順で取得
        $microposts = $user->microposts()->orderBy('created_at', 'desc')->paginate(10);

        // 認証したユーザーを取得
        $authUser = \Auth::user();

        // このユーザーがお気に入りした投稿のidを取得して配列にする
        $micropostsId = $authUser->favorites()->pluck('favorites.micropost_id')->toArray();

        // ユーザー詳細ビューでそれを表示
        return view('users.show', [
            'user' => $user,
            'microposts' => $microposts,
            'favoritesId' => $micropostsId,
        ]);
    }

    /**
     * ユーザーのフォロー一覧ページを表示するアクション。
     *
     * @param  $id  ユーザーのid
     * @return \Illuminate\Http\Response
     */
    public function followings($id)
    {
        // idの値でユーザーを検索して取得
        $user = User::findOrFail($id);

        // 関係するモデルの件数をロード
        $user->loadRelationshipCounts();

        // ユーザーのフォロー一覧を取得
        $followings = $user->followings()->paginate(10);

        //dd($followings);
        // フォロー一覧ビューでそれらを表示
        return view('users.followings', [
            'user' => $user,
            'users' => $followings,
        ]);
    }

    /**
     * ユーザーのフォロワー一覧ページを表示するアクション。
     *
     * @param  $id  ユーザーのid
     * @return \Illuminate\Http\Response
     */
    public function followers($id)
    {
        // idの値でユーザーを検索して取得
        $user = User::findOrFail($id);

        // 関係するモデルの件数をロード
        $user->loadRelationshipCounts();

        // ユーザーのフォロワー一覧を取得
        $followers = $user->followers()->paginate(10);
        // フォロワー一覧ビューでそれらを表示
        return view('users.followers', [
            'user' => $user,
            'users' => $followers,
        ]);
    }

    /**
     * ユーザーのお気に入り投稿一覧ページを表示するアクション。
     *
     * @param  $id  ユーザーのid
     * @return \Illuminate\Http\Response
     */
    public function favorites($id)
    {
        // idの値でユーザーを検索して取得
        $user = User::findOrFail($id);

        // 関係するモデルの件数をロード
        $user->loadRelationshipCounts();

        // このユーザーがお気に入りした投稿のidを取得して配列にする
        $thiUserFavoriteIds = $user->favorites()->pluck('favorites.micropost_id')->toArray();

        //dd($micropostsId);
        // それらのユーザーが所有する投稿に絞り込む
        $favoriteMicroPosts = Micropost::whereIn('id', $thiUserFavoriteIds)->paginate(10);

        // 認証したユーザーを取得
        $authUser = \Auth::user();

        // 認証したユーザーのお気に入りにした投稿のidを取得して配列にする
        $authUserFavoriteIds = $authUser->favorites()->pluck('favorites.micropost_id')->toArray();

        // お気に入り一覧ビューでそれらを表示
        return view('users.favorites', [
            'user' => $user,
            'microposts' => $favoriteMicroPosts,
            'favoritesId' => $authUserFavoriteIds,
        ]);
    }
}