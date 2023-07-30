@foreach ($photos as $photo)
    <div>
        <span>{{ $photo->id }}</span>
        <span>{{ $photo->name }}</span>
    </div>
@endforeach

@if (session()->has('message'))
    <div>
        {{ session()->get('message')}}
    </div>

@endif

