<div>
    <span>{{ $photo->id }}</span>
    <span>{{ $photo->name }}</span>
</div>
<img src="{{ asset('images/'.$photo->name) }}"
height="200px" width="200px">
<form
method="POST"
action="/photos/{{$photo->id}}}}"
enctype="multipart/form-data">
@csrf
@method('PUT')
    <input type="number" name="rank" value="{{ $photo->rank }}">
    <select id="category" class="block mt-1 w-full" name="category" required>
        <option value="wedding" @if($photo->category === 'wedding') selected @endif>Wedding</option>
        <option value="product" @if($photo->category === 'product') selected @endif>Product</option>
        <option value="outdoor" @if($photo->category === 'outdoor') selected @endif>Outdoor</option>
    </select>
    <button type="submit">Update</button>
