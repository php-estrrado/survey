<option value="">Select</option>
@if($admins && count($admins)>0)
    @foreach($admins as $admin)
        <option value="{{$admin->admin_id}}">{{$admin->email}}</option>
    @endforeach
@endif