<template>
    <modal-cover  @closeModal="checkUnsavedAndShowMessage" :modal-hide="false" modal_size="modal-lg" modal-class="city_modal">
      <!-- MODAL BODY -->
        <div slot="modal-title">
            <span v-if="form.form_id == 0">Add  Department ( <span v-text="city.city_name"></span>)</span>
            <span v-if="form.form_id > 0">Edit Department  ( <span v-text="city.city_name"></span>)</span>
        </div>
        <div slot="modal-cover-body">
            <div class="form-horizontal">
                <div class="card-body">
                    <div class = "form-row">
                        <div class="col">
                            <div class="form-group">
                                <label for="department_type" class="in-label-title required">Department Type</label>
                                <select class="form-control" v-model="form.department_type"  v-bind:class="{ 'is-invalid': form.errors.get('department_type') }" >
                                    <option v-for="(type,index) in department_types"  :key="index" :value="type.value">
                                        {{type.name}}
                                    </option>
                                </select>
                                <span id="basic-msg" v-if="form.errors.get('department_type')" class="invalid-feedback">{{ form.errors.get('department_type') }}</span>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <div class="col" v-if="form.department_type == 'water' || form.department_type == 'tax'  || form.department_type == ''">
                                    <label for="department_name" class="in-label-title required">City/Muncipality</label>
                                </div>

                                <div class="col" v-if="form.department_type == 'hydro' || form.department_type == 'gas'">
                                    <label for="department_name" class="in-label-title required">Service Provider</label>
                                </div>

                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('department_name') }" type="text" v-model ="form.department_name">
                                <span id="basic-msg" v-if="form.errors.get('department_name')" class="invalid-feedback">{{ form.errors.get('department_name') }}</span>
                            </div>
                        </div>


                    </div>
                     <div class = "form-row">

                         <div class="col">
                            <div class="form-group">
                                <label for="attention" class="in-label-title required">Attention</label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('attention') }" type="text" v-model ="form.attention">
                                <span id="basic-msg" v-if="form.errors.get('attention')" class="invalid-feedback">{{ form.errors.get('attention') }}</span>
                            </div>
                        </div>

                                                    <div class="col">
                                <div class="form-group">
                                <label for="street_no" class="in-label-title ">Street</label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('street_no') }" type="text" v-model ="form.street_no">
                                <span id="basic-msg" v-if="form.errors.get('street_no')" class="invalid-feedback">{{ form.errors.get('number') }}</span>
                                </div>
                            </div>

                    </div>
                    <div class = "form-row">
                            <div class="col">
                                <div class="form-group">
                                <label for="street_name" class="in-label-title ">Other</label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('street_name') }" type="text" v-model ="form.street_name">
                                <span id="basic-msg" v-if="form.errors.get('street_name')" class="invalid-feedback">{{ form.errors.get('street_name') }}</span>
                                </div>
                            </div>

                            <div class="col">

                            <div class="form-group">
                                <label for="city_municipality" class="in-label-title required">City</label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('city_municipality') }" type="text" v-model ="form.city_municipality">
                                <span id="basic-msg" v-if="form.errors.get('city_municipality')" class="invalid-feedback">{{ form.errors.get('city_municipality') }}</span>
                            </div>
                            </div>

                        </div>
                     <div class = "form-row">

                            <div class="col">
                                <div class="form-group">
                                <label for="province" class="in-label-title ">Province</label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('province') }" type="text" disabled v-model ="form.province">
                                <span id="basic-msg" v-if="form.errors.get('province')" class="invalid-feedback">{{ form.errors.get('province') }}</span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                <label for="postal_code" class="in-label-title ">Postal Code</label>
                                <input class="form-control"  v-bind:class="{ 'is-invalid': form.errors.get('postal_code') }" type="text" v-model ="form.postal_code" @input="postalCode('postal_code',$event.target.value)">
                                <span id="basic-msg" v-if="form.errors.get('postal_code')" class="invalid-feedback">{{ form.errors.get('postal_code') }}</span>
                                </div>
                            </div>
                    </div>
                     <div class = "form-row">
                            <div class="col">
                                <div class="form-group">
                                <label for="phone" class="in-label-title ">Phone</label>
                                <input class="form-control" @input="acceptNumber('phone')"   v-bind:class="{ 'is-invalid': form.errors.get('phone') }" type="text" v-model ="form.phone">
                                <span id="basic-msg" v-if="form.errors.get('phone')" class="invalid-feedback">{{ form.errors.get('phone') }}</span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                <label for="fax" class="in-label-title ">Fax</label>
                                <input class="form-control" @input="acceptNumber('fax')"   v-bind:class="{ 'is-invalid': form.errors.get('fax') }" type="text" v-model ="form.fax">
                                <span id="basic-msg" v-if="form.errors.get('fax')" class="invalid-feedback">{{ form.errors.get('fax') }}</span>
                                </div>
                            </div>
                     </div>
                     <div class = "form-row">

                            <div class="col">
                                <div class="form-group">
                                <label for="email" class="in-label-title ">Email</label>
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('email') }" type="text"  v-model ="form.email">
                                <span id="basic-msg" v-if="form.errors.get('email')" class="invalid-feedback">{{ form.errors.get('email') }}</span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                <label for="website_link" class="in-label-title ">Website Link</label>
                                <input class="form-control"  v-bind:class="{ 'is-invalid': form.errors.get('website_link') }" type="text" v-model ="form.website_link">
                                <span id="basic-msg" v-if="form.errors.get('website_link')" class="invalid-feedback">{{ form.errors.get('website_link') }}</span>
                                </div>
                            </div>
                    </div>
                     <div class ="mt-4">
                        <input class="btn iw-btn iw-btn-submit" :value="form.form_id > 0 ? 'Update' : 'Save'" @click.prevent ="submitForm" type="submit">
                        <input class="btn iw-btn iw-btn-cancel" value ="Cancel" @click.prevent ="resetForm" type="submit" >
                    </div>
                </div>
            </div>
        </div>
    </modal-cover>
