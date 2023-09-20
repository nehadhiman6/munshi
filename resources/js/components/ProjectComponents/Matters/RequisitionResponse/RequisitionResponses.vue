<template>
    <div>

        <div class=" card-header d-flex flex-wrap align-items-center justify-content-between  py-1">
            <div class="card-title mb-0"><span><strong>Response to Requisition</strong></span></div>
            <div class ="float-right">
                <input class="btn iw-btn iw-btn-submit py-1" :value="form.form_id > 0 ? 'Update' : 'Save'" @click.prevent ="submitForm" type="submit">
            </div>
        </div>
        <div class="card-body">
        <div class="iw-horizontal-tabs">
            <nav>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item"  v-for="(requisition_response,index) in form.requisition_responses" :key="requisition_response.random">
                        <a class="nav-link" :class="{'active':index == 0}" :id="'requisition_response-tab_'+index" data-toggle="tab"
                            :href="'#requisition_responses'+index" role="tab" :aria-controls="'requisition_response-tab_'+index" :aria-selected="index == 0">
                                Requisition {{getNumber(index)}}
                            <span class="iw-close-tab" @click.prevent="removeRequisitionResponse"><i class="mdi mdi-close"></i></span>
                        </a>
                    </li>
                    <li v-if="form.requisition_responses.length < 6">
                        <a class="nav-link"  @click.prevent="addRequisitionResponse" href="#">+ Add Requisition Response </a>
                    </li>
                </ul>
             </nav>
            <div class="tab-content" id="myTabContent">
                <requisition-tab v-for="(requisition_response,index) in form.requisition_responses" :key="requisition_response.random"
                    :form="form"
                    :permissions="permissions"
                    :requisition_response="requisition_response"
                    :index="index"
                    @removeRequisitionResponse="removeRequisitionResponse">
                </requisition-tab>
            </div>
        </div>

        <div class ="mt-4">
            <input class="btn iw-btn iw-btn-submit" :value="form.form_id > 0 ? 'Update' : 'Save'" @click.prevent ="submitForm" type="submit">
        </div>
    </div>
    </div>
</template>

<script>
import FormatPrecedence from './FormatPrecedence.vue';
import RequisitionTab from './RequisitionTab.vue';
function addResponseRequisiton(){
    return{
        id:0,
        date:'',
        received_date:'',
        precedent:'',
        response_sent:'',
        random:Utilities.getRandomNumber()
    }

}

function getNewForm(){
    return new Form({
        requisition_responses:[],
        file_opening_id:0,
    })
}


export default
 {
    props:['file_opening_id','permissions'],
    components: { RequisitionTab, FormatPrecedence },
    data:function(){
        return {
            form:getNewForm(),
            create_url:'requisition-responses',
            base_url:Munshi.base_url,
            show:true,
            random:Utilities.getRandomNumber(),
            imported:false
        }
    },
    mounted:function(){
        this.getRequisitionResponse();
        this.form.file_opening_id = this.file_opening_id;
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

        getRequisitionResponse:function(){
            var self = this;
            self.show=false;
            axios.get(this.base_url+'/file-page/'+this.file_opening_id)
            .then(function(response){
                console.log(response);
                if(response.data.success){
                    var requisition_responses = response.data.file_opening.requisition_responses;
                    if(requisition_responses.length ==0  ){
                        self.addRequisitionResponse();
                    }
                    else{
                        requisition_responses.forEach(element => {
                            element.random = Utilities.getRandomNumber();
                        });
                        self.form.requisition_responses = requisition_responses;
                    }
                   self.form.copyData = JSON.parse(JSON.stringify(self.form.data()));
                }
            })
            .catch(function(error){
                console.log(error);
            });
        },
        addRequisitionResponse:function(e){
            this.form.requisition_responses.push(addResponseRequisiton(this.file_opening_id));
            var index = this.form.requisition_responses.length-1;
            setTimeout(function(){
                $('.nav-tabs a[href="#requisition_responses'+index+'"]').tab('show');
            },300);
        },
        getNumber:function(index){
            return  parseInt(index)+1;
        },
        submitForm:function(){
            var self = this;
            Utilities.showConfirmationPopMessage('Do you want to save the changes?',function(save){
                if(save == true){
                    self.form['postForm'](self.base_url+'/'+self.create_url)
                    .then(function(response){
                        if(response.success){
                            self.form.copyData = JSON.parse(JSON.stringify(self.form.data()));
                            Utilities.showToast(self,'success','Requisition Response updated successfully',2200,true);
                        }
                    })
                    .catch(function(error){
                        console.log(error);
                    });
                }
            },true,false);

        },

        removeRequisitionResponse:function(index){
            this.form.requisition_responses.splice(index,1);
            var active = 0;
            if(index > 0){
                active = index-1;
            }
            else if(this.form.requisition_responses.length>0){
                active = index+1;
            }
            setTimeout(function(){
                $('.nav-tabs a[href="#requisition_responses'+active+'"]').tab('show');
            },500);
        },
    }
}
</script>

<style>

</style>
