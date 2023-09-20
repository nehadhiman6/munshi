<template>
<div>
    <div class="row mt-2">
        <div class="col-md-6">
            <div class="iw-sider-card-wrap">
                <div class="card">
                    <div class="card-header">
                        <strong>Solicitors </strong>
                        <button class="btn iw-btn-add float-right" @click.prevent="addEmployee('solicitor')"><i class="fe fe-plus"></i> Add New Solicitor</button>
                    </div>
                </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6" v-for="emp in  employees.filter(emp => emp.type == 'solicitor')" :key="emp.id">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title" v-text="getName(emp)"></h5>
                                <h6 class="card-subtitle mb-2 text-muted" v-text="emp.email">Solicitor</h6>
                                <p class="card-text">
                                    <h6>Work Phone: <span v-text="emp.work_phone"></span></h6>
                                    <h6>Cell Phone: <span v-text="emp.cell_phone"></span></h6>
                                    <h6>Fax: <span v-text="emp.fax"></span></h6>
                                </p>
                                <a href="" class="btn  iw-btn-edit-absolute card-link" @click.prevent="editEmployee(emp.id,'solicitor')">
                                    <span class="mdi mdi-pencil"></span>
                                    Edit</a>
                                     <a href="" class="btn iw-btn-delete-absolute card-link"  @click.prevent="deleteEmployee(emp.id,'solicitor')">
                                <span class="mdi mdi-delete"></span>
                                Delete</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            </div>
        </div>
    <div class="col-md-6">
        <div class="iw-sider-card-wrap">
            <div class="card">
            <div class="card-header">
                <strong>Law Clerks</strong>
                <button class="btn iw-btn-add float-right" @click.prevent="addEmployee('law_clerk')"><i class="fe fe-plus"></i> Add New Law Clerk</button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6" v-for="emp in  employees.filter(emp => emp.type == 'law_clerk')" :key="emp.id">
                        <div class="card mb-4">
                        <div class="card-body " >
                            <h5 class="card-title" v-text="getName(emp)"></h5>
                            <h6 class="card-subtitle mb-2 text-muted" v-text="emp.email">Solicitor</h6>
                            <p class="card-text">
                                <h6>Work Phone: <span v-text="emp.work_phone"></span></h6>
                                <h6>Cell Phone: <span v-text="emp.cell_phone"></span></h6>
                                <h6>Fax: <span v-text="emp.fax"></span></h6>
                            </p>
                            <a href="" class="btn iw-btn-edit-absolute card-link"  @click.prevent="editEmployee(emp.id,'law_clerk')">
                                <span class="mdi mdi-pencil"></span>
                                Edit</a>
                            <a href="" class="btn iw-btn-delete-absolute card-link"  @click.prevent="deleteEmployee(emp.id,'law_clerk')">
                                <span class="mdi mdi-delete"></span>
                                Delete</a>
                        </div>
                    </div>
                    </div>
                </div>

            </div>
        </div>
        </div>

    </div>
</div>
<employee-form v-if="formOpen"
:permissions="permissions"
            :type="type"
            :form-id="form_id"
            @closeTriggered="resetForm">
               <span slot="employee-type" v-text="type == 'solicitor' ? 'Solicitor':'Law Clerk'"></span>
</employee-form>
</div>
</template>

<script>
import EmployeeForm from './EmployeeForm.vue';
export default {
  components: { EmployeeForm },
    props:['permissions'],
    data:function(){
        return {
            create_url:'employees',
            base_url:Munshi.base_url,
            employees:[],
            type:'',
            formOpen:false,
            form_id:0
        }
    },
    mounted:function(){
        this.getEmployees();
    },
    methods:{
        getEmployees:function(){
            var self = this;
            axios.get(this.base_url+'/'+this.create_url)
            .then(function(response){
                console.log(response);
                self.employees = response.data.data;
            })
            .catch(function(error){

            });
        },
        getName:function(emp){
            var name = emp.first_name +' ';
            name+= emp.middle_name ? emp.middle_name +' ' :'';
            name+= emp.last_name ? emp.last_name  :'';
            return name;
        },
        addEmployee:function(type){
            this.formOpen = true;
            this.type = type;
        },
        resetForm:function(){
            this.formOpen = false;
            this.type = '';
            this.form_id =0;
            this.getEmployees();
        },
        editEmployee:function(id,type){
            this.form_id = id;
            this.addEmployee(type);
        },
        deleteEmployee:function(emp_id){
            var self = this;
              Utilities.showConfirmationPopMessage('Do you really want to delete?',function(save){
                if(save == true){
                    axios.delete(self.base_url+'/'+self.create_url+'/'+emp_id)
                    .then(function(response){
                        console.log(response);
                        if(response.data && response.data.deleted){
                            Utilities.showToast(self,'success','Employee deleted successfully',2200,true);
                            self.getEmployees();
                        }
                        else{
                            Utilities.showToast(self,'error','Unable to delete this employee due to a dependency/reference in another record',4000,true);
                        }
                    })
                    .catch(function(error){
                        console.log(error);
                    });
                }
            },true,false);
        }
    }
}
</script>

<style>
.iw-btn-edit-absolute {
    position: absolute;
    right: 0;
    top: 0;
    padding: 0 10px;
    background: #031893;
    color: #fff!important;
    font-size: 13px;
}

.iw-btn-delete-absolute {
    position: absolute;
    right: 0;
    bottom: 0;
    padding: 0 10px;
    background: #f44336;
    color: #fff!important;
    font-size: 13px;
}
</style>
