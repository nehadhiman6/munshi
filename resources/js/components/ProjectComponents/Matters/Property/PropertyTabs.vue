<template>
  <div class="form-horizontal">
          <div class=" card-header d-flex flex-wrap align-items-center justify-content-between  py-1">
            <div class="card-title mb-0"><span><strong>Property</strong></span></div>
            <div class ="float-right">
                <input class="btn iw-btn iw-btn-submit py-1" :value="form.form_id > 0 ? 'Update' : 'Save'" @click.prevent ="submitForm" type="submit">
            </div>
        </div>
                <div class="card-body">
                    <div class = "form-row">
                        <div class="col-md-3">
                            <label for="lro" class="in-label-title">Land Registry Office</label>
                            <lro-select v-if="show" v-model='form.property.lro' :index="1" :initials="lro" :selected="[form.property.lro]"></lro-select>
                            <!-- <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('property.lro') }" type="text" plceholder="LRO No." v-model ="form.property.lro"> -->
                            <span id="basic-msg" v-if="form.errors.get('property.lro')" class="invalid-feedback">{{ form.errors.get('property.lro') }}</span>
                        </div>
                    </div>
                    <div class="form-row">
                            <div class="col-md-3">
                                <label for="survey_available" class="in-label-title ">Sale of</label>
                                 <select class="form-control" v-model ="form.property.sale_of" class-name="survey_available" >
                                    <option value="Resale">Resale</option>
                                    <option value="Newly Constructed">Newly Constructed</option>
                                    <option value="Commercial">Commercial</option>
                                    <option value="Condo Corporation">Condo Corporation</option>
                                    <option value="Vacant Land">Vacant Land</option>
                                    <option value="Farm Land">Farm Land</option>
                                </select>
                                <span id="basic-msg" v-if="form.errors.get('property.survey_available')" class="invalid-feedback">{{ form.errors.get('property.survey_available') }}</span>
                            </div>
                             <div class="col-md-3" v-if="form.property.sale_of == 'Condo Corporation'">
                                <label for="condo_corporation" class="in-label-title ">Condo Corporation/Management Company Name</label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('property.condo_corporation') }" type="text" v-model ="form.property.condo_corporation">
                                <span id="basic-msg" v-if="form.errors.get('property.condo_corporation')" class="invalid-feedback">{{ form.errors.get('property.condo_corporation') }}</span>
                            </div>

                            <div class="col-md-3">
                                <label for="lot_part" class="in-label-title ">Lot /Part Lot</label>
                                 <select class="form-control" v-model ="form.property.lot_part" class-name="lot_part" >
                                    <option value="Lot">Lot</option>
                                    <option value="Part Lort">Part Lot</option>
                                </select>
                                <span id="basic-msg" v-if="form.errors.get('property.lot_part')" class="invalid-feedback">{{ form.errors.get('property.lot_part') }}</span>
                            </div>
                             <div class="col-md-3">
                                <label for="lot" class="in-label-title ">Lot</label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('property.lot') }" type="text" v-model ="form.property.lot">
                                <span id="basic-msg" v-if="form.errors.get('property.lot')" class="invalid-feedback">{{ form.errors.get('property.lot') }}</span>
                            </div>

                             <div class="col-md-3">
                                <label for="being_part" class="in-label-title ">Being Part</label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('property.being_part') }" type="text" v-model ="form.property.being_part">
                                <span id="basic-msg" v-if="form.errors.get('property.being_part')" class="invalid-feedback">{{ form.errors.get('property.being_part') }}</span>
                            </div>
                             <div class="col-md-3">
                                <label for="on_plan" class="in-label-title ">On Plan</label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('property.on_plan') }" type="text" v-model ="form.property.on_plan">
                                <span id="basic-msg" v-if="form.errors.get('property.on_plan')" class="invalid-feedback">{{ form.errors.get('property.on_plan') }}</span>
                            </div>
                            <div class="col-md-3">
                                <label for="parcel" class="in-label-title ">Parcel</label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('property.parcel') }" type="text" v-model ="form.property.parcel">
                                <span id="basic-msg" v-if="form.errors.get('property.parcel')" class="invalid-feedback">{{ form.errors.get('property.parcel') }}</span>
                            </div>
                             <div class="col-md-3">
                                <label for="section" class="in-label-title ">Section</label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('property.section') }" type="text" v-model ="form.property.section">
                                <span id="basic-msg" v-if="form.errors.get('property.section')" class="invalid-feedback">{{ form.errors.get('property.section') }}</span>
                            </div>
                          </div>
                    <fieldset class="fieldset">
                        <legend class="legend">Sale Property Address</legend>
                        <div class="form-row">
                            <div class="col">
                                <label for="street_no" class="in-label-title ">Number</label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('property.street_no') }" type="text" v-model ="form.property.street_no">
                                <span id="basic-msg" v-if="form.errors.get('property.street_no')" class="invalid-feedback">{{ form.errors.get('property.street_no') }}</span>
                            </div>
                            <div class="col">
                                <label for="street_name" class="in-label-title ">Street </label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('property.street_name') }" type="text" v-model ="form.property.street_name">
                                <span id="basic-msg" v-if="form.errors.get('property.street_name')" class="invalid-feedback">{{ form.errors.get('property.street_name') }}</span>
                            </div>
                        </div>
                        <div class = "form-row" >
                            <div class="col">
                                <label for="unit_no" class="in-label-title ">Unit Number</label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('property.unit_no') }" type="text" v-model ="form.property.unit_no">
                                <span id="basic-msg" v-if="form.errors.get('property.unit_no')" class="invalid-feedback">{{ form.errors.get('property.unit_no') }}</span>
                            </div>
                                <div class="col">
                                    <label for="city_id" class="in-label-title ">City</label>
                                    <div class="input-group flex-nowrap mb-3">
                                        <div class="w-100">
                                            <city-select  v-if="show"  @updateCity="updateCity"  :initials="initialCity" :selected="selectedCity"
                                                :key="'property'+form.property.random"  :index="'property'+form.property.random" :lro_id ="form.property.lro" :disabled="form.property.lro == '' || form.property.lro == 0"
                                                v-bind:class="{ 'is-invalid': form.errors.get('property.city_id') }" type="text" v-model ="form.property.city_id"></city-select>
                                        </div>
                                        <div class="input-group-append" v-if="permissions['cities-modify'] == 'cities-modify'">
                                            <button class="btn iw-add-new-btn" @click.prevent="addCity()" ><span class="mdi mdi-plus"></span></button>
                                        </div>
                                    </div>

                                    <span id="basic-msg" v-if="form.errors.get('property.city_id')" class="invalid-feedback">{{ form.errors.get('property.property.city_id') }}</span>
                                </div>

                        </div>
                        <div class = "form-row">
                            <div class="col">
                                <label for="province" class="in-label-title ">Province</label>
                                <input class="form-control"  disabled v-bind:class="{ 'is-invalid': form.errors.get('property.province') }" type="text" v-model ="form.property.province">
                                <span id="basic-msg" v-if="form.errors.get('property.province')" class="invalid-feedback">{{ form.errors.get('property.province') }}</span>
                            </div>
                            <div class="col">
                                <label for="country" class="in-label-title ">Country</label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('property.country') }" type="text" disabled v-model ="form.property.country">
                                <span id="basic-msg" v-if="form.errors.get('property.country')" class="invalid-feedback">{{ form.errors.get('property.country') }}</span>
                            </div>
                            <div class="col">
                                <label for="postal_code" class="in-label-title ">Postal Code</label>
                                <input class="form-control" @input="postalCode('postal_code')" v-bind:class="{ 'is-invalid': form.errors.get('property.postal_code') }" type="text" v-model ="form.property.postal_code">
                                <span id="basic-msg" v-if="form.errors.get('property.postal_code')" class="invalid-feedback">{{ form.errors.get('property.postal_code') }}</span>
                            </div>
                        </div>


                    </fieldset>

                    <fieldset class="fieldset">
                            <legend  class='legend'>PINs</legend>
                            <property-pin v-for="(pin,index) in form.property.pins" :key="pin.random"
                                :form="form"
                                :pin="pin"
                                :index="index"
                                @removePin="removePin">
                            </property-pin>
                            <span class="iw-add-pin-btn" @click.prevent="addPin"><i class="fe fe-plus"></i> Add Pin</span>
                    </fieldset>
                    <fieldset class="fieldset">

                        <legend class="legend">Legal Description</legend>
                          <div class = "form-row">
                            <div class="col">
                                <label for="roll_no" class="in-label-title ">Roll Number</label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('property.roll_no') }" type="text" v-model ="form.property.roll_no">
                                <span id="basic-msg" v-if="form.errors.get('property.roll_no')" class="invalid-feedback">{{ form.errors.get('property.roll_no') }}</span>
                            </div>
                              <div class="col">
                                <label for="customer_no" class="in-label-title ">Customer Number</label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('property.customer_no') }" type="text" v-model ="form.property.customer_no">
                                <span id="basic-msg" v-if="form.errors.get('property.customer_no')" class="invalid-feedback">{{ form.errors.get('property.customer_no') }}</span>
                            </div>
                            <div class="col">
                                <label for="survey_available" class="in-label-title ">Surveyor Available</label>
                                 <select class="form-control" v-model ="form.property.survey_available" class-name="survey_available" >
                                    <option value="Y">Yes</option>
                                    <option value="N">No</option>
                                </select>
                                <span id="basic-msg" v-if="form.errors.get('property.survey_available')" class="invalid-feedback">{{ form.errors.get('property.survey_available') }}</span>
                            </div>
                              <div class="col" v-if="form.property.survey_available == 'Y'">
                                <label for="surveyor" class="in-label-title ">Surveyor</label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('property.surveyor') }" type="text" v-model ="form.property.surveyor">
                                <span id="basic-msg" v-if="form.errors.get('property.surveyor')" class="invalid-feedback">{{ form.errors.get('property.surveyor') }}</span>
                            </div>

                        </div>
                         <!-- <div class = "form-row">
                            <div class="col">
                                <label for="title_search_performed" class="in-label-title ">Title Search Performed</label>
                                 <select class="form-control" v-model ="form.property.title_search_performed" class-name="title_search_performed" v-bind:class="{ 'is-invalid': form.errors.get('property.title_search_performed') }"  >
                                    <option value="Y">Yes</option>
                                    <option value="N">No</option>
                                </select>
                                <span id="basic-msg" v-if="form.errors.get('property.title_search_performed')" class="invalid-feedback">{{ form.errors.get('property.title_search_performed') }}</span>
                            </div>
                            <div class="col-md-3" v-bind:class="{ 'is-invalid': form.errors.get('property.date') }">
                                <label for="date" class="in-label-title "  >Date</label>
                                <date-picker v-model ="form.property.date" class-name="date"> </date-picker>
                                <span id="basic-msg" v-if="form.errors.get('property.date')" class="invalid-feedback">{{ form.errors.get('property.date') }}</span>
                            </div>
                        </div> -->
                    </fieldset>
                      <div class ="mt-4">
                        <input class="btn iw-btn iw-btn-submit" :value="form.form_id > 0 ? 'Update' : 'Save'" @click.prevent ="submitForm" type="submit">
                    </div>
                </div>
                <city-form v-if="showCity"
                :lro="lro"
                        @closeTriggered="closeCityModal"
                    >
                </city-form>
        </div>
