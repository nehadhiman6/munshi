<template>
 <span >
    <select :class="'form-control ' + customClass +' lro_'+index"  :disabled="disabled"></select>
</span>
</template>

<script>
export default {
    props:{
        index: {default:-1 ,type: [String,Number]},
        initials: {default: () => [],type: Array},
        selected: {default: () => [],type: Array},
        url:{default:'lro/filtered',type: String},
        getIndex: {default:false , type: Boolean},
        disabled: {default:false , type: Boolean},
        customClass: {default:'selectItem',type:String},
        focus: {default:false, type: Boolean},
        enableNew: {default:false, type:Boolean},
        type: {default:'', type:String},
        stringValue:{default:false,type:Boolean}
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
                var itemComponent = $('.lro_'+self.index);
                var item = itemComponent.select2({
                    dropdownAutoWidth : true,
                    placeholder: "LRO no.",
                    dropdownParent:$(".modal").length ? $(".modal"): $('body'),
                    width: '100%',
                    data:self.initials,
                    templateResult: self.setName,
                    templateSelection: self.selection,
                })
                .on('change', function () {
                })
                .on('select2:select', function (e) {
                    self.selected_data = e.params.data;
                    var item =  parseInt($('.lro_'+ self.index).val());
                    if(self.stringValue){
                        self.$emit('input', self.selected_data.text);
                    }
                    else{
                        self.$emit('input', item);

                    }
                    $(".lro_"+self.index+" option:selected").html();
                    // update item returns (value, index, acname, item)
                    self.$emit('updateLro',item,self.index,self.selected_data);
                });

                if(typeof(this.index) !="undefined"){
                    // $('.acid'+self.index).val(self.selected).trigger('change');
                    $('.lro_'+self.index).val(self.selected).trigger('change');
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
