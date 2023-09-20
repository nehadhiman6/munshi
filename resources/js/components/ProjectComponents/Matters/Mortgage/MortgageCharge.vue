<template>
    <div>
         <div class = "form-row">
            <div class="col-md-9">
                <div class="form-group">
                <label for="particulars" class="in-label-title ">Particulars</label>
                <input class="form-control"   v-bind:class="{ 'is-invalid': form.errors.get('mortgages.'+index+'.additional_charges.'+ind+'.particulars') }"  type="text"  v-model ="charge.particulars">

                <span id="basic-msg" v-if="form.errors.get('mortgages.'+index+'.additional_charges.'+ind+'.particulars')" class="invalid-feedback">{{ form.errors.get('mortgages.'+index+'.additional_charges.'+ind+'.particulars') }}</span>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                <label for="amount" class="in-label-title ">Amount</label>
                  <currency-input v-bind:class="{ 'is-invalid': form.errors.get('mortgages.'+index+'.additional_charges.'+ind+'.amount') }" v-model="charge.amount"></currency-input>
                <span id="basic-msg" v-if="form.errors.get('mortgages.'+index+'.additional_charges.'+ind+'.amount')" class="invalid-feedback">{{ form.errors.get('mortgages.'+index+'.additional_charges.'+ind+'.amount') }}</span>
                </div>
            </div>
             <div class="col">
                <div class="form-group">
                    <span title="delete" class="iw-remove-icon mt-4" @click.prevent='removeCharges()'><span class="mdi mdi-delete"></span></span>
                </div>
             </div>
        </div>
    </div>
</template>

<script>
export default {
    props:['charge','index','ind','form'],
    methods:{
        removeCharges:function(){
            this.$emit('removeCharges',this.index);
        }
    }
}
</script>

<style>

</style>
