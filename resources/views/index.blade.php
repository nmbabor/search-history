@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
        <div class="col-md-4 border mb-10">
            <form id="filter-form">
                <div class="col-md-12 mt-2">
                    <button type="reset" class="btn btn-sm btn-warning float-end clearBtn" >Clear All</button>
                </div>
                <div class="form-group">
                    <label class="col-md-12 fw-bold">All Keywords: </label>
                    <div class="col-md-12">
                        <ul class="list-group">
                            @foreach($keywords as $keyword)
                                <li class="list-group-item d-flex justify-content-between align-items-start"><label class="cursor-pointer"><input type="checkbox" name="keywords[]" value="{{$keyword->keyword}}" class="keywords filter"> {{$keyword->keyword}} <span class="badge bg-info rounded-pill">{{$keyword->total}}</span> </label></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12 fw-bold">All Users: </label>
                    <div class="col-md-12">
                        <ul class="list-group">
                            @foreach($users as $user)
                            <li class="list-group-item"><label class="cursor-pointer"><input type="checkbox" name="users[]" value="{{$user->id}}" class="users filter"> {{$user->name}} </label></li>
                            @endforeach

                        </ul>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12 fw-bold">Time Range: </label>
                    <div class="col-md-12">
                        <ul class="list-group">
                            <li class="list-group-item"><label class="cursor-pointer"><input type="checkbox" name="time_range[]" class="time-range filter" value="1"> See data from yesterday </label></li>
                            <li class="list-group-item"><label class="cursor-pointer"><input type="checkbox" name="time_range[]" class="time-range filter" value="2"> See data from last week </label></li>
                            <li class="list-group-item"><label class="cursor-pointer"><input type="checkbox" name="time_range[]" class="time-range filter" value="3"> See data from last month </label></li>

                        </ul>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12 fw-bold">Select Date: </label>
                    <div class="col-md-12">
                        <input name="start_date" class="form-control start_date" placeholder="Enter Start Date" type="date">
                        <input name="end_date" class="form-control end_date my-1" placeholder="Enter End Date" type="date">
                        <button type="button" class="btn btn-sm btn-success my-1" onclick="formSubmit()">GO</button>
                    </div>
                </div>
        </form>

        </div>
        <div class="col-md-8">
            <div class="form-group">
                <div class="col-md-12">
                    <div class="input-group">
                        <input type="text" name="keyword" class="form-control" id="keyword" placeholder="Search Here...">
                        <div class="input-group-addon search-button" onclick="search()"><i class="fa fa-search" aria-hidden="true"></i></div>
                    </div>
                </div>
            </div>
            <h2>Search Results <small class="fs-5 total_items">  </small></h2>
            <table class="table table-bordered result-table">
                <thead>
                <tr class="bg-info">
                    <th> Keyword </th>
                    <th> User </th>
                    <th> Created At </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td colspan="3" class="text-center">No Items Found!</td>
                </tr>


                </tbody>
            </table>
        </div>

    </div>
    </div>

@endsection

@push('script')
    <script src="{{asset('assets/js/search.js')}}"></script>
@endpush
