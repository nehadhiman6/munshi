<template>
    <modal-cover  @closeModal="checkUnsavedAndShowMessage" :modal-hide="false" modal_size="modal-sm" modal-class="city_modal">
      <!-- MODAL BODY -->
        <div slot="modal-title">
            <span v-if="form.form_id == 0">Add City</span>
            <span v-if="form.form_id > 0">Edit City</span>
        </div>
        <div slot="modal-cover-body">
            <div class="form-horizontal">
                <div class="card-body">
                    <div class = "form-row">
                        <div class="col">
                            <div class="form-group">
                            <label for="city_name" class="in-label-title required">City Name</label>
                            <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('city_name') }" type="text" v-model ="form.city_name">
                            <span id="basic-msg" v-if="form.errors.get('city_name')" class="invalid-feedback">{{ form.errors.get('city_name') }}</span>
                            </div>
                        </div>
                    </div>
                     <div class = "form-row">

                         <div class="col">
                             <div class="form-group" v-bind:class="{ 'is-invalid': form.errors.get('state') }" >
                            <label for="state" class="in-label-title required">Province</label>
                            <!-- <input class="form-control" type="text" v-model ="form.state"> -->
                            <canadian-state-select v-if="show" v-model="form.state" :initials="initialProvince" :selected="selectedProvince"></canadian-state-select>
                            <span id="basic-msg" v-if="form.errors.get('state')" class="invalid-feedback">{{ form.errors.get('state') }}</span>
                             </div>
                        </div>
                     </div>
                      <div class = "form-row">
                          <div class="col">
                              <div class="form-group">
                            <label for="country" class="in-label-title required">Country</label>
                            <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('country') }" type="text" v-model ="form.country">
                            <span id="basic-msg" v-if="form.errors.get('country')" class="invalid-feedback">{{ form.errors.get('country') }}</span>
                              </div>
                        </div>
                    </div>
                     <div class = "form-row">
                          <div class="col">
                              <div class="form-group">
                            <label for="lro_id" class="in-label-title">LRO </label>
                            <lro-select v-if="show" v-model='form.lro_id' :index="'lro'+1" :initials="lro" :selected="[form.lro_id]"></lro-select>
                            <span id="basic-msg" v-if="form.errors.get('lro_id')" class="invalid-feedback">{{ form.errors.get('lro_id') }}</span>
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
        city_name:'',
        state:'',
        lro_id:0,
        country:'Canada',
    })
}
export default
 {
    props:{
        formId:{
            default:0,
            type:[String,Number]
        },
        categories:{
            default:function(){
                return [];
            },
            type:[Array]
        },
        lro:{
            default:function(){
                return [];
            },
            type:[Array]
        }
    },
    data:function(){
        return {
            form:getNewForm(),
            create_url:'cities',
            base_url:Munshi.base_url,
            initialProvince:[],
            selectedProvince:[],
            show:true
        }
    },

    mounted(){
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
                            Utilities.showToast(self,'success','Cities updated successfully',2200,true);
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
                    var city = response.data.city;
                    Utilities.copyProperties(city, self.form);
                    self.form.form_id = city.id;
                    self.initialProvince = [{'id':city.state,'text':city.state}];
                    self.selectedProvince = [city.state];
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

        }
    }
}
</script>

<style>

</style>
