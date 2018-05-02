@extends('layout.default')
@section('title','菜品统计')
@section('content')
    <div class="panel panel-info">
        <div class="row">
            <div class="col-sm-6">
                <table class="table table-bordered">
                    <tr>
                        <th colspan="2">菜品月统计</th>
                    </tr>
                    <tr>
                        <td>菜品id</td>
                        <td>菜品数量</td>
                    </tr>
                    <tr>
                        @foreach($month as $row)
                        <td>{{$row->foods_id}}</td>
                        <td>{{$row->m}}</td>
                        @endforeach
                    </tr>
                </table>
            </div>
            <div class="col-sm-6">
                <table class="table table-bordered">
                    <tr>
                        <th colspan="2">菜品总统计</th>
                    </tr>
                    <tr>
                        <td>菜品id</td>
                        <td>菜品数量</td>
                    </tr>
                    @foreach($total as $row)
                    <tr>
                        <td>{{$row->foods_id}}</td>
                        <td>{{$row->total}}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered">
                    <tr>
                        <form action="{{route('food.time')}}" method="post" class="form-control">
                            <th>
                                日查询:<input type="date" name="date">
                                <button class="btn btn-group-sm btn-info">查询</button>
                            </th>
                            <th>
                                月查询:<input type="month" name="month">
                                <button class="btn btn-group-sm btn-info">查询</button>
                            </th>
                            <th>
                                范围查询:<input type="datetime-local" name="datetime1">--
                                <input type="datetime-local" name="datetime2">
                                <button class="btn btn-group-sm btn-info">查询</button>
                            </th>
                            {{ csrf_field() }}
                        </form>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    @stop