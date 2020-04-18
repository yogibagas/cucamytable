@extends('panel.layout.app')
@section("page_name") Dashboard @endsection
@section('content')
    <!-- Table -->
    <div class="container-fluid mt--7">

    <div class="row">
        <div class="col-4">
          <div class="card shadow">
            <div class="card-header border-0">
                <div class="row">
                    <div class="col-12">
                    <h3 class="mb-3"><span class="fa fa-trophy"></span> Top 10 Badges Collector</h3>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Rank</th>
                    <th scope="col">User</th>
                    <th scope="col">Badge Collected </th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($topBadge as $b)
                  <tr>
                    <td>
                      {{$loop->iteration}}
                    </td>
                    <td>
                      <a href="{{route('user.show',$b->id_user)}}">{{$b->name}}</a>
                    </td>
                    <td>
                      <span class="badge small badge-primary">{{$b->total}} Badges</span>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <div class="card-footer py-4">
              <nav aria-label="...">
              </nav>
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="card shadow">
            <div class="card-header border-0">
                <div class="row">
                    <div class="col-12">
                    <h3 class="mb-3"><span class="fa fa-trophy"></span> Top 10 Reservation Made</h3>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Rank</th>
                    <th scope="col">User</th>
                    <th scope="col">Reservation Mades </th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($topReservation as $b)
                  <tr>
                    <td>
                      {{$loop->iteration}}
                    </td>
                    <td>
                      <a href="{{route('user.show',$b->id_user)}}">{{$b->name}}</a>
                    </td>
                    <td>
                      <span class="badge small badge-primary">{{$b->total}} Reservation</span>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <div class="card-footer py-4">
              <nav aria-label="...">
              </nav>
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="card shadow">
            <div class="card-header border-0">
                <div class="row">
                    <div class="col-12">
                    <h3 class="mb-3"><span class="fa fa-trophy"></span> Top 10 Highest Point</h3>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Rank</th>
                    <th scope="col">User</th>
                    <th scope="col">Point Collected </th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($topPoint as $b)
                  <tr>
                    <td>
                      {{$loop->iteration}}
                    </td>
                    <td>
                      <a href="{{route('user.show',$b->id_user)}}">{{$b->name}}</a>
                    </td>
                    <td>
                      <span class="badge small badge-primary">{{number_format($b->total)}} Point</span>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <div class="card-footer py-4">
              <nav aria-label="...">
              </nav>
            </div>
          </div>
        </div>
      </div>



          <div class="row mt-5">
              <div class="col-4">
                <div class="card shadow">
                  <div class="card-header border-0">
                      <div class="row">
                          <div class="col-12">
                          <h3 class="mb-3"><span class="fa fa-trophy"></span> Top 10 Total Spend on Reservation</h3>
                          </div>
                      </div>
                  </div>

                  <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                      <thead class="thead-light">
                        <tr>
                          <th scope="col">Rank</th>
                          <th scope="col">User</th>
                          <th scope="col">Total Spending </th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($topSpend as $b)
                        <tr>
                          <td>
                            {{$loop->iteration}}
                          </td>
                          <td>
                            <a href="{{route('user.show',$b->id_user)}}">{{$b->name}}</a>
                          </td>
                          <td>
                            <span class="badge small badge-primary">IDR. {{($b->total/1000)}}K </span>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                  <div class="card-footer py-4">
                    <nav aria-label="...">
                    </nav>
                  </div>
                </div>
              </div>
            </div>
    </div>
@endsection
