<template>
 <span >
    <select :class="'form-control ' + customClass +' canadian_states'+index "  :disabled="disabled"
        :id="'select-'+uid"
    >
    <option></option></select>
</span>
</template>

<script>
export default {
    props:{
        index: {default:-1 ,type: [String,Number]},
        initials: {default: () => [],type: Array},
        selected: {default: () => [],type: Array},
        url:{default:'canadian-states/filtered',type: String},
        getIndex: {default:false , type: Boolean},
        disabled: {default:false , type: Boolean},
        customClass: {default:'selectItem',type:String},
        focus: {default:false, type: Boolean},
        enableNew: {default:false, type:Boolean},
    },

    mounted:function(){
        var self = this;
        this.modal_class = 'modal-'+this.uid;
        if($(".modal").length) {
            var modal_node = $($("#select-"+this.uid)).closest('.modal')[0];
            this.$nextTick(function() {
                $(modal_node).addClass(this.modal_class);
            })
        }
        self.getData();
    },

    data:function(){
        return {
            selected_data: {},
            data:[],
            uid: this._uid,
            modal_class:''
        }
    },

    methods:{
        getData:function(){
            var self = this;
            axios.post(Munshi.base_url+'/'+this.url)
            .then(function(response){
                self.data = response.data.results;
                self.intialiseSelect();
            })
            .catch(function(error){

            });

        },
        intialiseSelect:function(){
                var self = this;
                var itemComponent = $('.canadian_states'+self.index);
                var item = itemComponent.select2({
                    dropdownAutoWidth : true,
                    placeholder: "Select",
                    width: '100%',
                    data:self.data,
                    dropdownParent:$(".modal").length ? $('.'+this.modal_class) : $('body'),
                    templateResult: self.setName,
                    templateSelection: self.selection,
                })
                .on('change', function () {
                })
                .on('select2:select', function (e) {
                    self.selected_data = e.params.data;
                    var item =  $('.canadian_states'+ self.index).val();
                    self.$emit('input', self.selected_data.text);
                    $(".canadian_states"+self.index+" option:selected").html();
                    // update item returns (value, index, acname, item)
                    self.$emit('updateState',item,self.index,self.selected_data);
                });

                if(typeof(this.index) !="undefined" && self.selected.length > 0){
                    // $('.acid'+self.index).val(self.selected).trigger('change');
                    $('.canadian_states'+self.index).val(self.selected).trigger('change');
                }
            },
            setName :function(details) {
                    if (!details.id) { return details.text; }
                    var $details = $('<div class="row"><div class="col-md-7">' + details.text + '</div><div class="col-md-5">'+details.code+'<div></div>');
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