</template>

<script>

function getNewForm(){
    return new Form({
        form_id:0,
        city_id:'',
        department_type:'',
        department_name:'',
        city_municipality:'',
        service_provider_name:'',
        attention:'',
        street_no:'',
        street_name:'',
        province:'',
        postal_code:'',
        phone:'',
        fax:'',
        email:'',
        website_link:''
    })
}
export default
 {
    props:{
        formId:{
            default:0,
            type:[String,Number]
        },
        department_types:{
            default:function(){
                return [];
            },
            type:[Array]
        },
        city:{
            default:function(){
                return null
            }
        }

    },
    data:function(){
        return {
            form:getNewForm(),
            create_url:'city-departments',
            base_url:Munshi.base_url,
            initialProvince:[],
            selectedProvince:[],
            show:true
        }
    },
    mounted(){
        this.form.province = this.city.state;
        this.form.city_id = this.city.id;
        if(this.formId >0){
            this.editCity();
        }
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
                            Utilities.showToast(self,'success','City Departments updated successfully',2200,true);
                            $('.city_modal').modal('hide');
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
            $('.city_modal').modal('hide');
            // this.$emit('closeTriggered');
        },

        editCity:function(){
            var self = this;
            this.show = false;
            axios.get(this.base_url+'/'+this.create_url+'/'+this.formId+'/edit')
            .then(function(response){
                if(response.data.success){
                    var city_department = response.data.city_department;
                    Utilities.copyProperties(city_department, self.form);
                    self.form.form_id = city_department.id;
                     self.show = true;
                    self.form.copyData = JSON.parse(JSON.stringify(self.form.data()));
                }
            })
            .catch(function(error){
            });
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
            // this.form[field] = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
        },

        postalCode(field){
            this.form[field] =  this.form[field].toUpperCase();
            var str =  this.form[field];
            var matched = true;
            var x= '';
            switch(str.length) {
                case 1:
                    x = this.form[field].match(/[A-Z]/g);
                break;

                case 2:
                    x =this.form[field].match(/[A-Z][0-9]/g);
                break;

                case 3:
                    x = this.form[field].match(/[A-Z][0-9][A-Z]/g);
                break;

                case 4:
                    x = this.form[field].match(/[A-Z][0-9][A-Z][ ]/g);
                break;

                case 5:
                    x = this.form[field].match(/[A-Z][0-9][A-Z][ ][0-9]/g);
                break;

                case 6:
                    x =this.form[field].match(/[A-Z][0-9][A-Z][ ][0-9][A-Z]/g);
                break;

                case 7:
                    x =this.form[field].match(/[A-Z][0-9][A-Z][ ][0-9][A-Z][0-9]/g);
            }
            if(x== null){
                this.form[field]=  this.form[field].substring(0, this.form[field].length - 1);
                 if(str.length == 4){
                       this.form[field]= this.form[field]+ ' ';
                }

            }
            if(str.length > 7 ){
                this.form[field]  = this.form[field].substring(0, 7);
            }
            // var x = this.form.address[field].match(/[A-Z][0-9][A-Z][ ][0-9][A-Z][0-9]/g);
        },

    }
}
</script>

<style>

</style>
