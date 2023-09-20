<template>
    <div>
        <div class="card border-bottom-0 border-radius-0" v-if="file_opening">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h5 class="card-title mb-0">File Number: <span v-text="file_opening.file_no"></span ></h5>
                <h6>Closing Date(<span v-text="file_opening.closing_date"></span>)</h6>
                <div class="iw-pagination-button-area">
                    <button class="btn  iw-btn-prev" v-if="active_tab !='file'" @click.prevent="changeTab('previous')">Previous</button>
                    <button class="btn  iw-btn-next"  v-if="active_tab !='documents'" @click.prevent="changeTab('next')">Next</button>
                </div>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-start">
            <div class="vertical-tabs">
                <nav>
                    <div class="nav flex-column nav-pills nav flex-column nav-pills mr-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="v-pills-file-tab" data-toggle="pill" href="#v-pills-file" @click="active_tab='file'" role="tab" aria-controls="v-pills-file" aria-selected="true">File</a>
                        <a class="nav-link" id="v-pills-seller-tab" data-toggle="pill" href="#v-pills-seller" @click="active_tab='seller'" role="tab" aria-controls="v-pills-seller" aria-selected="true"  v-if="file_opening_id > 0">Sellers</a>
                        <a class="nav-link" id="v-pills-purchaser-tab" data-toggle="pill" href="#v-pills-purchaser" @click="active_tab='purchaser'"  role="tab" aria-controls="v-pills-purchaser" aria-selected="false"  v-if="file_opening_id > 0">Purchasers</a>
                        <a class="nav-link" id="v-pills-property-tab" data-toggle="pill" href="#v-pills-property" @click="active_tab='property'"  role="tab" aria-controls="v-pills-property" aria-selected="false"  v-if="file_opening_id > 0">Property</a>
                        <a class="nav-link" id="v-pills-mortgage-tab" data-toggle="pill" href="#v-pills-mortgage" @click="active_tab='mortgage'"  role="tab" aria-controls="v-pills-mortgage" aria-selected="false"  v-if="file_opening_id > 0">Mortgage</a>
                        <a class="nav-link" id="v-pills-condo-corpo-tab" v-if="showCondo && file_opening_id>0" href="#v-pills-condo-corpo"  data-toggle="pill" @click="active_tab='condo-corpo'"  role="tab" aria-controls="v-pills-condo-corpo" aria-selected="false">Condo Corporation</a>
                        <!-- <a class="nav-link" id="v-pills-ammended-tab" data-toggle="pill" href="#v-pills-ammended" @click="active_tab='ammended'"  role="tab" aria-controls="v-pills-ammended" aria-selected="false">Commission</a> -->
                        <a class="nav-link" id="v-pills-account-tab" data-toggle="pill" href="#v-pills-account" @click="active_tab='account'"  role="tab" aria-controls="v-pills-account" aria-selected="false"  v-if="file_opening_id > 0">Accounts</a>
                        <a class="nav-link" id="v-pills-requisitions-response-tab" data-toggle="pill" href="#v-pills-requisitions-response"  v-if="file_opening_id > 0" @click="active_tab='requisitions-response'"  role="tab" aria-controls="v-pills-requisitions-response" aria-selected="false">Requisition Response</a>
                        <a class="nav-link" id="v-pills-writ-tab" data-toggle="pill" href="#v-pills-writ"  v-if="file_opening_id > 0" @click="active_tab='writ'"  role="tab" aria-controls="v-pills-writ" aria-selected="false">Writ of Execution</a>
                        <a class="nav-link" id="v-pills-compliance-tab" data-toggle="pill" href="#v-pills-compliance"  v-if="file_opening_id > 0" @click="active_tab='compliance'"  role="tab" aria-controls="v-pills-compliance" aria-selected="false">Post Closing</a>
                        <a class="nav-link" id="v-pills-signing-tab" data-toggle="pill" href="#v-pills-signing"  v-if="file_opening_id > 0" @click="active_tab='signing'"  role="tab" aria-controls="v-pills-signing" aria-selected="false">Remote Signing</a>
                        <a class="nav-link" id="v-pills-documents-tab" data-toggle="pill" href="#v-pills-documents"  v-if="file_opening_id > 0" @click="active_tab='documents'"  role="tab" aria-controls="v-pills-documents" aria-selected="false">Store Documents</a>
                    </div>

				</nav>
                <div class="tab-content" id="v-pills-tabContent" style=" width: 100%; ">
                    <div class="tab-pane fade show active" id="v-pills-file" role="tabpanel" aria-labelledby="v-pills-file-tab">
                        <div class="">
                            <div class="card-header">
                                File
							</div>
                            <div class="card-body">
                                <file-opening-form v-if="active_tab == 'file'" :key="getRandomNumber()"
                                    ref="file"
                                 :permissions="permissions"
                                :form-id ="file_opening_id"
                                @closeTriggered="fileSaved">
								</file-opening-form >
							</div>
						</div>
					</div>
                    <div class="tab-pane fade show" id="v-pills-seller" role="tabpanel" aria-labelledby="v-pills-seller-tab" v-if="file_opening_id > 0">
                        <div class="">
                            <div class="card-header">
                                Sellers
                            </div>
                            <div class="card-body">
                                <sellers-tabs v-if="active_tab == 'seller'" :key="getRandomNumber()"
                                    ref="seller"
                                    :permissions="permissions"
                                    :file_opening_id="file_opening_id">
                                </sellers-tabs>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-purchaser" role="tabpanel" aria-labelledby="v-pills-profile-tab"  v-if="file_opening_id > 0">
                        <div class="">
                            <div class="card-header">
                                Purchasers
                            </div>
                            <div class="card-body ">
                                <purchasers-tabs v-if="active_tab == 'purchaser'" :key="getRandomNumber()"
                                    ref="purchaser"
                                    :permissions="permissions"
                                    :file_opening_id="file_opening_id">
                                </purchasers-tabs>
                            </div>
                        </div>
					</div>
                    <div class="tab-pane fade" id="v-pills-property" role="tabpanel" aria-labelledby="v-pills-property-tab"  v-if="file_opening_id > 0">
                        <div class="">
                            <div class="card-header">
                                Property
                            </div>
                            <div class="card-body ">
                                <property-tabs v-if="active_tab == 'property'" :key="getRandomNumber()"
                                     ref="property"
                                   :permissions="permissions"
                                    :lro="lro_arr"
                                    :file_opening_id="file_opening_id">
                                </property-tabs>
                            </div>
                        </div>
					</div>
                    <div class="tab-pane fade" id="v-pills-mortgage" role="tabpanel" aria-labelledby="v-pills-mortgage-tab"  v-if="file_opening_id > 0">
                        <div class="">
                            <div class="card-header">
                                Mortgage
                            </div>
                            <div class="card-body ">
                                <mortgage-tabs v-if="active_tab == 'mortgage'" :key="getRandomNumber()"
                                    ref="mortgage"
                                  :permissions="permissions"
                                    :file_opening_id="file_opening_id">
                                </mortgage-tabs>
                            </div>
                        </div>
					</div>
                    <div class="tab-pane fade" id="v-pills-condo-corpo" role="tabpanel" aria-labelledby="v-pills-condo-corpo-tab"  v-if="showCondo && file_opening_id > 0">
                        <div class="">
                            <div class="card-header">
                                Condo Corporation
							</div>
                            <div class="card-body ">
                                <condo-corporation-tab v-if="active_tab == 'condo-corpo'" :key="getRandomNumber()"
                                    ref="condo-corpo"
                                  :permissions="permissions"
                                    :file_opening_id="file_opening_id">
                                </condo-corporation-tab>
                            </div>
						</div>
					</div>


                    <div class="tab-pane fade"   id="v-pills-account" role="tabpanel" aria-labelledby="v-pills-account-tab"  v-if="file_opening_id > 0" >
                        <div class="" v-if="active_tab == 'account'">
                            <nav>
                                <div class="nav nav-tabs w-100 justify-content-between" id="nav-tab" role="tablist">
                                    <div class="nav">
                                    <a class="nav-item nav-link active" id="nav-statement-adjustment-tab" data-toggle="tab" href="#nav-statement-adjustment"  @click="active_account_tab ='statement-adjustment'"
                                     role="tab" aria-controls="nav-statement-adjustment" aria-selected="true">  Statement of Adjustment</a>
                                    <a class="nav-item nav-link" id="nav-commission-tab" data-toggle="tab" href="#nav-commission" role="tab"  @click="active_account_tab ='commission'"
                                     aria-controls="nav-commission" aria-selected="false">Commission</a>
                                    <a class="nav-item nav-link" id="nav-account-statement-tab" data-toggle="tab" href="#account-statement" role="tab"  @click="active_account_tab ='account-statement'"
                                     aria-controls="account-statement" aria-selected="false">Account Statement</a>
                                    <a class="nav-item nav-link" id="nav-trust-ledger-tab" data-toggle="tab" href="#trust-ledger" role="tab"  @click="active_account_tab ='trust-ledger'"
                                     aria-controls="trust-ledger" aria-selected="false">Trust Ledger</a>
                                    <!-- <a class="nav-item nav-link" id="nav-direction-funds-tab" data-toggle="tab" href="#direction-funds" role="tab"
                                     aria-controls="direction-funds" aria-selected="false">Direction Funds</a> -->
                                    <a class="nav-item nav-link" id="nav-re-direction-funds-tab" data-toggle="tab" href="#re-direction-funds" role="tab"  @click="active_account_tab ='re-direction-funds'"
                                     aria-controls="re-direction-funds" aria-selected="false">Re Direction Funds</a>
                                    </div>
                                     <div class="iw-pagination-button-area mr-3 float-right">
                                        <button class="btn  iw-btn-prev iw-btn-square" v-if="active_account_tab !='statement-adjustment'" @click.prevent="changeAccountTab('previous')"><span class="mdi mdi-chevron-left"></span></button>
                                        <button class="btn  iw-btn-next iw-btn-square"  v-if="active_account_tab !='re-direction-funds'" @click.prevent="changeAccountTab('next')"><span class="mdi mdi-chevron-right"></span></button>
                                </div>
                                </div>

							</nav>

                            <accounts
                                ref="account"
                                :active_account_tab="active_account_tab"
                                :file_opening_id="file_opening_id"
                                :permissions="permissions">
                            </accounts>
                        </div>
                    </div>
                    <div class="tab-pane fade"   id="v-pills-requisitions-response" role="tabpanel" aria-labelledby="v-pills-requisitions-tab"  v-if="file_opening_id > 0">
                        <div class="" v-if="active_tab == 'requisitions-response'">
                            <div class="card-header">
                                 Response to Requisition
                            </div>
                            <div class="card-body ">
                                <requisition-responses :key="getRandomNumber()"
                                    ref='requisitions-response'
                                    :permissions="permissions"
                                    :file_opening_id="file_opening_id">
                                </requisition-responses>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade"   id="v-pills-writ" role="tabpanel" aria-labelledby="v-pills-writ-tab"  v-if="file_opening_id > 0">
                        <div class="" v-if="active_tab == 'writ'">
                            <div class="card-header">
                                Writ of Execution
                            </div>
                            <div class="card-body ">
                                <writ-form :key="getRandomNumber()"
                                    :permissions="permissions"
                                    :file_opening_id="file_opening_id">
                                </writ-form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade"   id="v-pills-signing" role="tabpanel" aria-labelledby="v-pills-signing-tab"  v-if="file_opening_id > 0">
                        <div class="" v-if="active_tab == 'signing'">
                            <div class="card-header">
                                Signing
                            </div>
                            <div class="card-body ">
                                <signing-form :key="getRandomNumber()"
                                    :permissions="permissions"
                                    :file_opening_id="file_opening_id">
                                </signing-form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade"   id="v-pills-documents" role="tabpanel" aria-labelledby="v-pills-documents-tab"  v-if="file_opening_id > 0">
                        <div class="" v-if="active_tab == 'documents'">
                            <div class="card-header">
                                File Documents/Attachments
                            </div>
                            <div class="card-body ">
                                <file-documents :key="getRandomNumber()"
                                    ref="documents"
                                    :permissions="permissions"
                                    :file_opening_id="file_opening_id">
                                </file-documents>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade"   id="v-pills-compliance" role="tabpanel" aria-labelledby="v-pills-compliance-tab"  v-if="file_opening_id > 0">
                        <div class="" v-if="active_tab == 'compliance'">
                            <div class="card-header">
                                Compliance
                            </div>
                            <div class="card-body ">
                                <compliance-form :key="getRandomNumber()"
                                    ref="compliance"
                                    :permissions="permissions"
                                    :file_opening_id="file_opening_id">
                                </compliance-form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import PropertyTabs from '../Property/PropertyTabs.vue';
