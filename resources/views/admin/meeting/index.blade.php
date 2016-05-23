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
            url: "{!! url('/admin/api/meeting') !!}",
            formatters: {
                "year": function(column, row) {
                    return parseInt(row.year)+543;
                },
                "date": function(column, row) {
                    var year = parseInt(moment(row.start_at).format("YYYY"))+543;
                    return moment(row.start_at).format("DD/MM")+"/"+year;
                },
            	"commands": function(column, row) {
            		return "<a href=\"{{ url('/admin/meeting') }}/" + row.id + "/user\" class=\"btn btn-xs btn-default command-add\" data-row-id=\"" + row.id + "\"><span class=\"ion-plus\"></span> เพิ่มผู้เข้าร่วมประชุม</a> " + 
            		"<a href=\"{{ url('/admin/meeting') }}/" + row.id + "/edit\" class=\"btn btn-xs btn-default command-edit\" data-row-id=\"" + row.id + "\"><span class=\"ion-compose\"></span></a> " + 
            		"<button type=\"button\" class=\"btn btn-xs btn-default command-delete\" data-row-id=\"" + row.id + "\"><span class=\"ion-trash-a\"></span></button>";
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
					$.post('{{ url('/admin/meeting') }}/' + id, {_method: 'DELETE'}, function(data, textStatus, xhr) {
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
			<strong>การประชุม</strong>
		</h2>
		<div class="pull-right">
			<a href="{{ url('/admin/meeting/create') }}">เพิ่มการประชุม</a>
		</div>
	</div>
	<div class="panel-body">
		<table id="table-meeting" class="table">
			<thead>
				<tr>
					<th data-column-id="id" data-visible="false" data-width="75px">#</th>
					<th data-column-id="name">ชื่อการประชุม</th>
					<th data-column-id="year" data-formatter="year" data-width="85px">ประจำปี</th>
					<th data-column-id="start_at" data-formatter="date" data-width="100px">วันเริ่มต้น</th>
					<th data-column-id="commands" data-formatter="commands" data-width="190px"></th>
				</tr>
			</thead>
		</table>
	</div>
</div>
@endsection
