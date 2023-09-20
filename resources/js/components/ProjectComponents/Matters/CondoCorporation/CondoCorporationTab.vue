<template>
    <div class="form-horizontal">
        <div class="">
            <div class = "form-row">
                <div class="col">
                    <div class="form-group">
                    <label for="condo_corporation_name" class="in-label-title">Corporation Name</label>
                    <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('condo_corporation_name') }" type="text" plceholder="LRO No." v-model ="form.condo_corporation.condo_corporation_name">
                    <span id="basic-msg" v-if="form.errors.get('condo_corporation_name')" class="invalid-feedback">{{ form.errors.get('condo_corporation_name') }}</span>
                    </div>
                </div>
            </div>
            <div class="form-row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="type" class="in-label-title ">Type</label>
                                <select class="form-control" v-model ="form.condo_corporation.type" class-name="type" >
                                <option value="self_managed">Self Managed</option>
                                <option value="management_company">Management Company</option>
                            </select>
                            <span id="basic-msg" v-if="form.errors.get('type')" class="invalid-feedback">{{ form.errors.get('type') }}</span>
                         </div>
                    </div>
                    <div class="col-md-3" v-if="form.condo_corporation.type == 'management_company'">
                        <div class="form-group">
                            <label for="management_company" class="in-label-title ">Management Company Name</label>
                            <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('management_company') }" type="text" v-model ="form.condo_corporation.management_company">
                            <span id="basic-msg" v-if="form.errors.get('management_company')" class="invalid-feedback">{{ form.errors.get('management_company') }}</span>
                        </div>
                    </div>
                 <div class="col-md-3">
                    <div class="form-group">
                        <label for="phone" class="in-label-title ">Phone</label>
                        <input class="form-control"  @input="acceptNumber"  v-bind:class="{ 'is-invalid': form.errors.get('phone') }" type="text" v-model ="form.condo_corporation.phone">
                        <span id="basic-msg" v-if="form.errors.get('phone')" class="invalid-feedback">{{ form.errors.get('phone') }}</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="fax" class="in-label-title ">Fax</label>
                        <input class="form-control"  @input="acceptNumber('fax')"  v-bind:class="{ 'is-invalid': form.errors.get('fax') }" type="text" v-model ="form.condo_corporation.fax">
                        <span id="basic-msg" v-if="form.errors.get('fax')" class="invalid-feedback">{{ form.errors.get('fax') }}</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="attention" class="in-label-title ">Attention</label>
                        <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('attention') }" type="text" v-model ="form.condo_corporation.attention">
                        <span id="basic-msg" v-if="form.errors.get('attention')" class="invalid-feedback">{{ form.errors.get('attention') }}</span>
                    </div>
                </div>
                 <div class="col-md-6">
                    <div class="form-group">
                        <label for="email" class="in-label-title ">Email</label>
                        <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('email') }" type="text" v-model ="form.condo_corporation.email">
                        <span id="basic-msg" v-if="form.errors.get('email')" class="invalid-feedback">{{ form.errors.get('email') }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status_certificate_fees" class="in-label-title ">Status Certificate Fees</label>
                        <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('status_certificate_fees') }" type="text" v-model ="form.condo_corporation.status_certificate_fees">
                        <span id="basic-msg" v-if="form.errors.get('status_certificate_fees')" class="invalid-feedback">{{ form.errors.get('status_certificate_fees') }}</span>
                    </div>
                </div>
            </div>

            <fieldset class="fieldset  mt-1" v-if="form.condo_corporation.type == 'management_company'">
                <legend class="legend">Company Address</legend>
                <div class = "form-row">
                    <div class="col">
                        <div class="form-group">
                        <label for="number" class="in-label-title ">Number</label>
                        <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('number') }" type="text" v-model ="form.condo_corporation.address.number">
                        <span id="basic-msg" v-if="form.errors.get('number')" class="invalid-feedback">{{ form.errors.get('number') }}</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                        <label for="street" class="in-label-title ">Street</label>
                        <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('street') }" type="text" v-model ="form.condo_corporation.address.street">
                        <span id="basic-msg" v-if="form.errors.get('street')" class="invalid-feedback">{{ form.errors.get('street') }}</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                        <label for="city_id" class="in-label-title ">City</label>
                            <div class="input-group flex-nowrap mb-3">
                            <div class="w-100">
                                <city-select @updateCity="updateCity" v-if="show" :index="form.condo_corporation.random" :key="form.condo_corporation.random" :initials="initialCity" :selected="selectedCity"  v-bind:class="{ 'is-invalid': form.errors.get('city_id') }" type="text" v-model ="form.condo_corporation.address.city_id"></city-select>
                            </div>
                            <div class="input-group-append">
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
                        <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('province') }" type="text" disabled v-model ="form.condo_corporation.address.province">
                        <span id="basic-msg" v-if="form.errors.get('province')" class="invalid-feedback">{{ form.errors.get('province') }}</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                        <label for="country" class="in-label-title ">Country</label>
                        <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('country') }" disabled  type="text" v-model ="form.condo_corporation.address.country">
                        <span id="basic-msg" v-if="form.errors.get('country')" class="invalid-feedback">{{ form.errors.get('country') }}</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                        <label for="postal_code" class="in-label-title ">Postal Code</label>
                        <input class="form-control" @input="postalCode('postal_code')" v-bind:class="{ 'is-invalid': form.errors.get('postal_code') }" type="text" v-model ="form.condo_corporation.address.postal_code">
                        <span id="basic-msg" v-if="form.errors.get('postal_code')" class="invalid-feedback">{{ form.errors.get('postal_code') }}</span>
                        </div>
                    </div>
                </div>
            </fieldset>
            <div class ="">
                <input class="btn iw-btn iw-btn-submit" :value="form.form_id > 0 ? 'Update' : 'Save'" @click.prevent ="submitForm" type="submit">
            </div>
        </div>
        <city-form v-if="showCity"
                @closeTriggered="closeCityModal"
            >
        </city-form>
    </div>
