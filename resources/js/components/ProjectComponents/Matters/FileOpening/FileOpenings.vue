<template>
    <div>
          <file-opening-form v-if="formOpen"
                :form="form"
                :permissions="permissions"
                :form-id ="form_id"
                @closeTriggered="reloadTable"
            >
            </file-opening-form>
        <div class="iw-sider-card-wrap m-box p-0">
                <div class="card-header">
                    <strong>File Openings List</strong>
                    <!-- <button class="btn iw-btn iw-btn-add pull-right ml-2" v-show="formOpen == false" @click.prevent="formOpen = !formOpen">New area</button> -->
                    <a class="btn iw-btn-add  float-right ml-3"  v-show="formOpen == false && permissions['file-opening-modify'] == 'file-opening-modify'" @click.prevent="formOpen = !formOpen">
                        <i class="fe fe-plus"></i> New File Opening
                    </a>
                </div>
                <div class="card-body">
                    <table id="dt-file-opening-table" class="table table-striped table-bordered" width="100%">
                    </table>
                </div>
        </div>
    </div>
</template>


<script>
function getNewForm(){
    return new Form({
        form_id:0,
        file_no:'',
        record_no:'',
        client_name:'',
        closing_date:'',
        agreement_of_ps_date:'',
        requisition_date:'',
        law_clerk_id:'',
        client_reference:'',
        real_estate_agent_id:'',
        solicitor_id:'',
        closed_file_no:'',
        box_no:'',
        special_notes:'',
        agent_work_phone:'',
        rate:''
    })
}
 import FileOpeningForm from './FileOpeningForm.vue';
    export default{
        props:['permissions'],
        components:{
            FileOpeningForm
        },
        data: function(){
            return {
                base_url:Munshi.base_url,
                form:getNewForm(),
                createUrl:'file-openings',
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
                self.table = $('#dt-file-opening-table').DataTable({
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
                    // fixedColumns:{
                    //     rightColumns: 1,
                    //     leftColumns: 0
                    // },
                    "scrollX": true,
                    columnDefs: [
                        { title: 'S.No.',targets: target++, data: 'id',
                            "render": function( data, type, row, meta) {
                                var index = meta.row + parseInt(meta.settings.json.start);
                                index =  index +1;
                                // var str = index + '<br><a data-item-id='+data+' data-item-action="Edit" class="btn iw-btn iw-btn-edit file-open">Open File</a>';
                                // var str = index +'.' + '<a href='+self.base_url+"/file-page?file_opening_id="+data+' target="_blank" class="btn iw-btn btn-secondary file-open mx-3" title="Open File"><span class="mdi mdi-folder-outline"></span></span></a>';
                                var str = index +'.';

                                return str;
                            }
                        },

                        { title: 'File Number', targets: target++, data: 'file_no',
                            'render': function(data, type, row, meta) {
                                return '<a href='+self.base_url+"/file-page?file_opening_id="+row.id+' target="_blank" title="Open File">'+data+'</a>';
                            }
                        },

                         { title: 'Record Number', targets: target++, data: 'record_no',
                        },
                        { title: 'Closing Date', targets: target++, data: 'closing_date',
                        },
                        { title: 'Date of agreement P&S', targets: target++, data: 'agreement_of_ps_date',
                        },
                        { title: 'Requisition Date', targets: target++, data: 'requisition_date',
                        },
                        { title: 'Law Clerk', targets: target++, data: 'law_clerk_id',
                            "render": function( data, type, row, meta) {
                                var str='';
                                if(row.law_clerk){
                                    var first_name = row.law_clerk.first_name ? row.law_clerk.first_name:'';
                                    var middle_name = row.law_clerk.middle_name ? row.law_clerk.middle_name:'';
                                    var last_name = row.law_clerk.last_name ? row.law_clerk.last_name:'';
                                    str+= first_name+' '+middle_name+' '+last_name;
                                }
                                return str;
                            }
                        },
                        { title: 'Real Estate Agent Clerk', targets: target++, data: 'real_estate_agent_id',
                            "render": function( data, type, row, meta) {
                                var str='';
                                if(row.real_estate_agent){
                                    var first_name = row.real_estate_agent.first_name ? row.real_estate_agent.first_name:'';
                                    var middle_name = row.real_estate_agent.middle_name ? row.real_estate_agent.middle_name:'';
                                    var last_name = row.real_estate_agent.last_name ? row.real_estate_agent.last_name:'';
                                    str+= first_name+' '+middle_name+' '+last_name;
                                }
                                return str;
                            }
                        },
                        { title: 'Client Reference', targets: target++, data: 'client_reference'},
                        { title: 'Solicitor', targets: target++, data: 'solicitor_id',
                            "render": function( data, type, row, meta) {
                                var str='';
                                if(row.solicitor){
                                    var first_name = row.solicitor.first_name ? row.solicitor.first_name:'';
                                    var middle_name = row.solicitor.middle_name ? row.solicitor.middle_name:'';
                                    var last_name = row.solicitor.last_name ? row.solicitor.last_name:'';
                                    str+= first_name+' '+middle_name+' '+last_name;
                                }
                                return str;
                            }
                        },
                        { title: 'Client Name', targets: target++, data: 'client_name'},
                        { title: 'Box No', targets: target++, data: 'box_no'},
                         { title: 'Closed File No', targets: target++, data: 'closed_file_no',
                        },
                          { title: 'Special Notes', targets: target++, data: 'special_notes',
                        },
                    //    { visible: self.checkPermission(), title: 'Action', targets: target++, data: 'id',
                    //         "render": function( data, type, row, meta) {
                    //             return '<a data-item-id='+data+' data-item-action="Edit" class="btn iw-btn iw-btn-edit edit-item" title="Edit"><span class="mdi mdi-pencil"></span> </a>';
                    //         }
                    //     },
                    ],
                    "drawCallback": function( settings ) {
                        $(".edit-item").on( 'click', function (e) {
                            self.formOpen = false;
                            self.editContact(e.target.dataset.itemId);
                        });
                    },
                    // "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    //     // var id = aData.id;

                    //     $('#dt-file-opening-table').on( 'click', 'tr', function () {
                    //         var id = self.table.row( this ).data().id;

                    //     } );

                    // }
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
                this.form = getNewForm();
                this.formOpenReset(false);
                this.form_id =0;
                this.formOpen = false;
            },

            formOpenReset:function(value){
                this.formOpen = value;
            },

            checkPermission: function(){
                if(this.permissions['file-opening-modify'] == 'file-opening-modify'){
                    return true;
                }else{
                    return false;
                }
            }
        }
    }
</script>

<style>
.file-open {
    background: #03a9f4;
    border-color: #03a9f4;
}
.edit-item {
    padding: 6px 12px!important;
}
</style>
