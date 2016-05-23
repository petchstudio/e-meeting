@extends('layouts.admin')

@section('script')
    @parent
    <script type="text/javascript">
    $(document).ready(function() {
        var grid = $("#table-position").bootgrid({
            ajax: true,
            ajaxSettings: {
                method: "GET",
            },
            url: "{!! url('/admin/api/position') !!}",
            formatters: {
            	"commands": function(column, row) {
            		return "<a href=\"{{ url('/admin/position') }}/" + row.id + "/edit\" class=\"btn btn-xs btn-default command-edit\" data-row-id=\"" + row.id + "\"><span class=\"ion-compose\"></span></a> " + 
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
					$.post('{{ url('/admin/position') }}/' + id, {_method: 'DELETE'}, function(data, textStatus, xhr) {
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
			<strong>ตำแหน่งการประชุม</strong>
		</h2>
		<div class="pull-right">
			<a href="{{ url('/admin/position/create') }}">เพิ่มตำแหน่งการประชุม</a>
		</div>
	</div>
	<div class="panel-body">
		<table id="table-position" class="table">
			<thead>
				<tr>
					<th data-column-id="id" data-visible="false" data-width="75px">#</th>
					<th data-column-id="name">ชื่อตำแหน่งการประชุม</th>
					<th data-column-id="commands" data-formatter="commands" data-width="75px"></th>
				</tr>
			</thead>
		</table>
	</div>
</div>
@endsection
