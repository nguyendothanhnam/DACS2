@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                
            </div>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <?php
                    $message = Session::get('message');
                    if ($message) {
                        echo '<span class="text-alert">' . $message . '</span>';
                        Session::put('message', null);
                    }
                    ?>
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên user</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Password</th>
                            <th>Author</th>
                            <th>Admin</th>
                            <th>User</th>
                            <th>Phân quyền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admin as $key => $user)
                            <form action="{{ url('/assign-roles') }}" method="POST">
                                @csrf
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->admin_name }}</td>
                                    <td>{{ $user->admin_email }}
                                        <input type="hidden" name="admin_email" value="{{ $user->admin_email }}">
                                    </td>
                                    <td>{{ $user->admin_phone }}</td>
                                    <td>
                                        {{-- {{ $user->admin_password }} --}}
                                        {{ strlen($user->admin_password) > 10 ? substr($user->admin_password, 0, 5) . '...' . substr($user->admin_password, -5) : $user->admin_password }}
                                    </td>
                                    <td>
                                        <input type="checkbox" name="author_role" {{ $user->hasRole('author') ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input type="checkbox" name="admin_role" {{ $user->hasRole('admin') ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input type="checkbox" name="user_role" {{ $user->hasRole('user') ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input type="submit" value="Assign roles" class="btn btn-sm btn-default"> 
                                    </td>
                                </tr>
                            </form>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <footer class="panel-footer">
                <div class="row">

                    <div class="col-sm-5 text-center">
                        <small class="text-muted inline m-t-sm m-b-sm"></small>
                    </div>
                    <div class="col-sm-7 text-right text-center-xs">
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                            <li>{{ $admin->links() }}</li>
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection
