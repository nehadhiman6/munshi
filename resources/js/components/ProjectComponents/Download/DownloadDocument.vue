<template>
  <div>
    <div class="iw-sider-card-wrap m-box p-0">
      <div class="card-body">
        <h4>Letters to client</h4>
        <div class="row">
          <ol>
            <li>
              <first-letter-to-client
                v-if="file_opening"
                :client_name="client_name"
                :client_sub_title="client_sub_title"
                :client_address="client_address"
                :client_phone="client_phone"
                :client_email="client_email"
                :file_opening_id="file_opening_id"
                :file_opening="file_opening"
              >
              </first-letter-to-client>
            </li>
            <li>
              <letter-to-inform-about-utilities
                v-if="file_opening"
                :client_name="client_name"
                :client_sub_title="client_sub_title"
                :client_address="client_address"
                :client_phone="client_phone"
                :client_email="client_email"
                :file_opening_id="file_opening_id"
                :file_opening="file_opening"
                :departments="departments"
              >
              </letter-to-inform-about-utilities>
            </li>
            <li>
              <reporting-letter
                v-if="file_opening"
                :client_name="client_name"
                :client_sub_title="client_sub_title"
                :client_address="client_address"
                :client_phone="client_phone"
                :client_email="client_email"
                :file_opening_id="file_opening_id"
                :file_opening="file_opening"
              >
              </reporting-letter>
            </li>
          </ol>
        </div>
        <h4>Other transaction related letters and fax</h4>
        <div class="row">
          <ol>
            <li>
              <first-letter-to-purchase-solicitor
                v-if="file_opening"
                :client_name="client_name"
                :client_sub_title="client_sub_title"
                :client_address="client_address"
                :client_phone="client_phone"
                :client_email="client_email"
                :file_opening_id="file_opening_id"
                :file_opening="file_opening"
              >
              </first-letter-to-purchase-solicitor>
            </li>
            <li>
              <response-to-requisition
                v-if="file_opening"
                :client_name="client_name"
                :client_sub_title="client_sub_title"
                :client_address="client_address"
                :client_phone="client_phone"
                :client_email="client_email"
                :file_opening_id="file_opening_id"
                :file_opening="file_opening"
              >
              </response-to-requisition>
            </li>
            <li>
              <extension-letter
                v-if="file_opening"
                :client_name="client_name"
                :client_sub_title="client_sub_title"
                :client_address="client_address"
                :client_phone="client_phone"
                :client_email="client_email"
                :file_opening_id="file_opening_id"
                :file_opening="file_opening"
              >
              </extension-letter>
            </li>
            <li>
              <letter-notifying-other-solicitor-fulfilling-undertaking
                v-if="file_opening"
                :client_name="client_name"
                :client_sub_title="client_sub_title"
                :client_address="client_address"
                :client_phone="client_phone"
                :client_email="client_email"
                :file_opening_id="file_opening_id"
                :file_opening="file_opening"
              >
              </letter-notifying-other-solicitor-fulfilling-undertaking>
            </li>

            <!-- seller wise -->

            <li v-if="file_opening && file_opening.mortgages.length > 0">
              <span class="">Request for mortgage discharge statement</span>
              <ol class="" type="I">
                <li
                  v-for="mortgage in file_opening.mortgages"
                  :key="mortgage.id"
                >
                  <span class="">
                    (Mortgage Loan No.{{ mortgage.instrument_no }})</span
                  >
                  <!-- <ol class="" type="a" v-if="file_opening.sellers.length > 0">
                    <li
                      v-for="seller in file_opening.sellers"
                      :key="'waiver_spouse' + seller.id"
                    > -->
                       <letter-to-bank-for-payout-statement-request
                        v-if="file_opening"
                        :mortgage="mortgage"
                        :client_name="client_name"
                        :client_sub_title="client_sub_title"
                        :client_address="client_address"
                        :client_phone="client_phone"
                        :client_email="client_email"
                        :file_opening_id="file_opening_id"
                        :file_opening="file_opening"
                      >
                      </letter-to-bank-for-payout-statement-request>
                      <!-- <letter-to-bank-for-payout-statement-request
                        v-if="file_opening"
                        :mortgage="mortgage"
                        :doc_seller="seller"
                        :client_name="client_name"
                        :client_sub_title="client_sub_title"
                        :client_address="client_address"
                        :client_phone="client_phone"
                        :client_email="client_email"
                        :file_opening_id="file_opening_id"
                        :file_opening="file_opening"
                      >
                      </letter-to-bank-for-payout-statement-request> -->
                    <!-- </li> -->
                  <!-- </ol> -->
                </li>
              </ol>
            </li>

            <!-- end sellers -->

            <!-- 6 -->
            <li v-if="file_opening && file_opening.mortgages.length > 0">
              <span class="">Mortgage payout statement with funds.</span>
              <ol class="" type="I">
                <li
                  v-for="mortgage in file_opening.mortgages"
                  :key="mortgage.id"
                >
                  <span class="">
                    (Mortgage Loan No.{{ mortgage.instrument_no }})</span
                  >
                  <!-- <ol class="" type="a" v-if="file_opening.sellers.length > 0"> -->
                    <!-- <li
                      v-for="seller in file_opening.sellers"
                      :key="'mortgage_payout_funds' + seller.id"
                    > -->
                      <letter-to-bank-payout-mortgage-with-funds
                        v-if="file_opening"
                        :mortgage="mortgage"
                        :client_name="client_name"
                        :client_sub_title="client_sub_title"
                        :client_address="client_address"
                        :client_phone="client_phone"
                        :client_email="client_email"
                        :file_opening_id="file_opening_id"
                        :file_opening="file_opening"
                      >
                      </letter-to-bank-payout-mortgage-with-funds>
                    <!-- </li> -->
                  <!-- </ol> -->
                </li>
              </ol>
            </li>
            <!-- 6 end -->

            <!-- 7  -->
            <li v-if="file_opening && file_opening.mortgages.length > 0">
              <span class="">Follow up for discharge from bank</span>
              <ol class="" type="I">
                <li
                  v-for="mortgage in file_opening.mortgages"
                  :key="mortgage.id"
                >
                  <span class="">
                    (Mortgage Loan No.{{ mortgage.instrument_no }})</span
                  >
                  <!-- <ol class="" type="a" v-if="file_opening.sellers.length > 0">
                    <li
                      v-for="seller in file_opening.sellers"
                      :key="'letter_to_bank_follow_up' + seller.id"
                    > -->
                      <letters-to-bank-follow-up-discharge
                        v-if="file_opening"
                        :mortgage="mortgage"
                        :client_name="client_name"
                        :client_sub_title="client_sub_title"
                        :client_address="client_address"
                        :client_phone="client_phone"
                        :client_email="client_email"
                        :file_opening_id="file_opening_id"
                        :file_opening="file_opening"
                      >
                      </letters-to-bank-follow-up-discharge>
                    <!-- </li>
                  </ol> -->
                </li>
              </ol>
            </li>
            <!-- 7 end -->

            <li>
              <letter-to-brokerage-to-payout-commission
                v-if="file_opening"
                :client_name="client_name"
                :client_sub_title="client_sub_title"
                :client_address="client_address"
                :client_phone="client_phone"
                :client_email="client_email"
                :file_opening_id="file_opening_id"
                :file_opening="file_opening"
              >
              </letter-to-brokerage-to-payout-commission>
            </li>
            <li>
              <letters-to-lro
                v-if="file_opening"
                :client_name="client_name"
                :client_sub_title="client_sub_title"
                :client_address="client_address"
                :client_phone="client_phone"
                :client_email="client_email"
                :file_opening_id="file_opening_id"
                :file_opening="file_opening"
              >
              </letters-to-lro>
            </li>
            <li>
              <span class="">Letters to Utilities</span>
              <ol class="" type="a">
                <li>
                  <letters-to-utilities-water-department
                    v-if="file_opening"
                    :client_name="client_name"
                    :client_sub_title="client_sub_title"
                    :client_address="client_address"
                    :client_phone="client_phone"
                    :client_email="client_email"
                    :file_opening_id="file_opening_id"
                    :file_opening="file_opening"
                  >
                  </letters-to-utilities-water-department>
                </li>
                <li>
                  <letters-to-utilities-hydro-department
                    v-if="file_opening"
                    :client_name="client_name"
                    :client_sub_title="client_sub_title"
                    :client_address="client_address"
                    :client_phone="client_phone"
                    :client_email="client_email"
                    :file_opening_id="file_opening_id"
                    :file_opening="file_opening"
                  >
                  </letters-to-utilities-hydro-department>
                </li>
                <li>
                  <letters-to-utilities-gas-department
                    v-if="file_opening"
                    :client_name="client_name"
                    :client_sub_title="client_sub_title"
                    :client_address="client_address"
                    :client_phone="client_phone"
                    :client_email="client_email"
                    :file_opening_id="file_opening_id"
                    :file_opening="file_opening"
                  >
                  </letters-to-utilities-gas-department>
                </li>
              </ol>
            </li>
            <li>
              <letter-to-city-payout-tax-arrear
                v-if="file_opening"
                :client_name="client_name"
                :client_sub_title="client_sub_title"
                :client_address="client_address"
                :client_phone="client_phone"
                :client_email="client_email"
                :file_opening_id="file_opening_id"
                :file_opening="file_opening"
              >
              </letter-to-city-payout-tax-arrear>
            </li>
            <li>
              <sale-coversheet
                v-if="file_opening"
                :client_name="client_name"
                :client_sub_title="client_sub_title"
                :client_address="client_address"
                :client_phone="client_phone"
                :client_email="client_email"
                :file_opening_id="file_opening_id"
                :file_opening="file_opening"
              >
              </sale-coversheet>
            </li>
            <li>
              <lawyer-undertaking-discharge
                v-if="file_opening"
                :client_name="client_name"
                :client_sub_title="client_sub_title"
                :client_address="client_address"
                :client_phone="client_phone"
                :client_email="client_email"
                :file_opening_id="file_opening_id"
                :file_opening="file_opening"
              >
              </lawyer-undertaking-discharge>
            </li>
          </ol>
        </div>
        <h4>Fax coversheets</h4>
        <div class="row">
          <ol>
            <li>
              <fax-coversheet-to-lawyer
                v-if="file_opening"
                :client_name="client_name"
                :client_sub_title="client_sub_title"
                :client_address="client_address"
                :client_phone="client_phone"
                :client_email="client_email"
                :file_opening_id="file_opening_id"
                :file_opening="file_opening"
              >
              </fax-coversheet-to-lawyer>
            </li>
            <li>
              <fax-coversheet-to-bank
                v-if="file_opening"
                :client_name="client_name"
                :client_sub_title="client_sub_title"
                :client_address="client_address"
                :client_phone="client_phone"
                :client_email="client_email"
                :file_opening_id="file_opening_id"
                :file_opening="file_opening"
              >
              </fax-coversheet-to-bank>
            </li>
            <li>
              <fax-coversheet-to-brokerage
                v-if="file_opening"
                :client_name="client_name"
                :client_sub_title="client_sub_title"
                :client_address="client_address"
                :client_phone="client_phone"
                :client_email="client_email"
                :file_opening_id="file_opening_id"
                :file_opening="file_opening"
              >
              </fax-coversheet-to-brokerage>
            </li>
          </ol>
        </div>
        <h4>Documents to be signed by seller</h4>
        <div class="row">
          <ol>
            <li>
              <retainer
                v-if="file_opening"
                :client_name="client_name"
                :client_sub_title="client_sub_title"
                :client_address="client_address"
                :client_phone="client_phone"
                :client_email="client_email"
                :file_opening_id="file_opening_id"
                :file_opening="file_opening"
              >
              </retainer>
            </li>
            <li>
              <joint-retainer
                v-if="file_opening"
                :client_name="client_name"
                :client_sub_title="client_sub_title"
                :client_address="client_address"
                :client_phone="client_phone"
                :client_email="client_email"
                :file_opening_id="file_opening_id"
                :file_opening="file_opening"
              >
              </joint-retainer>
            </li>
            <li>
              <interest-acknowledgment
                v-if="file_opening"
                :client_name="client_name"
                :client_sub_title="client_sub_title"
                :client_address="client_address"
                :client_phone="client_phone"
                :client_email="client_email"
                :file_opening_id="file_opening_id"
                :file_opening="file_opening"
              >
              </interest-acknowledgment>
            </li>
            <!-- <li><a href="#">Direction funds</a></li>
                            <li><a href="#">Statutory declaration</a></li> -->
            <li>
              <vendor-undertaking-residence
                v-if="file_opening"
                :client_name="client_name"
                :client_sub_title="client_sub_title"
                :client_address="client_address"
                :client_phone="client_phone"
                :client_email="client_email"
                :file_opening_id="file_opening_id"
                :file_opening="file_opening"
              >
              </vendor-undertaking-residence>
            </li>
            <li>
              <undertaking-and-warranty
                v-if="file_opening"
                :client_name="client_name"
                :client_sub_title="client_sub_title"
                :client_address="client_address"
                :client_phone="client_phone"
                :client_email="client_email"
                :file_opening_id="file_opening_id"
                :file_opening="file_opening"
              >
              </undertaking-and-warranty>
            </li>
            <li>
              <client-affidavit-execution
                v-if="file_opening"
                :client_name="client_name"
                :client_sub_title="client_sub_title"
                :client_address="client_address"
                :client_phone="client_phone"
                :client_email="client_email"
                :file_opening_id="file_opening_id"
                :file_opening="file_opening"
              >
              </client-affidavit-execution>
            </li>
            <li>
              <solicitor-affidavit-execution
                v-if="file_opening"
                :client_name="client_name"
                :client_sub_title="client_sub_title"
                :client_address="client_address"
                :client_phone="client_phone"
                :client_email="client_email"
                :file_opening_id="file_opening_id"
                :file_opening="file_opening"
              >
              </solicitor-affidavit-execution>
            </li>
            <li v-if="married_sellers.length > 0">
              <span class="">Waiver of ILA by spouse </span>
              <ol class="" type="a">
                <li
                  v-for="seller in married_sellers"
                  :key="'waiver_spouse' + seller.id"
                >
                  <waiver-spouse
                    v-if="file_opening"
                    :married_seller="seller"
                    :client_name="client_name"
                    :client_sub_title="client_sub_title"
                    :client_address="client_address"
                    :client_phone="client_phone"
                    :client_email="client_email"
                    :file_opening_id="file_opening_id"
                    :file_opening="file_opening"
                  >
                  </waiver-spouse>
                </li>
              </ol>
            </li>
          </ol>
        </div>
        <!-- <h4>Recent Documents</h4>
        <div class="row">
          <ol>
            <li>
              <acknowledgement-direction-for-transfer
                v-if="file_opening"
                :client_name="client_name"
                :client_sub_title="client_sub_title"
                :client_address="client_address"
                :client_phone="client_phone"
                :client_email="client_email"
                :file_opening_id="file_opening_id"
                :file_opening="file_opening"
              >
              </acknowledgement-direction-for-transfer>
            </li>
            <li v-if="married_sellers.length > 0">
              <span class="">Spouse Consent</span>
              <ol class="" type="a">
                <li v-for="seller in married_sellers" :key="seller.id">
                  <spousal-consent
                    v-if="file_opening"
                    :married_seller="seller"
                    :client_name="client_name"
                    :client_sub_title="client_sub_title"
                    :client_address="client_address"
                    :client_phone="client_phone"
                    :client_email="client_email"
                    :file_opening_id="file_opening_id"
                    :file_opening="file_opening"
                  >
                  </spousal-consent>
                </li>
              </ol>
            </li>
          </ol>
        </div> -->
      </div>
    </div>
  </div>
