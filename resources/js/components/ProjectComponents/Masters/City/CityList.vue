<template>
    <div>
          <city-form v-if="formOpen"
                :form-id ="form_id"
                 :lro="lro_arr"
                @closeTriggered="reloadTable"
            >
            </city-form>
        <div class="iw-sider-card-wrap m-box p-0">
                <div class="card-header">
                    <strong>Cities List</strong>
                    <!-- <button class="btn iw-btn iw-btn-add pull-right ml-2" v-show="formOpen == false" @click.prevent="formOpen = !formOpen">New area</button> -->
                    <a class="btn iw-btn-add  float-right ml-3"  v-show="formOpen == false && permissions['cities-modify'] == 'cities-modify'" @click.prevent="formOpen = !formOpen">
                        <i class="fe fe-plus"></i> New City
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
 import CityForm from './CityForm.vue';
    export default{
        props:['permissions','lro'],
        components:{
            CityForm
        },
        data: function(){
            return {
                createUrl:'cities',
                formOpen:false,
                form_id: 0,
                table:null,
                base_url:Munshi.base_url
            }
        },

        computed:{
            	lro_arr:function(){
				var arr =  this.lro;
				arr.forEach(element => {
					element.id = parseInt(element.id);
				});
				return arr;
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
                        { title: 'City', targets: target++, data: 'city_name',
                        },
                        { title: 'Province', targets: target++, data: 'state',
                        },
                        { title: 'Country', targets: target++, data: 'country',
                        },
                        { visible: self.checkPermission("cities-modify") || self.checkPermission("city-departments-modify")  , title: 'Action', targets: target++, data: 'id',
                            "render": function( data, type, row, meta) {
                                var str= '';
                                if(self.checkPermission("cities-modify")){
                                    str += '<a data-item-id='+data+' data-item-action="Edit" class="btn iw-btn btn-sm iw-btn-edit btn edit-item">Edit</a>';
                                }
                                if(self.checkPermission("city-departments-modify")){
                                    str += '<a  href='+self.base_url+"/city-departments?city_id="+row.id+'  class="btn iw-btn iw-btn-edit ml-2">City Departments</a>';
                                }
                                return str;
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

            checkPermission: function(per){
                if(this.permissions[per] == per){
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
