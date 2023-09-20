<template>
 <span >
    <select :class="'form-control ' + customClass +' city_'+index"  :disabled="disabled"></select>
</span>
</template>

<script>
export default {
    props:{
        index: {default:-1 ,type: [String,Number]},
        initials: {default: () => [],type: Array},
        selected: {default: () => [],type: Array},
        url:{default:'city/filtered',type: String},
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
                var itemComponent = $('.city_'+self.index);
                var item = itemComponent.select2({
                    dropdownAutoWidth : true,
                    dropdownParent:$(".modal").length ? $(".modal"): $('body'),
                    placeholder: "Select City",
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
                                lro_id:self.lro_id,
                                page: params.page || 1,
                            }
                            // Query parameters will be ?search=[term]&page=[page]
                            return query;
                        },
                        processResults: function (data,params) {
                            params.page = params.page || 1;
                            // Tranforms the top-level key of the response object from 'items' to 'results'
                            data.results.forEach(function(ele){
                                ele.text = ele.city_name;
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
                    var item =  parseInt($('.city_'+ self.index).val());
                    self.$emit('input', item);
                    $(".city_"+self.index+" option:selected").html();
                    // update item returns (value, index, acname, item)
                    self.$emit('updateCity',item,self.index,self.selected_data);
                });

                if(typeof(this.index) !="undefined"){
                    // $('.acid'+self.index).val(self.selected).trigger('change');
                    $('.city_'+self.index).val(self.selected).trigger('change');
                }
            },
            setName :function(details) {
                    if (!details.id) { return details.text; }
                    var $details = $('<div class="row"><div class="col-md-7">' + details.text + '</div><div class="col-md-5">'+details.state+'<div></div>');
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