</template>


<script>
import FirstLetterToClient from "./WithLetterHeadDocuments/FirstLetterToClient.vue";
import ReportingLetter from "./WithLetterHeadDocuments/ReportingLetter.vue";
import LetterToBankPayoutMortgageWithFunds from "./WithLetterHeadDocuments/LetterToBankPayoutMortgageWithFunds.vue";
import LetterToInformAboutUtilities from "./WithLetterHeadDocuments/LetterToInformAboutUtilities.vue";
import FirstLetterToPurchaseSolicitor from "./WithLetterHeadDocuments/FirstLetterToPurchaseSolicitor.vue";
import ResponseToRequisition from "./WithLetterHeadDocuments/ResponseToRequisition.vue";
import LettersToLro from "./WithLetterHeadDocuments/LettersToLro.vue";
import ExtensionLetter from "./WithLetterHeadDocuments/ExtensionLetter.vue";
import LettersToBankFollowUpDischarge from "./WithLetterHeadDocuments/LettersToBankFollowUpDischarge.vue";
import LetterNotifyingOtherSolicitorFulfillingUndertaking from "./WithLetterHeadDocuments/LetterNotifyingOtherSolicitorFulfillingUndertaking.vue";
import LetterToBankForPayoutStatementRequest from "./WithLetterHeadDocuments/LetterToBankForPayoutStatementRequest.vue";
import SaleCoversheet from "./WithLetterHeadDocuments/SaleCoversheet.vue";
import LawyerUndertakingDischarge from "./WithLetterHeadDocuments/LawyerUndertakingDischarge.vue";
import LetterToBrokerageToPayoutCommission from "./WithLetterHeadDocuments/LetterToBrokerageToPayoutCommission.vue";
import LetterToCityPayoutTaxArrear from "./WithLetterHeadDocuments/LetterToCityPayoutTaxArrear.vue";
import LettersToUtilitiesWaterDepartment from "./WithLetterHeadDocuments/LettersToUtilitiesWaterDepartment.vue";
import LettersToUtilitiesHydroDepartment from "./WithLetterHeadDocuments/LettersToUtilitiesHydroDepartment.vue";
import LettersToUtilitiesGasDepartment from "./WithLetterHeadDocuments/LettersToUtilitiesGasDepartment.vue";