import PurchasersTabs from '../Purchasers/PurchasersTabs.vue';
import SellersTabs from '../Sellers/SellersTabs.vue';
import MortgageTabs from '../Mortgage/MortgageTabs.vue';
import CondoCorporationTab from '../CondoCorporation/CondoCorporationTab.vue';
import RequisitionResponses from '../RequisitionResponse/RequisitionResponses.vue';
import FileOpeningForm from '../FileOpening/FileOpeningForm.vue';
import FileDocuments from '../FileDocument/FileDocuments.vue';
import ComplianceForm from '../Compliance/ComplianceForm.vue';
import WritForm from '../Writ/WritForm.vue';
import SigningForm from '../RemoteSigning/SigningForm.vue';
import Accounts from './Accounts.vue';

	export default {
		props:['file_opening_id','lro','permissions'],

		components:{
            SellersTabs,
            PurchasersTabs,
            PropertyTabs,MortgageTabs,
            CondoCorporationTab,
            RequisitionResponses,
            FileOpeningForm,
            FileDocuments,
            ComplianceForm,
            WritForm,
            SigningForm,
            Accounts
		},

		data:function(){
			return {
				create_url:'file-page',
				base_url:Munshi.base_url,
				file_opening:null,
				active_tab:'file',
				active_account_tab:'statement-adjustment'
			}
		},
		computed:{
			showCondo:function(){
				if(this.file_opening && this.file_opening.property && this.file_opening.property.sale_of == 'Condo Corporation'){
					return true;
				}
				return false;
			},

			lro_arr:function(){
				var arr =  this.lro;
				arr.forEach(element => {
					element.id = parseInt(element.id);
				});
				return arr;
			}

		},
		mounted:function(){
			this.getFileOpening();
		},
		methods:{
			getFileOpening:function(){
				var self = this;
				axios.get(this.base_url+'/file-openings/'+this.file_opening_id)
				.then(function(response){
					if(response.data.success){
						self.file_opening = response.data.file_opening;
						if( self.file_opening.file_no)
						document.title = self.file_opening.file_no;

					}
				})
				.catch(function(error){
				});
			},

			changeTab:function(status){
				var self = this;
				var tabs = this.showCondo ? [
                'file',
                'seller',
                'purchaser',
                'property',
                'mortgage',
                'condo-corpo',
                // 'ammended',
                'account',
                'requisitions-response',
                'writ',
                'compliance',
                'signing',
                'documents',
            ]:[
                'file',
                'seller',
                'purchaser',
                'property',
                'mortgage',
                // 'ammended',
                'account',
                'requisitions-response',
                'writ',
                'compliance',
                'signing',
                'documents',
            ];
            var index =  tabs.indexOf(this.active_tab);
            if(status == 'previous' && index >0 ){
                self.active_tab = tabs[index-1];
                $('#v-pills-'+tabs[index-1]+'-tab').click();

				}
				if(status == 'next' && index < tabs.length){
					self.active_tab = tabs[index+1];
					$('#v-pills-'+tabs[index+1]+'-tab').click();
				}
			},

			changeAccountTab:function(status){
				var self = this;
				var tabs =  [
                'statement-adjustment',
                'commission',
                'account-statement',
                'trust-ledger',
                're-direction-funds',
				];
				var index =  tabs.indexOf(this.active_account_tab);
				if(status == 'previous' && index >0 ){
					self.active_account_tab = tabs[index-1];
					$('#nav-'+tabs[index-1]+'-tab').click();

				}
				if(status == 'next' && index < tabs.length){
					self.active_account_tab = tabs[index+1];
					$('#nav-'+tabs[index+1]+'-tab').click();
				}
			},

			fileSaved:function(file){
				vm.file_opening_id = file.id;
				var newurl = Munshi.base_url + "/file-page?file_opening_id="+file.id;
				window.history.pushState({path:newurl},'',newurl);
			},

        getRandomNumber(){
            return Utilities.getRandomNumber()
        },

        makeTabActive:function(tab){
            var self = this;
            console.log("is Current Component Dirty");
            console.log(this.isAnyComponentDirty());
            if(this.isAnyComponentDirty()){
                 Utilities.showConfirmationPopMessage('<h6>You currently have unsaved changes!!!\n\nAre you sure you want to exit without saving.\n\nChoose ‘Leave this Tab’ to exit without saving changes.\nChoose ‘Stay on this Tab’ to return.</h6>',function(save){
                    if(save == false){
                        self.active_tab = tab;
                    }
                    else{
                          $('#v-pills-'+self.active_tab+'-tab').click();
                    }
                },true,false,'Stay on this Tab','Leave this Tab',false,false);
            }
            else{
                self.active_tab = tab;
            }
        },

        isAnyComponentDirty:function(){
            var self = this;
            var dirty = false;
             var tabs = this.showCondo ? [
                'file',
                'seller',
                'purchaser',
                'property',
                'mortgage',
                'condo-corpo',
                // 'ammended',
                'account',
                'requisitions-response',
                'documents',
                'compliance'

            ]:[
                'file',
                'seller',
                'purchaser',
                'property',
                'mortgage',
                // 'ammended',
                'account',
                'requisitions-response',
                'documents',
                 'compliance'
            ];

            tabs.forEach(function(ele){
                if(self.$refs[ele] && self.$refs[ele].isComponentDirty()){
                    dirty = true;
                }
            });
            return dirty;
        },
    }
}
</script>

<style>
	.border-radius-0 {
    border-radius: 0;
	}
	.vertical-tabs > nav {
    background: #fff;
    border: 1px solid rgba(0, 0, 0, 0.125);
    border-right:0
	}
	.vertical-tabs > nav a.nav-link.active:after {
    left: inherit;
    transform: translateY(-50%) rotate(-90deg);
    top: 50%;
    right: -20px;
	}
	.vertical-tabs {
    display: flex;
    flex: 1;
	}
	.iw-pagination-button-area .iw-btn-prev {
    border-radius: 50px;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
    min-width:80px;
    background: transparent;
    border: 1px solid #031893;
    color: #031893;
	}
	.iw-pagination-button-area .iw-btn-next {
    border-radius: 50px;
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
    min-width:80px;
    background: transparent;
    border: 1px solid #031893;
    color: #031893;
	}
	.iw-pagination-button-area > .btn:hover, .iw-pagination-button-area > .btn:focus {
    background: #031893;
    color: #fff;
	}
	.iw-pagination-button-area .iw-btn-square {
    border-radius: 0;
    min-width: 30px;
    font-size: 25px;
    line-height: 1;
    margin: 5px 0;
    padding: 5px 5px;
	}
</style>
