@extends('admin.layouts.app')

@section('panel')
<div class="container-fluid">
            <div class="card">
                <div class="card-header">User Online Status</div>

                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                          <th>Serial</th>
                            <th>Username</th>
                            <th>Amount</th>
                            <th>Last Seen</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                              <td>{{ $loop->iteration }}</td>
                                <td><a href="{{ route('admin.users.detail', $user->id) }}">{{ $user->username }}</a></td>
                                <td>{{ getAmount($user->balance) }}</td>
                                <td>
                                    {{ Carbon\Carbon::parse($user->last_seen)->diffForHumans() }}
                                </td>
                                <td>
                                    @if(Cache::has('user-is-online-' . $user->id))
                                        <span class="badge badge-success">Online</span>
                                    @else
                                        <span class="badge badge-secondary">Offline</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                </div>
            </div>
</div>
@endsection
@push('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
    <script>

        $(document).ready(function() {
            $('#example').DataTable();
        } );
    </script>
@endpush