// Without letterhead
import Retainer from "./WithoutLetterHeadDocuments/Retainer.vue";
import JointRetainer from "./WithoutLetterHeadDocuments/JointRetainer.vue";
import InterestAcknowledgment from "./WithoutLetterHeadDocuments/InterestAcknowledgment.vue";
import UndertakingAndWarranty from "./WithoutLetterHeadDocuments/UndertakingAndWarranty.vue";
import ClientAffidavitExecution from "./WithoutLetterHeadDocuments/ClientAffidavitExecution.vue";
import SolicitorAffidavitExecution from "./WithoutLetterHeadDocuments/SolicitorAffidavitExecution.vue";

// facecover sheet
import FaxCoversheetToBank from "./FaxCoverDocuments/FaxCoversheetToBank.vue";
import FaxCoversheetToLawyer from "./FaxCoverDocuments/FaxCoversheetToLawyer.vue";
import FaxCoversheetToBrokerage from "./FaxCoverDocuments/FaxCoversheetToBrokerage.vue";
import VendorUndertakingResidence from "./WithoutLetterHeadDocuments/VendorUndertakingResidence.vue";

// recent

import AcknowledgementDirectionForTransfer from "./WithoutLetterHeadDocuments/AcknowledgementDirectionForTransfer.vue";
import SpousalConsent from "./WithoutLetterHeadDocuments/SpousalConsent.vue";
import WaiverSpouse from "./WithoutLetterHeadDocuments/WaiverSpouse.vue";

