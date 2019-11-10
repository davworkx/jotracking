@extends('layouts.app')

@section('content')

            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                    <div class="row">
                        <div class="col-12 d-flex no-block align-items-center">
                            <h4 class="page-title">Manage Billings</h4>

                            <div class="ml-auto text-right">
                            <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Billings</li>
                                    </ol>
                                </nav>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Container fluid  -->
                <!-- ============================================================== -->
                <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                @if(session('successb'))
                <div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Success! </strong>{{session('successb')}}
                </div>
                @endif
                @if(count($errors) > 0)
                <div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Error!</strong>
                    {{$errors->first('ornumber')}}<br>
                    {{$errors->first('paymentdate')}}<br>
                    {{$errors->first('amount')}}<br>
                </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <div class="table-responsive">
                        <table class="table table-sm table-hover table-striped">
                    <thead>
                      <tr>
                        <th scope="col">JO#</th>
                        <th scope="col">Company/Client Name</th>
                        <th scope="col">Date Created</th>
                        <th scope="col">Amount Due</th>
                        <th scope="col">Amount Paid</th>
                        <th scope="col">OR Number</th>
                        <th scope="col">Balance</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if(count($billings) > 0)
                         @foreach($billings as $bill)
                         <tr id="tr">
                           <td>{{$bill->id}}</td>
                           <td>{{$bill->clientname}}</td>
                           <td align="right">{{$bill->created_at}}</td>
                           <td align="right">{{number_format($bill->amount, 2, '.', ',')}}</td>
                           <td align="right">{{number_format($bill->paidamount, 2, '.', ',')}}</td>
                           <td>{{$bill->ornumber}}</td>
                           <td align="right">Php {{ number_format(($bill->amount - $bill->paidamount), 2, '.', ',') }}
                           </td>
                           <td align="center">
                           @if(($bill->amount - $bill->paidamount) == 0)

                           @else
                           <button class="btn btn-success" onClick="addpayment('{{$bill->id}}','{{ ($bill->amount - $bill->paidamount) }}')" data-toggle="modal" data-target="#paymentModal" rel="tooltip" title="Add Payment" type="button"><span class="fa fa-credit-card"></span></button>
                           @endif
                           <a href="{{url('billing/jid')}}/{{$bill->id}}" target="_blank">
                           <button class="btn btn-info" onClick="" data-toggle="modal" data-target="" rel="tooltip" title="View Transaction" type="button"><span class="fa fa-print"></span></button>
                           </a>
                          </td>
                          </tr>
                         @endforeach
                         @else
                         <tr>
                           <td colspan="7">NO Client's Billing Found.</td>
                         </tr>
                         @endif
                    </tbody>
                  </table>
                  {{ $billings->links() }}

                        </div>
                    </div>
                </div>

                

<!-- Modal -->
<div class="modal fade" id="paymentModal" tabindex="" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Payment to JO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="paymentForm" action="{{url('/billing/addpayment')}}" method="post">
          {{ csrf_field() }}
          <input type="text" name="joid" id="joid" value="" hidden>
          <div class="form-group col-sm-12">


            <div class="input-group input-group-sm mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">OR Number:&nbsp &nbsp</span>
              </div>
              <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="ornumber" name="ornumber" required autofocus>
            </div>
            <div class="input-group input-group-sm mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">Amount (Php):</span>
              </div>
              <input type="number" step="0.01" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="amount" name="amount" required>
            </div>
            <div class="input-group input-group-sm mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">Payment Date:</span>
              </div>
              <input type="date" class="form-control" value="{{date('Y-m-d')}}" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="paymentdate" required>
            </div>
            <div class="input-group input-group-sm mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">Remarks:</span>
              </div>
              <input type="text" class="form-control" aria-label="Small" value="settle payment" aria-describedby="inputGroup-sizing-sm" name="remarks">
            </div>

          </div>
      </div>
      <div class="modal-footer">
        <button type="reset" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" onclick="form_submit()" class="btn btn-primary btn-sm">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- End Modal -->


                    <!-- ============================================================== -->
                    <!-- End PAge Content -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Right sidebar -->
                    <!-- ============================================================== -->
                    <!-- .right-sidebar -->
                    <!-- ============================================================== -->
                    <!-- End Right sidebar -->
                    <!-- ============================================================== -->
                </div>
                <!-- ============================================================== -->
                <!-- End Container fluid  -->
                <!-- ============================================================== -->

@endsection
<script type="text/javascript">
function form_submit() {
  var orn = document.getElementById('ornumber').value;
  if(orn == null || orn == ""){
    alert('Pleaser enter OR Number');
  }else{
    var txt;
    var r = confirm("Please confirm your entries.");
    if (r == true) {
        document.getElementById("paymentForm").submit();
    } else {
        alert("You pressed Cancel!");
    }
  }

}
function addpayment(j,a)
{
  document.getElementById('joid').value = j.toString();
  document.getElementById('amount').value = a.toString();
  //alert(j+'   '+a);
}
</script>