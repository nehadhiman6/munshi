<template>
 <span >
    <select :class="'form-control ' + customClass +' contact'+index"  :disabled="disabled"></select>
</span>
</template>

<script>
export default {
    props:{
        index: {default:-1 ,type: [String,Number]},
        initials: {default: () => [],type: Array},
        selected: {default: () => [],type: Array},
        url:{default:'contacts/filtered',type: String},
        getIndex: {default:false , type: Boolean},
        disabled: {default:false , type: Boolean},
        customClass: {default:'selectItem',type:String},
        focus: {default:false, type: Boolean},
        enableNew: {default:false, type:Boolean},
        type: {default:'mortgagee', type:String},
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
                var itemComponent = $('.contact'+self.index);
                var item = itemComponent.select2({
                    dropdownAutoWidth : true,
                    placeholder: "Select",
                    dropdownParent:$(".modal").length ? $(".modal"): $('body'),
                    width: '100%',
                    allowClear: true,
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
                               var first_name = ele.first_name ? ele.first_name : '';
                                var middle_name = ele.middle_name ? ele.middle_name : '';
                                var last_name = ele.last_name ? ele.last_name : '';
                                var name = first_name +' '+ middle_name + ' ' +last_name;
                                ele.text = ele.company_name ? ele.company_name : name;
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
                    var item =  parseInt($('.contact'+ self.index).val());
                    self.$emit('input', item);
                    $(".contact"+self.index+" option:selected").html();
                    // update item returns (value, index, acname, item)
                    self.$emit('updateContact',item,self.index,self.selected_data);
                });

                if(typeof(this.index) !="undefined"){
                    // $('.acid'+self.index).val(self.selected).trigger('change');
                    $('.contact'+self.index).val(self.selected);
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
