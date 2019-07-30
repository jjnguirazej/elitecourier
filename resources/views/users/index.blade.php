@extends('layouts.app')

@section('content')
<div class="panel-heading">
<h1>Internal Users Administration </h1>

    <a href="{{ route('users.create') }}" class="btn btn-success">Add User</a>
<br>
</div>
    @if(count($users) > 0)
        <?php
            $colcount = count($users);
            $i = 1;
        ?>
        
        <table class="table table-striped" >
            <tr>
                <th>User Name</th>
                <th>Full Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Branch</th>
                <th>User Type</th>
                @if(Auth::user()->usertype == 'superadmin')
                <th>Company</th>
                @endif
                <th>Status</th>
                <th></th>
            </tr>
            @foreach($users as $user)
            @if ($user['id'] != Auth::user()->id)
            <tr>
                <td>{{$user['username']}}</td>
                <td>{{$user['fullname']}}</td>
                <td>{{$user['phone']}}</td>
                <td>{{$user['email']}}</td>
                <td>{{$user['station']['name']}}</td>
                <td>{{$user['usertype']}}</td>
                @if(Auth::user()->usertype == 'superadmin')
                <td>{{$user['company']['name']}}</td>
                @endif
                <td><?php if ($user['status'] == 1 ) {echo "Active";} else {echo "Inactive";} ?></td>
                <td><a class="btn btn-default btn-xs" href="{{ route('users.edit', ['user' => $user->id ]) }}">Edit</a></td>  
            </tr>
            @endif
            @endforeach
        </table>
        {{$users->links()}}
    @else
      <p>No users To Display</p>
    @endif
@endsection