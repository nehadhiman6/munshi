<template>
 <span >
    <select :class="'form-control ' + customClass +' credit_type'+index"  :disabled="disabled"></select>
</span>
</template>

<script>
export default {
    props:{
        index: {default:-1 ,type: [String,Number]},
        initials: {default: () => [],type: Array},
        selected: {default: () => [],type: Array},
        url:{default:'credit-types/filtered',type: String},
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
                var itemComponent = $('.credit_type'+self.index);
                var item = itemComponent.select2({
                    dropdownAutoWidth : true,
                    dropdownParent:$(".modal").length ? $(".modal"): $('body'),
                    placeholder: "Select",
                    width: '100%',
                    data:self.initials,
                    ajax: {
                        method:'POST',
                        url: function() {
                            return self.url;
                        },
                        delay: 250,
                        dataType: 'json',
                        cache: true,
                        data: function (params) {
                            var query = {
                                search: params.term,
                                type: self.type,
                                page: params.page || 1,
                            }
                            // Query parameters will be ?search=[term]&page=[page]
                            return query;
                        },
                        processResults: function (data,params) {
                            params.page = params.page || 1;
                            // Tranforms the top-level key of the response object from 'items' to 'results'
                            data.results.forEach(function(ele){
                                ele.text =ele.type_name;
                            });
                            // this is a mondatory object that's why i added here
                            data.pagination = {
                                "more": (params.page * 30) < data.count_filtered
                            };
                            return data;
                        }
                    },
                    templateResult: self.setName,
                    templateSelection: self.selection,
                })
                .on('change', function () {
                })
                .on('select2:select', function (e) {
                    self.selected_data = e.params.data;
                    var item =  parseInt($('.credit_type'+ self.index).val());
                    if(self.stringValue){
                        self.$emit('input', self.selected_data.text);
                    }
                    else{
                        self.$emit('input', item);

                    }
                    $(".credit_type"+self.index+" option:selected").html();
                    // update item returns (value, index, acname, item)
                    self.$emit('updateCreditType',item,self.index,self.selected_data);
                });

                if(typeof(this.index) !="undefined"){
                    // $('.acid'+self.index).val(self.selected).trigger('change');
                    $('.credit_type'+self.index).val(self.selected);
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
