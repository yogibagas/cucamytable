
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
                    <h2 class="text-center pb-3">Users Report</h2>
                    <table class='table table-striped table-bordered'>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Country</th>
                                <th>Gender</th>
                                <th>Role</th>
                                <th>Status</th>
                            </tr>

                        </thead>
                        <tbody>
                        @foreach($user as $u)
                        <tr>
                          <td>{{$loop->iteration}}</td>
                            <td width="20%">{{$u->name}}</td>
                            <td>{{$u->username}}</td>
                            <td>{{$u->email}}</td>
                            <td>{{$u->phone}}</td>
                            <td>{{$u->country->nicename }} - {{$u->country->iso}}</td>
                            <td>{{$u->gender == 0 ? "Male" : "Female"}}</td>
                            <td>{{$u->role == 0 ? "Admin" : false}} {{$u->role == 1 ? "Member" : false}} {{$u->role == 2 ? "Cashier" : false}}</td>
                            <td>{{$u->status == 1 ? "Active" : "Suspended"}}</td>
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
