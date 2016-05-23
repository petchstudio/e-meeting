@extends('layouts.app')

@section('script')
    @parent
    <script type="text/javascript">
    $(document).ready(function() {
        var formatters = {
            "year": function(column, row) {
                return parseInt(row.year)+543;
            },
            "date": function(column, row) {
                var year = parseInt(moment(row.start_at).format("YYYY"))+543;
                return moment(row.start_at).format("DD/MM")+"/"+year;
            },
            "commands": function(column, row) {
                return "<a href=\"{{ url('/storage/') }}/" + row.file + "\" class=\"btn btn-xs btn-default command-download\" data-row-id=\"" + row.id + "\"><span class=\"ion-archive\"></span> ดาวน์โหลดไฟล์</a> ";
            }
        };

        var grid = $("#table-meeting").bootgrid({
            ajax: true,
            ajaxSettings: {
                method: "GET",
            },
            url: "{!! url('/api/meeting') !!}",
            formatters: formatters,
        });

        var grid = $("#table-meeting-today").bootgrid({
            ajax: true,
            ajaxSettings: {
                method: "GET",
            },
            url: "{!! url('/api/meeting/today') !!}",
            formatters: formatters,
        });

        var grid = $("#table-meeting-new").bootgrid({
            ajax: true,
            ajaxSettings: {
                method: "GET",
            },
            url: "{!! url('/api/meeting/new') !!}",
            formatters: formatters,
        });
    });
    </script>
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">การประชุมที่ยังไม่ถึง</div>

                <div class="panel-body">
                    <table id="table-meeting-new" class="table">
                        <thead>
                            <tr>
                                <th data-column-id="id" data-visible="false" data-width="75px">#</th>
                                <th data-column-id="name">ชื่อการประชุม</th>
                                <th data-column-id="year" data-formatter="year" data-width="85px">ประจำปี</th>
                                <th data-column-id="start_at" data-formatter="date" data-width="100px">วันเริ่มต้น</th>
                                <th data-column-id="commands" data-formatter="commands" data-width="120px"></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <div class="panel panel-primary">
                <div class="panel-heading">การประชุมวันนี้</div>

                <div class="panel-body">
                    
                    <table id="table-meeting-today" class="table">
                        <thead>
                            <tr>
                                <th data-column-id="id" data-visible="false" data-width="75px">#</th>
                                <th data-column-id="name">ชื่อการประชุม</th>
                                <th data-column-id="year" data-formatter="year" data-width="85px">ประจำปี</th>
                                <th data-column-id="start_at" data-formatter="date" data-width="100px">วันเริ่มต้น</th>
                                <th data-column-id="commands" data-formatter="commands" data-width="120px"></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">การประชุมของคุณที่ผ่าน</div>

                <div class="panel-body">
                    <table id="table-meeting" class="table">
                        <thead>
                            <tr>
                                <th data-column-id="id" data-visible="false" data-width="75px">#</th>
                                <th data-column-id="name">ชื่อการประชุม</th>
                                <th data-column-id="year" data-formatter="year" data-width="85px">ประจำปี</th>
                                <th data-column-id="start_at" data-formatter="date" data-width="100px">วันเริ่มต้น</th>
                                <th data-column-id="commands" data-formatter="commands" data-width="120px"></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
