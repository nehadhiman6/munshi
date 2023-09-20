<template>
<div>
    <div class="iw-sider-card-wrap m-box p-0 mb-4 ">
      <!-- MODAL BODY -->
       <div class=" card-header d-flex flex-wrap align-items-center justify-content-between  py-1">
            <span v-if="form.form_id == 0"><strong> File Opening</strong></span>
            <span v-if="form.form_id > 0"><strong>Edit File Opening</strong></span>
            <div class="float-right">
                <input class="btn iw-btn iw-btn-submit py-1" :value="form.form_id > 0 ? 'Update' : 'Save'" @click.prevent ="submitForm" type="submit">
            </div>
        </div>
        <div class="card-body">
            <div class="form-horizontal">
                <div class = "form-row">
                    <div class="col">
                        <div class="form-group">
                        <label for="file_no" class="in-label-title required">File Number</label>
                        <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('file_no') }" type="text" v-model ="form.file_no">
                        <span id="basic-msg" v-if="form.errors.get('file_no')" class="invalid-feedback">{{ form.errors.get('file_no') }}</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                        <label for="record_no" class="in-label-title ">Record Number</label>
                        <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('record_no') }" type="text" v-model ="form.record_no">
                        <span id="basic-msg" v-if="form.errors.get('record_no')" class="invalid-feedback">{{ form.errors.get('record_no') }}</span>
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-group">
                        <label for="client_name" class="in-label-title ">Client Name</label>
                        <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('client_name') }" type="text" v-model ="form.client_name">
                        <span id="basic-msg" v-if="form.errors.get('client_name')" class="invalid-feedback">{{ form.errors.get('client_name') }}</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group" v-bind:class="{ 'is-invalid': form.errors.get('closing_date') }">
                            <label for="closing_date" class="in-label-title ">Closing Date</label>
                            <date-picker v-model ="form.closing_date" class-name="closing_date"   yearsRange="-100:+50"></date-picker>
                            <span id="basic-msg" v-if="form.errors.get('closing_date')" class="invalid-feedback">{{ form.errors.get('closing_date') }}</span>
                        </div>
                    </div>
                     <div class="col">
                         <div class="form-group" v-bind:class="{ 'is-invalid': form.errors.get('agreement_of_ps_date') }">
                        <label for="agreement_of_ps_date" class="in-label-title ">Date of PS agreement</label>
                        <date-picker v-model ="form.agreement_of_ps_date" class-name="agreement_of_ps_date"></date-picker>
                        <span id="basic-msg" v-if="form.errors.get('agreement_of_ps_date')" class="invalid-feedback">{{ form.errors.get('agreement_of_ps_date') }}</span>
                        </div>
                    </div>
                </div>
                 <div class = "form-row">
                    <div class="col">
                        <div class="form-group" v-bind:class="{ 'is-invalid': form.errors.get('requisition_date') }">
                        <label for="requisition_date" class="in-label-title ">Requisition Date</label>
                        <date-picker v-model ="form.requisition_date" class-name="requisition_date"></date-picker>
                        <span id="basic-msg" v-if="form.errors.get('requisition_date')" class="invalid-feedback">{{ form.errors.get('requisition_date') }}</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group"  v-bind:class="{ 'is-invalid': form.errors.get('law_clerk_id') }">
                        <label for="law_clerk_id" class="in-label-title ">Law Clerk </label>
                        <div class="input-group flex-nowrap mb-3" >
                            <!-- <select class="form-control" v-model ="form.law_clerk_id" class-name="law_clerk_id" >
                                   <option value="1">1</option>
                            </select> -->
                            <div class="w-100">
                                   <employee-select v-if="show" index="1"  v-model="form.law_clerk_id" :initials="lawClerkInitials" :selected="lawClerkSelected" type="law_clerk"></employee-select>
                            </div>
                            <div class="input-group-append" v-if="permissions['employees-modify'] =='employees-modify'">
                                <button class="btn iw-add-new-btn" @click.prevent="addEmployee('law_clerk')"><span class="mdi mdi-plus"></span></button>
                            </div>
                            </div>

                        </div>
                        <span id="basic-msg" v-if="form.errors.get('law_clerk_id')" class="invalid-feedback">{{ form.errors.get('law_clerk_id') }}</span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                        <label for="client_reference" class="in-label-title ">Client Reference</label>
                        <select class="form-control" v-model ="form.client_reference" class-name="client_reference" >
                            <option value="agent">Agent</option>
                            <option value="returned_client">Returned Client</option>
                        </select>
                        <span id="basic-msg" v-if="form.errors.get('client_reference')" class="invalid-feedback">{{ form.errors.get('client_reference') }}</span>
                        </div>
                    </div>
                     <!-- <div class="col" v-if="form.client_reference == 'agent'">
                         <div class="form-group">
                        <label for="real_estate_agent_id" class="in-label-title ">Real Estate Agent</label>
                        <real-estate-agent-select v-model ="form.real_estate_agent_id" v-if='show' :initials="realEstateAgentInitials" :selected="realEstateAgentSelected"></real-estate-agent-select>
                        <span id="basic-msg" v-if="form.errors.get('real_estate_agent_id')" class="invalid-feedback">{{ form.errors.get('real_estate_agent_id') }}</span>
                        </div>
                    </div> -->
                    <div class="col"  v-if="form.client_reference == 'agent'">
                        <div class="form-group">
                        <label for="real_estate_agent_id" class="in-label-title ">Real Estate Agent</label>
                        <div class="input-group flex-nowrap mb-3">
                            <div class="w-100">
                                <real-estate-agent-select v-model ="form.real_estate_agent_id" v-if='show' :initials="realEstateAgentInitials" :selected="realEstateAgentSelected" @updateRealEstateAgent="updateRealEstateAgent"></real-estate-agent-select>
                            </div>
                            <div class="input-group-append"  v-if="permissions['real-estate-agent-modify'] == 'real-estate-agent-modify'">
                                <a class="btn iw-add-new-btn" @click.prevent="ShowRealEstateModal" ><span class="mdi mdi-plus"></span></a>
                            </div>
                        </div>

                        <span id="basic-msg" v-if="form.errors.get('real_estate_agent_id')" class="invalid-feedback">{{ form.errors.get('real_estate_agent_id') }}</span>
                        </div>
                    </div>
                    <div class="col"  v-if="form.client_reference == 'agent'">
                          <div class="form-group">
                            <label for="agent_work_phone" class="in-label-title ">Agent Phone </label>
                            <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('agent_work_phone') }" disabled type="text" v-model ="form.agent_work_phone">
                            <span id="basic-msg" v-if="form.errors.get('agent_work_phone')" class="invalid-feedback">{{ form.errors.get('agent_work_phone') }}</span>
                        </div>
                    </div>
                    </div>
                 <div class = "form-row">
                    <div class="col">

                        <div class="form-group"  v-bind:class="{ 'is-invalid': form.errors.get('solicitor_id') }">
                            <label for="solicitor_id" class="in-label-title ">Solicitor</label>
                            <div class="input-group flex-nowrap mb-3">
                                <div class="w-100">
                            <employee-select v-if="show" index="2" v-model="form.solicitor_id" :initials="solicitorInitials" :selected="solicitorSelected" type="solicitor"></employee-select>
                            </div>
                                <div class="input-group-append" v-if="permissions['employees-modify'] =='employees-modify'">
                                    <button class="btn iw-add-new-btn" @click.prevent="addEmployee('solicitor')" ><span class="mdi mdi-plus"></span></button>
                                </div>
                            </div>
                            <span id="basic-msg" v-if="form.errors.get('solicitor_id')" class="invalid-feedback">{{ form.errors.get('solicitor_id') }}</span>
                        </div>
                    </div>
                     <div class="col">
                         <div class="form-group">
                        <label for="closed_file_no" class="in-label-title ">Closed File Number</label>
                        <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('closed_file_no') }" type="text" v-model ="form.closed_file_no">
                        <span id="basic-msg" v-if="form.errors.get('closed_file_no')" class="invalid-feedback">{{ form.errors.get('closed_file_no') }}</span>
                        </div>
                    </div>
                      <div class="col">
                          <div class="form-group">
                        <label for="box_no" class="in-label-title ">Box Number</label>
                        <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('box_no') }" type="text" v-model ="form.box_no">
                        <span id="basic-msg" v-if="form.errors.get('box_no')" class="invalid-feedback">{{ form.errors.get('box_no') }}</span>
                        </div>
                    </div>
                </div>
                 <div class = "form-row">
                     <div class="col">
                         <div class="form-group">
                        <label for="special_notes" class="in-label-title ">Special Notes</label>
                        <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('special_notes') }" type="text" v-model ="form.special_notes">
                        <span id="basic-msg" v-if="form.errors.get('special_notes')" class="invalid-feedback">{{ form.errors.get('special_notes') }}</span>
                        </div>
                    </div>
                </div>
                  <div class = "form-row" v-if="form.form_id == 0">
                     <div class="col">
                         <div class="form-group">
                        <label for="rate" class="in-label-title ">Rate</label>
                        <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('rate') }" type="text" v-model ="form.rate">
                        <span id="basic-msg" v-if="form.errors.get('rate')" class="invalid-feedback">{{ form.errors.get('rate') }}</span>
                        </div>
                    </div>
                </div>
                <div v-if="form.errors.get('gen_msg')" class="alert alert-danger" role="alert">
                   {{ form.errors.get('gen_msg') }}
                </div>
                <div class ="mt-2">
                    <input class="btn iw-btn iw-btn-submit" :value="form.form_id > 0 ? 'Update' : 'Save'" @click.prevent ="submitForm" type="submit">
                    <input class="btn iw-btn iw-btn-cancel" value ="Cancel" @click.prevent ="checkUnsavedAndShowMessage" type="submit" >
                </div>
            </div>
            </div>
        </div>
        <employee-form v-if="formOpen"
            :permissions="permissions"
            :type="type"
            :form-id="0"
            @closeTriggered="resetEmployeeForm">
            <span slot="employee-type" v-text="type == 'solicitor' ? 'Solicitor':'Law Clerk'"></span>
        </employee-form>
        <real-estate-agent-form v-if="showRealEstate"
            :form-id ="0"
            :permissions="permissions"
            @closeTriggered="closeRealEstateModal">

        </real-estate-agent-form>
        <document-generator></document-generator>
    </div>
