<template>
    <div class = "form-row" >
        <div class="col-md-3">
            <div class="form-group">
            <label for="pin" class="in-label-title ">#{{index+1}} Pin</label>
            <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('property.pins.'+index+'.pin') }" type="text" v-model ="pin.pin">
            <span id="basic-msg" v-if="form.errors.get('property.pins.'+index+'.pin')" class="invalid-feedback">{{ form.errors.get('property.pins.'+index+'.pin') }}</span>
            </div>
        </div>
        <span class="iw-remove-pin-btn" v-if="index > 0" @click.prevent="$emit('removePin',index)"><span class="mdi mdi-delete-outline"></span></span>
    </div>
</template>

<script>
export default {
    props:['pin','form' ,'index']
}
</script>

<style>
.iw-remove-pin-btn {
    align-self: flex-end;
    display: inline-block;
    margin-bottom: 16px;
    cursor: pointer;
    color: #fff;
}
.iw-remove-pin-btn span.mdi {
    font-size: 25px;
    color: red;
}
</style>
