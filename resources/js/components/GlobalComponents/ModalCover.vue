<template>
  <div>
        <div :class="'modal '+ modalClass+ ' fade'" id="iw-new-task"  data-backdrop="static" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-centered" :class="modal_size +' '+ modal_style" role="document" >
                <div class="modal-content modal-style">
                    <div class="modal-header">
                        <slot name="modal-title"></slot>
                        <button class="close" type="button" @click="closeModal">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <slot name="modal-cover-body"></slot>
                    </div>
                </div>
            </div>
        </div>
  </div>
</template>

<script>
export default {
	name: "Modal",
	props: {
		modal_style: {
            type: String,
            required: false,
            default:''
		},
        modal_size:{
            type:String,
            required:false,
            default:function(){
                return 'modal-lg'
            }
        },
        modalClass:{
            type:String,
            required:false,
            default:function(){
                return 'cover_modal'
            }
        },
        modalHide:{
            type:Boolean,
            default:true
        }
    },
    beforeDestroy:function(){
        $('.'+this.modalClass).modal('hide');
        $('.modal-backdrop').remove();
    },
    mounted:function(){
        var self = this;
         $('.'+this.modalClass).modal('show');
         if(this.modalHide == true){
            $('.'+this.modalClass).on('hidden.bs.modal', function (e) {
                self.$emit('closeModal');
            });
         }

    },
    methods:{
        closeModal:function(){
            if(this.modalHide == true){
                $('.'+this.modalClass).modal('hide');
            }
            this.$emit('closeModal');
        }
    }
};
</script>

<style lang='scss'>

</style>
