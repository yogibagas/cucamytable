@extends('panel.layout.app')
@section("page_name") Dashboard @endsection
@section('content')
    <!-- Table -->
    <div class="container-fluid mt--7">

    <div class="row">
        <div class="col">
          <div class="card shadow">
            <div class="card-header border-0">
                <div class="row">
                    <div class="col-12">
                    <h3 class="mb-3">Your Point Logs</h3>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">No</th>
                      <th scope="col">User</th>
                    <th scope="col">Points</th>
                    <th scope="col">Desc</th>
                    <th scope="col">Date</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($point as $b)
                  <tr>
                    <td>
                      {{$loop->iteration}}
                    </td>
                    <td>{{$b->user->name}}</td>
                    <td>
                      {{number_format($b->points)}}
                    </td>
                    <td>
                      <span class="">{{$b->desc}} </span>
                    </td>
                    <td>
                      {{\Carbon\Carbon::parse($b->created_at)->format('d F Y H:i')}}
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <div class="card-footer py-4">
              <nav aria-label="...">
              {!! $point->links() !!}
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
