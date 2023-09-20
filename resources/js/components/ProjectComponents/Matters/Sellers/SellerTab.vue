<template>
     <div class="tab-pane fade" :class="{'show active':index == 0}" :id="'seller'+index"  role="tabpanel" :aria-labelledby="'seller-tab_'+index">
         <!-- <span class="iw-remove-btn"  @click.prevent="$emit('removeSeller',index)"><i class="ti ti-close"></i> Remove</span> -->
        <div class="form-horizontal">
                <div class="card-body">
                    <div class = "form-row">
                        <div class="col-md-3">
                            <div class="form-group">
                            <label for="first_name" class="in-label-title ">Salutation</label>
                            <select class="form-control" v-model="seller.salutation">
                                <option selected="selected" value="Mr.">Mr.</option>
                                <option value="Mrs.">Mrs.</option>
                                <option value="Miss">Miss</option>
                                <option value="Dr.">Dr.</option>
                                <option value="Corporation">Corporation</option>
                            </select>
                            <span id="basic-msg" v-if="form.errors.get('salutation')" class="invalid-feedback">{{ form.errors.get('salutation') }}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <label for="first_name" class="in-label-title ">First Name</label>
                            <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('sellers.'+index+'.first_name') }" type="text" v-model ="seller.first_name">
                            <span id="basic-msg" v-if="form.errors.get('sellers.'+index+'.first_name')" class="invalid-feedback">{{ form.errors.get('sellers.'+index+'.first_name') }}</span>
                            </div>
                        </div>
                         <div class="col-md-3">
                             <div class="form-group">
                            <label for="middle_name" class="in-label-title ">Middle Name</label>
                            <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('sellers.'+index+'.middle_name') }" type="text" v-model ="seller.middle_name">
                            <span id="basic-msg" v-if="form.errors.get('sellers.'+index+'.middle_name')" class="invalid-feedback">{{ form.errors.get('sellers.'+index+'.middle_name') }}</span>
                            </div>
                        </div>
                          <div class="col-md-3">
                              <div class="form-group">
                            <label for="last_name" class="in-label-title ">Last Name</label>
                            <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('sellers.'+index+'.last_name')  }" type="text" v-model ="seller.last_name">
                            <span id="basic-msg" v-if="form.errors.get('sellers.'+index+'.last_name')" class="invalid-feedback">{{ form.errors.get('sellers.'+index+'.last_name')}}</span>
                            </div>
                        </div>

                         <div class="col-md-3"  v-if="seller.salutation == 'Corporation'">
                             <div class="form-group">
                            <label for="company_name" class="in-label-title ">Company Name</label>
                            <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('sellers.'+index+'.company_name') }" type="text" v-model ="seller.company_name">
                            <span id="basic-msg" v-if="form.errors.get('sellers.'+index+'.company_name')" class="invalid-feedback">{{ form.errors.get('sellers.'+index+'.company_name') }}</span>
                            </div>
                        </div>
                          <div class="col-md-3"  v-if="seller.salutation == 'Corporation'">
                              <div class="form-group">
                            <label for="signing_officer_title" class="in-label-title ">Signing Officer and Title</label>
                            <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('sellers.'+index+'.signing_officer_title') }" type="text" v-model ="seller.signing_officer_title">
                            <span id="basic-msg" v-if="form.errors.get('sellers.'+index+'.signing_officer_title')" class="invalid-feedback">{{ form.errors.get('sellers.'+index+'.signing_officer_title') }}</span>
                            </div>
                        </div>
                        <div class="col-md-3" v-if="seller.salutation != 'Corporation' && seller.salutation != ''">
                            <div class="form-group">
                            <label for="marital_status" class="in-label-title ">Marital Status</label>
                           <select class="form-control" v-model="seller.marital_status"  v-bind:class="{ 'is-invalid': form.errors.get('sellers.'+index+'.marital_status') }" >
                                <option value="single">Single</option>
                                <option value="married">Married</option>
                                <option value="divorced">Divorced</option>
                                <option value="common_law">Common Law</option>

                            </select>
                            <span id="basic-msg" v-if="form.errors.get('sellers.'+index+'.marital_status')" class="invalid-feedback">{{ form.errors.get('sellers.'+index+'.marital_status') }}</span>
                            </div>
                        </div>
                         <div class="col-md-3" v-if="seller.marital_status == 'married'||seller.common_law == 'married' && seller.salutation != 'Corporation'">
                             <div class="form-group">
                            <label for="spouse_name" class="in-label-title ">Spouse Name</label>
                            <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('sellers.'+index+'.spouse_name') }" type="text" v-model ="seller.spouse_name">
                            <span id="basic-msg" v-if="form.errors.get('sellers.'+index+'.spouse_name') " class="invalid-feedback">{{ form.errors.get('sellers.'+index+'.spouse_name')  }}</span>
                            </div>
                        </div>
                         <div class="col-md-3">
                             <div class="form-group">
                            <label for="email" class="in-label-title ">Email</label>
                            <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('sellers.'+index+'.email')  }" type="text" v-model ="seller.email">
                            <span id="basic-msg" v-if="form.errors.get('sellers.'+index+'.email') " class="invalid-feedback">{{ form.errors.get('sellers.'+index+'.email')  }}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" >
                            <label for="phone" class="in-label-title ">Phone</label>
                            <input class="form-control"  @input="acceptNumber"  v-bind:class="{ 'is-invalid': form.errors.get('sellers.'+index+'.phone') }" type="text" v-model ="seller.phone">
                            <span id="basic-msg" v-if="form.errors.get('sellers.'+index+'.phone')" class="invalid-feedback">{{ form.errors.get('sellers.'+index+'.phone') }}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" >
                            <label for="occupation" class="in-label-title ">Occupation</label>
                            <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('sellers.'+index+'.occupation') }" type="text" v-model ="seller.occupation">
                            <span id="basic-msg" v-if="form.errors.get('sellers.'+index+'.occupation')" class="invalid-feedback">{{ form.errors.get('sellers.'+index+'.occupation') }}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" >
                            <label for="business_name" class="in-label-title ">Business Name</label>
                            <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('sellers.'+index+'.business_name') }" type="text" v-model ="seller.business_name">
                            <span id="basic-msg" v-if="form.errors.get('sellers.'+index+'.business_name')" class="invalid-feedback">{{ form.errors.get('sellers.'+index+'.business_name') }}</span>
                            </div>
                        </div>
                         <div class="col-md-3">
                            <div class="form-group" >
                            <label for="business_address" class="in-label-title ">Business Address</label>
                            <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('sellers.'+index+'.business_address') }" type="text" v-model ="seller.business_address">
                            <span id="basic-msg" v-if="form.errors.get('sellers.'+index+'.business_address')" class="invalid-feedback">{{ form.errors.get('sellers.'+index+'.business_address') }}</span>
                            </div>
                        </div>


                    </div>
                    <div class = "form-row">
                        <div class="form-check ml-2">
                            <input type="checkbox" class="form-check-input" true-value='Y'  false-value="N" v-model="seller.is_current_address_subject_property" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Please tick, if the seller is living in the subject property.</label>
                        </div>
                    </div>
                    <fieldset class="fieldset" v-if="seller.is_current_address_subject_property =='N'">
                        <legend> Current Address</legend>
                        <div class = "form-row">
                            <div class="col">
                                <div class="form-group">
                                <label for="number" class="in-label-title ">Number</label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('sellers.'+index+'.current_address.number') }" type="text" v-model ="seller.current_address.number">
                                <span id="basic-msg" v-if="form.errors.get('sellers.'+index+'.current_address.number')" class="invalid-feedback">{{ form.errors.get('sellers.'+index+'.current_address.number') }}</span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                <label for="street" class="in-label-title ">Street</label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('sellers.'+index+'.current_address.street') }" type="text" v-model ="seller.current_address.street">
                                <span id="basic-msg" v-if="form.errors.get('sellers.'+index+'.current_address.street')" class="invalid-feedback">{{ form.errors.get('sellers.'+index+'.current_address.number') }}</span>
                                </div>
                            </div>
                            <div class="col">

                                <div class="form-group"  v-bind:class="{ 'is-invalid': form.errors.get('sellers.'+index+'.current_address.city_id') }">
                                <label for="city_id" class="in-label-title ">City</label>
                                  <div class="input-group flex-nowrap mb-3">
                                        <div class="w-100">
                                            <city-select  v-if="show"  @updateCity="updateCurrentCity" :index="random+'_'+index+'_1'" :key="random+'_'+index+'_1'" :initials="initialCurrentCity" :selected="selectedCurrentCity"  v-bind:class="{ 'is-invalid': form.errors.get('city_id') }" type="text" v-model ="seller.current_address.city_id"></city-select>
                                        </div>
                                        <div class="input-group-append" v-if="permissions['cities-modify'] == 'cities-modify'">
                                            <button class="btn iw-add-new-btn" @click.prevent="addCity()" ><span class="mdi mdi-plus"></span></button>
                                        </div>
                                    </div>

                                <span id="basic-msg" v-if="form.errors.get('sellers.'+index+'.current_address.city_id')" class="invalid-feedback">{{ form.errors.get('sellers.'+index+'.current_address.city_id') }}</span>
                                </div>
                            </div>
                        </div>
                         <div class = "form-row">
                            <div class="col">
                                <div class="form-group">
                                <label for="province" class="in-label-title ">Province</label>
                                <input class="form-control" disabled v-bind:class="{ 'is-invalid': form.errors.get('sellers.'+index+'.current_address.province') }" type="text"  v-model ="seller.current_address.province">
                                <span id="basic-msg" v-if="form.errors.get('sellers.'+index+'.current_address.province')" class="invalid-feedback">{{ form.errors.get('sellers.'+index+'.current_address.province') }}</span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                <label for="country" class="in-label-title ">Country</label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('sellers.'+index+'.current_address.country') }" disabled type="text" v-model ="seller.current_address.country">
                                <span id="basic-msg" v-if="form.errors.get('sellers.'+index+'.current_address.country')" class="invalid-feedback">{{ form.errors.get('sellers.'+index+'.current_address.country') }}</span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                <label for="postal_code" class="in-label-title ">Postal Code</label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('sellers.'+index+'.current_address.postal_code') }" type="text" @input="postalCode('postal_code','current_address')" v-model ="seller.current_address.postal_code">
                                <span id="basic-msg" v-if="form.errors.get('sellers.'+index+'.current_address.postal_code')" class="invalid-feedback">{{ form.errors.get('sellers.'+index+'.current_address.postal_code') }}</span>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="fieldset" v-if="1 == 2">
                        <legend> Closing Address</legend>
                        <div class = "form-row">
                            <div class="col">
                                <div class="form-group">
                                <label for="number" class="in-label-title ">Number</label>
                                <input class="form-control" disabled v-bind:class="{ 'is-invalid': form.errors.get('sellers.'+index+'.closing_address.number') }" type="text" v-model ="seller.closing_address.number">
                                <span id="basic-msg" v-if="form.errors.get('sellers.'+index+'.closing_address.number')" class="invalid-feedback">{{ form.errors.get('sellers.'+index+'.closing_address.number') }}</span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                <label for="street" class="in-label-title ">Street</label>
                                <input class="form-control" disabled v-bind:class="{ 'is-invalid': form.errors.get('sellers.'+index+'.closing_address.street')  }" type="text" v-model ="seller.closing_address.street">
                                <span id="basic-msg" v-if="form.errors.get('sellers.'+index+'.closing_address.street') " class="invalid-feedback">{{ form.errors.get('sellers.'+index+'.closing_address.street')  }}</span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group" v-bind:class="{ 'is-invalid': form.errors.get('sellers.'+index+'.closing_address.city_id')  }" >
                                <label for="city_id" class="in-label-title ">City</label>
                                  <div class="input-group flex-nowrap mb-3">
                                        <div class="w-100">
                                             <city-select :disabled="true"  v-if="show"  @updateCity="updateClosingCity"  :key="random+'_'+index+'_2'" :index="random+'_'+index+'_2'"  :initials="initialClosingCity" :selected="selectedClosingCity"  v-bind:class="{ 'is-invalid': form.errors.get('city_id') }" type="text" v-model ="seller.closing_address.city_id"></city-select>
                                        </div>
                                        <div class="input-group-append" v-if="permissions['cities-modify'] == 'cities-modify'">
                                            <button class="btn iw-add-new-btn" @click.prevent="addCity()" ><span class="mdi mdi-plus"></span></button>
                                        </div>
                                    </div>

                                <span id="basic-msg" v-if="form.errors.get('sellers.'+index+'.closing_address.city_id') " class="invalid-feedback">{{ form.errors.get('sellers.'+index+'.closing_address.city_id')  }}</span>
                                </div>
                            </div>
                        </div>
                         <div class = "form-row">
                            <div class="col">
                                <div class="form-group"  >
                                <label for="province" class="in-label-title ">Province</label>
                                <input class="form-control"  disabled v-bind:class="{ 'is-invalid': form.errors.get('sellers.'+index+'.closing_address.province')  }" type="text"  v-model ="seller.closing_address.province">
                                <span id="basic-msg" v-if="form.errors.get('province')" class="invalid-feedback">{{ form.errors.get('province') }}</span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group" >
                                <label for="country" class="in-label-title ">Country</label>
                                <input class="form-control" disabled v-bind:class="{ 'is-invalid': form.errors.get('sellers.'+index+'.closing_address.country')  }"  type="text" v-model ="seller.closing_address.country">
                                <span id="basic-msg" v-if="form.errors.get('country')" class="invalid-feedback">{{ form.errors.get('country') }}</span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group"  >
                                <label for="postal_code" class="in-label-title ">Postal Code</label>
                                <input class="form-control" disabled v-bind:class="{ 'is-invalid': form.errors.get('sellers.'+index+'.closing_address.postal_code')  }"  @input="postalCode('postal_code','closing_address')" type="text" v-model ="seller.closing_address.postal_code">
                                <span id="basic-msg" v-if="form.errors.get('postal_code')" class="invalid-feedback">{{ form.errors.get('postal_code') }}</span>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="fieldset">
                        <legend> Seller Ids Details</legend>
                        <div class = "form-row">
                            <div class="col-md-3">
                                <div class="form-group" >
                                <label for="id_verified_by" class="in-label-title ">Id Verified By</label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('sellers.'+index+'.id_verified_by') }" type="text" v-model ="seller.id_verified_by">
                                <span id="basic-msg" v-if="form.errors.get('sellers.'+index+'.id_verified_by')" class="invalid-feedback">{{ form.errors.get('sellers.'+index+'.id_verified_by') }}</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group" v-bind:class="{ 'is-invalid': form.errors.get('sellers.'+index+'.meeting_date') }" >
                                <label for="meeting_date" class="in-label-title ">Meeting Date</label>
                                <date-picker v-model="seller.meeting_date" class-name="meeting_date"  yearsRange="-100:+50"></date-picker>
                                <span id="basic-msg" v-if="form.errors.get('sellers.'+index+'.meeting_date') " class="invalid-feedback">{{ form.errors.get('sellers.'+index+'.meeting_date')  }}</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"  v-bind:class="{ 'is-invalid': form.errors.get('sellers.'+index+'.file_review_date') }" >
                                <label for="file_review_date" class="in-label-title ">File Review Date</label>
                                <date-picker v-model="seller.file_review_date" class-name="file_review_date"  yearsRange="-100:+50"></date-picker>
                                <span id="basic-msg" v-if="form.errors.get('sellers.'+index+'.file_review_date') " class="invalid-feedback">{{ form.errors.get('sellers.'+index+'.file_review_date')  }}</span>
                                </div>
                            </div>
                        </div>
                        <seller-id v-for='(seller_id,ind) in seller.seller_ids' :key="seller_id.random"
                            :form = 'form'
                            :seller-index="index"
                            :seller_id = "seller_id"
                            :index="ind"
                        >
                        </seller-id>
                    </fieldset>
                </div>
                <city-form v-if="showCity"
                        @closeTriggered="closeCityModal"
                    >
                </city-form>
        </div>
    </div>