</template>

<script>
import CityForm from '../../Masters/City/CityForm.vue';

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
        condo_corporation:{
            id:'0',
            file_opening_id:0,
            condo_corporation_name:'',
            type:'',
            management_company:'',
            address:'',
            attention:'',
            phone:'',
            fax:'',
            email:'',
            status_certificate_fees:'',
            address:getAddress(),
            random:Utilities.getRandomNumber()
        },
        file_opening_id:0,
    })
}
export default {
  components: {  CityForm },

    props:['file_opening_id','permissions'],
        data:function(){
        return {
            form:getNewForm(),
            create_url:'condo-corporations',
            base_url:Munshi.base_url,
            show:true,
            initialCity :[],
            selectedCity:[],
            showCity:false
        }
    },
    mounted:function(){
        this.getProperty();
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

        getProperty:function(){
            var self = this;
            this.show = false;
            axios.get(this.base_url+'/file-page/'+this.file_opening_id)
            .then(function(response){
                console.log(response);
                if(response.data.success){
                    var condo_corporation = response.data.file_opening.condo_corporation;
                    if(condo_corporation){
                        self.form =getNewForm();
                        Utilities.copyProperties(condo_corporation,self.form.condo_corporation);
                        if(condo_corporation.address && condo_corporation.address.city){
                            self.initialCity = [{'text':condo_corporation.address.city.city_name ,'id':condo_corporation.address.city.id}];
                            self.selectedCity = [condo_corporation.address.city.id];
                        }
                    }
                    self.form.file_opening_id = self.file_opening_id;
                }
                self.show = true;
                 self.form.copyData = JSON.parse(JSON.stringify(self.form.data()));
            })
            .catch(function(error){
                console.log("error");
                console.log(error);
            });
        },

        submitForm:function(){
            var self = this;
            Utilities.showConfirmationPopMessage('Do you want to save the changes?',function(save){
                if(save == true){
                    self.form['postForm'](self.base_url+'/'+self.create_url)
                    .then(function(response){
                        if(response.success){
                            self.form.copyData = JSON.parse(JSON.stringify(self.form.data()));
                            Utilities.showToast(self,'success','Condo Corporation updated successfully',2200,true);
                            self.$emit('closeTriggered');
                        }
                    })
                    .catch(function(error){
                        console.log(error);
                    });
                }
            },true,false);
        },

        updateCity:function(value,index,city){
            this.form.condo_corporation.address.country = city.country;
            this.form.condo_corporation.address.province = city.state;
        },

        addCity:function(){
            this.showCity = true;
        },

        closeCityModal:function(){
            this.showCity = false;
        },

        acceptNumber() {
            // var x = this.condo_corporation.phone.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
            // this.condo_corporation.phone = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');

            var value = this.condo_corporation.phone.replace(/\D/g, "");
            if(value.length <= 10){
                var x = this.condo_corporation.phone.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
                this.condo_corporation.phone = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
            }
            if(value.length == 11){
                var x = this.condo_corporation.phone.replace(/\D/g, '').match(/(\d{1})(\d{3})(\d{3})(\d{4})/);
                this.condo_corporation.phone = x[1] +   ' (' + x[2] + ') '+  x[3]+'-'+x[4];
            }
            if(value.length > 11){
                var x = this.condo_corporation.phone.replace(/\D/g, '').match(/(\d{2})(\d{3})(\d{3})(\d{4})/);
                this.condo_corporation.phone = x[1] +   ' (' + x[2] + ') '+  x[3]+'-'+x[4];
            }
        },


        postalCode(field){
            this.form.condo_corporation.address[field] =  this.form.condo_corporation.address[field].toUpperCase();
            var str =  this.form.condo_corporation.address[field];
            var matched = true;
            var x= '';
            switch(str.length) {
                case 1:
                    x = this.form.condo_corporation.address[field].match(/[A-Z]/g);
                break;

                case 2:
                    x =this.form.condo_corporation.address[field].match(/[A-Z][0-9]/g);
                break;

                case 3:
                    x = this.form.condo_corporation.address[field].match(/[A-Z][0-9][A-Z]/g);
                break;

                case 4:
                    x = this.form.condo_corporation.address[field].match(/[A-Z][0-9][A-Z][ ]/g);
                break;

                case 5:
                    x = this.form.condo_corporation.address[field].match(/[A-Z][0-9][A-Z][ ][0-9]/g);
                break;

                case 6:
                    x =this.form.condo_corporation.address[field].match(/[A-Z][0-9][A-Z][ ][0-9][A-Z]/g);
                break;

                case 7:
                    x =this.form.condo_corporation.address[field].match(/[A-Z][0-9][A-Z][ ][0-9][A-Z][0-9]/g);
            }
            if(x== null){
                this.form.condo_corporation.address[field]=  this.form.condo_corporation.address[field].substring(0, this.form.condo_corporation.address[field].length - 1);
                 if(str.length == 4){
                       this.form.condo_corporation.address[field]= this.form.condo_corporation.address[field]+ ' ';
                }

            }
             if(str.length == 3){
                 this.form.condo_corporation.address[field] =  this.form.condo_corporation.address[field]+' ';
            }
            if(str.length > 7 ){
                this.form.condo_corporation.address[field]  = this.form.condo_corporation.address[field].substring(0, 7);
            }
            // var x = this.form.address[field].match(/[A-Z][0-9][A-Z][ ][0-9][A-Z][0-9]/g);
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
