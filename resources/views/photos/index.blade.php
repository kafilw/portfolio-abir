@if (session()->has('message'))
    <div>
        {{ session()->get('message')}}
    </div>

@endif

{{--
@foreach ($photos as $photo)
    <div>
        <span>{{ $photo->id }}</span>
        <span>{{ $photo->name }}</span>
    </div>
@endforeach --}}


<!-- your_blade_view.blade.php -->

@foreach($photos->groupBy('category') as $category => $items)
    <h2>{{ $category }} Category:</h2>
    <ul>
        @foreach($items as $item)
            <li><img src="{{ asset('images/' . $item->name) }}"
                height= "200px" width= "200px">  Rank - {{ $item->rank }}</li>
                <a href="/photos/{{$item->id}}/edit">
                    edit
                </a>
                <form action="/photos/{{$item->id}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
        @endforeach
    </ul>
@endforeach
