<template>
    <modal-cover  @closeModal="$emit('closeTriggered')" :modal-hide="true" modal_size="modal-lg" modal-class="information_modal">
      <!-- MODAL BODY -->
        <div slot="modal-title">
            <slot name="form-title"></slot>
        </div>
        <div slot="modal-cover-body">
            <div class="form-horizontal">
                <div class="card-body">
                     <div class = "form-row" v-if="detail"  >
                         <div class="col-md-4" v-for="(field,index) in detail.fields" :key='index'>
                             <div class="form-group" v-bind:class="{ 'is-invalid': form.errors.get(field.field_name) }" >
                            <label :for="field.field_name" class="in-label-title ">{{field.caption}}</label>
                            <date-picker v-if="field.input_type == 'datepicker'" v-model="field.value" :class-name="field.field_name" ></date-picker>
                            <component :is="field.select2" v-else-if="field.input_type == 'select2'" v-model ="field.value" :selected="field.selected" :initials="field.initials">
                            </component>
                            <input v-else class="form-control" :type="field.input_type" v-model ="field.value">
                            <span id="basic-msg" v-if="form.errors.get(field.field_name)" class="invalid-feedback">{{ form.errors.get(field.field_name) }}</span>
                             </div>
                        </div>
                     </div>

                     <div class ="mt-4">
                        <input class="btn iw-btn iw-btn-submit" value="Add" @click.prevent ="submitForm" type="submit">
                        <input class="btn iw-btn iw-btn-cancel" value ="Cancel" @click.prevent ="resetForm" type="submit" >
                    </div>
                </div>
            </div>
        </div>
    </modal-cover>
</template>

<script>


function clientFields(){
    return [
        {
            field_name:'writ_date',
            value:Munshi.today,
            caption:'Writ Date',
            input_type:'datepicker'
        },
        {
            field_name:'city',
            value:'',
            caption:'City ',
            input_type:'select2',
            select2:'city-select',
            initials:[],
            selected:[],
        },
        {
            field_name:'land_registery',
            value:'',
            caption:'Land Registery',
            input_type:'text'
        },
        {
            field_name:'municipality',
            value:'',
            caption:'Municipality  ',
            input_type:'text'
        },
        {
            field_name:'execution_no',
            value:'',
            caption:'Execution Number  ',
            input_type:'text'
        },
        {
            field_name:'client_name',
            value:'',
            caption:'Client Name  ',
            input_type:'select2',
            select2:'client-select',
            initials:[],
            selected:[],
        },
         {
            field_name:'solicitor_name',
            value:'',
            caption:'Solicitor Name  ',
            input_type:'text'
        },
        {
            field_name:'address',
            value:'',
            caption:'Property Address',
            input_type:'textarea'
        },
          {
            field_name:'debtor',
            value:'',
            caption:'Debtor',
            input_type:'text'
        },
         {
            field_name:'creditor',
            value:'',
            caption:'Creditor',
            input_type:'text'
        },
        {
            field_name:'amount',
            value:'',
            caption:'Amount',
            input_type:'text'
        },
        {
            field_name:'amount_percentage',
            value:'',
            caption:'Percentage',
            input_type:'text'
        },
            {
            field_name:'plus_cost',
            value:'',
            caption:'Plus Cost',
            input_type:'text'
        },
            {
            field_name:'plus_cost_percentage',
            value:'',
            caption:'Plus Cost Percentage',
            input_type:'text'
        },
          {
            field_name:'lot_number',
            value:'',
            caption:'Lot Number',
            input_type:'text'
        },
          {
            field_name:'plan_number',
            value:'',
            caption:'Plan Number',
            input_type:'text'
        }
    ]
}

