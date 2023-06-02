@extends('layouts.admin')
@section('header', 'Note')

@section('content')
<div id="controller">
    <div class="row">
        <div class="col-md-5 offset-md-3">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
                <input type="text" class="form-control" placeholder="Search from title" autocomplete="off" v-model="search">
            </div>
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary" @click="addData()">+ New Artikel</button>

        </div>
    </div>

	<hr>

    <div class="row">
        <div class="col-md-7 col-sm-9 col-xs-15" v-for="note in filteredList">
            <div class="info-box" v-on:click="editData(note)">
                <div class="info-box-content">
                    <span class="info-box-text h5"> TITLE </span>
                    <span class="info-box-text h5"> @{{ note.title }} </span>
                    <span class="info-box-text h5"> Content </span>
                    <span class="info-box-text h5">@{{ note.content }} </span>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
        <div class="modal-content">
        <form method="POST"  :action="actionUrl" autocomplete="off" @submit="submitForm($event, note.id)">
        <div class="modal-header">
        <h4 class="modal-title">note</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            @csrf

            <input type="hidden" name="_method" value="PUT" v-if="editStatus">

           
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control"  required=""  :value="note.title">
            </div>
            
            <div class="form-group">
                <label>Content</label>
                <input type="text" name="content" class="form-control"  required=""  :value="note.content">
            </div>

        </div>
        <div class="modal-footer justify-content-between">
         <button type="button" class="btn btn-danger" data-dismiss="modal" v-if ="editStatus" v-on:click="deleteData(note.id)">Delete</button>
        <button type="submit" class="btn btn-primary">Confirm</button>
        </div>
        </form>
        </div>
        </div>
    </div>

</div>

@endsection

@section('js')
<script type="text/javascript">
    var actionUrl = '{{ url('notes') }}';
    var apiUrl = '{{ url('api/notes') }}';

    var app = new Vue({
        el: '#controller',
        data: {
            notes: [],
            search: '',
            note: {},
            editStatus: false,
            actionUrl,
			apiUrl
        },
        mounted: function() {
            this.get_notes();
        },
        methods: {
            get_notes() {
                const _this = this
                $.ajax({
                    url: apiUrl,
                    method: 'GET',
                    success: function(data) {
                        _this.notes = JSON.parse(data)
                    },
                    error: function(error) {
                        console.log(error);
                    }
                })
            },
            addData() {
                this.note = {};
                this.actionUrl = '{{ url ('notes') }}';
                this.editStatus = false;
                $('#modal-default').modal();
            },
            editData(note) {
                this.note = note;
                this.actionUrl = '{{ url ('notes') }}' + '/' + note.id;
                this.editStatus = true;
                $('#modal-default').modal();
            },
            deleteData(id) {
				this.actionUrl = '{{ url('notes') }}'+'/'+id;
				if (confirm("Are you sure?")) {
					axios.post(this.actionUrl, {_method: 'DELETE'}).then(response => {
						location.reload();
					});
				}
			},
    
        },
        computed: {
			filteredList() {
				return this.notes.filter(note => {
					return note.title.toLowerCase().includes(this.search.toLowerCase())
				})
			}
		}
	})
</script>
@endsection