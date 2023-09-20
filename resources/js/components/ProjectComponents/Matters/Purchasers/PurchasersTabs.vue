<template>
    <div>
        <div class=" card-header d-flex flex-wrap align-items-center justify-content-between  py-1">
            <div class="card-title mb-0"><span><strong>Purchasers</strong></span></div>
            <div class ="float-right">
                <input class="btn iw-btn iw-btn-submit py-1" :value="form.form_id > 0 ? 'Update' : 'Save'" @click.prevent ="submitForm" type="submit">
            </div>
        </div>
        <div class="card-body">
        <div class="iw-horizontal-tabs">
            <nav>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item"  v-for="(purchaser,index) in form.purchasers" :key="purchaser.random">
                        <a class="nav-link" :class="{'active':index == 0}" :id="'purchaser-tab_'+index" data-toggle="tab"  :href="'#purchaser'+index" role="tab" :aria-controls="'purchaser-tab_'+index" :aria-selected="index == 0">
                            <span v-text="purchaser.first_name ? purchaser.first_name :'purchaser '+getNumber(index)"></span>
                            <span class="iw-close-tab" @click.prevent="removePurchaser"><i class="mdi mdi-close"></i></span>
                        </a>
                    </li>
                    <li v-if="form.purchasers.length < 6">
                        <a class="nav-link"  @click.prevent="addPurchaser" href="#">+ Add Purchaser </a>
                    </li>
                </ul>
             </nav>
            <div class="tab-content" id="myTabContent">
                <purchaser-tab v-for="(purchaser,index) in form.purchasers" :key="purchaser.random"
                    :form="form"
                    :purchaser="purchaser"
                    :index="index"
                    :random='purchaser.random'
                    :permissions='permissions'
                    @removePurchaser="removePurchaser">
                </purchaser-tab>
            </div>
        </div>


        <fieldset class="fieldset form-horizontal">
            <legend class="legend">
                Solicitors & Law Clerk
            </legend>
            <div class = "form-row">
                <div class="col">
                    <div class="form-group">
                        <label for="solicitor_id" class="in-label-title ">Solicitor</label>
                        <div class="input-group flex-nowrap mb-3">
                            <div class="w-100">
                                <solicitor-select @updateSolicitor="updateSolicitor" :index="random"  v-if="show" v-model="form.purchaser_solicitor.solicitor_id" :initials="solicitorInitials" :selected="solicitorSelected" type="solicitor"></solicitor-select>
                            </div>
                            <div class="input-group-append"  v-if="permissions['solicitor-modify'] =='solicitor-modify'">
                                <button class="btn iw-add-new-btn" @click.prevent="addSolicitor()"><span class="mdi mdi-plus"></span></button>
                            </div>
                        </div>
                         <span id="basic-msg" v-if="form.errors.get('solicitor_id')" class="invalid-feedback">{{ form.errors.get('solicitor_id') }}</span>
                    </div>
                </div>
                <div class="col">
                    <label for="solicitor_email" class="in-label-title ">Solicitor Email</label>
                    <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('purchaser_solicitor.solicitor_email') }" type="text" v-model ="form.purchaser_solicitor.solicitor_email">
                    <span id="basic-msg" v-if="form.errors.get('purchaser_solicitor.solicitor_email')" class="invalid-feedback">{{ form.errors.get('purchaser_solicitor.solicitor_email') }}</span>
                </div>
            </div>
            <div class = "form-row">
                  <div class="col">
                    <div class="form-group" v-bind:class="{ 'is-invalid': form.errors.get('purchaser_solicitor.law_firm_id') }">
                        <label for="solicitor_id" class="in-label-title ">Law Firm</label>
                        <div class="input-group flex-nowrap mb-3">
                            <div class="w-100">
                                <law-firm-select :index="random"    v-model ="form.purchaser_solicitor.law_firm_id" :initials="lawFirmInitials" :selected="lawFirmSelected"  v-if="lawFirm" @updateLawFirm="updateLawFirm"></law-firm-select>
                            </div>
                            <div class="input-group-append" v-if="permissions['law-firms-modify'] =='law-firms-modify'">
                                <button class="btn iw-add-new-btn" @click.prevent="addLawFirm()"><span class="mdi mdi-plus"></span></button>
                            </div>
                        </div>
                        <span id="basic-msg" v-if="form.errors.get('purchaser_solicitor.law_firm_id')" class="invalid-feedback">{{ form.errors.get('purchaser_solicitor.law_firm_id') }}</span>
                    </div>
                  </div>
                <!-- <div class="col" v-bind:class="{ 'is-invalid': form.errors.get('purchaser_solicitor.law_firm_id') }"> -->
                    <!-- <label for="law_firm_id" class="in-label-title ">Law Firm</label> -->
                    <!-- <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('purchaser_solicitor.law_firm_id') }" type="text" v-model ="form.purchaser_solicitor.law_firm_id"> -->


                    <!-- <law-firm-select :index="random"    v-model ="form.purchaser_solicitor.law_firm_id" :initials="lawFirmInitials" :selected="lawFirmSelected"  v-if="lawFirm" @updateLawFirm="updateLawFirm"></law-firm-select> -->
                    <!-- <span id="basic-msg" v-if="form.errors.get('purchaser_solicitor.law_firm_id')" class="invalid-feedback">{{ form.errors.get('purchaser_solicitor.law_firm_id') }}</span> -->
                <!-- </div> -->
                    <div class="col" v-bind:class="{ 'is-invalid': form.errors.get('purchaser_solicitor.law_firm_address') }">
                    <label for="law_firm_address" class="in-label-title ">Law Firm Address</label>
                    <textarea class="form-control" disabled v-bind:class="{ 'is-invalid': form.errors.get('law_firm_address') }" v-model ="form.purchaser_solicitor.law_firm_address"><textarea></textarea>
                    <span id="basic-msg" v-if="form.errors.get('purchaser_solicitor.law_firm_address')" class="invalid-feedback">{{ form.errors.get('purchaser_solicitor.law_firm_address') }}</span>
                </div>
            </div>
                <div class = "form-row">
                <div class="col" v-bind:class="{ 'is-invalid': form.errors.get('purchaser_solicitor.law_clerk_id') }">
                    <label for="law_clerk_id" class="in-label-title ">Law Clerk Name</label>
                    <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('purchaser_solicitor.law_clerk_name') }" type="text" v-model ="form.purchaser_solicitor.law_clerk_name">


                    <!-- <employee-select :index="random"   v-if="show" v-model="form.purchaser_solicitor.law_clerk_id"  :initials="lawClerkInitials" :selected="lawClerkSelected"  type="law_clerk"></employee-select> -->
                    <span id="basic-msg" v-if="form.errors.get('purchaser_solicitor.law_clerk_id')" class="invalid-feedback">{{ form.errors.get('purchaser_solicitor.law_clerk_id') }}</span>
                </div>
                <div class="col"  v-bind:class="{ 'is-invalid': form.errors.get('purchaser_solicitor.file_number') }">
                    <label for="file_number" class="in-label-title ">File Number</label>
                    <input class="form-control" tyepe="text" v-bind:class="{ 'is-invalid': form.errors.get('file_number') }" v-model ="form.purchaser_solicitor.file_number">
                    <span id="basic-msg" v-if="form.errors.get('purchaser_solicitor.file_number')" class="invalid-feedback">{{ form.errors.get('purchaser_solicitor.file_number') }}</span>
                </div>
            </div>
             <div class = "form-row">
                <div class="col"  v-bind:class="{ 'is-invalid': form.errors.get('purchaser_solicitor.phone') }">
                    <label for="phone" class="in-label-title ">Phone</label>
                    <input class="form-control"  @input="acceptNumber('phone')"  v-bind:class="{ 'is-invalid': form.errors.get('phone') }" type="text" v-model ="form.purchaser_solicitor.phone">
                    <span id="basic-msg" v-if="form.errors.get('purchaser_solicitor.phone')" class="invalid-feedback">{{ form.errors.get('purchaser_solicitor.phone') }}</span>
                </div>
                <div class="col"  v-bind:class="{ 'is-invalid': form.errors.get('purchaser_solicitor.fax') }">
                    <label for="fax" class="in-label-title ">Fax</label>
                    <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('fax') }"   @input="acceptNumber('fax')" type="text" v-model ="form.purchaser_solicitor.fax">
                    <span id="basic-msg" v-if="form.errors.get('purchaser_solicitor.fax')" class="invalid-feedback">{{ form.errors.get('purchaser_solicitor.fax') }}</span>
                </div>
                    <!-- <div class="col" v-bind:class="{ 'is-invalid': form.errors.get('purchaser_solicitor.email') }">
                    <label for="email" class="in-label-title ">Business Address</label>
                    <input type="text" class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('email') }" v-model ="form.purchaser_solicitor.email">
                    <span id="basic-msg" v-if="form.errors.get('purchaser_solicitor.email')" class="invalid-feedback">{{ form.errors.get('purchaser_solicitor.email') }}</span> -->
                <!-- </div> -->
            </div>

        </fieldset>

         <solicitor-form v-if="showSolicitor"
                :permissions='permissions'
                :form-id ="0"
                @closeTriggered="closeSolicitorModal"
            >
            </solicitor-form>
            <law-firm-form v-if="showLawFirm"
                  :permissions='permissions'
                :form-id ="0"
                @closeTriggered="closeLawFirm">
            </law-firm-form>
        <div class ="mt-4">
            <input class="btn iw-btn iw-btn-submit" :value="form.form_id > 0 ? 'Update' : 'Save'" @click.prevent ="submitForm" type="submit">
        </div>
    </div>
    </div>
