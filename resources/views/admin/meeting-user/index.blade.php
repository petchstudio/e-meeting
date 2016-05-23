@extends('layouts.admin')

@section('script')
    @parent
    <script type="text/javascript">
    $(document).ready(function() {
        var grid = $("#table-meeting").bootgrid({
            ajax: true,
            ajaxSettings: {
                method: "GET",
            },
            url: "{!! url('/admin/api/meeting/'. $meeting->id .'/user') !!}",
            formatters: {
                "year": function(column, row) {
                    return parseInt(row.year)+543;
                },
                "date": function(column, row) {
                    var year = parseInt(moment(row.start_at).format("YYYY"))+543;
                    return moment(row.start_at).format("DD/MM")+"/"+year;
                },
            	"commands": function(column, row) {
            		return "<button type=\"button\" class=\"btn btn-xs btn-default command-delete\" data-row-id=\"" + row.id + "\"><span class=\"ion-trash-a\"></span></button>";
            	}
            },
        }).on("loaded.rs.jquery.bootgrid", function() {
			$('[data-toggle="tooltip"]').tooltip();

			grid.find(".command-delete").on("click", function(e) {
				var id = $(this).data("row-id");

				swal({
					title: 'ลบข้อมูล',
					text: 'ยืนยันการลบข้อมูล ?',
					type: "warning",
					showCancelButton: true,
					cancelButtonText: "ยกเลิก",
					confirmButtonText: 'ลบข้อมูล',
				}, function() {
					$.post('{{ url('/admin/meeting/'. $meeting->id .'/user') }}/' + id, {_method: 'DELETE'}, function(data, textStatus, xhr) {
						swal("ลบข้อมูล", "ลบข้อมูลสำเร็จ", "success");
						grid.bootgrid("reload");
					});
		        });
		    });
		});
    });
    </script>
@stop

@section('content-admin')

@include('includes.alert-response-session')

<div class="panel panel-default">
	<div class="panel-heading clearfix">
		<h2 class="panel-title pull-left">
			<strong>เพิ่มผู้เข้าร่วมประชุม</strong>
		</h2>
		<div class="pull-right">
			<a href="{{ url('/admin/meeting/'. $meeting->id .'/user/create') }}">เพิ่มผู้ใช้</a>
			|
			<a href="{{ url('/admin/meeting') }}">การประชุมทั้งหมด</a>
		</div>
	</div>
	<div class="panel-body">
		<div class="row m-b-10">
			<div class="col-xs-2 text-right"><strong>เรื่อง</strong></div>
			<div class="col-xs-8">{{ $meeting->name }}</div>
		</div>
		<div class="row m-b-10">
			<div class="col-xs-2 text-right"><strong>ปี</strong></div>
			<div class="col-xs-8">{{ $meeting->year+543 }}</div>
		</div>
		<div class="row m-b-10">
			<div class="col-xs-2 text-right"><strong>วันที่เริ่ม</strong></div>
			<div class="col-xs-8">
				{{ Carbon\Carbon::parse($meeting->start_at)->day }}
				/
				{{ Carbon\Carbon::parse($meeting->start_at)->month }}
				/
				{{ Carbon\Carbon::parse($meeting->start_at)->year+543 }}
			</div>
		</div>
		<table id="table-meeting" class="table">
			<thead>
				<tr>
					<th data-column-id="id" data-visible="false" data-width="75px">#</th>
					<th data-column-id="position">ตำแหน่ง</th>
					<th data-column-id="firstname">ชื่อ</th>
					<th data-column-id="lastname">นามสกุล</th>
					<th data-column-id="username">ชื่อผู้ใช้</th>
					<th data-column-id="commands" data-formatter="commands" data-width="30px"></th>
				</tr>
			</thead>
		</table>
	</div>
</div>
@endsection
