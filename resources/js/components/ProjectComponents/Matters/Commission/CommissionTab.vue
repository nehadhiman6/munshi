<template>

    <div class="form-horizontal">

        <div class="card-body">
            <div class = "form-row">
                <div class="col">
                    <div class="form-group">
                    <label for="brokerage_id" class="in-label-title">Real Estate Broker</label>
                        <div class="input-group flex-nowrap mb-3">
                            <div class="w-100">
                                <brokerage-select :index="1"  :key="1"  v-model ="form.commission.brokerage_id" v-if='show' @updateBroker="updateBroker" :initials="brokerInitials"
                                    :selected="brokerSelected"
                                    >
                                </brokerage-select>
                            </div>
                            <div class="input-group-append" >
                                <button class="btn iw-add-new-btn" @click.prevent="addCity()" ><span class="mdi mdi-plus"></span></button>
                            </div>
                        </div>
                        <span id="basic-msg" v-if="form.errors.get('brokerage_id')" class="invalid-feedback">{{ form.errors.get('brokerage_id') }}</span>
                    </div>
                </div>
            </div>
            <div class="form-row" v-if="form.brokerage">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="phone" class="in-label-title ">Phone</label>
                        <input class="form-control"  @input="acceptNumber('phone')"  v-bind:class="{ 'is-invalid': form.errors.get('phone') }" disabled type="text" v-model ="form.brokerage.phone">
                        <span id="basic-msg" v-if="form.errors.get('phone')" class="invalid-feedback">{{ form.errors.get('phone') }}</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="fax" class="in-label-title ">Fax</label>
                        <input class="form-control" @input="acceptNumber('fax')"  v-bind:class="{ 'is-invalid': form.errors.get('fax') }" disabled type="text" v-model ="form.brokerage.fax">
                        <span id="basic-msg" v-if="form.errors.get('fax')" class="invalid-feedback">{{ form.errors.get('fax') }}</span>
                    </div>
                </div>

                 <div class="col-md-3">
                    <div class="form-group">
                        <label for="email" class="in-label-title ">Email</label>
                        <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('email') }" disabled type="text" v-model ="form.brokerage.email">
                        <span id="basic-msg" v-if="form.errors.get('email')" class="invalid-feedback">{{ form.errors.get('email') }}</span>
                    </div>
                </div>

            </div>
            <fieldset class="fieldset  mt-1" v-if="form.brokerage && form.brokerage.address">
                <legend class="legend">Mailing Address</legend>
                <div class = "form-row">
                    <div class="col">
                        <div class="form-group">
                        <label for="number" class="in-label-title ">Number</label>
                        <input class="form-control" disabled v-bind:class="{ 'is-invalid': form.errors.get('number') }" type="text" v-model ="form.brokerage.address.number">
                        <span id="basic-msg" v-if="form.errors.get('number')" class="invalid-feedback">{{ form.errors.get('number') }}</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                        <label for="street" class="in-label-title ">Street</label>
                        <input class="form-control" disabled v-bind:class="{ 'is-invalid': form.errors.get('street') }" type="text" v-model ="form.brokerage.address.street">
                        <span id="basic-msg" v-if="form.errors.get('street')" class="invalid-feedback">{{ form.errors.get('street') }}</span>
                        </div>
                    </div>
                    <div class="col" v-if="form.brokerage.address && form.brokerage.address.city">
                        <div class="form-group">
                        <label for="city_id" class="in-label-title ">City</label>
                            <div class="input-group flex-nowrap mb-3">
                            <div class="w-100">
                                <input class="form-control" disabled v-bind:class="{ 'is-invalid': form.errors.get('street') }" type="text" v-model ="form.brokerage.address.city.city_name">
                            </div>
                            <!-- <div class="input-group-append">
                                <button class="btn iw-add-new-btn" @click.prevent="addCity()"><span class="mdi mdi-plus"></span></button>
                            </div> -->
                        </div>

                        <span id="basic-msg" v-if="form.errors.get('city_id')" class="invalid-feedback">{{ form.errors.get('city_id') }}</span>
                        </div>
                    </div>
                </div>
                    <div class = "form-row"  v-if="form.brokerage.address">
                    <div class="col">
                        <div class="form-group">
                        <label for="province" class="in-label-title ">Province</label>
                        <input class="form-control" disabled v-bind:class="{ 'is-invalid': form.errors.get('province') }" type="text"  v-model ="form.brokerage.address.province">
                        <span id="basic-msg" v-if="form.errors.get('province')" class="invalid-feedback">{{ form.errors.get('province') }}</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                        <label for="country" class="in-label-title ">Country</label>
                        <input class="form-control" disabled v-bind:class="{ 'is-invalid': form.errors.get('country') }"   type="text" v-model ="form.brokerage.address.country">
                        <span id="basic-msg" v-if="form.errors.get('country')" class="invalid-feedback">{{ form.errors.get('country') }}</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                        <label for="postal_code" class="in-label-title ">Postal Code</label>
                        <input class="form-control" disabled v-bind:class="{ 'is-invalid': form.errors.get('postal_code') }" @input="postalCode('postal_code')" type="text" v-model ="form.brokerage.address.postal_code">
                        <span id="basic-msg" v-if="form.errors.get('postal_code')" class="invalid-feedback">{{ form.errors.get('postal_code') }}</span>
                        </div>
                    </div>
                </div>
            </fieldset>


            <fieldset class="fieldset  mt-1">
                <legend class="legend">Commission</legend>
                <div class = "form-row">

                  <div class="col-md-3">
                    <div class="form-group">
                        <label for="real_estate_agent_id" class="in-label-title ">Agent</label>
                        <input type="text" v-model="form.agent_name" disabled class="form-control">
                        <span id="basic-msg" v-if="form.errors.get('real_estate_agent_id')" class="invalid-feedback">{{ form.errors.get('real_estate_agent_id') }}</span>
                    </div>
                </div>
                </div>
                <div class = "form-row">
                    <div class="col">
                        <div class="form-group">
                            <label for="total_commission" class="in-label-title ">Total Commission</label>
                             <currency-input  v-bind:class="{ 'is-invalid': form.errors.get('total_commission') }"   v-model="form.commission.total_commission"></currency-input>
                            <span id="basic-msg" v-if="form.errors.get('total_commission')" class="invalid-feedback">{{ form.errors.get('total_commission') }}</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="gst" class="in-label-title ">GST/HST at 13%</label>
                             <currency-input  v-bind:class="{ 'is-invalid': form.errors.get('gst') }"   v-model="gst"></currency-input>
                            <span id="basic-msg" v-if="form.errors.get('gst')" class="invalid-feedback">{{ form.errors.get('gst') }}</span>
                        </div>
                    </div>
                      <div class="col">
                        <div class="form-group">
                            <label for="total_commission_after_gst" class="in-label-title ">Total Commission after HST</label>
                              <currency-input v-bind:class="{ 'is-invalid': form.errors.get('total_commission_after_gst') }"   v-model="total_commission_after_gst"></currency-input>
                            <span id="basic-msg" v-if="form.errors.get('total_commission_after_gst')" class="invalid-feedback">{{ form.errors.get('total_commission_after_gst') }}</span>
                        </div>
                    </div>
                </div>
                <div class = "form-row">
                     <div class="col">
                        <!-- <div class="form-group">
                            <label for="less_deposit" class="in-label-title ">Less Deposit</label>
                              <currency-input v-bind:class="{ 'is-invalid': form.errors.get('less_deposit') }"   v-model="form.commission.less_deposit"></currency-input>
                            <span id="basic-msg" v-if="form.errors.get('less_deposit')" class="invalid-feedback">{{ form.errors.get('less_deposit') }}</span>
                        </div> -->
                         <div class="form-group" v-bind:class="{ 'is-invalid': form.errors.get('commission.less_deposit') }"  >
                             <label for="less_deposit" class="in-label-title ">Less Deposit $ {{deposit}}</label>
                            <div class="input-group flex-nowrap mb-3"  >
                                <div class="w-100">
                                    <currency-input v-bind:class="{ 'is-invalid': form.errors.get('less_deposit') }"   v-model="form.commission.less_deposit"></currency-input>
                                    <span id="basic-msg" v-if="form.errors.get('commission.less_deposit')" class="invalid-feedback">{{ form.errors.get('commission.less_deposit') }}</span>
                                </div>
                                <div class="input-group-append"  >
                                    <button class="btn btn-primary" @click.prevent="addStatementDeposit()">Copy From Statment</button>
                                </div>
                            </div>
                            <span id="basic-msg" v-if="form.errors.get('less_deposit')" class="invalid-feedback">{{ form.errors.get('commission.less_deposit') }}</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="commission_payable" class="in-label-title ">Commission Payable After Closing</label>
                             <currency-input  disabled="true" v-bind:class="{ 'is-invalid': form.errors.get('commission_payable') }"   v-model="commission_payable"></currency-input>
                            <span id="basic-msg" v-if="form.errors.get('commission_payable')" class="invalid-feedback">{{ form.errors.get('commission_payable') }}</span>
                        </div>
                    </div>
                      <div class="col">
                        <div class="form-group">
                             <label for="excess_deposit_to_seller" class="in-label-title "> Excess deposit to Seller </label>
                            <currency-input  disabled="true" v-bind:class="{ 'is-invalid': form.errors.get('excess_deposit_to_seller') }"   v-model="excess_deposit_to_seller"></currency-input>
                            <span id="basic-msg" v-if="form.errors.get('excess_deposit_to_seller')" class="invalid-feedback">{{ form.errors.get('excess_deposit_to_seller') }}</span>
                        </div>
                    </div>
                </div>
            </fieldset>


        <brokerage-form v-if="showCity"
            :form-id="0"
            @closeTriggered="closeCityModal"
        >

        </brokerage-form>

        </div>

    </div>
