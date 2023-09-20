<template>
    <modal-cover @closeModal="$emit('closeTriggered')" modal_size="modal-lg" modal-class="cover_modal">
      <!-- MODAL BODY -->
        <div slot="modal-title">
            <span>Requisition Response</span>
        </div>
        <div slot="modal-cover-body">
            <div class="form-horizontal">
                <div class="card-body">
                    <div class = "form-row" v-if="type== ''">
                        <div class="col">
                            <div class="form-group">
                            <label for="precendent_id" class="in-label-title ">Select Precedent</label>
                                <precedent-select  :index="1" v-model="precendent_id" @updatePrecedent="updatePrecedent"></precedent-select>
                            </div>
                        </div>
                    </div>
                    <div class = "form-row" v-if="type== 'save'">
                        <div class="col">
                            <div class="form-group">
                                <label for="precendent_id" class="in-label-title required">Precedent Name</label>
                                <input type="text" v-model="form.name"   v-bind:class="{ 'is-invalid': form.errors.get('name') }"  class="form-control">
                                <span id="basic-msg" v-if="form.errors.get('name')" class="invalid-feedback">{{ form.errors.get('name') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class = "form-row" v-if="type== 'override'">
                        <div class="col">
                            <div class="form-group">
                                <label for="precendent_id" class="in-label-title ">Select Name</label>
                                <precedent-select :index="2" v-model="form.form_id"></precedent-select>
                            </div>
                        </div>
                    </div>
                    <label for="precendent_id" v-if="precedent" class="in-label-title ">Format</label>
                    <div v-html="precedent"></div>
                </div>
                <button class="btn btn-primary" @click.prevent="insertFormat" v-if="type ==''">Insert Format</button>
                <button class="btn btn-primary" @click.prevent="saveFormat" v-else-if="type =='save'">Save Format</button>
                <button class="btn btn-primary" @click.prevent="saveFormat" v-else-if="type =='override'">Override Format</button>

            </div>
        </div>
    </modal-cover>
</template>

<script>
function getNewForm(){
    return new Form({
        form_id:0,
        name:'',
        format_text:''
    });
}

export default
 {
    props:['selected_precedent_id','precedent_content','type'],
    data:function(){
        return {
            create_url:'precedents',
            base_url:Munshi.base_url,
            precendent_id:0,
            precedent:null,
            form:getNewForm()
        }
    },
    mounted:function(){
        if(this.type != '' && this.precedent !=''){
            this.precedent = this.precedent_content;
            this.form.format_text = this.precedent_content;
        }
    },
    methods:{
        updatePrecedent:function(value,index,data){
            if(this.type ==''){
                this.precedent = data.format_text;
                this.precendent_id = value;
            }
        },

        insertFormat:function(){
            $('.cover_modal').modal('hide');
            this.$emit('insertFormat',this.precendent_id,this.precedent);
        },


        saveFormat:function(){
            var self = this;
             Utilities.showConfirmationPopMessage('Do you want to save the changes?',function(save){
                if(save == true){
                    self.form['postForm'](self.base_url+'/'+self.create_url)
                    .then(function(response){
                        if(response.success){
                            Utilities.showToast(self,'success','Precedent updated successfully',2200,true);
                            $('.cover_modal').modal('hide');
                            self.$emit('closeTriggered');
                        }
                    })
                    .catch(function(error){
                        console.log(error);
                    });
                }
            },true,false);
        }


    }
}
</script>

<style>

</style>
