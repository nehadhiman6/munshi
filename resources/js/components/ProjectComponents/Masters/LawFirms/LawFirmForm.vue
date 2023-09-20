<template>
<div>
    <modal-cover  @closeModal="checkUnsavedAndShowMessage"  :modal-hide="false" modal_size="modal-lg" modal-class="law_firm_modal">
      <!-- MODAL BODY -->
        <div slot="modal-title">
            <span v-if="form.form_id == 0">Add Firm</span>
            <span v-if="form.form_id > 0">Edit Firm</span>
        </div>
        <div slot="modal-cover-body">
            <div class="form-horizontal">
                <div class="card-body">
                    <div class = "form-row">
                        <div class="col">
                            <div class="form-group">
                            <label for="firm_name" class="in-label-title required">Firm Name</label>
                            <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('firm_name') }" type="text" v-model ="form.firm_name">
                            <span id="basic-msg" v-if="form.errors.get('firm_name')" class="invalid-feedback">{{ form.errors.get('firm_name') }}</span>
                            </div>
                        </div>
                    </div>
                    <fieldset class="fieldset">
                        <legend>Address</legend>
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
                                         <city-select  v-if="show" :initials="initialCity"  @updateCity="updateCity" :selected="selectedCity"  v-bind:class="{ 'is-invalid': form.errors.get('city_id') }" type="text" v-model ="form.address.city_id"></city-select>
                                    </div>
                                    <div class="input-group-append"  v-if="permissions['cities-modify'] == 'cities-modify'">
                                        <button class="btn btn-primary" @click.prevent="addCity()" style="width:100px">Add New</button>
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
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('country') }" disabled type="text" v-model ="form.address.country">
                                <span id="basic-msg" v-if="form.errors.get('country')" class="invalid-feedback">{{ form.errors.get('country') }}</span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                <label for="postal_code" class="in-label-title ">Postal Code</label>
                                <input class="form-control"  v-bind:class="{ 'is-invalid': form.errors.get('postal_code') }" type="text" v-model ="form.address.postal_code" @input="postalCode('postal_code',$event.target.value)">
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
        </div>
    </modal-cover>
        <city-form v-if="showCity"
                @closeTriggered="closeCityModal"
            >
        </city-form>
    </div>
</template>

<script>
import CityForm from '../City/CityForm.vue';
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
        firm_name:'',
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
            default:null,
            type:Object
        }
    },
    data:function(){
        return {
            form:getNewForm(),
            create_url:'law-firms',
            base_url:Munshi.base_url,
             initialCity:[],
            selectedCity:[],
            show:true,
            showCity:false
        }
    },
    mounted(){
        if(this.formId >0){
            this.editEmployee();
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
                            Utilities.showToast(self,'success','Solicitor updated successfully',2200,true);
                            $('.law_firm_modal').modal('hide');
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
            $('.law_firm_modal').modal('hide');
            this.$emit('closeTriggered');
        },

        editEmployee:function(){
            var self = this;
            self.show = false;
            axios.get(this.base_url+'/'+this.create_url+'/'+this.formId+'/edit')
            .then(function(response){
                if(response.data.success){
                    var law_firm = response.data.law_firm;
                    Utilities.copyProperties(law_firm, self.form);
                    self.form.form_id = law_firm.id;
                    if(self.form.address == null){
                        self.form.address = getAddress();
                    }
                    if(law_firm.address && law_firm.address.city){
                        var city = law_firm.address.city;
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
        // acceptNumber(field) {
        //     var x = this.form[field].replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
        //     console.log(x);
        //     this.form[field] = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
        // },

        postalCode(field,input_value){
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
