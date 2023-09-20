<template>
    <div :id="'requisition_responses'+index" class="tab-pane fade" :class="index == 0 ? 'active show':''"  role="tabpanel" :aria-labelledby="'requisition_responses-tab_'+index">
         <!-- <span class="iw-remove-btn"  @click.prevent="$emit('removeRequisitionResponse',index)">Remove</span> -->

        <div class="form-horizontal">
            <div class="card-body">
                <div class = "form-row">
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group" v-bind:class="{ 'is-invalid': form.errors.get('requisition_responses.'+index+'.date') }">
                                    <label for="date" class="in-label-title required">Requisition Date</label>
                                    <date-picker v-model ="requisition_response.date" :class-name='"requisition_date"+random'></date-picker>
                                    <span id="basic-msg" v-if="form.errors.get('requisition_responses.'+index+'.date')" class="invalid-feedback">{{ form.errors.get('requisition_responses.'+index+'.date') }}</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group" v-bind:class="{ 'is-invalid': form.errors.get('requisition_responses.'+index+'.received_date') }">
                                    <label for="received_date" class="in-label-title required">Received Date</label>
                                    <date-picker v-model ="requisition_response.received_date" :class-name='"received_date"+random'></date-picker>
                                    <span id="basic-msg" v-if="form.errors.get('requisition_responses.'+index+'.received_date')" class="invalid-feedback">{{ form.errors.get('requisition_responses.'+index+'.received_date') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input type="checkbox" v-bind:class="{ 'is-invalid': form.errors.get('requisition_responses.'+index+'.response_sent') }" class="form-check-input" id="response_sent" v-model="requisition_response.response_sent" true-value='Y' false-value='Y'>
                                            <label class="form-check-label" for="response_sent">Response Sent</label>
                                            <span id="basic-msg" v-if="form.errors.get('requisition_responses.'+index+'.response_sent')" class="invalid-feedback">{{ form.errors.get('requisition_responses.'+index+'.response_sent') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button class="btn btn-sm btn-primary  float-right ml-1 mb-2" @click.prevent='showModal("save")'>+ Save</button>
                                        <button class="btn btn-sm btn-primary float-right ml-2 mb-2" @click.prevent="insertFormat()" :disabled="!precedent_id>0"> Import</button>
                                        <button v-if="precedent_id > 0" class="btn btn-sm btn-primary  float-right ml-1 mb-2" @click.prevent='showModal("override")'>Override</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card card-body">
                            <format-precedence v-if="showPrecedent"
                            @closeTriggered="importPrecedent">
                            </format-precedence>
                        </div>
                    </div>
                </div>
                 <div class = "form-row">
                    <div class="col">
                         <div class="form-check">
                           <label for="precedent" class="in-label-title required">Precedent</label>
                            <editor ref="iweditor" v-model='requisition_response.precedent'></editor>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-4 user">
                    <file-pond
                        ref="pond"
                        :imagePreviewMaxHeight="50"
                        labelIdle =  'Drag & drop your document here'
                        style-panel-layout="compact"
                        accepted-file-types = "image/jpeg, image/png"
                        v-bind:server="{
                            url: base_url+'/',
                            timeout: 7000,
                            process: {
                                url: 'attachments',
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN':token
                                },
                                withCredentials: false,
                                onload: onResponse,
                            },
                            revert: null
                        }"
                        :files="myFiles"
                        @removefile ="removedFile"
                        >
                    </file-pond>
                    <!-- <a :href="#" v-if="seller_id.resources.length>0 && seller_id.resources[0].attachment_id > 0">Download</a> -->
                </div>
            </div>

        </div>

        <requisition-response-modal v-if="show"
            :selected_precedent_id="precedent_id"
            :precedent_content="requisition_response.precedent"
            :key="requisition_response.random"
            :type="type"
            :random=  "requisition_response.random"
            @closeTriggered="closeTriggered"
            @insertFormat="insertFormat">
        </requisition-response-modal>
    </div>
</template>

<script>
import FormatPrecedence from './FormatPrecedence.vue';
import RequisitionResponseModal from './RequisitionResponseModal.vue';

export default{
  components: { RequisitionResponseModal, FormatPrecedence },
    props:['requisition_response','index','form','permissions'],
    data:function(){
        return {
            show:false,
            precedent_id:0,
            type:'',
            random:Utilities.getRandomNumber(),
            base_url:Munshi.base_url,
            token : $('meta[name="csrf-token"]').attr('content'),
            myFiles:[],
            showPrecedent:true,
            selectionIndex:0,
            precedent:''

        }
    },

    methods:{
        getNumber:function(){
            return  parseInt(this.index)+1;
        },

        showModal:function(type=''){
            this.show = true;
            this.type = type;

        },
        closeTriggered:function(){
            this.show = false;
            this.precedent_id=0;
            this.type='';
            Utilities.refreshComponent(this,'showPrecedent');
        },
        insertFormat:function(){
            // this.selectionIndex = this.$refs.iweditor.$children[0].quill.getSelection()? this.$refs.iweditor.$children[0].quill.getSelection().index:0;// get cursor position
            this.selectionIndex = this.$refs.iweditor.currentCursorLoc ? this.$refs.iweditor.currentCursorLoc.index : 0;// get cursor position
            if (this.selectionIndex >= 0) {
                this.$refs.iweditor.$children[0].quill.clipboard.dangerouslyPasteHTML(this.selectionIndex, this.precedent.format_text, "silent");
                // this.$refs.iweditor.$children[0].quill?this.$refs.iweditor.$children[0].quill.insertText(this.selectionIndex, delta):""; // insert text after the index

            }
                this.show = false;
                this.selectionIndex = 0
        },

         onResponse:function(r) {

        },
        removedFile:function () {
        },

        importPrecedent:function(precedent_id, precedent){
            this.precedent_id = precedent_id;
            this.precedent =  precedent;
        },

    }
}
</script>

<style>

</style>
