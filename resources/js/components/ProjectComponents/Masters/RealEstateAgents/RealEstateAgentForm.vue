<template>
        <modal-cover @closeModal="checkUnsavedAndShowMessage()" modal_size="modal-lg" :modal-hide="false">
      <!-- MODAL BODY -->
            <div slot="modal-title">
                <span v-if="form.form_id == 0">Add Real Estate Agent</span>
                <span v-if="form.form_id > 0">Edit Real Estate Agent</span>
            </div>
            <div slot="modal-cover-body">
            <div class="form-horizontal">
                <div class="card-body">
                     <div class = "form-row">
                        <div class="col-md-2">
                            <div class="form-group">
                            <label for="is_active" class="in-label-title d-block required">Active</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" v-model="form.is_active" type="radio" name="inlineRadioOptionsactive" id="is_form_active" value="Y">
                                <label class="form-check-label" for="is_form_active">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" v-model="form.is_active" type="radio" :name="'inlineRadioOptionsactive'+random" id="is_form_active_no" value="N">
                                <label class="form-check-label" for="is_form_active_no">No</label>
                            </div>
                            <span id="basic-msg" v-if="form.errors.get('is_active')" class="invalid-feedback">{{ form.errors.get('is_active') }}</span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                            <label for="gender" class="in-label-title required">Gender</label>
                            <select class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('gender') }" v-model ="form.gender">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                            <span id="basic-msg" v-if="form.errors.get('gender')" class="invalid-feedback">{{ form.errors.get('gender') }}</span>
                            </div>
                        </div>

                    </div>
                    <div class = "form-row">
                        <div class="col">
                            <div class="form-group">
                            <label for="first_name" class="in-label-title required">First Name</label>
                            <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('first_name') }" type="text" v-model ="form.first_name">
                            <span id="basic-msg" v-if="form.errors.get('first_name')" class="invalid-feedback">{{ form.errors.get('first_name') }}</span>
                            </div>
                        </div>
                         <div class="col">
                             <div class="form-group">
                            <label for="middle_name" class="in-label-title ">Middle Name</label>
                            <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('middle_name') }" type="text" v-model ="form.middle_name">
                            <span id="basic-msg" v-if="form.errors.get('middle_name')" class="invalid-feedback">{{ form.errors.get('middle_name') }}</span>
                            </div>
                        </div>
                          <div class="col">
                              <div class="form-group">
                            <label for="last_name" class="in-label-title ">Last Name</label>
                            <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('last_name') }" type="text" v-model ="form.last_name">
                            <span id="basic-msg" v-if="form.errors.get('last_name')" class="invalid-feedback">{{ form.errors.get('last_name') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class = "form-row">

                         <div class="col">
                             <div class="form-group">
                            <label for="home_phone" class="in-label-title ">Home Phone</label>
                            <input class="form-control"  @input="acceptNumber('home_phone')" v-bind:class="{ 'is-invalid': form.errors.get('home_phone') }" type="text" v-model ="form.home_phone">
                            <span id="basic-msg" v-if="form.errors.get('home_phone')" class="invalid-feedback">{{ form.errors.get('home_phone') }}</span>
                            </div>
                        </div>
                         <div class="col">
                             <div class="form-group">
                            <label for="work_phone" class="in-label-title ">Work Phone</label>
                            <input class="form-control"  @input="acceptNumber('work_phone')" v-bind:class="{ 'is-invalid': form.errors.get('work_phone') }" type="text" v-model ="form.work_phone">
                            <span id="basic-msg" v-if="form.errors.get('work_phone')" class="invalid-feedback">{{ form.errors.get('work_phone') }}</span>
                            </div>
                        </div>
                        <div class="col">
                              <div class="form-group">
                            <label for="cell_phone" class="in-label-title ">Cell Phone</label>
                            <input class="form-control"  @input="acceptNumber('cell_phone')" v-bind:class="{ 'is-invalid': form.errors.get('cell_phone') }" type="text" v-model ="form.cell_phone">
                            <span id="basic-msg" v-if="form.errors.get('cell_phone')" class="invalid-feedback">{{ form.errors.get('cell_phone') }}</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                            <label for="fax" class="in-label-title ">Fax</label>
                            <input class="form-control"  @input="acceptNumber('fax')"  v-bind:class="{ 'is-invalid': form.errors.get('fax') }" type="text" v-model ="form.fax">
                            <span id="basic-msg" v-if="form.errors.get('fax')" class="invalid-feedback">{{ form.errors.get('fax') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class = "form-row">
                        <div class="col">
                            <div class="form-group">
                            <label for="email" class="in-label-title required">Email</label>
                            <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('email') }" type="text" v-model ="form.email">
                            <span id="basic-msg" v-if="form.errors.get('email')" class="invalid-feedback">{{ form.errors.get('email') }}</span>
                            </div>
                        </div>
                    </div>
                    <fieldset class="fieldset  mt-1">
                        <legend class="legend">Address</legend>
                        <div class = "form-row">
                            <div class="col">
                                <div class="form-group">
                                <label for="number" class="in-label-title ">Number</label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('number') }" type="text" v-model ="form.address.number">
                                <span id="basic-msg" v-if="form.errors.get('number')" class="invalid-feedback">{{ form.errors.get('number') }}</span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                <label for="street" class="in-label-title ">Street</label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('street') }" type="text" v-model ="form.address.street">
                                <span id="basic-msg" v-if="form.errors.get('street')" class="invalid-feedback">{{ form.errors.get('street') }}</span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                <label for="city_id" class="in-label-title ">City</label>
                                 <div class="input-group flex-nowrap mb-3">
                                    <div class="w-100">
                                        <city-select @updateCity="updateCity" v-if="show" :initials="initialCity" :selected="selectedCity"  v-bind:class="{ 'is-invalid': form.errors.get('city_id') }" type="text" v-model ="form.address.city_id"></city-select>
                                    </div>
                                    <div class="input-group-append" v-if="permissions['cities-modify'] == 'cities-modify'">
                                        <button class="btn iw-add-new-btn" @click.prevent="addCity()"><span class="mdi mdi-plus"></span></button>
                                    </div>
                                </div>

                                <span id="basic-msg" v-if="form.errors.get('city_id')" class="invalid-feedback">{{ form.errors.get('city_id') }}</span>
                                </div>
                            </div>
                        </div>
                         <div class = "form-row">
                            <div class="col">
                                <div class="form-group">
                                <label for="province" class="in-label-title ">Province</label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('province') }" type="text" disabled v-model ="form.address.province">
                                <span id="basic-msg" v-if="form.errors.get('province')" class="invalid-feedback">{{ form.errors.get('province') }}</span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                <label for="country" class="in-label-title ">Country</label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('country') }" disabled  type="text" v-model ="form.address.country">
                                <span id="basic-msg" v-if="form.errors.get('country')" class="invalid-feedback">{{ form.errors.get('country') }}</span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                <label for="postal_code" class="in-label-title ">Postal Code</label>
                                <input class="form-control" @input="postalCode('postal_code')" v-bind:class="{ 'is-invalid': form.errors.get('postal_code') }" type="text" v-model ="form.address.postal_code">
                                <span id="basic-msg" v-if="form.errors.get('postal_code')" class="invalid-feedback">{{ form.errors.get('postal_code') }}</span>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                     <div class ="mt-4">
                            <input class="btn iw-btn iw-btn-submit" :value="form.form_id > 0 ? 'Update' : 'Save'" @click.prevent ="submitForm" type="submit">
                            <input class="btn iw-btn iw-btn-cancel" value ="Cancel" @click.prevent ="checkUnsavedAndShowMessage" type="submit" >
                        </div>
                </div>
            </div>
                    <city-form v-if="showCity"
                        @closeTriggered="closeCityModal"
                    >
                </city-form>
            </div>
        </modal-cover>