</template>

<script>
import PurchaserTab from './PurchaserTab.vue';
import EmployeeSelect from '../../SelectComponents/EmployeeSelect.vue';
import SolicitorSelect from '../../SelectComponents/SolicitorSelect.vue';
import LawFirmSelect from '../../SelectComponents/LawFirmSelect.vue';
import SolicitorForm from '../../Masters/Solicitors/SolicitorForm.vue';
import LawFirmForm from '../../Masters/LawFirms/LawFirmForm.vue';
function getNewForm(){
    return new Form({
        purchasers:[],
        purchaser_solicitor:getPurchaseSolicitor(),
        file_opening_id:0,
    })
}

function getPurchaseSolicitor(file_opening_id=0){
    return{
        id:0,
        file_opening_id:file_opening_id,
        solicitor_id:"",
        solicitor_email:"",
        law_firm_id:"",
        law_firm_address:"",
        law_clerk_id:"",
        law_clerk_name:'',
        file_number:"",
        phone:"",
        fax:"",
        email:"",
        random:Utilities.getRandomNumber(),
    }
}

function addPurchaser(file_opening_id=0){
    return{
        id:0,
        file_opening_id:file_opening_id,
        salutation:'',
        company_name:'',
        first_name:"",
        middle_name:"",
        last_name:"",
        dob:"",
        title_capacity:"",
        other_title_capacity:'',
        random:Utilities.getRandomNumber(),
    }
}
export default {
  components: { PurchaserTab,EmployeeSelect, SolicitorSelect, LawFirmSelect, SolicitorForm, LawFirmForm},
    props:['file_opening_id','permissions'],
    data:function(){
        return {
            form:getNewForm(),
            create_url:'purchasers',
            base_url:Munshi.base_url,
            show:true,
            lawClerkInitials:[],
            lawClerkSelected:[],
            solicitorInitials:[],
            solicitorSelected:[],
            lawFirmInitials:[],
            lawFirmSelected:[],
            lawFirm:true,
            showSolicitor:false,
            showLawFirm:false,
            random:Utilities.getRandomNumber()
        }
    },
    mounted:function(){
        this.getPurchasers();
        var self = this;
        window.onbeforeunload = function (event) {
           var is_dirty = self.form.isDirty();
            if(is_dirty){
                return "You currently have unsaved changes!!";
                return "<h6>You currently have unsaved changes!!!\n\nAre you sure you want to exit without saving.\n\nChoose ‘Leave this Tab’ to exit without saving changes.\nChoose ‘Stay on this Tab’ to return.</h6>";
            }

        }
    },
     methods:{
        isComponentDirty:function(){
            return this.form.isDirty();
        },

        getPurchasers:function(){
            var self = this;
            self.show=false;
            self.lawFirm=false;
            axios.get(this.base_url+'/file-page/'+this.file_opening_id)
            .then(function(response){
                if(response.data.success){
                    var purchasers = response.data.file_opening.purchasers;
                    var purchaser_solicitor = response.data.file_opening.purchaser_solicitor;
                    console.log(purchaser_solicitor);
                    self.form =getNewForm();
                    if(purchasers.length > 0 ){
                        self.form =getNewForm();
                        purchasers.forEach(element => {
                            var purchaser= addPurchaser(self.file_opening_id);
                            Utilities.copyProperties(element,purchaser);
                            self.form.purchasers.push(purchaser);

                        });
                    }
                    else{
                        self.form.purchasers.push(addPurchaser(self.file_opening_id));
                    }
                    self.form.file_opening_id = self.file_opening_id;
                    self.form.purchaser_solicitor.file_opening_id = self.file_opening_id;
                    Utilities.copyProperties(purchaser_solicitor,self.form.purchaser_solicitor);
                    if(purchaser_solicitor && purchaser_solicitor.law_clerk){
                        var first_name = purchaser_solicitor.law_clerk.first_name ? purchaser_solicitor.law_clerk.first_name : '';
                        var middle_name = purchaser_solicitor.law_clerk.middle_name ? purchaser_solicitor.law_clerk.middle_name : '';
                        var last_name = purchaser_solicitor.law_clerk.last_name ? purchaser_solicitor.law_clerk.last_name : '';
                        var name = first_name +' '+ middle_name + ' ' +last_name;
                        self.lawClerkInitials = [{'id':purchaser_solicitor.law_clerk.id,'text':name}];
                        self.lawClerkSelected = [purchaser_solicitor.law_clerk_id];
                    }
                    if(purchaser_solicitor && purchaser_solicitor.solicitor){
                        var first_name = purchaser_solicitor.solicitor.first_name ? purchaser_solicitor.solicitor.first_name : '';
                        var middle_name = purchaser_solicitor.solicitor.middle_name ? purchaser_solicitor.solicitor.middle_name : '';
                        var last_name = purchaser_solicitor.solicitor.last_name ? purchaser_solicitor.solicitor.last_name : '';
                        var name = first_name +' '+ middle_name + ' ' +last_name;
                        self.solicitorInitials = [{'id':purchaser_solicitor.solicitor.id,'text':name}];
                        self.solicitorSelected = [purchaser_solicitor.solicitor_id];
                    }

                    if(purchaser_solicitor && purchaser_solicitor.law_firm){
                        //   self.form.purchaser_solicitor.law_firm_name = purchaser_solicitor.law_firm_name;
                        self.lawFirmInitials = [{'id':purchaser_solicitor.law_firm.id,'text':purchaser_solicitor.law_firm.firm_name}];
                        self.lawFirmSelected = [purchaser_solicitor.law_firm.id];
                    }
                    self.show = true;
                    self.lawFirm = true;
                    self.form.copyData = JSON.parse(JSON.stringify(self.form.data()));

                }
            })
            .catch(function(error){
                console.log(error);
            });
        },
        addPurchaser:function(e){
            this.form.purchasers.push(addPurchaser(this.file_opening_id));
            var index = this.form.purchasers.length-1;
            setTimeout(function(){
                $('.nav-tabs a[href="#purchaser'+index+'"]').tab('show');
            },300);
        },
        getNumber:function(index){
            return  parseInt(index)+1;
        },
        submitForm:function(){
            var self = this;
            Utilities.showConfirmationPopMessage('Do you want to save the changes?',function(save){
                if(save == true){
                    self.form['postForm'](self.base_url+'/'+self.create_url)
                    .then(function(response){
                        if(response.success){
                            self.form.copyData = JSON.parse(JSON.stringify(self.form.data()));
                            Utilities.showToast(self,'success','Purchasers updated successfully',2200,true);
                            self.$emit('closeTriggered');
                        }
                    })
                    .catch(function(error){
                        console.log(error);
                    });
                }
            },true,false);

        },

        removePurchaser:function(index){
            this.form.purchasers.splice(index,1);
            var active = 0;
            if(index > 0){
                active = index-1;
            }
            else if(this.form.purchasers.length>0){
                active = index+1;
            }
            setTimeout(function(){
                $('.nav-tabs a[href="#purchaser'+active+'"]').tab('show');
            },500);
        },

        acceptNumber(field) {
            // var x = this.form.purchaser_solicitor.phone.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
            // this.form.purchaser_solicitor.phone = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');

             var value =this.form.purchaser_solicitor[field].replace(/\D/g, "");
            if(value.length <= 10){
                var x =this.form.purchaser_solicitor[field].replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
               this.form.purchaser_solicitor[field] = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
            }
            if(value.length == 11){
                var x =this.form.purchaser_solicitor[field].replace(/\D/g, '').match(/(\d{1})(\d{3})(\d{3})(\d{4})/);
               this.form.purchaser_solicitor[field] = x[1] +   ' (' + x[2] + ') '+  x[3]+'-'+x[4];
            }
            if(value.length > 11){
                var x =this.form.purchaser_solicitor[field].replace(/\D/g, '').match(/(\d{2})(\d{3})(\d{3})(\d{4})/);
               this.form.purchaser_solicitor[field] = x[1] +   ' (' + x[2] + ') '+  x[3]+'-'+x[4];
            }
        },

        updateLawFirm:function(value,index,data){
            console.log(data);
            var str =  data.address.number ? data.address.number:'';
            str +=  data.address.street ? data.address.street +', ':'';
            str +=  data.address.country ? data.address.country+', ':'';
            str +=  data.address.postal_code ? data.address.postal_code +', ':'';
            str +=  data.address.province ? data.address.province :'';
            this.form.purchaser_solicitor.law_firm_address = str;
        },

        updateSolicitor:function(value,index,data){
            var self = this;
            axios.get(Munshi.base_url+'/solicitors/'+value)
            .then(function(response){
                console.log(response.data);
                    self.lawFirm = false;
                    self.form.purchaser_solicitor.law_firm_address = '';
                    self.lawFirmInitials = [];
                    self.lawFirmSelected = [];
                    self.form.purchaser_solicitor.solicitor_email='';
                if(response.data && response.data.solicitor ){
                    var solicitor =  response.data.solicitor;
                    // self.form.purchaser_solicitor.law_firm_name = response.data.solicitor.law_firm.firm_name;
                    if(response.data.solicitor.law_firm ){
                        self.lawFirmInitials = [{'id':solicitor.law_firm.id,'text':solicitor.law_firm.firm_name}];
                        self.lawFirmSelected = [solicitor.law_firm.id];
                        self.form.purchaser_solicitor.law_firm_address='';
                        self.form.purchaser_solicitor.law_firm_id = solicitor.law_firm.id;
                        if( solicitor.law_firm.address){
                            var address = solicitor.law_firm.address;
                            var str =  address.number ? address.number:'';
                            str +=  address.street ? address.street:'';
                            str+=', ';
                            str +=  address.country ? address.country:'';
                            str+=', ';
                            str +=  address.province ? address.province :'';
                            str+=', ';
                            str +=  address.postal_code ? address.postal_code :'';

                            self.form.purchaser_solicitor.law_firm_address = str;
                        }
                    }
                }
                    self.form.purchaser_solicitor.solicitor_email = solicitor.email? solicitor.email:'';
                    self.form.purchaser_solicitor.phone = solicitor.work_phone? solicitor.work_phone:'';
                    self.form.purchaser_solicitor.fax = solicitor.fax? solicitor.fax:'';
                   setTimeout(function(){
                       self.lawFirm = true;
                   },100);

            })
            .catch(function(error){
                console.log(error);
            })
        },
         addSolicitor:function(){
            this.showSolicitor = true;
        },
        closeSolicitorModal:function(){
            this.showSolicitor = false;
        },

        addLawFirm:function(){
            this.showLawFirm = true;
        },
        closeLawFirm:function(){
            this.showLawFirm = false;
        },


     }
}
</script>

<style>

</style>
