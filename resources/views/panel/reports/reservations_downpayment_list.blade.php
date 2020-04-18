
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
  <style>.table {
  width: 100%;
  max-width: 100%;
  margin-bottom: 1rem;
}

.table th,
.table td {
  padding: 0.75rem;
  vertical-align: top;
  border-top: 1px solid #eceeef;
}

.table thead th {
  vertical-align: bottom;
  border-bottom: 2px solid #eceeef;
}

.table tbody + tbody {
  border-top: 2px solid #eceeef;
}

.table .table {
  background-color: #fff;
}

.table-sm th,
.table-sm td {
  padding: 0.3rem;
}

.table-bordered {
  border: 1px solid #eceeef;
}

.table-bordered th,
.table-bordered td {
  border: 1px solid #eceeef;
}

.table-bordered thead th,
.table-bordered thead td {
  border-bottom-width: 2px;
}

.table-striped tbody tr:nth-of-type(odd) {
  background-color: rgba(0, 0, 0, 0.05);
}

.table-hover tbody tr:hover {
  background-color: rgba(0, 0, 0, 0.075);
}

.table-active,
.table-active > th,
.table-active > td {
  background-color: rgba(0, 0, 0, 0.075);
}

.table-hover .table-active:hover {
  background-color: rgba(0, 0, 0, 0.075);
}

.table-hover .table-active:hover > td,
.table-hover .table-active:hover > th {
  background-color: rgba(0, 0, 0, 0.075);
}

.table-success,
.table-success > th,
.table-success > td {
  background-color: #dff0d8;
}

.table-hover .table-success:hover {
  background-color: #d0e9c6;
}

.table-hover .table-success:hover > td,
.table-hover .table-success:hover > th {
  background-color: #d0e9c6;
}

.table-info,
.table-info > th,
.table-info > td {
  background-color: #d9edf7;
}

.table-hover .table-info:hover {
  background-color: #c4e3f3;
}

.table-hover .table-info:hover > td,
.table-hover .table-info:hover > th {
  background-color: #c4e3f3;
}

.table-warning,
.table-warning > th,
.table-warning > td {
  background-color: #fcf8e3;
}

.table-hover .table-warning:hover {
  background-color: #faf2cc;
}

.table-hover .table-warning:hover > td,
.table-hover .table-warning:hover > th {
  background-color: #faf2cc;
}

.table-danger,
.table-danger > th,
.table-danger > td {
  background-color: #f2dede;
}

.table-hover .table-danger:hover {
  background-color: #ebcccc;
}

.table-hover .table-danger:hover > td,
.table-hover .table-danger:hover > th {
  background-color: #ebcccc;
}

.thead-inverse th {
  color: #fff;
  background-color: #292b2c;
}

.thead-default th {
  color: #464a4c;
  background-color: #eceeef;
}

.table-inverse {
  color: #fff;
  background-color: #292b2c;
}

.table-inverse th,
.table-inverse td,
.table-inverse thead th {
  border-color: #fff;
}

.table-inverse.table-bordered {
  border: 0;
}

.table-responsive {
  display: block;
  width: 100%;
  overflow-x: auto;
  -ms-overflow-style: -ms-autohiding-scrollbar;
}

.table-responsive.table-bordered {
  border: 0;
}
  </style>
  <meta name="csrf-token" content="dHJwSc2PJBL2hFBSuJCL6Fmzq6vvTXytI4hgURX9">
</head>
<body class="">
    <!-- Table -->
    <div class="container-fluid mt-2">

          <div class="row">
              <div class="col">
                  <div class="card-body" style="padding:0">
                    <h2 class="text-center pb-3">Reservation Down Payment Report</h2>
                    <h3 class="text-center pb-3">{{\Carbon\Carbon::parse($date['start'])->format('d/M/Y')}} - {{\Carbon\Carbon::parse($date['end'])->format('d/M/Y')}}</h3>
                    <br>
                    Payment Channel : {{$totals['reservationStatus']}}<br><br>
                    <table class='table table-striped table-bordered'>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Reservation Code</th>
                                <th>Reservator Name</th>
                                <th>Payment Channel</th>
                                <th>Payment Date</th>
                                <th>Total Pay</th>
                                <th>Tax & Service</th>
                                <th>Bank Fee</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                          @php
                          $totalRevenue =0;
                          $tax =0;
                          $bank = 0;
                          @endphp
                        @foreach($data as $u)
                        @php
                            $multiple = 0.5;

                            if($u->payment_status == -2)
                            $status = "Cancel";
                            elseif($u->payment_status == -1)
                            $status = "Waiting for Payment";
                            elseif($u->payment_status ==0)
                            $status = "Upcoming Reservation";
                            elseif($u->payment_status ==1)
                            $status = "Not Coming";
                            else
                            $status = "Completed";

                            $totalRevenue += ($u->total_payment*$multiple);
                            $tax += ($u->tax * $multiple);
                            $bank += ($u->bank_fee * $multiple);
                        @endphp
                        <tr>
                          <td>{{$loop->iteration}}</td>
                            <td width="0%">{{$u->reservation_code}}</td>
                            <td width="20%">{{$u->name}}</td>
                            <td width="15%">{{$u->brand}}</td>
                            <td width="15%">{{\Carbon\Carbon::parse($u->reservation_datetime)->format('d-m-Y H:i:s')}}</td>
                            <td style="text-align:right">{{number_format($u->total_payment*$multiple)}}

                            </td>
                            <td style="text-align:right">{{number_format($u->tax*$multiple)}}</td>
                            <td style="text-align:right">{{number_format($u->bank_fee*$multiple)}}</td>
                            <td style="text-align:right">{{number_format(($u->total_payment+$u->tax+$u->bank_fee)*$multiple)}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                          <tr style="background:skyblue;color:red;">
                            <td colspan="5">Total</td>
                            <td style="text-align:right">{{number_format($totalRevenue)}}</td>
                            <td style="text-align:right">{{number_format($tax)}}</td>
                            <td style="text-align:right">{{number_format($bank)}}</td>
                            <td style="text-align:right">{{number_format(($totalRevenue+$tax+$bank))}}</td>
                          </tr>
                        </tfoot>
                    </table>
                </div>
        </div>
  </div>
</div>
</body>
</html>
