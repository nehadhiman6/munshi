<template>
    <div>
        <div class=" card-header d-flex flex-wrap align-items-center justify-content-between  py-1">
            <div class="card-title mb-0"><span><strong>Mortgage</strong></span></div>
            <div class ="float-right">
                <input class="btn iw-btn iw-btn-submit py-1" :value="form.form_id > 0 ? 'Update' : 'Save'" @click.prevent ="submitForm" type="submit">
            </div>
        </div>
        <div class="card-body">
        <div class="iw-horizontal-tabs">
            <nav>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item"  v-for="(mortgage,index) in form.mortgages" :key="mortgage.random">
                        <a class="nav-link" :class="{'active':index == 0}" :id="'mortgage-tab_'+index" data-toggle="tab"  :href="'#mortgage'+index" role="tab" :aria-controls="'mortgage-tab_'+index" :aria-selected="index == 0">
                            <span v-text="mortgage.instrument_no ? mortgage.instrument_no :'mortgage '+getNumber(index)"></span>
                            <span class="iw-close-tab" @click.prevent="removeMortgage(index)"><i class="mdi mdi-close"></i></span>
                        </a>
                    </li>
                     <li>
                        <a class="nav-link"  @click.prevent="addMortgage" href="#">+ Add Mortgage </a>
                    </li>
                </ul>
             </nav>
            <div class="tab-content" id="myTabContent">
                <mortgage-tab v-for="(mortgage,index) in form.mortgages" :key="mortgage.random"
                    :closing_date="closing_date"
                    :form="form"
                    :mortgage="mortgage"
                    :index="index"
                    :random='mortgage.random'
                    :permissions="permissions"
                    @removeMortgage="removeMortgage">
                </mortgage-tab>

            </div>
        </div>
        <div class ="mt-4">
            <input class="btn iw-btn iw-btn-submit" :value="form.form_id > 0 ? 'Update' : 'Save'" @click.prevent ="submitForm" type="submit">
        </div>
    </div>
    </div>
</template>

<script>
function getNewForm(){
    return new Form({
        mortgages:[],
        file_opening_id:0,
    })
}
function getAddress(type){
    return {
            id:0,
            type:type,
            number:'',
            street:'',
            city_id:'',
            country:'',
            postal_code:'',
            province:'',
            addressable_type:'',
            addressable_id:'',
        };
}
function addMortgage(file_opening_id=0){
    return{
        id:0,
        file_opening_id:file_opening_id,
        instrument_no:'',
        instrument_date:'',
        instrument_type:'',
        obtaining_discharge:'',
        mortgagee_reference_number:'',
        principal_amount:'',
        per_diem:'',
        total_mortgage_payable_discharge:'',
        mortgagee_id:'',
        contact:'',
        solicitor_id:'',
        discharged_on:'',
        extra_interest:'',
        phone:'',
        fax:'',
        email:'',
        attention:'',
        discharge_no:'',
        discharge_date:'',
        random:Utilities.getRandomNumber(),
        address:getAddress(),
        additional_charges:[]
    }
}
import MortgageTab from './MortgageTab.vue';
export default {
    props:['file_opening_id','permissions'],
    components: { MortgageTab },
    data:function(){
        return {
            form:getNewForm(),
            create_url:'mortgages',
            base_url:Munshi.base_url,
            closing_date:''
        }
    },
    mounted:function(){
        this.getMortgage();
        if(this.form.mortgages.length ==0){
            this.form.mortgages.push(addMortgage());
        }
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

        getMortgage:function(){
            var self = this;
            axios.get(this.base_url+'/file-page/'+this.file_opening_id)
            .then(function(response){
                console.log("Mortgage");
                console.log(response);
                if(response.data.success){
                    var mortgages = response.data.file_opening.mortgages;
                    self.closing_date =response.data.file_opening.closing_date;
                    if(mortgages.length > 0 ){
                        self.form = getNewForm();
                        self.form.file_opening_id = self.file_opening_id;
                        mortgages.forEach(element => {
                            var mortgage = addMortgage(self.file_opening_id);
                            Utilities.copyProperties(element,mortgage);
                            if(element.mortgagee){
                                mortgage.mortgagee = element.mortgagee;
                            }
                            if(element.solicitor){
                                mortgage.solicitor = element.solicitor;
                            }

                            element.additional_charges.forEach(function(charge){
                                charge.random = Utilities.getRandomNumber();
                            });
                            self.form.mortgages.push(mortgage);
                        });
                    }
                    else{
                        self.form = getNewForm();
                        self.form.mortgages.push(addMortgage(self.file_opening_id));
                        self.form.file_opening_id = self.file_opening_id;
                    }
                    console.log("self.form.data");
                    console.log(self.form.data);
                    self.form.copyData = JSON.parse(JSON.stringify(self.form.data()));
                }

            })
            .catch(function(error){
                console.log(error.response);
            });
        },

        addMortgage:function(e){
            if(this.form.mortgages.length < 6){
                this.form.mortgages.push(addMortgage(this.file_opening_id));
                var index = this.form.mortgages.length-1;
                setTimeout(function(){
                    $('.nav-tabs a[href="#mortgage'+index+'"]').tab('show');
                },300);
            }
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
                            Utilities.showToast(self,'success','Mortgage updated successfully',2200,true);
                            self.$emit('closeTriggered');
                        }
                    })
                    .catch(function(error){
                        console.log(error);
                    });
                }
            },true,false);


        },

        removeMortgage:function(index){
            this.form.mortgages.splice(index,1);
            var active = 0;
            if(index > 0){
                active = index-1;
            }
            else if(this.form.mortgages.length>0){
                active = index+1;
            }
            setTimeout(function(){
                $('.nav-tabs a[href="#mortgage'+active+'"]').tab('show');
            },500);
        },


     }
}
</script>

<style>
.iw-horizontal-tabs .nav-item .nav-link {
    padding-right: 40px;
}

.iw-horizontal-tabs span.iw-close-tab {
    position: absolute;
    right: 6px;
    top: 50%;
    transform: translateY(-50%);
}
</style>
