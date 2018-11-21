                              <option value="">Select service from template</option>
							  @foreach($allServices as $allService)
							  <option value="{{$allService->plan_id}}">{{$allService->nickname}}</option>
							  @endforeach