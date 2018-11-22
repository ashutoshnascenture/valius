Vero
Invoice Detail 
Name :- {{Auth::user()->first_name}}
<table class="table table-dark">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Plan Name</th>
      <th scope="col">Amount</th>
      <th scope="col">Date</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>{{$data['amount']['plan_name']}}</td>
      <td>{{$data['amount']['plan_amount']/100}}</td>
      <td>{{$data['created_at']}}</td>
    </tr>
  </tbody>
</table>
