<template>
    <div>
        <div class=" card-header d-flex flex-wrap align-items-center justify-content-between  py-1">
            <div class="card-title mb-0"><span><strong>Seller</strong></span></div>
            <div class ="float-right">
                <input class="btn iw-btn iw-btn-submit py-1" :value="form.form_id > 0 ? 'Update' : 'Save'" @click.prevent ="submitForm" type="submit">
            </div>
        </div>
        <div class="card-body">
        <div class="iw-horizontal-tabs">

            <nav>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item"  v-for="(seller,index) in form.sellers" :key="seller.random">
                        <a class="nav-link" :class="{'active':index == 0}" :id="'seller-tab_'+index" data-toggle="tab"  :href="'#seller'+index" role="tab" :aria-controls="'seller-tab_'+index" :aria-selected="index == 0">
                             <span v-text="seller.first_name ? seller.first_name :'seller '+getNumber(index)"></span>
                            <span class="iw-close-tab" @click.prevent="removeSeller(index)"><i class="mdi mdi-close"></i></span>
                        </a>
                    </li>
                     <li>
                        <a class="nav-link"  @click.prevent="addSeller($event,property)" href="#">+ Add Seller </a>
                    </li>
                </ul>
             </nav>
            <div class="tab-content" id="myTabContent">
                  <seller-tab v-for="(seller,index) in form.sellers" :key="seller.random"
                    :permissions='permissions'
                    :form="form"
                    :seller="seller"
                    :index="index"
                    :random='seller.random'
                    @removeSeller="removeSeller">
                </seller-tab>
            </div>
        </div>
        <div class ="mt-4">
            <input class="btn iw-btn iw-btn-submit" :value="form.form_id > 0 ? 'Update' : 'Save'" @click.prevent ="submitForm" type="submit">
        </div>
    </div>
    </div>
</template>

<script>
function getNewForm(){
    return new Form({
        sellers:[],
        file_opening_id:0,
    })
}
function getSellerId(){
    return {
            id:0,
            seller_id:"",
            id_type:"",
            expiry_date:"",
            number:"",
            issuing_jurisdiction:"",
            issuing_country:"",
            resources:[],
            random:Utilities.getRandomNumber()
        };
}
function getAddress(type,property){
    return {
            id:0,
            type:type,
            number:property ? property.street_no:'',
            street:property ? property.street_name:'',
            city_id:property ? property.city_id:'',
            country:property ? property.country:'',
            postal_code:property ? property.postal_code:'',
            province:property ? property.province:'',
            city:property ? property.city:null,
            addressable_type:'',
            addressable_id:'',
        };
}
function addSeller(file_opening_id=0,property){
    return{
        id:0,
        file_opening_id:file_opening_id,
        type:'',
        salutation:'',
        first_name:'',
        middle_name:'',
        last_name:'',
        company_name:'',
        signing_officer_title:'',
        marital_status:'',
        spouse_name:'',
        phone:'',
        email:'',
        business_address:'',
        business_name:'',
        occupation:'',
        id_verified_by:'',
        meeting_date:'',
        file_review_date:'',
        random:Utilities.getRandomNumber(),
        current_address:getAddress('current'),
        closing_address:getAddress('closing',property),
        is_current_address_subject_property:'N',
        seller_ids:[
            getSellerId(),
            getSellerId()
        ],
        random:Utilities.getRandomNumber()
    }
}
import SellerTab from './SellerTab.vue';
export default {
    props:['file_opening_id','permissions'],
    components: { SellerTab },
    data:function(){
        return {
            form:getNewForm(),
            create_url:'sellers',
            base_url:Munshi.base_url,
            property:null
        }
    },
    mounted:function(){
        this.getSellers();
        var self = this;
         window.onbeforeunload = function (event) {
            console.log(self.form);
             var is_dirty = self.form.isDirty();
            if(is_dirty){
                return "You currently have unsaved changes!!";
                return "<h6>You currently have unsaved changes!!!\n\nAre you sure you want to exit without saving.\n\nChoose ‘Leave this Tab’ to exit without saving changes.\nChoose ‘Stay on this Tab’ to return.</h6>";
            }

        }
    },
     methods:{
        isComponentDirty:function(){
            return this.form.isDirty();
        },

        getSellers:function(){
            var self = this;
            console.log('get sellers');
            axios.get(this.base_url+'/file-page/'+this.file_opening_id)
            .then(function(response){
                console.log(response);
                if(response.data.success){
                    var sellers = response.data.file_opening.sellers;
                    var property = response.data.file_opening.property;
                    self.property = property;
                    if(sellers.length > 0 ){
                        self.form = getNewForm();
                        self.form.file_opening_id = self.file_opening_id;
                        sellers.forEach(element => {
                            var seller= addSeller(self.file_opening_id,property);
                            Utilities.copyProperties(element,seller);
                            var seller_ids = seller.seller_ids;
                            seller.seller_ids = [];
                            seller_ids.forEach(function(ele){
                                var sel_id = getSellerId();
                                Utilities.copyProperties(ele,sel_id);
                                 seller.seller_ids.push(sel_id);
                            });

                            if(seller.seller_ids.length < 2){
                                for(var i=seller.seller_ids.length;i < 2;i++){
                                    seller.seller_ids.push(getSellerId());
                                }
                            }
                            // if(property) {
                            //     seller.closing_address.number = property.street_no;
                            //     seller.closing_address.street = property.street_name;
                            //     seller.closing_address.province = property.province;
                            //     seller.closing_address.city_id = property.city_id;
                            //     seller.closing_address.city = property.city;
                            //     seller.closing_address.country = property.country;
                            //     seller.closing_address.postal_code = property.postal_code;
                            // }
                            self.form.sellers.push(seller);
                        });
                    }
                    else{
                        self.form.sellers.push(addSeller(self.file_opening_id,property));
                        self.form.file_opening_id = self.file_opening_id;
                    }

                }

                self.form.copyData = JSON.parse(JSON.stringify(self.form.data()));
            })
            .catch(function(error){
                console.log(error);
            });
        },
        addSeller:function(e,property){
            this.form.sellers.push(addSeller(this.file_opening_id,property));
            var index = this.form.sellers.length-1;
            setTimeout(function(){
                $('.nav-tabs a[href="#seller'+index+'"]').tab('show');
            },300);
        },
        getNumber:function(index){
            return  parseInt(index)+1;
        },
        submitForm:function(){
            var self = this;
            Utilities.showConfirmationPopMessage('Do you want to save the changes?',function(save){
                if(save == true){
                    self.form['postForm'](self.base_url+'/'+self.create_url)
                    .then(function(response){
                         if(response.success){
                            Utilities.showToast(self,'success','Sellers updated successfully',2200,true);
                            self.form.copyData = JSON.parse(JSON.stringify(self.form.data()));
                            self.$emit('closeTriggered');
                        }
                    })
                    .catch(function(error){
                        console.log(error);
                    });
                }
            },true,false);

        },

        removeSeller:function(index){
            this.form.sellers.splice(index,1);
            var active = 0;
            if(index > 0){
                active = index-1;
            }
            else if(this.form.sellers.length>0){
                active = index+1;
            }
            setTimeout(function(){
                $('.nav-tabs a[href="#seller'+active+'"]').tab('show');
            },500);
        },


     }
}
</script>

<style>

.iw-horizontal-tabs .nav-item .nav-link {
    padding-right: 40px;
}

.iw-horizontal-tabs span.iw-close-tab {
    position: absolute;
    right: 6px;
    top: 50%;
    transform: translateY(-50%);
}
</style>
