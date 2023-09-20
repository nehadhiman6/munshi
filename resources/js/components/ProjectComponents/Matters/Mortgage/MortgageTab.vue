<template>
     <div class="tab-pane fade" :class="{'show active':index == 0}" :id="'mortgage'+index"  role="tabpanel" :aria-labelledby="'mortgage-tab_'+index">
         <!-- <span class="iw-remove-btn"  @click.prevent="$emit('removeSeller',index)"><i class="ti ti-close"></i> Remove</span> -->
        <div class="form-horizontal">
                <div class="card-body">
                    <div class = "form-row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="instrument_no" class="in-label-title ">Instrument number</label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('mortgages.'+index+'.instrument_no') }" type="text" v-model ="mortgage.instrument_no">
                                <span id="basic-msg" v-if="form.errors.get('mortgages.'+index+'.instrument_no')" class="invalid-feedback">{{ form.errors.get('mortgages.'+index+'.instrument_no') }}</span>
                            </div>
                        </div>
                         <div class="col-md-3">
                             <div class="form-group" v-bind:class="{ 'is-invalid': form.errors.get('mortgages.'+index+'.instrument_date') }">
                                <label for="instrument_date" class="in-label-title ">Instrument Date</label>
                                <date-picker v-model="mortgage.instrument_date" class-name="instrument_date"></date-picker>
                                <span id="basic-msg" v-if="form.errors.get('mortgages.'+index+'.instrument_date')" class="invalid-feedback">{{ form.errors.get('mortgages.'+index+'.instrument_date') }}</span>
                            </div>
                        </div>
                          <div class="col-md-3">
                            <div class="form-group">
                                <label for="instrument_type " class="in-label-title ">Instrument Type</label>
                                <select v-bind:class="{ 'is-invalid': form.errors.get('mortgages.'+index+'.instrument_type') }" v-model ="mortgage.instrument_type "  class="form-control">
                                    <option value='Charge'>Charge</option>
                                    <option value='Bridge-Loan'>Bridge-Loan</option>
                                    <option value='Postponement'>Postponement</option>
                                    <option value='Condo or construction Lien'>Condo or construction Lien</option>
                                    <option value='Notice'>Notice</option>
                                    <option value='Security Interest'>Security Interest</option>
                                    <option value='Other'>Other</option>
                                </select>
                                <span id="basic-msg" v-if="form.errors.get('mortgages.'+index+'.instrument_type')" class="invalid-feedback">{{ form.errors.get('mortgages.'+index+'.instrument_type') }}</span>
                            </div>
                        </div>
                         <div class="col-md-3">
                            <div class="form-group">
                                <label for="obtaining_discharge " class="in-label-title ">Obtaining Discharge</label>
                                <select v-bind:class="{ 'is-invalid': form.errors.get('mortgages.'+index+'.obtaining_discharge') }" v-model ="mortgage.obtaining_discharge"  class="form-control">
                                    <option value='Y'>Yes</option>
                                    <option value='N'>No</option>
                                </select>
                                <span id="basic-msg" v-if="form.errors.get('mortgages.'+index+'.obtaining_discharge')" class="invalid-feedback">{{ form.errors.get('mortgages.'+index+'.obtaining_discharge') }}</span>
                            </div>
                        </div>
                    </div>

                     <div class = "form-row">
                         <div class="col-md-3">
                            <div class="form-group">
                                <label for="mortgagee_reference_number" class="in-label-title ">Mortgage Reference Number</label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('mortgages.'+index+'.mortgagee_reference_number') }" type="text" v-model ="mortgage.mortgagee_reference_number">
                                <span id="basic-msg" v-if="form.errors.get('mortgages.'+index+'.mortgagee_reference_number')" class="invalid-feedback">{{ form.errors.get('mortgages.'+index+'.mortgagee_reference_number') }}</span>
                            </div>
                        </div>
                         <div class="col-md-3" >
                            <div class="form-group" >
                                <label for="closing_date" class="in-label-title">Closing Date</label>
                                <input class="form-control " disabled type="text" v-model ="closing_date">
                            </div>
                        </div>

                         <div class="col-md-3">
                            <div class="form-group">
                                <label for="principal_amount" class="in-label-title ">Principal Amount</label>
                                <!-- <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('mortgage.principal_amount') }" type="text" v-model ="mortgage.principal_amount"> -->
                                <currency-input  v-bind:class="{ 'is-invalid': form.errors.get('mortgages.'+index+'.principal_amount') }"  v-model="mortgage.principal_amount"></currency-input>
                                <span id="basic-msg" v-if="form.errors.get('mortgage.principal_amount')" class="invalid-feedback">{{ form.errors.get('mortgage.principal_amount') }}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="principal_amount" class="in-label-title ml-5 mt-4"> ${{mortgage.principal_amount}}.00
                                     </label>

                            </div>
                        </div>

                          <!-- <div class="col-md-3">
                            <div class="form-group">
                                <label for="closing_date" class="in-label-title">Closing Date</label>
                                <input class="form-control " disabled v-bind:class="{ 'is-invalid': form.errors.get('closing_date') }" type="text" v-model ="closing_date">
                            </div>
                        </div> -->

                     </div>
                    <div class="form-row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="per_diem" class="in-label-title ">Per Diem</label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('mortgages.'+index+'.per_diem') }" type="text" v-model ="mortgage.per_diem">
                                <span id="basic-msg" v-if="form.errors.get('mortgages.'+index+'.per_diem')" class="invalid-feedback">{{ form.errors.get('mortgages.'+index+'.per_diem') }}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <!-- <div class="form-group" v-bind:class="{ 'is-invalid': form.errors.get('mortgages.'+index+'.discharged_on') }" >
                                <label for="discharged_on" class="in-label-title ">Discharged On</label>
                                <date-picker class-name="discharged_on" v-model ="mortgage.discharged_on" ></date-picker>
                                <span id="basic-msg" v-if="form.errors.get('mortgages.'+index+'.discharged_on')" class="invalid-feedback">{{ form.errors.get('mortgages.'+index+'.discharged_on') }}</span>
                            </div> -->
                             <div class="form-group" v-bind:class="{ 'is-invalid': form.errors.get('mortgages.'+index+'.discharged_on') }"  >
                                <label for="mortgagee_id" class="in-label-title ">Discharged On</label>
                                <div class="input-group flex-nowrap mb-3"  >
                                    <div class="w-100">
                                        <date-picker class-name="discharged_on" v-model ="mortgage.discharged_on" ></date-picker>
                                        <span id="basic-msg" v-if="form.errors.get('mortgages.'+index+'.discharged_on')" class="invalid-feedback">{{ form.errors.get('mortgages.'+index+'.discharged_on') }}</span>
                                    </div>
                                    <div class="input-group-append"  >
                                        <button class="btn btn-primary" @click.prevent="addClosingDate()">Closing</button>
                                    </div>
                                </div>
                                   <span id="basic-msg" v-if="form.errors.get('mortgages.'+index+'.mortgagee_id')" class="invalid-feedback">{{ form.errors.get('mortgages.'+index+'.mortgagee_id') }}</span>
                            </div>
                        </div>

                          <div class="col-md-3">
                            <div class="form-group">
                                <label for="discharged_on" class="in-label-title mt-4">Days :{{extra_days}}</label>

                            </div>
                        </div>
                           <div class="col-md-3">
                            <div class="form-group">
                                <label for="extra_interest" class="in-label-title ">Extra Charge</label>
                                <input class="form-control" disabled v-bind:class="{ 'is-invalid': form.errors.get('mortgages.'+index+'.extra_interest') }" type="text" v-model ="extra_interest">
                                <span id="basic-msg" v-if="form.errors.get('mortgages.'+index+'.extra_interest')" class="invalid-feedback">{{ form.errors.get('mortgages.'+index+'.extra_interest') }}</span>
                            </div>
                        </div>


                    </div>
                    <fieldset class="fieldset">
                        <legend> Additional Charges</legend>
                        <mortgage-charge v-for="(charge,ind) in mortgage.additional_charges" :key="charge.random"
                            :ind='ind'
                            :index="index"
                            :charge='charge'
                            :form="form"
                            @removeCharges='removeCharges'>
                        </mortgage-charge>
                        <button class="btn btn-primary" @click.prevent='addCharges()'>Add</button>

                    </fieldset>
                      <div class = "form-row">
                        <div class="col-md-3 offset-9">
                            <div class="form-group">
                            <label for="total" class="in-label-title ">Total</label>
                            <currency-input v-bind:class="{ 'is-invalid': form.errors.get('mortgages.'+index+'.total') }" :disabled="true" v-model="total_charge"></currency-input>
                            <span id="basic-msg" v-if="form.errors.get('mortgages.'+index+'.total') " class="invalid-feedback">{{ form.errors.get('mortgages.'+index+'.total')  }}</span>
                            </div>
                        </div>

                    </div>
                     <!-- <div class="form-row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="total_mortgage_payable_discharge" class="in-label-title ">Total Mortgage Payable Discharge</label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('total_mortgage_payable_discharge') }" type="text" v-model ="mortgage.total_mortgage_payable_discharge">
                                <span id="basic-msg" v-if="form.errors.get('total_mortgage_payable_discharge')" class="invalid-feedback">{{ form.errors.get('total_mortgage_payable_discharge') }}</span>
                            </div>
                        </div>
                    </div> -->
                    <div class = "form-row">
                          <div class="col-md-3">
                            <div class="form-group" >
                                <label for="contact_id" class="in-label-title ">Contact</label>
                                <select class="form-control" v-model="mortgage.contact" @change="getContactAddress" v-bind:class="{ 'is-invalid': form.errors.get('mortgages.'+index+'.contact_id') }">
                                    <option value='solicitor'>Solicitor</option>
                                    <option value='mortgagee'>Mortgagee</option>
                                </select>

                                <span id="basic-msg" v-if="form.errors.get('mortgages.'+index+'.contact_id')" class="invalid-feedback">{{ form.errors.get('mortgages.'+index+'.contact_id') }}</span>
                            </div>
                        </div>
                          <div class="col-md-5">
                            <div class="form-group" v-bind:class="{ 'is-invalid': form.errors.get('mortgages.'+index+'.mortgagee_id') }">
                                <label for="mortgagee_id" class="in-label-title ">Mortgagee</label>
                                <div class="input-group flex-nowrap mb-3">
                                    <div class="w-100">
                                         <contact-select v-if="show" v-model="mortgage.mortgagee_id"  :index="random" :initials="initialContact" :selected="selectedContact" type="mortgagee"
                                       @updateContact="getContactAddress" ></contact-select>
                                    </div>
                                    <div class="input-group-append"  v-if="permissions['contacts-modify'] == 'contacts-modify'">
                                        <button class="btn iw-add-new-btn" @click.prevent="addMortgagee()"><span class="mdi mdi-plus"></span></button>
                                    </div>
                                </div>
                                   <span id="basic-msg" v-if="form.errors.get('mortgages.'+index+'.mortgagee_id')" class="invalid-feedback">{{ form.errors.get('mortgages.'+index+'.mortgagee_id') }}</span>
                            </div>
                          </div>

                         <div class="col-md-4">
                             <div class="form-group"  v-bind:class="{ 'is-invalid': form.errors.get('mortgages.'+index+'.solicitor_id') }">
                                <label for="solicitor_id" class="in-label-title ">Solicitor</label>
                                <div class="input-group flex-nowrap mb-3">
                                    <div class="w-100">
                                         <solicitor-select v-if="show" v-model="mortgage.solicitor_id" :initials="initialSolicitor" :selected="selectedSolicitor"
                                    type="solicitor" :index="mortgage.random" @updateSolicitor="getContactAddress"></solicitor-select>
                                    </div>
                                    <div class="input-group-append"  v-if="permissions['solicitor-modify'] =='solicitor-modify'">
                                        <button class="btn iw-add-new-btn" @click.prevent="addSolicitor()"><span class="mdi mdi-plus"></span></button>
                                    </div>
                                </div>
                                <span id="basic-msg" v-if="form.errors.get('mortgages.'+index+'.solicitor_id')" class="invalid-feedback">{{ form.errors.get('mortgages.'+index+'.solicitor_id') }}</span>
                            </div>
                        </div>
                    </div>
                           <fieldset class="fieldset">
                        <legend> Address</legend>
                        <div class = "form-row">
                            <div class="col">
                                <div class="form-group" v-bind:class="{ 'is-invalid': form.errors.get('mortgages.'+index+'.address.number') }">
                                <label for="number" class="in-label-title ">Number</label>
                                <input class="form-control" type="text" v-model ="mortgage.address.number">
                                <span id="basic-msg" v-if="form.errors.get('mortgage.address.number')" class="invalid-feedback">{{ form.errors.get('mortgage.address.number') }}</span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group"  v-bind:class="{ 'is-invalid': form.errors.get('mortgages.'+index+'.address.street') }">
                                <label for="street" class="in-label-title ">Street</label>
                                <input class="form-control"  type="text" v-model ="mortgage.address.street">
                                <span id="basic-msg" v-if="form.errors.get('mortgages.'+index+'.address.street')" class="invalid-feedback">{{ form.errors.get('mortgages.'+index+'.address.street') }}</span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group"  v-bind:class="{ 'is-invalid': form.errors.get('mortgages.'+index+'.address.city_id') }">
                                <label for="city_id" class="in-label-title ">City</label>
                                  <div class="input-group flex-nowrap mb-3">
                                        <div class="w-100">
                                            <city-select  v-if="city"  @updateCity="updateCity" :index="random+'_'+index+'_1'" :initials="initialCity" :selected="selectedCity"  v-bind:class="{ 'is-invalid': form.errors.get('city_id') }" type="text" v-model ="mortgage.address.city_id"></city-select>
                                        </div>
                                        <div class="input-group-append"  v-if="permissions['cities-modify'] == 'cities-modify'">
                                            <button class="btn iw-add-new-btn" @click.prevent="addCity()" ><span class="mdi mdi-plus"></span></button>
                                        </div>
                                    </div>

                                <span id="basic-msg" v-if="form.errors.get('mortgages.'+index+'.address.city_id')" class="invalid-feedback">{{ form.errors.get('mortgages.'+index+'.address.city_id') }}</span>
                                </div>
                            </div>
                        </div>
                         <div class = "form-row">
                            <div class="col">
                                <div class="form-group">
                                <label for="province" class="in-label-title ">Province</label>
                                <input class="form-control" disabled v-bind:class="{ 'is-invalid': form.errors.get('mortgages.'+index+'.address.province') }" type="text"  v-model ="mortgage.address.province">
                                <span id="basic-msg" v-if="form.errors.get('mortgages.'+index+'.address.province')" class="invalid-feedback">{{ form.errors.get('mortgages.'+index+'.address.province') }}</span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                <label for="country" class="in-label-title ">Country</label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('mortgages.'+index+'.address.country') }" disabled type="text" v-model ="mortgage.address.country">
                                <span id="basic-msg" v-if="form.errors.get('mortgages.'+index+'.address.country')" class="invalid-feedback">{{ form.errors.get('mortgages.'+index+'.address.country') }}</span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                <label for="postal_code" class="in-label-title ">Postal Code</label>
                                <input class="form-control" @input="postalCode('postal_code')" v-bind:class="{ 'is-invalid': form.errors.get('mortgages.'+index+'.address.postal_code')  }" type="text" v-model ="mortgage.address.postal_code">
                                <span id="basic-msg" v-if="form.errors.get('mortgages.'+index+'.address.postal_code') " class="invalid-feedback">{{ form.errors.get('mortgages.'+index+'.address.postal_code')  }}</span>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div class = "form-row">
                         <div class="col-md-3">
                            <div class="form-group">
                                <label for="phone" class="in-label-title ">Phone Number</label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('mortgages.'+index+'.phone')  }"  @input="acceptNumber('phone')" type="text" v-model ="mortgage.phone">
                                <span id="basic-msg" v-if="form.errors.get('mortgages.'+index+'.phone') " class="invalid-feedback">{{ form.errors.get('mortgages.'+index+'.phone')  }}</span>
                            </div>
                        </div>
                         <div class="col-md-3">
                            <div class="form-group">
                                <label for="fax" class="in-label-title ">Fax </label>
                                <input class="form-control" @input="acceptNumber('fax')" v-bind:class="{ 'is-invalid': form.errors.get('mortgages.'+index+'.address.fax') }" type="text" v-model ="mortgage.fax">
                                <span id="basic-msg" v-if="form.errors.get('mortgages.'+index+'.address.fax')" class="invalid-feedback">{{ form.errors.get('mortgages.'+index+'.address.fax') }}</span>
                            </div>
                        </div>
                         <div class="col-md-3">
                            <div class="form-group">
                                <label for="email" class="in-label-title ">Email</label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('mortgages.'+index+'.email') }" type="text" v-model ="mortgage.email">
                                <span id="basic-msg" v-if="form.errors.get('mortgages.'+index+'.email')" class="invalid-feedback">{{ form.errors.get('mortgages.'+index+'.email') }}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="attention" class="in-label-title ">Attention</label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('mortgages.'+index+'.attention') }" type="text" v-model ="mortgage.attention">
                                <span id="basic-msg" v-if="form.errors.get('mortgages.'+index+'.attention')" class="invalid-feedback">{{ form.errors.get('mortgages.'+index+'.attention') }}</span>
                            </div>
                        </div>
                    </div>


                    <div class = "form-row">
                         <div class="col-md-3">
                            <div class="form-group">
                                <label for="discharge_no" class="in-label-title ">Discharge Number</label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('mortgages.'+index+'.discharge_no') }" type="text" v-model ="mortgage.discharge_no">
                                <span id="basic-msg" v-if="form.errors.get('mortgages.'+index+'.discharge_no')" class="invalid-feedback">{{ form.errors.get('mortgages.'+index+'.discharge_no') }}</span>
                            </div>
                        </div>
                         <div class="col-md-3">
                            <div class="form-group" v-bind:class="{ 'is-invalid': form.errors.get('mortgages.'+index+'.discharge_date') }">
                                <label for="discharge_date" class="in-label-title " >Discharge Date </label>
                                <date-picker v-model="mortgage.discharge_date" class-name='discharge_date' yearsRange="-100:+100"></date-picker>
                                <span id="basic-msg" v-if="form.errors.get('mortgages.'+index+'.discharge_date')" class="invalid-feedback">{{ form.errors.get('mortgages.'+index+'.discharge_date') }}</span>
                            </div>
                        </div>
                    </div>

                </div>
                <city-form v-if="showCity"
                        @closeTriggered="closeCityModal"

                    >
                </city-form>
                <contact-form v-if="showMortgagee"
                :permissions="permissions"
                type='mortgagee'
                @closeTriggered="hideMortgageeModal">
                <div slot="title">
                    Add Mortgagee
                </div>
                </contact-form>

            <solicitor-form v-if="showSolicitor"
                :permissions='permissions'
                :form-id ="0"
                @closeTriggered="closeSolicitorModal"
            >
            </solicitor-form>
        </div>
    </div>
