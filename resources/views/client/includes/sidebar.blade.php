<div class="block categories" style="padding: 6px 16px">
    <h3 class="title select-cate-id mb-0" data-cate-id="">Tất cả</h3>
</div>
<div class="block categories">
    @foreach ($cates as $item)
        <h3 class="title select-cate-id mt-3 d-flex align-items-center" data-cate-id="{{ $item->id }}">
            <span> <img src="{{ asset('storage') . '/' . $item->image }}" alt="ảnh {{ $item->name }}" style="width: 42px; height:28px; border-radius:4px"></span>
            <span class="ml-2">{{ $item->name }}</span>
        </h3>
        <ul class="">
            @foreach ($item->children as $child)
                @if ($child->status == 1)
                    <li>
                        <span><i class="fas fa-caret-right"></i></span>
                        <span class="select-cate-id" data-cate-id="{{ $child->id }}">{{ $child->name }}</span>
                    </li>
                @endif
            @endforeach
        </ul>
    @endforeach
</div>
