<option value="">Select</option>
@if($cities && count($cities) > 0)
    @foreach($cities as $city)
        <option value="{{$city['id']}}">{{$city['city_name']}}</option>
    @endforeach
@endif