@extends('adminmodule::layouts.master')

@push('css_or_js')
    <link rel="stylesheet" href="{{asset('public/assets/admin-module')}}/plugins/dataTables/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="{{asset('public/assets/admin-module')}}/plugins/dataTables/select.dataTables.min.css"/>
@endpush

@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                     
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">subscription list</h3>
                            <div class="card-tools">
                                <a href="{{route('admin.subscriptionmodule.create')}}" class="btn btn-primary">Add Subscription</a>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <table id="subscriptionTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>image</th>
                                        <th>name</th>
                                        <th>price</th>
                                        <th>status</th>
                                        <th>Duration</th>
                                        <th>actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @foreach($subscriptions as $subscription)
                                    
                                        <tr>
                                            <td>{{$subscription->id}}</td>
                                            <td><img src="{{$subscription->image}}" width="50"/></td>
                                            <td>{{$subscription->name}}</td>
                                            <td>{{$subscription->price}}</td>
                                            <td>{{$subscription->status}}</td>
                                            <td>{{$subscription->duration}} days</td>
                                            
                                            <td>
                                                <a href="{{route('admin.subscriptionmodule.edit', $subscription->id)}}" class="btn btn-warning">edit</a>
                                                <a href="{{route('admin.subscriptionmodule.delete', $subscription->id)}}" class="btn btn-danger">delete</a>
                                                <a href="{{route('admin.subscriptionmodule.view', $subscription->id)}}" class="btn btn-info">view</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{asset('public/assets/admin-module')}}/plugins/select2/select2.min.js"></script>
    <script>
        "use strict"

        $(document).ready(function () {
            $('.js-select').select2();
        });
    </script>
    <script src="{{asset('public/assets/admin-module')}}/plugins/dataTables/jquery.dataTables.min.js"></script>
    <script src="{{asset('public/assets/admin-module')}}/plugins/dataTables/dataTables.select.min.js"></script>
@endpush
