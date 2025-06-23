@if (Auth::check())
    {{-- ユーザー一覧ページへのリンク --}}
    <li><a class="link link-hover" href="{{ route('users.index') }}">Users</a></li>
    {{-- ユーザー詳細ページへのリンク --}}
    <li><a class="link link-hover" href="{{ route('users.show', Auth::user()->id ) }} ">{{ Auth::user()->name }}&#39;s profile</a></li>
    {{-- お気に入りの一覧ページのリンク --}}
    <li><a href="{{ route('users.favorites', $user->id) }}" class="link link-hover">Favorites</a></li>
    <div class="divider lg:hidden"></div>
    {{-- ログアウトへのリンク --}}
    <li><a class="link link-hover" href="#" onclick="event.preventDefault();this.closest('form').submit();">Logout</a></li>
@else
    {{-- ユーザー登録ページへのリンク --}}
    <li><a class="link link-hover" href="{{ route('register') }}">Signup</a></li>
    <div class="divider lg:hidden"></div>
    {{-- ログインページへのリンク --}}
    <li><a class="link link-hover" href="{{ route('login') }}">Login</a></li>
@endif