</template>

<script>
import DocumentGenerator from '../../GlobalComponents/DocumentGenerator.vue';
import EmployeeForm from '../../Masters/Employees/EmployeeForm.vue';
import RealEstateAgentForm from '../../Masters/RealEstateAgents/RealEstateAgentForm.vue';
import EmployeeSelect from '../../SelectComponents/EmployeeSelect.vue';


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
export default

{
  components: { EmployeeForm, EmployeeSelect, RealEstateAgentForm, DocumentGenerator },
    props:{
        formId:{
            default:0,
            type:[String,Number]
        },
        categories:{
            default:function(){
                return [];
            },
            type:[Array]
        },
        permissions:{
            type:Object,
            default:function(){
                return null;
            }
        },
        form:{
            type:Object,
            default:function(){
                return getNewForm();
            }
        }
    },
    data:function(){
        return {
            create_url:'file-openings',
            base_url:Munshi.base_url,
            type:'',
            formOpen:false,
            show:true,
            lawClerkInitials:[],
            lawClerkSelected:[],
            solicitorInitials:[],
            solicitorSelected:[],
            realEstateAgentInitials:[],
            realEstateAgentSelected:[],
            showRealEstate:false
        }
    },
    mounted(){
        var self = this;
        this.form.rate = this.getFileRate();
        if(this.formId >0){
            this.editFileOpening();
        }
        window.onbeforeunload = function (event) {
            var is_dirty = self.form.isDirty();
            if(is_dirty){
                return "You currently have unsaved changes!!";
                return "<h6>You currently have unsaved changes!!!\n\nAre you sure you want to exit without saving.\n\nChoose ‘Leave this Tab’ to exit without saving changes.\nChoose ‘Stay on this Tab’ to return.</h6>";
            }
        }
        window.addEventListener("keydown", this.submitFormByEnter, true);
    },

    beforeDestroy(){
        window.removeEventListener("keydown", this.submitFormByEnter, true);
    },

    methods:{
        isComponentDirty:function(){
            return this.form.isDirty();
        },

        submitForm:function(){
            var self = this;
            Utilities.showConfirmationPopMessage('Do you want to save the changes?',function(save){
                if(save == true){
                    self.form['postForm'](self.base_url+'/'+self.create_url)
                    .then(function(response){
                        if(response.success){
                            var file_opening = response.file_opening;
                            self.form.copyData = JSON.parse(JSON.stringify(self.form.data()));
                            Utilities.showToast(self,'success','File Opening updated successfully',2200,true);
                            window.location = self.base_url+'/file-page?file_opening_id='+file_opening.id;
                            self.$emit('closeTriggered',file_opening);
                        }
                    })
                    .catch(function(error){
                        console.log(error);
                    });
                }
            },true,false);

        },


        submitFormByEnter:function(e){
            if(e.key == 'Enter')  {
                e.preventDefault();
                this.submitForm();
            }
        },

        resetForm:function(){
            $('.cover_modal').modal('hide');
            this.$emit('closeTriggered');
        },

        resetEmployeeForm:function(){
            this.type = '';
            this.formOpen = false;

        },

        getFileRate() {
            var self = this;
            axios.get(Munshi.base_url+'/file-rate')
                .then(function(response) {
                    console.log(response.data);
                    if(response.data.success) {
                        self.form.rate = response.data.rate;
                    }
                })
                .catch(function(error) {
                    console.log(error);
                })
        },

        editFileOpening:function(){
            var self = this;
            self.show = false;
            axios.get(this.base_url+'/'+this.create_url+'/'+this.formId+'/edit')
            .then(function(response){
                if(response.data.success){
                    var file_opening = response.data.file_opening;

                    // console.log("file_opening");
                    // console.log(file_opening);

                    Utilities.copyProperties(file_opening, self.form);
                    self.form.form_id = file_opening.id;
                    if(file_opening.law_clerk){
                        var first_name = file_opening.law_clerk.first_name ? file_opening.law_clerk.first_name : '';
                        var middle_name = file_opening.law_clerk.middle_name ? file_opening.law_clerk.middle_name : '';
                        var last_name = file_opening.law_clerk.last_name ? file_opening.law_clerk.last_name : '';
                        var name = first_name +' '+ middle_name + ' ' +last_name;
                        self.lawClerkInitials = [{'id':file_opening.law_clerk.id,'text':name}];
                        self.lawClerkSelected = [file_opening.law_clerk_id];
                    }
                    if(file_opening.solicitor){
                        var first_name = file_opening.solicitor.first_name ? file_opening.solicitor.first_name : '';
                        var middle_name = file_opening.solicitor.middle_name ? file_opening.solicitor.middle_name : '';
                        var last_name = file_opening.solicitor.last_name ? file_opening.solicitor.last_name : '';
                        var name = first_name +' '+ middle_name + ' ' +last_name;
                        self.solicitorInitials = [{'id':file_opening.solicitor.id,'text':name}];
                        self.solicitorSelected = [file_opening.solicitor_id];
                    }
                    if(file_opening.real_estate_agent){
                        var first_name = file_opening.real_estate_agent.first_name ? file_opening.real_estate_agent.first_name : '';
                        var middle_name = file_opening.real_estate_agent.middle_name ? file_opening.real_estate_agent.middle_name : '';
                        var last_name = file_opening.real_estate_agent.last_name ? file_opening.real_estate_agent.last_name : '';
                        var name = first_name +' '+ middle_name + ' ' +last_name;
                        self.form.agent_work_phone = file_opening.real_estate_agent.work_phone;
                        self.realEstateAgentInitials = [{'id':file_opening.real_estate_agent.id,'text':name}];
                        self.realEstateAgentSelected = [file_opening.real_estate_agent_id];
                    }
                    self.show = true;
                    self.form.copyData = JSON.parse(JSON.stringify(self.form.data()));
                }
            })
            .catch(function(error){
                console.log(error);
            });
        },
        addEmployee:function(type){
            this.type = type;
            this.formOpen = true;
        },

         ShowRealEstateModal:function(){
            this.showRealEstate = true;
        },
        closeRealEstateModal:function(){
            this.showRealEstate = false;
        },
        updateRealEstateAgent:function(id,index,agent){
            var self = this;
            console.log('agent');
            self.form.agent_work_phone = agent.work_phone;

        },

        checkUnsavedAndShowMessage:function(){
            var self = this;
            var is_dirty = self.form.isDirty();
            if(is_dirty){
                 Utilities.showConfirmationPopMessage('<h6>You currently have unsaved changes!!!\n\nAre you sure you want to exit without saving.\n\nChoose ‘Leave this Tab’ to exit without saving changes.\nChoose ‘Stay on this Tab’ to return.</h6>',function(save){
                    if(save == false){
                        self.resetForm();
                        return true;
                    }
                 },true,false,'Stay on this Tab','Leave this Tab');
            }
            else{
                self.resetForm();
                return false;
            }

        }
    }
}
</script>

<style>


</style>