export default {
  components: {
    FirstLetterToClient,
    ReportingLetter,
    LetterToBankPayoutMortgageWithFunds,
    LetterToInformAboutUtilities,
    FirstLetterToPurchaseSolicitor,
    ResponseToRequisition,
    LettersToLro,
    ExtensionLetter,
    LettersToBankFollowUpDischarge,
    LetterNotifyingOtherSolicitorFulfillingUndertaking,
    LetterToBankForPayoutStatementRequest,
    SaleCoversheet,
    LawyerUndertakingDischarge,
    LetterToBrokerageToPayoutCommission,
    LettersToUtilitiesWaterDepartment,
    LettersToUtilitiesHydroDepartment,
    LettersToUtilitiesGasDepartment,
    LetterToCityPayoutTaxArrear,
    FaxCoversheetToBank,
    FaxCoversheetToLawyer,
    FaxCoversheetToBrokerage,
    Retainer,
    JointRetainer,
    InterestAcknowledgment,
    UndertakingAndWarranty,
    ClientAffidavitExecution,
    SolicitorAffidavitExecution,
    VendorUndertakingResidence,
    AcknowledgementDirectionForTransfer,
    SpousalConsent,
    WaiverSpouse,
  },
  props: [
    "permissions",
    "client_name",
    "client_sub_title",
    "client_address",
    "client_phone",
    "client_email",
    "file_opening_id",
    "departments",
  ],
  data: function () {
    return {
      createUrl: "download-documents",
      file_opening: null,
      base_url: Munshi.base_url,
    };
  },

  mounted: function () {
    this.getFileOpening();
  },
  computed: {
    married_sellers: function () {
      if (this.file_opening)
        return this.file_opening.sellers.filter(
          (ele) => ele.marital_status == "married"
        );
      return [];
    },
  },
  methods: {
    getFileOpening: function () {
      var self = this;
      self.show = false;
      axios
        .get(this.base_url + "/file-page/" + this.file_opening_id)
        .then(function (response) {
          if (response.data.success) {
            self.file_opening = response.data.file_opening;
          }
        })
        .then(function () {
          self.show_documents = true;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
  },
};
</script>

<style>
</style>