</template>

<script>
import CityForm from '../../Masters/City/CityForm.vue'
import PropertyPin from './PropertyPin.vue'

function getPin(){
    return {
        id:0,
        pin:'',
        random:Utilities.getRandomNumber()
    }
}
function getNewForm(){
    return new Form({
        property:{
            id:'0',
            file_opening_id:0,
            lro:'',
            street_no:'',
            unit_no:'',
            street_name:'',
            city_id:'',
            province:'',
            country:'',
            postal_code:'',
            roll_no:'',
            survey_available:'',
            surveyor:'',
            date:'',
            title_search_performed:'',
            sale_of:'',
            condo_corporation:'',
            lot_part:'',
            lot:'',
            plan:'',
            being_part:'',
            on_plan:'',
            parcel:'',
            section:'',
            customer_no:'',
            pins:[],
            random:Utilities.getRandomNumber()
        },
        file_opening_id:0,
    })
}
export default {
  components: { PropertyPin, CityForm },

    props:['file_opening_id','lro','permissions'],
        data:function(){
        return {
            form:getNewForm(),
            create_url:'properties',
            base_url:Munshi.base_url,
            show:true,
            initialCity :[],
            selectedCity:[],
            showCity:false,
            initialLRO:[],
            selectedLRO:[]
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
            self.show = false;
            axios.get(this.base_url+'/file-page/'+this.file_opening_id)
            .then(function(response){
                console.log(response);
                if(response.data.success){
                    var property = response.data.file_opening.property;
                    if(property){
                        self.form =getNewForm();
                        Utilities.copyProperties(property,self.form.property);
                        if(property.city){
                            self.initialCity = [{'text':property.city.city_name,'id':property.city.id}];
                            self.selectedCity = [property.city.id];
                        }

                        if(property.lro>0){
                            self.initialLRO = [{'text':property.lro,'id':property.lro}];
                            self.selectedLRO = [property.lro];
                        }

                    }
                    self.form.property.pins= [];
                    if(property && property.pins.length> 0){
                        property.pins.forEach(element => {
                            var pin = getPin();
                            pin.pin  = element.pin;
                            pin.id  = element.id;
                            self.form.property.pins.push(pin);
                        });
                    }
                    else{
                        self.form.property.pins.push(getPin());
                    }
                    self.form.file_opening_id = self.file_opening_id;
                    self.show = true;
                    self.form.copyData = JSON.parse(JSON.stringify(self.form.data()));
                }
            })
            .catch(function(error){
                console.log("error in Property Tab");
                console.log(error);
            });
        },
        addPin:function(e){
            this.form.property.pins.push(getPin());
        },
        submitForm:function(){
            var self = this;
            Utilities.showConfirmationPopMessage('Do you want to save the changes?',function(save){
                if(save == true){
                    self.form['postForm'](self.base_url+'/'+self.create_url)
                    .then(function(response){
                        if(response.success){
                            Utilities.showToast(self,'success','Property updated successfully',2200,true);
                            self.$emit('closeTriggered');
                        }
                    })
                    .catch(function(error){
                        console.log(error);
                    });
                }
            },true,false);

        },

        removePin:function(index){
            this.form.property.pins.splice(index,1);
        },

        updateCity:function(value,index,city){
            this.form.property.country = city.country;
            this.form.property.province = city.state;
        },

        addCity:function(){
            this.showCity = true;
        },

        closeCityModal:function(){
            this.showCity = false;
        },

        postalCode(field){
            this.form.property[field] =  this.form.property[field].toUpperCase();
            var str =  this.form.property[field];
            var matched = true;
            var x= '';
            switch(str.length) {
                case 1:
                    x = this.form.property[field].match(/[A-Z]/g);
                break;

                case 2:
                    x =this.form.property[field].match(/[A-Z][0-9]/g);
                break;

                case 3:
                    x = this.form.property[field].match(/[A-Z][0-9][A-Z]/g);
                break;

                case 4:
                    x = this.form.property[field].match(/[A-Z][0-9][A-Z][ ]/g);
                break;

                case 5:
                    x = this.form.property[field].match(/[A-Z][0-9][A-Z][ ][0-9]/g);
                break;

                case 6:
                    x =this.form.property[field].match(/[A-Z][0-9][A-Z][ ][0-9][A-Z]/g);
                break;

                case 7:
                    x =this.form.property[field].match(/[A-Z][0-9][A-Z][ ][0-9][A-Z][0-9]/g);
            }
            if(x== null){
                this.form.property[field]=  this.form.property[field].substring(0, this.form.property[field].length - 1);
                 if(str.length == 4){
                       this.form.property[field]= this.form.property[field]+ ' ';
                }

            }
            if(str.length == 3){
                 this.property.address[field] =  this.property.address[field]+' ';
            }
            if(str.length > 7 ){
                this.form.property[field]  = this.form.property[field].substring(0, 7);
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
