<template>
    <div class="form-horizontal">
        <div class="card-body">

              <fieldset class="fieldset">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle mb-2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            + Add
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" @click.prevent="addInformation('client')">Add Client Affidavit</a>
                            <a class="dropdown-item" @click.prevent="addInformation('solicitor')">Add Solicitor Affidavit</a>
                        </div>
                    </div>
                    <table class="table">
                        <tbody>

                            <tr v-for="(client,index) in form.client_affidavits" :key="client.random">
                                <td>
                                    <span v-text="index +1">
                                   </span>
                                </td>
                                <td>
                                    <strong>
                                    Seller’s affidavit
                                   </strong>
                                </td>
                                <td><button class="btn btn-primary"  @click.prevent="addInformation('client',index)">Edit Information</button></td>
                                <td>

                                  <client-affidavit

                                    :file_opening="file_opening"
                                    :client="client"
                                    :author="author"
                                ></client-affidavit>
                                </td>
                            </tr>

                            <tr v-for="(solicitor,index) in form.solicitor_affidavits" :key="solicitor.random">
                                <td> <span v-text="form.client_affidavits.length+index +1">
                                   </span>
                                </td>
                                <td>
                                    <strong>
                                    Solicitor's affidavit
                                   </strong>
                                </td>
                                <td><button class="btn btn-primary" @click.prevent="addInformation('solicitor',index)">Edit Information</button></td>
                                 <td>
                                    <solicitor-affidavit

                                        :file_opening="file_opening"
                                        :solicitor="solicitor"
                                        :author="author">
                                    </solicitor-affidavit>
                                 </td>
                            </tr>
                        </tbody>
                    </table>

                </fieldset>
        </div>
        <information-modal v-if="showInformation"
            :file_opening="file_opening"
            :file_opening_id="file_opening_id"
            :form="form"
            :type = "type"
            :index="index"
            :lro="lro"
            :cities="cities_arr"
            @closeTriggered="closeTriggered"
        >
        <div slot="form-title">
            <span v-text="type =='client'?'Client Information':'Solicitor Information'"></span>
        </div>
        </information-modal>
    </div>
</template>

<script>
import ClientAffidavit from './ClientAffidavit.vue';
import InformationModal from './InformationModal.vue';
import SolicitorAffidavit from './SolicitorAffidavit.vue';


function getNewForm(){
    return new Form({
        file_opening_id:0,
        client_affidavits:[],
        solicitor_affidavits:[],
    });
}
export default {
    props:['file_opening_id','author','file_opening','lro','cities'],
    data() {
        return {
            base_url:Munshi.base_url,
            token : $('meta[name="csrf-token"]').attr('content'),
            myFiles:[],
            form:getNewForm(),
            type:'client',
            showInformation:false,
            solicitorFields:[],
            index:-1
        };
    },

    components:{
        InformationModal,
        ClientAffidavit,
        SolicitorAffidavit
    },

    mounted:function(){
        this.getAffidavit();
    },

    computed:{
         cities_arr:function(){
            var arr =  [];
            this.cities.forEach(element => {
                arr.push({'id':element.id,'text':element.text = element.city_name});
            });
            return arr;
        }
    },


    methods: {
        onResponse:function(r) {

        },
        removedFile:function () {
        },

        getAffidavit:function(){
            var self = this;
                var target =self.file_opening['executions'];
                var client_exe =  target.filter(function(event){
                    return event.document_name == 'client';
                });
                    var solicitor_exe =  target.filter(function(event){
                    return event.document_name == 'solicitor';
                });
                var client_documents = client_exe.reduce((acc, item) => {
                    if (!acc[item.document_no]) {
                        acc[item.document_no] = [];
                    }

                    acc[item.document_no].push(item);
                    return acc;
                }, {});

                var solicitor_documents = solicitor_exe.reduce((acc, item) => {
                    if (!acc[item.document_no]) {
                        acc[item.document_no] = [];
                    }

                    acc[item.document_no].push(item);
                    return acc;
                }, {});
                console.log(client_documents);

                for(var client in client_documents){
                    self.form.client_affidavits.push({
                        document_no:client,
                        document_name:'client',
                        file_opening_id:self.file_opening_id,
                        fields:client_documents[client]
                    })
                }
                    for(var solicitor in solicitor_documents){
                    self.form.solicitor_affidavits.push({
                        document_no:solicitor,
                        document_name:'solicitor',
                        file_opening_id:self.file_opening_id,
                        fields:solicitor_documents[solicitor]
                    })
                }

            self.form.copyData = JSON.parse(JSON.stringify(self.form.data()));
        },

        addInformation:function(type,index=-1){
            var self = this;
            this.type = type;
            this.index = index;
            this.showInformation = true;

        },

        closeTriggered:function(){
            this.showInformation = false;
            this.type = '';
            this.index = -1;
        },

        produceDocument:function(type,index){
            var completed = true;
            if(type == 'client'){
                this.form.client_affidavits[index].fields.forEach(function(ele){
                    if(ele.value == '' || ele.value == null){
                        completed = false;
                    }
                })


            }
            else if(type == 'solicitor'){
                this.form.solicitor_affidavits[index].fields.forEach(function(ele){
                    if(ele.value == '' || ele.value == null){
                        completed = false;
                    }
                })


            }

            return completed;
        }
    }

}
</script>

<style>

</style>
