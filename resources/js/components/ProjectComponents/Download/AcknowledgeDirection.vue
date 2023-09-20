<template>
  <div>
    <div class="iw-sider-card-wrap m-box p-0">
      <div class="card-body">
        <!-- <h4>Recent Documents</h4> -->
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
        </div>
      </div>
    </div>
  </div>
</template>


<script>
// recent

import AcknowledgementDirectionForTransfer from "./WithoutLetterHeadDocuments/AcknowledgementDirectionForTransfer.vue";
import SpousalConsent from "./WithoutLetterHeadDocuments/SpousalConsent.vue";
import WaiverSpouse from "./WithoutLetterHeadDocuments/WaiverSpouse.vue";

export default {
  components: {
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