function solicitorFields(){
    return [
        {
            field_name:'writ_date',
            value:Munshi.today,
            caption:'Writ Date',
            input_type:'datepicker'
        },
        {
            field_name:'city',
            value:'',
            caption:'City ',
            input_type:'select2',
            select2:'city-select',
            initials:[],
            selected:[],
        },
        {
            field_name:'land_registery',
            value:'',
            caption:'Land Registery',
            input_type:'text'
        },
        {
            field_name:'municipality',
            value:'',
            caption:'Municipality  ',
            input_type:'text'
        },
        {
            field_name:'execution_no',
            value:'',
            caption:'Execution Number  ',
            input_type:'text'
        },
        {
            field_name:'client_name',
            value:'',
            caption:'Client Name  ',
            input_type:'select2',
            select2:'client-select',
            initials:[],
            selected:[],
        },
         {
            field_name:'solicitor_name',
            value:'',
            caption:'Solicitor Name  ',
            input_type:'text'
        },
        {
            field_name:'address',
            value:'',
            caption:'Property Address',
            input_type:'textarea'
        },
          {
            field_name:'debtor',
            value:'',
            caption:'Debtor',
            input_type:'text'
        },
         {
            field_name:'creditor',
            value:'',
            caption:'Creditor',
            input_type:'text'
        },
        {
            field_name:'amount',
            value:'',
            caption:'Amount',
            input_type:'text'
        },
        {
            field_name:'amount_percentage',
            value:'',
            caption:'Percentage',
            input_type:'text'
        },
            {
            field_name:'plus_cost',
            value:'',
            caption:'Plus Cost',
            input_type:'text'
        },
            {
            field_name:'plus_cost_percentage',
            value:'',
            caption:'Plus Cost Percentage',
            input_type:'text'
        },
          {
            field_name:'lot_number',
            value:'',
            caption:'Lot Number',
            input_type:'text'
        },
          {
            field_name:'plan_number',
            value:'',
            caption:'Plan Number',
            input_type:'text'
        }
    ]
}
function getNewFormDetail(id=0,type,fields,number=0){
    return new Form({
        random:Utilities.getRandomNumber(),
        document_no:number,
        document_name:type,
        file_opening_id:id,
        fields:fields
    });
}