</template>

<script>
import CityForm from "../City/CityForm.vue";

function getAddress(){
    return {
            type:'',
            number:'',
            street:'',
            city_id:'',
            country:'',
            postal_code:'',
            province:'',
            addressable_type:'',
            addressable_id:'',
        };
}
function getNewForm(){
    return new Form({
        form_id:0,
        is_active:'Y',
        first_name:'',
        middle_name:'',
        last_name:'',
        gender:'',
        fax:'',
        home_phone:'',
        work_phone:'',
        cell_phone:'',
        email:'',
        dirty:false,
        address:getAddress(),
    })
}
export default

  {
    components: { CityForm },
    props:{
        formId:{
            default:0,
            type:[String,Number]
        },
        type:{
            default:function(){
                return null;
            },
            type:[String]
        },
        permissions:{
            default:function(){
                return null;
            },
            type:[Object]
        }
    },

    data:function(){
        return {
            form:getNewForm(),
            create_url:'real-estate-agents',
            base_url:Munshi.base_url,
             initialCity:[],
            selectedCity:[],
            show:true,
            random:Utilities.getRandomNumber(),
            showCity:false,
        }
    },
    mounted(){
        var self = this;
        if(this.formId >0){
            this.editRealEstateAgent();
        }
        this.form.type=this.type;
         window.addEventListener("keydown", this.submitFormByEnter, true);

    },

    beforeDestroy(){
        window.removeEventListener("keydown", this.submitFormByEnter, true);
    },

    methods:{
        submitForm:function(){
            var self = this;
            Utilities.showConfirmationPopMessage('Do you want to save the changes?',function(save){
                if(save == true){
                    self.form['postForm'](self.base_url+'/'+self.create_url)
                    .then(function(response){
                        if(response.success){
                            self.form.dirty = false;
                            Utilities.showToast(self,'success','Real Estate Agent updated successfully',2200,true);
                            $('.cover_modal').modal('hide');
                            self.$emit('closeTriggered');
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

        editRealEstateAgent:function(){
            var self = this;
            self.show = false;
            axios.get(this.base_url+'/'+this.create_url+'/'+this.formId+'/edit')
            .then(function(response){
                if(response.data.success){
                    var real_estate_agent = response.data.real_estate_agent;
                    Utilities.copyProperties(real_estate_agent, self.form);
                    self.form.form_id = real_estate_agent.id;
                    if(self.form.address == null){
                        self.form.address = getAddress();
                    }
                    if(real_estate_agent.address && real_estate_agent.address.city){
                        var city = real_estate_agent.address.city;
                        self.initialCity = [{'text':city.city_name ,'id':city.id}];
                        self.selectedCity = [city.id];
                    }
                    self.show = true;
                    self.form.copyData = JSON.parse(JSON.stringify(self.form.data()));
                }
            })
            .catch(function(error){
                console.log(error);
            });
        },
        updateCity:function(value,index,city){
            this.form.address.country = city.country;
            this.form.address.province = city.state;
        },

          addCity:function(){
            this.showCity = true;
        },
        closeCityModal:function(){
            this.showCity = false;
        },

        acceptNumber(field) {
            var value = this.form[field].replace(/\D/g, "");
            if(value.length <= 10){
                var x = this.form[field].replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
                this.form[field] = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
            }
            if(value.length == 11){
                var x = this.form[field].replace(/\D/g, '').match(/(\d{1})(\d{3})(\d{3})(\d{4})/);
                this.form[field] = x[1] +   ' (' + x[2] + ') '+  x[3]+'-'+x[4];
            }
            if(value.length > 11){
                var x = this.form[field].replace(/\D/g, '').match(/(\d{2})(\d{3})(\d{3})(\d{4})/);
                this.form[field] = x[1] +   ' (' + x[2] + ') '+  x[3]+'-'+x[4];
            }
        },

        postalCode(field){
            this.form.address[field] =  this.form.address[field].toUpperCase();
            var str =  this.form.address[field];
            var matched = true;
            var x= '';
            switch(str.length) {
                case 1:
                    x = this.form.address[field].match(/[A-Z]/g);
                break;

                case 2:
                    x =this.form.address[field].match(/[A-Z][0-9]/g);
                break;

                case 3:
                    x = this.form.address[field].match(/[A-Z][0-9][A-Z]/g);
                break;

                case 4:
                    x = this.form.address[field].match(/[A-Z][0-9][A-Z][ ]/g);
                break;

                case 5:
                    x = this.form.address[field].match(/[A-Z][0-9][A-Z][ ][0-9]/g);
                break;

                case 6:
                    x =this.form.address[field].match(/[A-Z][0-9][A-Z][ ][0-9][A-Z]/g);
                break;

                case 7:
                    x =this.form.address[field].match(/[A-Z][0-9][A-Z][ ][0-9][A-Z][0-9]/g);
            }
            if(x== null){
                this.form.address[field]=  this.form.address[field].substring(0, this.form.address[field].length - 1);
                 if(str.length == 4){
                       this.form.address[field]= this.form.address[field]+ ' ';
                }

            }
             if(str.length == 3){
                 this.form.address[field] =  this.form.address[field]+' ';
            }
            if(str.length > 7 ){
                this.form.address[field]  = this.form.address[field].substring(0, 7);
            }
            // var x = this.form.address[field].match(/[A-Z][0-9][A-Z][ ][0-9][A-Z][0-9]/g);
        },
        checkUnsavedAndShowMessage:function(){
            var self = this;
            var is_dirty = self.form.isDirty();
            if(is_dirty){
                 Utilities.showConfirmationPopMessage('<h6>You currently have unsaved changes!!!\n\nAre you sure you want to exit without saving.\n\nChoose ‘Leave this page’ to exit without saving changes.\nChoose ‘Stay on this page’ to return.</h6>',function(save){
                    if(save == false){
                        self.$emit('closeTriggered');
                    }
                 },true,false,'Stay on this page','Leave this page');
            }
            else{
                self.$emit('closeTriggered');
            }

        }
    }
}
</script>

<style>

</style>
