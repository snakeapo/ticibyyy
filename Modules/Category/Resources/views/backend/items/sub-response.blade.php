<option value="" disabled selected>Seçim Yapın</option>
@foreach($subCategories as $subCategory)
    <option value="{{ $subCategory->id }}">{{ $subCategory->sub_title }}</option>
@endforeach