export default
 {
    props:{
        file_opening_id:{
            default:0,
            type:[String,Number]
        },
        categories:{
            default:function(){
                return [];
            },
            type:[Array]
        },
        form:{
            default:function(){
                return {};
            },
            type:[Object]
        },
        type:{
            default:'',
            type:[String]
        },
        index:{
            default:-1,
            type:[Number,String]
        },
        file_opening:{
            default:null
        },
        lro:{
            default:[]
        },
        cities:{
            default:[]
        }
    },

        //directive for select2 client


    data:function(){
        return {
            create_url:'execution-documents',
            base_url:Munshi.base_url,
            show:true,
            detail:null
        }
    },

    computed:{
        clients:function(){
            var arr = [];
            this.file_opening.sellers.forEach(function(ele){
                arr.push({'id':ele.name,'text':ele.name});
            });
            return arr;
        }
    },
    mounted(){
        var self = this;
        // window.addEventListener("keydown", this.submitFormByEnter, true);
        if(this.type == 'client'){
            if(this.index >= 0 ){
                this.detail = getNewFormDetail();
                Utilities.copyProperties(this.form.client_affidavits[this.index], this.detail);
                var fields = clientFields();
                fields.forEach(function(ele){
                    var same_attribute = self.detail.fields.find((elem) => elem.field_name == ele.field_name);
                    if(same_attribute){
                        ele.value = same_attribute.value;
                        ele.id = same_attribute.id;
                    }
                    if(ele.input_type  == 'select2'){
                        if(ele.field_name == 'client_name'){
                            ele.selected = [same_attribute.value];
                            ele.initials = self.clients;
                            if(!self.clients.find((cli)=>cli.id === same_attribute.value)){
                                ele.initials.push({'id':same_attribute.value,'text':same_attribute.value});
                            }
                        }
                        else if(ele.field_name == 'city'){
                            ele.selected = [same_attribute.value];
                            ele.initials =  self.cities;

                        }
                    }
                });
                this.detail.fields = fields;
            }
            else{
                var clientfields = self.setFields(clientFields());
                this.detail = getNewFormDetail(this.file_opening_id,this.type, clientfields,this.form.client_affidavits.length+1);
            }
         }
        else if(this.type == 'solicitor'){
            if(this.index >= 0 ){
                this.detail = getNewFormDetail();
                Utilities.copyProperties(this.form.solicitor_affidavits[this.index], this.detail);
                var fields = solicitorFields();
                fields.forEach(function(ele){
                    var same_attribute = self.detail.fields.find((elem) => elem.field_name == ele.field_name);
                    if(same_attribute){
                        ele.value = same_attribute.value;
                        ele.id = same_attribute.id;
                    }
                     if(ele.input_type  == 'select2'){
                        if(ele.field_name == 'client_name'){
                            ele.selected = [same_attribute.value];
                            ele.initials = self.clients;
                            if(!self.clients.find((cli)=>cli.id === same_attribute.value)){
                                ele.initials.push({'id':same_attribute.value,'text':same_attribute.value});
                            }
                        }
                        else if(ele.field_name == 'city'){
                            ele.selected = [same_attribute.value];
                            ele.initials =  self.cities;
                        }
                    }
                });
                this.detail.fields = fields;
            }
            else{
                 var solicitorfields = self.setFields(solicitorFields());
                this.detail = getNewFormDetail(this.file_opening_id,this.type, solicitorfields,this.form.solicitor_affidavits.length+1);
            }
         }
         setTimeout(function(){
               $('.select-input').select2({
                tags:true,
                dropdownParent:$(".modal").length ? $(".modal"): $('body')
            })
            .on('change', function () {
                var data = $(".select-input").val();
            });
         },2000);

    },


    beforeDestroy(){
        window.removeEventListener("keydown", this.submitFormByEnter, true);
    },

    methods:{
        submitForm:function(){
            var self = this;
            this.detail['postForm'](Munshi.base_url+'/'+this.create_url)
            .then(function(response){
                if(response.success){
                 if(self.type == 'client'){
                    if(self.index >= 0){
                        self.form.client_affidavits[self.index]=self.detail;
                    }
                    else{
                        self.form.client_affidavits.push(self.detail);
                    }
                }
                else if(self.type == 'solicitor'){
                    if(self.index >= 0){
                        self.form.solicitor_affidavits[self.index]=self.detail;
                    }
                    else{
                        self.form.solicitor_affidavits.push(self.detail);
                    }
                }
                  $('.information_modal').modal('hide');
                    self.$emit('closeTriggered');
                }
            })
            .catch(function(error){
            });
        },

        submitFormByEnter:function(e){
            if(e.key == 'Enter')  {
                e.preventDefault();
                this.submitForm();
            }
        },

        resetForm:function(){
            $('.information_modal').modal('hide');
            this.$emit('closeTriggered');
        },

        setFields:function(fields){
            var self = this;
            if(this.file_opening){
                fields.forEach(function(ele){
            if(ele.field_name == 'city'&&  self.file_opening && self.file_opening.property &&self.file_opening.property.city){
                ele.initials =[{'text':self.file_opening.property.city.city_name ,'id':self.file_opening.property.city.id}];
                ele.selected=[self.file_opening.property.city.id];
                ele.value = self.file_opening.property.city.id;
            }
            else if(ele.field_name == 'writ_date'){
                ele.value = Munshi.today;
            }
            else if(ele.field_name == 'land_registery'){
                var lr = self.file_opening.property &&  self.file_opening.property ?  self.file_opening.property.lro:null;
                if(lr){
                    var lro_registry = self.lro.find((elem) => elem.id == lr);
                    var number = lro_registry.text.substring(3) + ' Land Registry (No '+ lr +')';
                    ele.value = number;
                }
            }
            else if(ele.field_name == 'municipality'){
                    var lr = self.file_opening.property &&  self.file_opening.property ?  self.file_opening.property.lro:null;
                    if(lr){
                    var lro_registry = self.lro.find((elem) => elem.id == lr);
                    var number = lro_registry.text.substring(3);
                    ele.value = number;
                }
            }
            else if(ele.field_name == 'client_name'){
                self.file_opening.sellers.forEach(function(e){
                    ele.initials.push({'id':e.name, 'text': e.first_name +' '+ e.last_name});
                });
            }
            else if(ele.field_name == 'solicitor_name'){
                ele.value = self.file_opening.solicitor ?  self.file_opening.solicitor.name:'';
            }
            else if(ele.field_name == 'address'){
                ele.value = self.file_opening.property ? self.file_opening.property.add_line2?  self.file_opening.property.addr_line1 + self.file_opening.property.add_line2:self.file_opening.property.addr_line1:'';
            }
            else if(ele.field_name == 'lot_number'){
                ele.value = self.file_opening.property ? self.file_opening.property.lot:'';
            }
            else if(ele.field_name == 'plan_number'){
                ele.value = self.file_opening.property ? self.file_opening.property.on_plan:'';
            }
        });
            }
            return fields;
        }

   }
}
</script>

<style>

</style>
