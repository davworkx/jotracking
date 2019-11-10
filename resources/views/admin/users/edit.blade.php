@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Edit User {{$user->name}}</div>

                <div class="card-body">
                  <form class="" action="{{route('superadmin.users.update',['user'=> $user->id])}}" method="post">
                    @csrf
                    {{method_field('PUT')}}
                    @foreach($roles as $role)
                      <div class="form-check">
                        <input type="checkbox" name="roles[]" value="{{$role->id}}" {{$user->hasAnyRole($role->name)?'checked':''}}>
                        <label for="">{{$role->name}}</label>
                      </div>
                    @endforeach
                    <button type="submit" name="button" class="btn btn-primary"> update </button>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