</template>

<script>
import CityForm from '../../Masters/City/CityForm.vue';
import BrokerageForm from '../../Masters/Brokerage/BrokerageForm.vue';

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

// function getNewForm(){
//     return new Form({
//         commission:{
//             id:'0',
//             file_opening_id:0,
//             brokerage_id:'',
//             total_commission:'',
//             gst:'',
//             total_commission_after_gst:'',
//             less_deposit:'',
//             commission_payable:'',
//             excess_deposit_to_seller:'',
//             agent_name:'',
//             address:getAddress(),
//             random:Utilities.getRandomNumber()
//         },
//         file_opening_id:0,
//     })
// }
export default {
  components: {  CityForm, BrokerageForm  },

    props:['file_opening_id','form','file_opening','update_file_opening'],
        data:function(){
        return {
            create_url:'commissions',
            base_url:Munshi.base_url,
            show:true,
            initialCity :[],
            selectedCity:[],
            brokerInitials :[],
            brokerSelected:[],
            showCity:false,
            deposit:0

        }
    },

    watch:{
        update_file_opening:{
            handler: function(newValue) {
                this.getCommission();
            },
        }
    },

    computed:{
        gst:function(){
            var gst = 0;
            if(this.form.commission.total_commission != ''){
                gst =  Utilities.round(13*this.form.commission.total_commission /100);
            }
            this.form.commission.gst = gst;
            return gst;
        },

        total_commission_after_gst:function(){
            var total_commission_after_gst = 0;
             if(this.form.commission.total_commission != ''){
                total_commission_after_gst =  Utilities.round(this.gst) +  Utilities.round(this.form.commission.total_commission);
            }
            this.form.commission.total_commission_after_gst = total_commission_after_gst;
            return total_commission_after_gst;
        },

        commission() {
            return this.total_commission_after_gst - this.form.commission.less_deposit
        },

        commission_payable() {
            var commission_payable = this.commission > 0 ? this.commission : 0;
            this.form.commission.commission_payable = commission_payable;
            return commission_payable;
        },

        excess_deposit_to_seller() {
            var excess_deposit_to_seller = this.commission < 0 ? (this.commission * -1) : 0;
            this.form.commission.excess_deposit_to_seller = excess_deposit_to_seller;
            return excess_deposit_to_seller;
        }


    },
    mounted:function(){
        this.getCommission();
    },
     methods:{
        updateCity:function(value,index,city){
            this.form.commission.address.country = city.country;
            this.form.commission.address.province = city.state;
        },

        addCity:function(){
            this.showCity = true;
        },

        closeCityModal:function(){
            this.showCity = false;
        },

        updateBroker:function(value,index,broker){
            this.form.brokerage = broker;
        },
        getCommission:function(){
            var self = this;
            this.show = false;
            var commission = self.file_opening.commission;
            var statement_adjustment = self.file_opening.statement_adjustment;
            self.deposit = statement_adjustment && statement_adjustment.deposit? statement_adjustment.deposit:'';
            console.log(commission);
            var agent = self.file_opening.real_estate_agent;
            if(commission){
                // self.form =getNewForm();
                Utilities.copyProperties(commission,self.form.commission);
                if(commission.brokerage){
                    self.brokerInitials = [{'text':commission.brokerage.name ,'id':commission.brokerage.id}];
                    self.brokerSelected = [commission.brokerage.id];
                    self.form.brokerage = commission.brokerage;
                }
            }
            self.form.file_opening_id = self.file_opening_id;
            if(agent){
                var first_name = agent.first_name ? agent.first_name :'';
                var middle_name = agent.middle_name ? agent.middle_name :'';
                var last_name = agent.last_name ? agent.last_name :'';
                var name = first_name+' '+ middle_name +' '+last_name;
                self.form.agent_name = name;
            }

            if(commission.resources)
            self.form.resources = commission.resources;


            self.$nextTick(() => {
                self.show = true;
            });
           self.form.copyData = JSON.parse(JSON.stringify(self.form.data()));

        },

        acceptNumber(field) {
            // var x = this.form.brokerage.phone.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
            // this.form.brokerage.phone = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');

               var value = this.form.brokerage[field].replace(/\D/g, "");
            if(value.length <= 10){
                var x = this.form.brokerage[field].replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
                this.form.brokerage[field] = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
            }
            if(value.length == 11){
                var x = this.form.brokerage[field].replace(/\D/g, '').match(/(\d{1})(\d{3})(\d{3})(\d{4})/);
                this.form.brokerage[field] = x[1] +   ' (' + x[2] + ') '+  x[3]+'-'+x[4];
            }
            if(value.length > 11){
                var x = this.form.brokerage[field].replace(/\D/g, '').match(/(\d{2})(\d{3})(\d{3})(\d{4})/);
                this.form.brokerage[field] = x[1] +   ' (' + x[2] + ') '+  x[3]+'-'+x[4];
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

        addStatementDeposit:function(){
            this.form.commission.less_deposit = this.deposit;
        }
     }
}
</script>

<style>
.iw-add-pin-btn {
    display: inline-block;
    padding: 2px 10px;
    background: #f44336;
    color: #fff;
    margin-bottom: 10px;
    font-size: 13px;
    cursor: pointer;
}
</style>
