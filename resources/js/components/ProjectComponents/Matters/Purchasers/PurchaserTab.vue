<template>
    <div :id="'purchaser'+index" class="tab-pane fade" :class="index == 0 ? 'active show':''"  role="tabpanel" :aria-labelledby="'purchaser-tab_'+index">
         <!-- <span class="iw-remove-btn"  @click.prevent="$emit('removePurchaser',index)">Remove</span> -->
        <div class="form-horizontal">
                <div class="card-body">
                    <div class = "form-row">
                        <div class="col-md-3">
                           <div class="form-group">
                            <label for="first_name" class="in-label-title required">Salutation</label>
                            <select class="form-control" v-model="purchaser.salutation"  v-bind:class="{ 'is-invalid': form.errors.get('purchasers.'+index+'.salutation') }">
                                <option selected="selected" value="Mr.">Mr.</option>
                                <option value="Mrs.">Mrs.</option>
                                <option value="Miss">Miss</option>
                                <option value="Corporation">Corporation</option>
                            </select>
                            <span id="basic-msg" v-if="form.errors.get('purchasers.'+index+'.salutation')" class="invalid-feedback">{{ form.errors.get('purchasers.'+index+'.salutation') }}</span>
                            </div>
                        </div>
                         <div class="col-md-3"  v-if="purchaser.salutation == 'Corporation'">
                             <div class="form-group">
                            <label for="company_name" class="in-label-title ">Company Name</label>
                            <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('purchasers.'+index+'.company_name') }" type="text" v-model ="purchaser.company_name">
                            <span id="basic-msg" v-if="form.errors.get('purchasers.'+index+'.company_name')" class="invalid-feedback">{{ form.errors.get('purchasers.'+index+'.company_name') }}</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                            <label for="first_name" class="in-label-title required">First Name</label>
                            <input class="form-control"  v-bind:class="{ 'is-invalid': form.errors.get('purchasers.'+index+'.first_name') }"   type="text" v-model ="purchaser.first_name">
                            <span id="basic-msg" v-if="form.errors.get('first_name')" class="invalid-feedback">{{  form.errors.get('purchasers.'+index+'.first_name')  }}</span>
                            </div>
                        </div>
                         <div class="col">
                             <div class="form-group">
                            <label for="middle_name" class="in-label-title ">Middle Name</label>
                            <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('purchasers.'+index+'.middle_name') }" type="text" v-model ="purchaser.middle_name">
                            <span id="basic-msg" v-if="form.errors.get('purchasers.'+index+'.middle_name')" class="invalid-feedback">{{ form.errors.get('purchasers.'+index+'.middle_name') }}</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="last_name" class="in-label-title ">Last Name</label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('purchasers.'+index+'.last_name') }" type="text" v-model ="purchaser.last_name">
                                <span id="basic-msg" v-if="form.errors.get('purchasers.'+index+'.last_name')" class="invalid-feedback">{{ form.errors.get('purchasers.'+index+'.last_name') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class = "form-row">
                         <div class="col-md-2">
                             <div class="form-group" v-bind:class="{ 'is-invalid': form.errors.get('purchasers.'+index+'.dob') }"  >
                                <label for="dob" class="in-label-title ">Date of Birth</label>
                                <date-picker class-name="dob" v-model="purchaser.dob" ></date-picker>
                                <span id="basic-msg" v-if="form.errors.get('dob')" class="invalid-feedback">{{  form.errors.get('purchasers.'+index+'.dob')  }}</span>
                             </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                            <label for="title_capacity" class="in-label-title ">Title Capacity</label>
                            <select class="form-control" v-model="purchaser.title_capacity" v-bind:class="{ 'is-invalid': form.errors.get('purchasers.'+index+'.title_capacity') }"  >
                                <option value='registered_owner'>Registered Owner</option>
                                <option value='joint_tenants'>Joint Tenants</option>
                                <option value='tenants_in_common'>Tenants in Common(each as to 50% Interest/ Tenants in Common (without specifying share)</option>
                                <option value='silent'>Silent(Capacity not to be specified)</option>
                                <option value='others'>Others</option>
                            </select>
                            <span id="basic-msg" v-if="form.errors.get('title_capacity')" class="invalid-feedback">{{ form.errors.get('title_capacity') }}</span>
                            </div>
                        </div>
                        <div class="col" v-if="purchaser.title_capacity == 'others'">
                            <div class="form-group">
                                <label for="other_title_capacity" class="in-label-title required">Please Define</label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('purchasers.'+index+'.other_title_capacity') }" type="text" v-model ="purchaser.other_title_capacity">
                                <span id="basic-msg" v-if="form.errors.get('purchasers.'+index+'.other_title_capacity')" class="invalid-feedback">{{ form.errors.get('purchasers.'+index+'.other_title_capacity') }}</span>
                            </div>
                        </div>

                    </div>
                </div>
        </div>
    </div>
</template>

<script>

export default{
    props:['purchaser','index','form','random','permissions'],
    data:function(){
        return {
            // initialCurrentCity:[],
            // selectedCurrentCity:[],
            // initialClosingCity:[],
            // selectedClosingCity:[],
            show:false
        }
    },
    mounted:function(){
        // if(this.purchaser.closing_address.city){
        //     this.initialClosingCity = [{'text':this.purchaser.closing_address.city.city_name,'id':this.purchaser.closing_address.city_id}];
        //     this.selectedClosingCity = [this.purchaser.closing_address.city_id];
        // }
        // if(this.purchaser.current_address.city){
        //     this.initialClosingCity = [{'text':this.purchaser.current_address.city.city_name,'id':this.purchaser.current_address.city_id}];
        //     this.selectedClosingCity = [this.purchaser.current_address.city_id];
        // }
        this.show = true;
    },
    methods:{
        getNumber:function(){
            return  parseInt(this.index)+1;
        },
        // updateCurrentCity:function(value,index,city){
        //     this.purchaser.current_address.country = city.country;
        // },
        // updateClosingCity:function(value,index,city){
        //     this.purchaser.closing_address.country = city.country;
        // }
    }
}
</script>

<style>

</style>
