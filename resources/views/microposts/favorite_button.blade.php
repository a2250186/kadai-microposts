@if (in_array($micropost->id,$favoritesId))
    {{-- お気に入り解除ボタンのフォーム --}}
    <form method="POST" action="{{ route('micropost.unfavorite', $micropost->id) }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm normal-case">Unfavorite</button>
    </form>
@else
    {{-- お気に入りボタンのフォーム --}}
    <form method="POST" action="{{ route('micropost.favorite', $micropost->id) }}">
        @csrf
        <button type="submit" class="btn btn-success btn-neutural btn-sm normal-case">favorite</button>
    </form>
@endif