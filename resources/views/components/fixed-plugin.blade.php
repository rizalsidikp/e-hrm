
<div class="fixed-plugin">
    <form action="{{ $active ? "/favorite/" . $user_id : "/favorite" }}" method="POST" role="form text-left">
        @csrf
        @if($active)
        @method('DELETE')
        @endif
        <div class="fixed-plugin-button position-fixed favorite">
            <div class="text-dark favorite-text">
                @if($active)
                Hapus dari favorit
                @else
                Tambahkan ke favorit
                @endif
            </div>
            <button type="submit" class="text-dark position-absolute px-3 py-2 cursor-pointer favorite-icon">
                <i class="fa fa-star py-2 favorite-icon-color @if($active) favorite-active @endif"> </i>
            </button>
        </div>
        <input type="hidden" name="user_id" value="{{ $user_id }}" />
        <input type="hidden" name="label" value="{{ $label }}" />
        <input type="hidden" name="icon" value="{{ $icon }}" />
        <input type="hidden" name="url" value="{{ $url }}" />
    </form>
</div>