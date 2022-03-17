@extends('layouts.app')
@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Dashboard-->
            <!--begin::Row-->
            <div class="row mt-0 mt-lg-8">

                <div class="col-xl-12">
                    <!--begin::Advance Table Widget 1-->
                    <div class="card card-custom card-stretch card-shadowless gutter-b pb-5">
                        <!--begin::Header-->
                        <div class="card-header border-0 py-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label font-weight-bolder text-dark">{{ Auth::user()->name }} Todays
                                    Collection</span>
                                <span class="text-muted mt-3 font-weight-bold font-size-sm">View todays
                                    collection</span>
                            </h3>
                            <div class="card-toolbar">
                                <a href="{{route('report.historyCurrentUser')}}"
                                    class="btn btn-sm btn-icon btn-light-primary">
                                    <i class="flaticon2-time"></i>
                                </a>
                            </div>

                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body py-0">
                            <!--begin::Table-->
                            <div class="table-responsive">
                                <table class="table table-head-custom table-vertical-center"
                                    id="kt_advance_table_widget_1">
                                    <thead>
                                        <th style="width:15%">Token Number</th>
                                        <th style="width:15%">Grand Total</th>
                                        <th style="width:15%">View Bill</th>
                                        <th style="width:10%">Time</th>
                                        <th style="width:15%">Customer Paid Amount</th>
                                        <th style="width:30%;float:right;">Status</th>

                                    </thead>

                                    <tbody>
                                        @foreach($orders as $key => $order)
                                        <tr>
                                            <th>{{ $order->token_no }}</th>
                                            <td>{{ $order->grand_total }}</td>

                                            <td class="pr-0 text-left">
                                                <a href="#" data-toggle="modal"
                                                    data-target={{"#detailModal".$order->id}}
                                                    class="btn btn-primary btn-sm rounded-0 mx-2 ">

                                                    <i class="fa fa-dollar  py-2"></i> Show Bill
                                                </a>
                                                <div class="modal fade" id={{"detailModal".$order->id}} tabindex="-1"
                                                    role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="detailModalLabel">Checkout
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <i aria-hidden="true" class="ki ki-close"></i>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <table class="table table-bordered">
                                                                    <tr>
                                                                        <th>Name</th>
                                                                        <th>Price</th>
                                                                        <th>Quantity</th>
                                                                        <th>Total</th>
                                                                        <th>Scheme</th>
                                                                    </tr>
                                                                    @foreach($order->foods as $key => $food)
                                                                    <tr>
                                                                        <td>{{ $food->name }}</td>
                                                                        <td>{{ $food->pivot->price }}</td>
                                                                        <td>{{ $food->pivot->quantity }}</td>
                                                                        <td>{{ $food->price*$food->pivot->quantity }}
                                                                        </td>
                                                                        <td>{{ $food->pivot->scheme }}</td>
                                                                    </tr>
                                                                    @endforeach
                                                                    <tr>
                                                                        <td colspan="5"><b>Grand Total</b>: Rs
                                                                            {{$order->grand_total}}</td>
                                                                    </tr>
                                                                </table>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button"
                                                                    class="btn rounded-0 mx-2 btn-light-primary font-weight-bold "
                                                                    data-dismiss="modal">Close</button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $order->created_at->format('H:i') }}</td>
                                            <td>Rs {{ $order->paid_amount }}</td>
                                            @if($order->status==0)

                                            <td>
                                                <a href="#" class="btn btn-danger btn-sm rounded-0 mx-2 float-right"
                                                    data-toggle="modal" data-target="#{{"cancel".$order->id}}">
                                                    Cancel Order
                                                </a>
                                                <div class=" modal fade" id="{{"cancel".$order->id}}" tabindex="-1"
                                                    role="dialog" aria-labelledby="exampleModalLabel"
                                                    aria-hidden="true">

                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Cancel
                                                                    Order</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <i aria-hidden="true" class="ki ki-close"></i>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <table class="table table-bordered">
                                                                    <tr>
                                                                        <th>Name</th>
                                                                        <th>Price</th>
                                                                        <th>Quantity</th>
                                                                        <th>Total</th>
                                                                        <th>Scheme</th>
                                                                    </tr>
                                                                    @foreach($order->foods as $key => $food)
                                                                    <tr>
                                                                        <td>{{ $food->name }}</td>
                                                                        <td>{{ $food->pivot->price }}</td>
                                                                        <td>{{ $food->pivot->quantity }}</td>
                                                                        <td>{{ $food->price*$food->pivot->quantity }}
                                                                        </td>
                                                                        <td>{{ $food->pivot->scheme }}</td>
                                                                    </tr>
                                                                    @endforeach
                                                                    <tr>
                                                                        <td colspan="5"><b>Grand Total</b>: Rs
                                                                            {{$order->grand_total}}</td>
                                                                    </tr>
                                                                </table>

                                                            </div>

                                                            <div class="modal-footer">


                                                                <button type="button"
                                                                    class="btn btn-danger btn-lg rounded-0 float-right mx-2 font-weight-bold"
                                                                    data-dismiss="modal">Close</button>
                                                                <a href="{{ route('order.cancel',$order->id) }}"
                                                                    class="btn btn-primary float-right rounded-0 mx-2 font-weight-bold btn-lg">Proceed</a>



                                                                <br>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a href="#" class="btn btn-primary btn-sm rounded-0 mx-2 float-right"
                                                    data-toggle="modal" data-target="#{{"reprint".$order->id}}">
                                                    Reprint Bill
                                                </a>
                                                <div class=" modal fade" id="{{"reprint".$order->id}}" tabindex="-1"
                                                    role="dialog" aria-labelledby="exampleModalLabel"
                                                    aria-hidden="true">

                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Reprint
                                                                    Bill</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <i aria-hidden="true" class="ki ki-close"></i>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <table class="table table-bordered">
                                                                    <tr>
                                                                        <th>Name</th>
                                                                        <th>Price</th>
                                                                        <th>Quantity</th>
                                                                        <th>Total</th>
                                                                        <th>Scheme</th>
                                                                    </tr>
                                                                    @foreach($order->foods as $key => $food)
                                                                    <tr>
                                                                        <td>{{ $food->name }}</td>
                                                                        <td>{{ $food->pivot->price }}</td>
                                                                        <td>{{ $food->pivot->quantity }}</td>
                                                                        <td>{{ $food->price*$food->pivot->quantity }}
                                                                        </td>
                                                                        <td>{{ $food->pivot->scheme }}</td>
                                                                    </tr>
                                                                    @endforeach
                                                                    <tr>
                                                                        <td colspan="5"><b>Grand Total</b>: Rs
                                                                            {{$order->grand_total}}</td>
                                                                    </tr>
                                                                </table>

                                                            </div>

                                                            <div class="modal-footer">


                                                                <button type="button"
                                                                    class="btn btn-danger btn-lg rounded-0 float-right mx-2 font-weight-bold"
                                                                    data-dismiss="modal">Close</button>
                                                                <a href="{{ route('order.reprint',$order->id) }}"
                                                                    class="btn btn-primary float-right rounded-0 mx-2 font-weight-bold btn-lg">Proceed</a>



                                                                <br>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>



                                            </td>
                                            @else
                                            <td class="text-danger text-right">
                                                <div class=" badge badge-danger text-light px-2 py-1">Canceled</div>
                                            </td>
                                            @endif
                                        </tr>

                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!--end::Table-->
                        </div>

                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Advance Table Widget 1-->
            </div>
        </div>
        <!--end::Row-->
        <!--begin::Row-->

        <!--end::Row-->



        <!--end::Dashboard-->
        <!--end::Container-->
    </div>
</div>
@endsection