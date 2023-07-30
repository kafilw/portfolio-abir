@foreach ($photos as $photo)
    <span> {{ $photo->name }} </span>
    <div>
        <img src="{{ asset('images/' . $photo->name) }}"
        height= "200px" width= "200px">
    </div>
@endforeach

<p> {{ $category }} </p>
