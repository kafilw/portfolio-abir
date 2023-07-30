@foreach ($photos as $photo)
    <span> {{ $photo->name }} </span>
@endforeach

<p> {{ $category }} </p>
