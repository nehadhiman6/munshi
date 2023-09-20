<template>
 <span >
    <select :class="'form-control ' + customClass +' client'+index"  :disabled="disabled"></select>
</span>
</template>

<script>
export default {
    props:{
        index: {default:-1 ,type: [String,Number]},
        initials: {default: () => [],type: Array},
        selected: {default: () => [],type: Array},
        url:{default:'clients/filtered',type: String},
        getIndex: {default:false , type: Boolean},
        disabled: {default:false , type: Boolean},
        customClass: {default:'selectItem',type:String},
        focus: {default:false, type: Boolean},
        enableNew: {default:false, type:Boolean},
        lro_id:{default:0,type:[String,Number]}
    },

    mounted:function(){
        this.intialiseSelect();
    },

    data:function(){
        return {
            selected_data: {}
        }
    },

    methods:{
        intialiseSelect:function(){
                var self = this;
                var itemComponent = $('.client'+self.index);
                var item = itemComponent.select2({
                    dropdownAutoWidth : true,
                    dropdownParent:$(".modal").length ? $(".modal"): $('body'),
                    placeholder: "Select Client",
                    width: '100%',
                    tags:true,
                    data:self.initials,
                    templateResult: self.setName,
                    templateSelection: self.selection,
                })
                .on('change', function () {
                })
                .on('select2:select', function (e) {
                    self.selected_data = e.params.data;
                    var item =  $('.client'+ self.index).val();
                    self.$emit('input', item);
                    $(".client"+self.index+" option:selected").html();
                    // update item returns (value, index, acname, item)
                    self.$emit('updateClient',item,self.index,self.selected_data);
                });

                if(typeof(this.index) !="undefined"){
                    // $('.acid'+self.index).val(self.selected).trigger('change');
                    $('.client'+self.index).val(self.selected).trigger('change');
                }
            },
            setName :function(details) {
                    if (!details.id) { return details.text; }
                    var $details = $('<div class="row"><div class="col-md-12">' + details.text + '</div></div>');
                    return $details;
            },
            selection :function(details) {
                if (!details.id) { return details.text; }
                    var $details = $('<div class="row"><div class="col-md-12">' + details.text + '</div></div>');
                    return $details;
            }
        }
}
</script>

<style>

</style>