</template>

<script>
function getCharge(){
    return {
            id:0,
            particulars:'',
            amount:'',
            random:Utilities.getRandomNumber()
        };
}
import CityForm from '../../Masters/City/CityForm.vue';
import ContactForm from '../../Masters/Contacts/ContactForm.vue';
import SolicitorForm from '../../Masters/Solicitors/SolicitorForm.vue';
import EmployeeSelect from '../../SelectComponents/EmployeeSelect.vue';
import SolicitorSelect from '../../SelectComponents/SolicitorSelect.vue';
import MortgageCharge from './MortgageCharge.vue';


export default {
  components: { EmployeeSelect, CityForm, SolicitorSelect, MortgageCharge, ContactForm, SolicitorForm },
    props:['mortgage','index','form','random','closing_date','permissions'],
    data:function(){
        return {
            initialCity:[],
            selectedCity:[],
            initialContact:[],
            selectedContact:[],
            initialSolicitor:[],
            selectedSolicitor:[],
            show:false,
            city:false,
            showCity:false,
            showMortgagee:false,
            showSolicitor:false,
        }
    },
    computed:{
        total_charge:function(){
             var total = Utilities.round(this.mortgage.principal_amount) + Utilities.round(this.mortgage.extra_interest);
            this.mortgage.additional_charges.forEach(element => {
                total += Utilities.round(element.amount);
            });
            this.mortgage.total_mortgage_payable_discharge = total;
            return total;
        },

        extra_days:function(){
            var self = this;
            var days = 0;
            var closing_date = moment(self.closing_date, "MM-DD-YYYY");
            var discharged_on = moment(self.mortgage.discharged_on, "MM-DD-YYYY");
            var diff =  discharged_on.diff(closing_date, 'days');
            days = diff > 0 ? diff :0;
            return days;
        },

        extra_interest:function(){
            var charge = 0;
            charge= this.extra_days * this.mortgage.per_diem;
            this.mortgage.extra_interest = charge;
            return charge;
        }
    },
    mounted:function(){
        var self= this;
        if(this.mortgage.address.city){
            this.initialCity = [{'text':this.mortgage.address.city.city_name,'id':this.mortgage.address.city_id}];
            this.selectedCity = [this.mortgage.address.city_id];
        }

        if(this.mortgage.mortgagee){
            var first_name = this.mortgage.mortgagee.first_name ? this.mortgage.mortgagee.first_name : '';
            var middle_name = this.mortgage.mortgagee.middle_name ? this.mortgage.mortgagee.middle_name : '';
            var last_name = this.mortgage.mortgagee.last_name ? this.mortgage.mortgagee.last_name : '';
            // this.initialContact = [{'text':first_name+' '+middle_name+' '+last_name,'id':this.mortgage.mortgagee.id}];
            this.initialContact = [{'text':this.mortgage.mortgagee.company_name}];
            this.selectedContact = [this.mortgage.mortgagee.id];
        }
        if(this.mortgage.solicitor){
            var first_name = this.mortgage.solicitor.first_name ? this.mortgage.solicitor.first_name : '';
            var middle_name = this.mortgage.solicitor.middle_name ? this.mortgage.solicitor.middle_name : '';
            var last_name = this.mortgage.solicitor.last_name ? this.mortgage.solicitor.last_name : '';
            this.initialSolicitor = [{'text':first_name+' '+middle_name+' '+last_name,'id':this.mortgage.solicitor.id}];
            this.selectedSolicitor = [this.mortgage.solicitor.id];
        }
        if(this.mortgage.additional_charges.length ==0){
            this.mortgage.additional_charges.push(getCharge());
        }
        this.show = true;
        this.city = true;
        self.form.copyData = JSON.parse(JSON.stringify(self.form.data()));
    },
    methods:{
        getNumber:function(){
            return  parseInt(this.index)+1;
        },
        updateCity:function(value,index,city){
            this.mortgage.address.country = city.country;
            this.mortgage.address.province = city.state;
        },
        addCity:function(){
            this.showCity = true;
        },
        closeCityModal:function(){
            this.showCity = false;
        },
        acceptNumber(field) {
            // var x = this.mortgage.phone.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
            // this.mortgage.phone = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
                  var value = this.mortgage[field].replace(/\D/g, "");
            if(value.length <= 10){
                var x = this.mortgage[field].replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
                this.mortgage[field] = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
            }
            if(value.length == 11){
                var x = this.mortgage[field].replace(/\D/g, '').match(/(\d{1})(\d{3})(\d{3})(\d{4})/);
                this.mortgage[field] = x[1] +   ' (' + x[2] + ') '+  x[3]+'-'+x[4];
            }
            if(value.length > 11){
                var x = this.mortgage[field].replace(/\D/g, '').match(/(\d{2})(\d{3})(\d{3})(\d{4})/);
                this.mortgage[field] = x[1] +   ' (' + x[2] + ') '+  x[3]+'-'+x[4];
            }
        },
        postalCode(field){
            this.mortgage.address[field] =  this.mortgage.address[field].toUpperCase();
            var str =  this.mortgage.address[field];
            var matched = true;
            var x= '';
            switch(str.length) {
                case 1:
                    x = this.mortgage.address[field].match(/[A-Z]/g);
                break;

                case 2:
                    x =this.mortgage.address[field].match(/[A-Z][0-9]/g);
                break;

                case 3:
                    x = this.mortgage.address[field].match(/[A-Z][0-9][A-Z]/g);
                break;

                case 4:
                    x = this.mortgage.address[field].match(/[A-Z][0-9][A-Z][ ]/g);
                break;

                case 5:
                    x = this.mortgage.address[field].match(/[A-Z][0-9][A-Z][ ][0-9]/g);
                break;

                case 6:
                    x =this.mortgage.address[field].match(/[A-Z][0-9][A-Z][ ][0-9][A-Z]/g);
                break;

                case 7:
                    x =this.mortgage.address[field].match(/[A-Z][0-9][A-Z][ ][0-9][A-Z][0-9]/g);
            }
            if(x== null){
                this.mortgage.address[field]=  this.mortgage.address[field].substring(0, this.mortgage.address[field].length - 1);
                 if(str.length == 4){
                       this.mortgage.address[field]= this.mortgage.address[field]+ ' ';
                }

            }
                if(str.length == 3){
                 this.mortgage.address[field] =  this.mortgage.address[field]+' ';
            }
            if(str.length > 7 ){
                this.mortgage.address[field]  = this.mortgage.address[field].substring(0, 7);
            }
            // var x = this.form.address[field].match(/[A-Z][0-9][A-Z][ ][0-9][A-Z][0-9]/g);
        },

        getContactAddress:function(){
            var self = this;
            var url = '';
            if(this.mortgage.contact == 'solicitor' && this.mortgage.solicitor_id > 0){
                url = Munshi.base_url +'/solicitors/'+ this.mortgage.solicitor_id;
            }
            else if(this.mortgage.contact == 'mortgagee' && this.mortgage.mortgagee_id > 0){
                url = Munshi.base_url +'/contacts/'+ this.mortgage.mortgagee_id;
            }
            if(url != ''){
                self.city = false;
                axios.get(url)
                .then(function(response){
                    var detail = null;
                    if(response.data.solicitor){
                        detail = response.data.solicitor;
                    }
                    else if(response.data.contact){
                        detail = response.data.contact;
                    }
                    self.mortgage.address.number = detail.address ? detail.address.number : '';
                    self.mortgage.address.street = detail.address? detail.address.street:'';
                    self.mortgage.address.province = detail.address? detail.address.province:'';
                    self.mortgage.address.country = detail.address? detail.address.country:'';
                    self.mortgage.address.postal_code =   detail.address ?  detail.address.postal_code:'';
                    self.mortgage.phone =  detail ? detail.cell_phone:'';
                    self.mortgage.fax =  detail ? detail.fax:'';
                    self.mortgage.email =  detail ? detail.email:'';
                    self.mortgage.attention =  detail ? detail.attention:'';
                    if(detail.address){
                        self.initialCity = [{'text':detail.address.city.city_name,'id':detail.address.city_id}];
                        self.selectedCity = [detail.address.city_id];
                    }
                    self.city = true;

                })
                .catch(function(error){
                    self.city = true;
                    console.log(error);
                });
            }

        },

        addCharges:function(){
            this.mortgage.additional_charges.push(getCharge());
        },

        removeCharges:function(index){
            this.mortgage.additional_charges.splice(index,1);
        },
        addMortgagee:function(){
            this.showMortgagee = true;
        },
        hideMortgageeModal:function(){
            this.showMortgagee = false;
        },
        addSolicitor:function(){
            this.showSolicitor = true;
        },
        closeSolicitorModal:function(){
            this.showSolicitor = false;
        },
        addClosingDate:function(){
            this.mortgage.discharged_on = this.closing_date;
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
