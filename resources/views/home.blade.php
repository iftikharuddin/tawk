<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

@extends('layouts.app')

<script>
    $(document).ready(function(){
        $('.dataTable').DataTable();
    });
</script>
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>{{Auth::user()->name }} Inbox</h2> 

                <table class="table table-bordered table-striped dataTable" style="font-size:14px;color:#333;" role="grid" aria-describedby="example1_info">
                <thead>
                <tr role="row">
                    
                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 181px;">Name</th>
                    <th class="sorting_desc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" aria-sort="descending" style="width: 224px;">Action</th>
                </tr>
                </thead>
                <tbody>
                @if($users)
                    @foreach($users as $user)
                    <tr role="row" class="odd">
                      <td> <img src="{{$user->avatar}}">
                                {{$user->name}}</td>
         
                      <td>
                        <a href="{{route('message.read', ['id'=>$user->id])}}" class="btn btn-success pull-right">Send New Message</a>
                      </td>
                    </tr>
                    @endforeach
               @endif
                </tbody>
              
              </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
