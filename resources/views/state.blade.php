<option value="">Select State</option>
@foreach($allStates as $allState)
<option value="{{$allState->id}}">{{$allState->name}}</option>
 @endforeach