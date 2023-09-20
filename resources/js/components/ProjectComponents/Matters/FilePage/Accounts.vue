<template>
         <div class="tab-content border-0" id="nav-tabContent" >
        <div class="tab-pane fade show active" id="nav-statement-adjustment" role="tabpanel" aria-labelledby="nav-statement-adjustment-tab">
            <div class="card-body">
            <accounts-tab v-if="file_opening" :key="getRandomNumber()"
                ref="account_adjustment"
                :update_file_opening = "update_file_opening"
                :file_opening = "file_opening"
                :permissions="permissions"
                :file_opening_id="file_opening_id"
                @updateFileOpening="updateFileOpening">
            </accounts-tab>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-commission" role="tabpanel" aria-labelledby="nav-commission-tab">
            <div class="card-body">
            <commission-tabs v-if="file_opening" :key="getRandomNumber()"
                ref="commission"
                :update_file_opening = "update_file_opening"
                :file_opening = "file_opening"
                :permissions="permissions"
                :file_opening_id="file_opening_id"
                @updateFileOpening="updateFileOpening">
            </commission-tabs>
            </div>
        </div>
        <div class="tab-pane fade" id="account-statement" role="tabpanel" aria-labelledby="nav-account-statement-tab">
            <div class="card-body">
            <account-statement-tab v-if="file_opening" :key="getRandomNumber()"
                ref ="account_statement"
                :file_opening = "file_opening"
                :update_file_opening = "update_file_opening"
                :permissions="permissions"
                :file_opening_id="file_opening_id"
                @updateFileOpening="updateFileOpening">
            </account-statement-tab>
            </div>
        </div>
        <div class="tab-pane fade" id="trust-ledger" role="tabpanel" aria-labelledby="nav-trust-ledger-tab">
            <div class="card-body">
            <trust-ledger-tabs v-if="file_opening" :key="getRandomNumber()"
                 ref ="trust_ledgers"
                :update_file_opening = "update_file_opening"
                :file_opening = "file_opening"
                :permissions="permissions"
                :file_opening_id="file_opening_id"
                @updateFileOpening="updateFileOpening">
            </trust-ledger-tabs>
            </div>
        </div>
        <div class="tab-pane fade" id="re-direction-funds" role="tabpanel" aria-labelledby="nav-re-direction-funds-tab">
            <div class="card-body">
            <re-direction-funds v-if="file_opening"
                ref ="re_direction_funds"
                :update_file_opening = "update_file_opening"
                :file_opening = "file_opening"
                :permissions="permissions"
                :file_opening_id="file_opening_id"
                 @updateFileOpening="updateFileOpening">
            </re-direction-funds>
            </div>
        </div>
    </div>
</template>

<script>
import AccountsTab from '../Accounts/AccountsTab.vue';
import CommissionTabs from '../Commission/CommissionTabs.vue';
import AccountStatementTab from '../AccountStatement/AccountStatementTab.vue';
import TrustLedgerTabs from '../TrustLedger/TrustLedgerTabs.vue';
import DirectionFunds from '../DirectionFunds/DirectionFunds.vue';
import ReDirectionFunds from '../ReDirectionFunds/ReDirectionFunds.vue';

export default {
    props:['permissions','file_opening_id','active_account_tab'],
    components:{
            CommissionTabs,
            AccountsTab,
            AccountStatementTab,
            TrustLedgerTabs,
            DirectionFunds,
            ReDirectionFunds,
    },
    data:function(){
        return {
            file_opening:null,
            base_url:Munshi.base_url,
            update_file_opening:false
        }
    },
    mounted:function(){
        this.getFileOpening();
        var self = this;
        window.onbeforeunload = function (event) {
            var is_dirty = self.isComponentDirty();
            if(is_dirty){
                return "You currently have unsaved changes!!";
                return "<h6>You currently have unsaved changes!!!\n\nAre you sure you want to exit without saving.\n\nChoose ‘Leave this Tab’ to exit without saving changes.\nChoose ‘Stay on this Tab’ to return.</h6>";
            }

        }
    },
    methods:{
        isComponentDirty:function(){
            if(this.$refs['account_adjustment'].isComponentDirty()
            || this.$refs['commission'].isComponentDirty()
            || this.$refs['account_statement'].isComponentDirty()
            || this.$refs['trust_ledgers'].isComponentDirty()
            || this.$refs['re_direction_funds'].isComponentDirty()){
              return true;
            }
            return false;
        },


        getRandomNumber(){
            return Utilities.getRandomNumber()
        },

        getFileOpening:function(){
            var self = this;
            axios.get(this.base_url+'/file-page/'+this.file_opening_id)
            .then(function(response){
                console.log(response);
                if(response.data.success){
                    self.file_opening = response.data.file_opening;
                }
            })
            .catch(function(error){
                console.log(error.response);
            });
        },
        updateFileOpening:function(object_name,object){
            var self = this;
            this.update_file_opening = false;
            this.file_opening[object_name] = object;
            setTimeout(function(){
                self.update_file_opening = true;
            },1000);
        }
    }
}
</script>

<style>

</style>
