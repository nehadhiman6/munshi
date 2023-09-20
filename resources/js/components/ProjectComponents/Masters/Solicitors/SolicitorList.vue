<template>
    <div>
          <solicitor-form v-if="formOpen"
                :permissions="permissions"
                :form-id ="form_id"
                @closeTriggered="reloadTable"
            >
            </solicitor-form>
        <div class="iw-sider-card-wrap m-box p-0">
                <div class="card-header">
                    <strong>Solicitors List</strong>
                    <!-- <button class="btn iw-btn iw-btn-add pull-right ml-2" v-show="formOpen == false" @click.prevent="formOpen = !formOpen">New area</button> -->
                    <a class="btn iw-btn-add  float-right ml-3"  v-show="formOpen == false && permissions['solicitor-modify'] == 'solicitor-modify'" @click.prevent="formOpen = !formOpen">
                        <i class="fe fe-plus"></i> New Solicitor
                    </a>
                </div>
                <div class="card-body">
                    <table id="dt-solicitor-table" class="table table-striped table-bordered" width="100%">
                    </table>
                </div>
        </div>
    </div>
</template>


<script>
 import SolicitorForm from './SolicitorForm.vue';
    export default{
        props:['permissions'],
        components:{
            SolicitorForm
        },
        data: function(){
            return {
                createUrl:'solicitors',
                formOpen:false,
                form_id: 0,
                table:null
            }
        },

        mounted:function(){
            this.setTable();
        },
        methods:{
            setTable:function(){
                var self = this;
                var target = 0;
                self.table = $('#dt-solicitor-table').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "searchDelay": 700,
                    "ajax": {
                        "url": self.createUrl,
                        "type": "GET",
                    },
                    data: [],
                    ordering: true,
                    scrollY: Munshi.table_scroll ? "300px":false,
                    scrollX: true,
                    scrollCollapse: true,
                    pageLength: 10,
                    paging: true,
                    fixedColumns:{
                        rightColumns: 1,
                        leftColumns: 0
                    },
                    "scrollX": true,
                    columnDefs: [
                        { title: 'S.No.',targets: target++, data: 'id',
                            "render": function( data, type, row, meta) {
                                var index = meta.row + parseInt(meta.settings.json.start);
                                return index +1;
                            }
                        },
                        { title: 'First Name', targets: target++, data: 'first_name',
                        },
                        { title: 'Middle Name', targets: target++, data: 'middle_name',
                        },
                        { title: 'Last Name', targets: target++, data: 'last_name',
                        },
                        { title: 'Fax', targets: target++, data: 'fax',
                        },
                        { title: 'Work Phone', targets: target++, data: 'work_phone',
                        },
                        { title: 'Cell Phone', targets: target++, data: 'cell_phone',
                        },
                        { title: 'Email', targets: target++, data: 'email',
                        },
                        { visible: self.checkPermission(), title: 'Action', targets: target++, data: 'id',
                            "render": function( data, type, row, meta) {
                                return '<a data-item-id='+data+' data-item-action="Edit" class="btn iw-btn iw-btn-edit edit-item">Edit</a>';
                            }
                        },
                    ],
                    "drawCallback": function( settings ) {
                        $(".edit-item").on( 'click', function (e) {
                            self.formOpen = false;
                            self.editContact(e.target.dataset.itemId);
                        });
                    }
                });
            },

            editContact:function(id){
                var self = this;
                self.form_id = id;
                setTimeout(function(){
                    self.formOpenReset(true);
                },100);
            },

            reloadTable: function() {
                var self = this;
                this.table.ajax.reload(null,false);
                this.formOpenReset(false);
                this.form_id =0;
            },

            formOpenReset:function(value){
                this.formOpen = value;
            },

            checkPermission: function(){
                if(this.permissions['solicitor-modify'] == 'solicitor-modify'){
                    return true;
                }else{
                    return false;
                }
            }
        }
    }
</script>

<style>

</style>
