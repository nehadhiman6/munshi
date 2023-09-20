<template>
    <div>
            <brokerage-form v-if="formOpen"
                :permissions="permissions"
                :form-id ="form_id"
                    @closeTriggered="reloadTable">
                 <div slot="title">
                    <span v-if="form_id == 0"> Add Brokerage</span>
                    <span v-if="form_id > 0">Edit Brokerage</span>
                </div>
            </brokerage-form>
        <div class="iw-sider-card-wrap m-box p-0">
                <div class="card-header">
                    <strong>Brokerages List</strong>
                    <!-- <button class="btn iw-btn iw-btn-add pull-right ml-2" v-show="formOpen == false" @click.prevent="formOpen = !formOpen">New area</button> -->
                    <a class="btn iw-btn-add  float-right ml-3"  v-show="formOpen == false && permissions['brokerage-modify'] == 'brokerage-modify'" @click.prevent="formOpen = !formOpen">
                        <i class="fe fe-plus"></i> New Brokerage
                    </a>
                </div>
                <div class="card-body">
                    <table id="dt-city-table" class="table table-striped table-bordered" width="100%">
                    </table>
                </div>
        </div>
    </div>
</template>


<script>
 import BrokerageForm from './BrokerageForm.vue';
    export default{
        props:['permissions'],
        components:{
            BrokerageForm
        },
        data: function(){
            return {
                createUrl:'brokerages',
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
                self.table = $('#dt-city-table').DataTable({
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
                        { title: 'Name', targets: target++, data: 'name',
                        },
                        { title: 'Phone', targets: target++, data: 'phone',
                        },
                        { title: 'Fax', targets: target++, data: 'fax',
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
                this.formOpen = false;
            },

            formOpenReset:function(value){
                this.formOpen = value;
            },

            checkPermission: function(){
                if(this.permissions['brokerage-modify'] == 'brokerage-modify'){
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
