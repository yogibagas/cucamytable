
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
    Cuca My Table Panel  </title>
  <!-- Favicon -->
  <link href="https://cuca-table.test/assets/img/brand/favicon.png" rel="icon" type="image/png">
  <!-- Fonts -->
  <!-- Icons -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <meta name="csrf-token" content="dHJwSc2PJBL2hFBSuJCL6Fmzq6vvTXytI4hgURX9">
</head>
<body class="">
    <!-- Table -->
    <div class="container-fluid mt-2">

          <div class="row">
              <div class="col">
                  <div class="card-body" style="padding:0">
                    <h2 class="text-center pb-3">Menu Report</h2>
                    <h3 class="text-center pb-3">{{\Carbon\Carbon::parse($date['start'])->format('d/M/Y')}} - {{\Carbon\Carbon::parse($date['end'])->format('d/M/Y')}}</h3>
                    <table class='table table-striped table-bordered'>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Total Sold</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $u)
                        <tr>
                          <td>{{$loop->iteration}}</td>
                            <td width="20%">{{$u->name}}</td>
                            <td>{{$u->category_name}}</td>
                            <td>{{$u->total_sold}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
        </div>
  </div>
</div>
</body>
</html>