</template>

<script>
import CityForm from '../../Masters/City/CityForm.vue';
import SellerId from './SellerId.vue';
export default {
  components: { CityForm, SellerId },
    props:['seller','index','form','random','permissions'],
    data:function(){
        return {
            initialCurrentCity:[],
            selectedCurrentCity:[],
            initialClosingCity:[],
            selectedClosingCity:[],
            show:false,
            showCity:false
        }
    },
    mounted:function(){
        // if(this.seller.closing_address.city){
        //     this.initialClosingCity = [{'text':this.seller.closing_address.city.city_name,'id':this.seller.closing_address.city_id}];
        //     this.selectedClosingCity = [this.seller.closing_address.city_id];
        // }
        if(this.seller.current_address.city){
            this.initialCurrentCity = [{'text':this.seller.current_address.city.city_name,'id':this.seller.current_address.city_id}];
            this.selectedCurrentCity = [this.seller.current_address.city_id];
        }
        this.show = true;
    },
    methods:{
        getNumber:function(){
            return  parseInt(this.index)+1;
        },
        updateCurrentCity:function(value,index,city){
            this.seller.current_address.country = city.country;
            this.seller.current_address.province = city.state;
        },
        updateClosingCity:function(value,index,city){
            this.seller.closing_address.country = city.country;
            this.seller.closing_address.province = city.state;
        },
        addCity:function(){
            this.showCity = true;
        },
        closeCityModal:function(){
            this.showCity = false;
        },
        acceptNumber() {
            // var x = this.seller.phone.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
            // this.seller.phone = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');

             var value =this.seller.phone.replace(/\D/g, "");
            if(value.length <= 10){
                var x =this.seller.phone.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
               this.seller.phone = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
            }
            if(value.length == 11){
                var x =this.seller.phone.replace(/\D/g, '').match(/(\d{1})(\d{3})(\d{3})(\d{4})/);
               this.seller.phone = x[1] +   ' (' + x[2] + ') '+  x[3]+'-'+x[4];
            }
            if(value.length > 11){
                var x =this.seller.phone.replace(/\D/g, '').match(/(\d{2})(\d{3})(\d{3})(\d{4})/);
               this.seller.phone = x[1] +   ' (' + x[2] + ') '+  x[3]+'-'+x[4];
            }
        },

        postalCode(field,parent){
            this.seller[parent][field] =  this.seller[parent][field].toUpperCase();
            var str =  this.seller[parent][field];
            var matched = true;
            var x= '';
            switch(str.length) {
                case 1:
                    x = this.seller[parent][field].match(/[A-Z]/g);
                break;

                case 2:
                    x =this.seller[parent][field].match(/[A-Z][0-9]/g);
                break;

                case 3:
                    x = this.seller[parent][field].match(/[A-Z][0-9][A-Z]/g);
                break;

                case 4:
                    x = this.seller[parent][field].match(/[A-Z][0-9][A-Z][ ]/g);
                break;

                case 5:
                    x = this.seller[parent][field].match(/[A-Z][0-9][A-Z][ ][0-9]/g);
                break;

                case 6:
                    x =this.seller[parent][field].match(/[A-Z][0-9][A-Z][ ][0-9][A-Z]/g);
                break;

                case 7:
                    x =this.seller[parent][field].match(/[A-Z][0-9][A-Z][ ][0-9][A-Z][0-9]/g);
            }
            if(x== null){
                this.seller[parent][field]=  this.seller[parent][field].substring(0, this.seller[parent][field].length - 1);
                 if(str.length == 4){
                       this.seller[parent][field]= this.seller[parent][field]+ ' ';
                }

            }
            if(str.length == 3){
                 this.seller[parent][field] =  this.seller[parent][field]+' ';
            }
            if(str.length > 7 ){
                this.seller[parent][field]  = this.seller[parent][field].substring(0, 7);
            }
            // var x = this.form.address[field].match(/[A-Z][0-9][A-Z][ ][0-9][A-Z][0-9]/g);
        }
    }
}
</script>

<style>
.iw-remove-btn {
    display: table;
    margin: 10px;
    background: #f44336;
    color: #fff;
    padding: 5px 20px;
    margin-left: auto;
    cursor: pointer;
}

</style>
