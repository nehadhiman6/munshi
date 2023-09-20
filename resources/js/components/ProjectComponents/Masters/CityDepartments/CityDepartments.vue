<template>
    <div>
        <a :href="base_url+'/cities'">Back to Cities List</a>
          <city-department-form v-if="formOpen"
                :form-id ="form_id"
                :city="city"
                :department_types="department_types"
                @closeTriggered="reloadTable"
            >
            </city-department-form>
        <div class="iw-sider-card-wrap m-box p-0">
                <div class="card-header">
                    <strong><span v-text='city.city_name'></span> Departments</strong>
                    <!-- <button class="btn iw-btn iw-btn-add pull-right ml-2" v-show="formOpen == false" @click.prevent="formOpen = !formOpen">New area</button> -->
                    <a class="btn iw-btn-add  float-right ml-3"  v-show="permissions['cities-modify'] == 'cities-modify'" @click.prevent="formOpen = !formOpen">
                        <i class="fe fe-plus"></i> Add Department
                    </a>
                </div>
                <div class="card-body">
                    <table id="dt-city-department-table" class="table table-striped table-bordered" width="100%">
                    </table>
                </div>
        </div>
    </div>
</template>


<script>
import CityDepartmentForm from './CityDepartmentForm.vue';
    export default{
        props:['permissions','city_id','city','department_types'],
        components:{
                CityDepartmentForm
        },
        data: function(){
            return {
                createUrl:'city-departments',
                formOpen:false,
                form_id: 0,
                table:null,
                base_url:Munshi.base_url
            }
        },

        mounted:function(){
            this.setTable();
        },
        methods:{
            setTable:function(){
                var self = this;
                var target = 0;
                self.table = $('#dt-city-department-table').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "searchDelay": 700,
                    "ajax": {
                        "url": self.createUrl,
                        "type": "GET",
                        "data":function(p){
                            p.city_id=self.city_id
                        },
                    },
                    data: [],
                    ordering: true,
                    scrollY: Munshi.table_scroll ? "300px":false,
                    scrollX: true,
                    scrollCollapse: true,
                    pageLength: 10,
                    paging: true,
                    fixedColumns:{
                        rightColumns: 0,
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
                        { title: 'Department Name', targets: target++, data: 'department_name',
                        },
                        { title: 'Department Type', targets: target++, data: 'department_type',
                        },
                        { title: 'City/Municipality', targets: target++, data: 'city_municipality',
                        },
                        { title: 'Service Provider', targets: target++, data: 'service_provider_name',
                        },
                        { title: 'Attention', targets: target++, data: 'attention',
                        },
                        { title: 'Street no.', targets: target++, data: 'street_no',
                        },
                        { title: 'Street Name', targets: target++, data: 'street_name',
                        },
                        { title: 'Province', targets: target++, data: 'province',
                        },
                        { title: 'Postal Code', targets: target++, data: 'postal_code',
                        },
                        { title: 'Phone', targets: target++, data: 'phone',
                        },
                        { title: 'Fax', targets: target++, data: 'fax',
                        },
                        { title: 'Email', targets: target++, data: 'email',
                        },
                         { title: 'Website link', targets: target++, data: 'website_link',
                        },
                         { title: 'Action', targets: target++, data: 'id',
                          "render": function( data, type, row, meta) {
                            var str= ''
                            str += '<a data-item-id='+data+' data-item-action="Edit" class="btn iw-btn btn-sm iw-btn-edit btn edit-item mr-1">Edit</a>';
                            str += '<a data-item-id='+data+' data-item-action="Edit" class="btn iw-btn btn-sm iw-btn-edit btn remove-item">Remove</a>';
                            return str;
                          }
                        }
                    ],
                    "drawCallback": function( settings ) {
                        $(".edit-item").on( 'click', function (e) {
                            self.formOpen = false;
                            self.editContact(e.target.dataset.itemId);
                        });
                          $(".remove-item").on( 'click', function (e) {
                            self.formOpen = false;
                            self.removeDepartmentCity(e.target.dataset.itemId);
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
            },

            removeDepartmentCity:function(id){
                var self = this;
                axios.delete(this.base_url+'/'+this.createUrl+'/'+id)
                .then(function(response){
                    console.log(response);
                    self.reloadTable();
                    Utilities.showToast(self,'success','City Department deleted successfully',2200,true);
                })
                .catch(function(error){
                    console.log(error);
                })
            }
        }
    }
</script>

<style>

</style>
