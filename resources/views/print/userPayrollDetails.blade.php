@extends('printLayout')
@section('content')

    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i> {{config('app.customer')}}.

                    <small class="pull-right">{{date("Y/m/d")}}</small>
                </h2>
                <h4 class="text-center">
                    Detail User Attendance.
                </h4>
                <h4 class="text-center">
                     {{$user_full_name}}
                </h4>
                <h6 class="text-center">
                    (FROM:{{$from_date}} TO:{{$to_date}}) - (Currency={{$currency}})
                </h6>
            </div>
            <!-- /.col -->
        </div>




        <div class="row">
            <div class="col-xs-12">
                <div class="">
                    <!-- /.box-header -->
                    <div class="">
                      <?php $deduction_amount=0;$total_deduction_amount=0;$total_late_min=0;$total_working_day=0;$total_worked_day=0;
                      ?>

                        @if(isset($reports))
                            <table class="table table-bordered" >

                                <tbody>
                                  <tr>
                                      <th >
                                          Date
                                      </th>

                                      <th>
                                          Day
                                      </th>
                                    
                                      <th style="white-space: nowrap;">
                                          Shift In
                                      </th>
                                      <th style="white-space: nowrap;">
                                          Clocked IN
                                      </th style="white-space: nowrap;">
                                      <th style="white-space: nowrap;">
                                          Shift out
                                      </th>
                                      <th style="white-space: nowrap;">
                                          Clocked OUT
                                      </th>
                                      <th>
                                          Late(mins)
                                      </th>
                                      <th>
                                          Total Shift(mins)
                                      </th>
                                      <th>
                                          Paid Rate
                                      </th>
                                      <th>
                                          deduction Amount
                                      </th>

                                  </tr>
                                @foreach($reports as $date=>$report)

                                <tr>
                                    <td  style="white-space: nowrap;" rowspan="{{count($report['shifts'])+1}}">{{$date}}</td>
                                    <td rowspan="{{count($report['shifts'])+1}}">{{$report["day"]}}</td>

                                </tr>
                                @foreach($report['shifts'] as $shift)
                                    <tr>
                                        <td  style="white-space: nowrap;" ><b>{{$shift['start_time']}}</b></td>
                                        <td  style="white-space: nowrap;">{{$shift["clock_in_time"]}}</td>
                                        <td  style="white-space: nowrap;"><b>{{$shift['end_time']}}</b></td>
                                        <td  style="white-space: nowrap;">{{$shift["clock_out_time"]}}</td>
                                        <td>{{$shift['late']}}</td>
                                        <td>{{$shift['total_shift_min']}}</td>
                                        <td>{{$rate_per_min=$report["total_min"]==0?$day_rate:(round($day_rate/$report["total_min"],4))}}</td>

                                        <td >{{$shift["clock_in_time"]==0?number_format($deduction_amount=($rate_per_min*$shift['late'])+($rate_per_min*$shift['total_shift_min']), 2, '.', ','):number_format($deduction_amount=$rate_per_min*$shift['late'], 2, '.', ',')}}</td>

                                    </tr>
                                    <?php $total_deduction_amount+=$deduction_amount; ?>
                                    <?php $total_late_min+=$shift['late']; ?>

                                @endforeach
                                <?php $total_working_day+=$report['working_day']; ?>
                                <?php $total_worked_day+=$report['worked_day']; ?>
                                @endforeach
                                <tr>

                                    <td><strong>TOTAL WORKING DAYS</strong></td>
                                    <td>{{$total_working_day}}</td>
                                    <td><strong>TOTAL WORKED DAYS</strong></td>
                                    <td>{{$total_worked_day}}</td>
                                    <td><strong>TOTAL ABSENT DAYS:</strong></td>
                                    <td>{{$total_working_day - $total_worked_day}}</td>
                                    <td><strong>TOTAL Late:</strong></td>
                                    <td>{{$total_late_min}}</td>
                                    <td><strong>TOTAL DEDUCTION:</strong></td>
                                    <td>{{number_format($total_deduction_amount, 2, '.', ',')}}</td>
                                    <td></td>
                                </tr>

                                </tbody>

                            </table>
                        @endif


                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>

    </section>


@stop
