<template>
    <modal-cover  @closeModal="checkUnsavedAndShowMessage"  :modal-hide="false" modal_size="modal-sm" modal-class="transaction-type">
      <!-- MODAL BODY -->
        <div slot="modal-title">
            <span v-if="form.form_id == 0">Add Credit Type Form</span>
            <span v-if="form.form_id > 0">Edit Credit Type Form</span>
        </div>
        <div slot="modal-cover-body">
            <div class="form-horizontal">
                <div class="card-body">
                    <div class = "form-row">
                        <div class="col">
                            <div class="form-group">
                            <label for="type_name" class="in-label-title required">Type Name</label>
                            <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('type_name') }" type="text" v-model ="form.type_name">
                            <span id="basic-msg" v-if="form.errors.get('type_name')" class="invalid-feedback">{{ form.errors.get('type_name') }}</span>
                            </div>
                        </div>
                    </div>
                     <div class ="mt-4">
                        <input class="btn iw-btn iw-btn-submit" :value="form.form_id > 0 ? 'Update' : 'Save'" @click.prevent ="submitForm" type="submit">
                        <input class="btn iw-btn iw-btn-cancel" value ="Cancel" @click.prevent ="checkUnsavedAndShowMessage" type="submit" >
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
        type_name:''
    })
}
export default
 {
    props:{
        formId:{
            default:0,
            type:[String,Number]
        },
    },
    data:function(){
        return {
            form:getNewForm(),
            create_url:'transaction-types',
            base_url:Munshi.base_url,
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
                            Utilities.showToast(self,'success','Transaction type updated successfully',2200,true);
                            $('.transaction-type').modal('hide');
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
            $('.transaction-type').modal('hide');
            // this.$emit('closeTriggered');
        },

        editCity:function(){
            var self = this;
            axios.get(this.base_url+'/'+this.create_url+'/'+this.formId+'/edit')
            .then(function(response){
                if(response.data.success){
                    var transaction_type = response.data.transaction_type;
                    Utilities.copyProperties(transaction_type, self.form);
                    self.form.form_id = transaction_type.id;
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
