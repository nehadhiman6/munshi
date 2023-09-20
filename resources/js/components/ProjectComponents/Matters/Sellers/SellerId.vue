<template>
    <fieldset class="fieldset-inner">
        <legend class="legend-inner">#ID {{index+1}}</legend>
        <div class = "form-row">
            <div class="col">
                <div class="form-group">
                <label for="id_type" class="in-label-title ">ID Type</label>
                <select class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('sellers.'+sellerIndex+'.seller_ids.'+index+'.id_type') }" v-model ="seller_id.id_type">
                    <option v-for="type in docTypes" :key="type.id" :value="type.id">{{type.value}}
                    </option>
                </select>
                <span id="basic-msg" v-if="form.errors.get('sellers.'+sellerIndex+'.seller_ids.'+index+'.id_type')" class="invalid-feedback">{{ form.errors.get('sellers.'+sellerIndex+'.seller_ids.'+index+'.id_type') }}</span>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                <label for="number" class="in-label-title ">Number</label>
                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('sellers.'+sellerIndex+'.seller_ids.'+index+'.number') }" type="text" v-model ="seller_id.number">
                <span id="basic-msg" v-if="form.errors.get('sellers.'+sellerIndex+'.seller_ids.'+index+'.number')" class="invalid-feedback">{{ form.errors.get('sellers.'+sellerIndex+'.seller_ids.'+index+'.number') }}</span>
                </div>
            </div>
            <div class="col">
                <div class="form-group"  v-bind:class="{ 'is-invalid': form.errors.get('sellers.'+sellerIndex+'.seller_ids.'+index+'.expiry_date') }" >
                <label for="expiry_date" class="in-label-title ">Expiry Date</label>
                <date-picker v-model="seller_id.expiry_date" :today-date="seller_id.expiry_date" class-name="expiry_date" yearsRange="-100:+50"></date-picker>
                <span id="basic-msg" v-if="form.errors.get('sellers.'+sellerIndex+'.seller_ids.'+index+'.expiry_date')" class="invalid-feedback">{{ form.errors.get('sellers.'+sellerIndex+'.seller_ids.'+index+'.expiry_date') }}</span>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                <label for="issuing_jurisdiction" class="in-label-title ">Issuing Jurisdiction</label>
                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('sellers.'+sellerIndex+'.seller_ids.'+index+'.issuing_jurisdiction') }" type="text" v-model ="seller_id.issuing_jurisdiction">
                <span id="basic-msg" v-if="form.errors.get('sellers.'+sellerIndex+'.seller_ids.'+index+'.issuing_jurisdiction')" class="invalid-feedback">{{ form.errors.get('sellers.'+sellerIndex+'.seller_ids.'+index+'.issuing_jurisdiction') }}</span>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                <label for="issuing_country" class="in-label-title ">Issuing Country</label>
                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('sellers.'+sellerIndex+'.seller_ids.'+index+'.issuing_country') }" type="text" v-model ="seller_id.issuing_country">
                <span id="basic-msg" v-if="form.errors.get('sellers.'+sellerIndex+'.seller_ids.'+index+'.issuing_country')" class="invalid-feedback">{{ form.errors.get('sellers.'+sellerIndex+'.seller_ids.'+index+'.issuing_country') }}</span>
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
                <a :href="base_url+'/attachments/download/'+seller_id.resources[0].attachment_id" v-if="seller_id.resources.length>0 && seller_id.resources[0].attachment_id > 0">Download</a>
            </div>
            <!-- <div class="col-md-2"  v-if="seller_id.resources.length > 0">
                <image-preview-gallery v-if="seller_id.resources.length > 0"  :key="seller_id.random"
                    :show-remove = "true"
                    :imagesArr= "seller_id.resources"
                    :initial-id ="0"
                    id-label="attachment_id"
                    path-thumbnail = "attachments-thumbnail"
                    path = "attachments"
                    @removeAttachment= "removeAttachment">
                </image-preview-gallery>
            </div> -->
            <!-- <div class="col-md-2">
                <input class="btn iw-btn iw-btn-attach mr-2" @click.prevent="showUpload = true" type="submit" value="Upload Idenetity Document">
            </div> -->
        </div>
           <!-- <attachment-upload-modal :key="seller_id.random"
                v-if="showUpload"
                :showRemarks="false"
                :strict-fixed-numbers="true"
                :number-attachments="1"
                :initial-resources ="seller_id.resources"
                :allow-file-type-validation ="true"
                :accepted-file-types = "['image/*','application/pdf']"
                @updateResources="updateResources">
                Upload Post Attachments
            </attachment-upload-modal> -->
    </fieldset>
</template>

<script>
function getAttachment(){
    return{
        id:0,
        attachment_id:0,
        doc_type:'0',
        doc_description:'',
        random:Utilities.getRandomNumber()
    }
}
import DatePicker from '../../../BasicComponents/DatePicker.vue';
export default {
  components: { DatePicker },
    props:['seller_id','form','index','sellerIndex'],
    data:function(){
        return {
            showUpload:false,
            docTypes:[
                {value:'Passport' ,'id':'Passport'},
                {value:'Driver’s Licence' ,'id':'Driver’s Licence'},
                {value:'SIN' ,'id':'SIN'},
                {value:'PR Card' ,'id':'PR Card'},
                {value:'Citizenship Certificate' ,'id':'Citizenship Certificate'},
                {value:'Naturalization  Card ','id':'Naturalization Card'},
                {value:'Birth Certificate' ,'id':'Birth Certificate'},
                {value:'Photo Card' ,'id':'Photo Card'},
                {value:'Others' ,'id':'Others'},
            ],
            base_url:Munshi.base_url,
            token : $('meta[name="csrf-token"]').attr('content'),
            myFiles:[]
        }
    },
    mounted:function(){
        var self = this;
        if(this.seller_id.resources.length == 0){
            self.seller_id.resources.push(getAttachment());
        }
        else{
            this.myFiles = [];
            self.myFiles.push({
                source:self.base_url+'/attachments/'+self.seller_id.resources[0].attachment_id,
                options:{
                    type:'local',
                    metadata: {
                        poster: self.base_url+'/attachments/'+self.seller_id.resources[0].attachment_id
                    },
                },
            });
        }
    },
    computed:{
        // myFiles:function(){
        //     var self = this;
            // self.seller_id.resources.forEach(element => {
            //     self.myFiles.push({
            //         source:self.base_url+'/attachments/'+element.attachment_id,
            //         options:{
            //             type:'local',
            //             metadata: {
            //                 poster: self.base_url+'/attachments/'+element.attachment_id
            //             },
            //         },
            //     });
            // });

        // }
    },
    methods:{
        updateResources:function(save=true,files){
            console.log(files);
            if(save == true){
                this.seller_id.resources = files;
            }
            this.showUpload= false;
        },
        // removeAttachment:function(index){
        //     this.seller_id.resources.splice(index,1);
        // },
        onResponse:function(r) {
            var data = JSON.parse(r);
            this.seller_id.resources[0].attachment_id = data.attachment;
        },
        removedFile:function () {
            console.log("removed File");
            this.seller_id.resources[0].attachment_id = 0;
        }
    }
}
</script>

<style>

</style>
