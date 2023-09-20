<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <fieldset class="fieldset">
                            <legend class="legend">Filter Files For Invoice</legend>
                            <form action="">
                                <div class="form-row align-items-center">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Month</label>
                                            <select class="form-control" placeholder="Select Month" v-model="filter_form.month">
                                                <option value="" selected>Select</option>
                                                <option value="1" >January</option>
                                                <option value="2" >February</option>
                                                <option value="3" >March</option>
                                                <option value="4" >April</option>
                                                <option value="5" >May</option>
                                                <option value="6" >June</option>
                                                <option value="7" >July</option>
                                                <option value="8" >August</option>
                                                <option value="9" >September</option>
                                                <option value="10" >October</option>
                                                <option value="11" >November</option>
                                                <option value="12" >December</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group" >
                                            <label for="">&nbsp;</label>
                                            <div class="text-center"><strong>OR</strong></div>
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group"  v-bind:class="{ 'is-invalid': filter_form.errors.get('from_date') }">
                                            <label for="">From Date</label>
                                            <date-picker class-name="from_date" v-model="filter_form.from_date"></date-picker>
                                            <span id="basic-msg" v-if="filter_form.errors.get('from_date')" class="invalid-feedback">{{ filter_form.errors.get('from_date') }}</span>
                                        </div>
                                    </div>

                                     <div class="col-md-3">
                                        <div class="form-group"  v-bind:class="{ 'is-invalid': filter_form.errors.get('to_date') }">
                                            <label for="">To Date</label>
                                               <date-picker class-name="to_date" v-model="filter_form.to_date"></date-picker>
                                               <span id="basic-msg" v-if="filter_form.errors.get('to_date')" class="invalid-feedback">{{ filter_form.errors.get('to_date') }}</span>
                                        </div>
                                    </div>
                                      <div class="col">
                                    <div class="form-group"  >
                                            <label for="">&nbsp;</label>
                                            <input class="btn iw-btn iw-btn-submit mt-4" @click.prevent ="checkForm" value="Show" type="submit">
                                      </div>
                                </div>
                                <div class="alert alert-danger" role="alert" v-if="errors.length > 0">
                                        <span v-for="(error,index) in errors" :key="index">
                                            {{error}}
                                        </span>
                                    </div>
                                </div>
                            </form>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
        <file-fee-report v-if="show"
            :filter_form="filter_form">
        </file-fee-report>
    </div>
</template>

<script>
function getNewForm(){
    return new Form({
        from_date:"",
        to_date:"",
        month:""
    });
}
export default {
    data:function(){
        return {
            filter_form:getNewForm(),
             errors:[],
             type:'none',
             show:false,
            copy_filter_form:null
        }
    },
    created:function(){
        this.filter_form.from_date = Munshi.yesterday;
        this.filter_form.to_date = Munshi.today;
    },
    methods:{
            showTable:function(){
                this.copy_filter_form =  JSON.parse(JSON.stringify(this.filter_form));
                Utilities.refreshComponent(this,'show');
            },
           checkForm: function (e) {
            this.errors = [];
            if (this.filter_form.from_date != "" || this.filter_form.to_date != "" ) {
                if(this.filter_form.from_date == "" ){
                    this.errors.push("Please add From Date");
                }
                else if(this.filter_form.to_date == "" ){
                    this.errors.push("Please add to Date");
                }else{
                this.type = 'date';
                }
            }
            else if (this.filter_form.month !="") {
                this.type = 'month';

            }
            else{
                this.errors.push('Any of the one  field is required. ');
            }
            if(this.errors.length > 0){
                return;
            }
            this.showTable();
        },
    }
}
</script>

<style>

</style>
