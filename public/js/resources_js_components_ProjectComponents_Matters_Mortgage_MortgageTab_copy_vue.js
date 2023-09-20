"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ProjectComponents_Matters_Mortgage_MortgageTab_copy_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ProjectComponents/Matters/Mortgage/MortgageTab copy.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ProjectComponents/Matters/Mortgage/MortgageTab copy.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Masters_City_CityForm_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../Masters/City/CityForm.vue */ "./resources/js/components/ProjectComponents/Masters/City/CityForm.vue");
/* harmony import */ var _SelectComponents_EmployeeSelect_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../SelectComponents/EmployeeSelect.vue */ "./resources/js/components/ProjectComponents/SelectComponents/EmployeeSelect.vue");
/* harmony import */ var _SelectComponents_SolicitorSelect_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../SelectComponents/SolicitorSelect.vue */ "./resources/js/components/ProjectComponents/SelectComponents/SolicitorSelect.vue");
/* harmony import */ var _MortgageCharge_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./MortgageCharge.vue */ "./resources/js/components/ProjectComponents/Matters/Mortgage/MortgageCharge.vue");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
function getCharge() {
  return {
    id: 0,
    particulars: '',
    amount: '',
    random: Utilities.getRandomNumber()
  };
}





/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    EmployeeSelect: _SelectComponents_EmployeeSelect_vue__WEBPACK_IMPORTED_MODULE_1__["default"],
    CityForm: _Masters_City_CityForm_vue__WEBPACK_IMPORTED_MODULE_0__["default"],
    SolicitorSelect: _SelectComponents_SolicitorSelect_vue__WEBPACK_IMPORTED_MODULE_2__["default"],
    MortgageCharge: _MortgageCharge_vue__WEBPACK_IMPORTED_MODULE_3__["default"]
  },
  props: ['mortgage', 'index', 'form', 'random', 'closing_date'],
  data: function data() {
    return {
      initialCity: [],
      selectedCity: [],
      initialContact: [],
      selectedContact: [],
      initialSolicitor: [],
      selectedSolicitor: [],
      show: false,
      city: false,
      showCity: false
    };
  },
  computed: {
    total_charge: function total_charge() {
      var total = Utilities.round(this.mortgage.principal_amount) + Utilities.round(this.mortgage.extra_interest);
      this.mortgage.additional_charges.forEach(function (element) {
        total += Utilities.round(element.amount);
      });
      this.mortgage.total_mortgage_payable_discharge = total;
      return total;
    },
    extra_days: function extra_days() {
      var self = this;
      var days = 0;
      var closing_date = moment(self.closing_date, "MM-DD-YYYY");
      var discharged_on = moment(self.mortgage.discharged_on, "MM-DD-YYYY");
      var diff = discharged_on.diff(closing_date, 'days');
      days = diff > 0 ? diff : 0;
      return days;
    },
    extra_interest: function extra_interest() {
      var charge = 0;
      charge = this.extra_days * this.mortgage.per_diem;
      this.mortgage.extra_interest = charge;
      return charge;
    }
  },
  mounted: function mounted() {
    if (this.mortgage.address.city) {
      this.initialCity = [{
        'text': this.mortgage.address.city.city_name,
        'id': this.mortgage.address.city_id
      }];
      this.selectedCity = [this.mortgage.address.city_id];
    }

    if (this.mortgage.mortgagee) {
      var first_name = this.mortgage.mortgagee.first_name ? this.mortgage.mortgagee.first_name : '';
      var middle_name = this.mortgage.mortgagee.middle_name ? this.mortgage.mortgagee.middle_name : '';
      var last_name = this.mortgage.mortgagee.last_name ? this.mortgage.mortgagee.last_name : ''; // this.initialContact = [{'text':first_name+' '+middle_name+' '+last_name,'id':this.mortgage.mortgagee.id}];

      this.initialContact = [{
        'text': this.mortgage.mortgage.company_name
      }];
      this.selectedContact = [this.mortgage.mortgagee.id];
    }

    if (this.mortgage.solicitor) {
      var first_name = this.mortgage.solicitor.first_name ? this.mortgage.solicitor.first_name : '';
      var middle_name = this.mortgage.solicitor.middle_name ? this.mortgage.solicitor.middle_name : '';
      var last_name = this.mortgage.solicitor.last_name ? this.mortgage.solicitor.last_name : '';
      this.initialSolicitor = [{
        'text': first_name + ' ' + middle_name + ' ' + last_name,
        'id': this.mortgage.solicitor.id
      }];
      this.selectedSolicitor = [this.mortgage.solicitor.id];
    }

    if (this.mortgage.additional_charges.length == 0) {
      this.mortgage.additional_charges.push(getCharge());
    }

    this.show = true;
    this.city = true;
  },
  methods: {
    getNumber: function getNumber() {
      return parseInt(this.index) + 1;
    },
    updateCity: function updateCity(value, index, city) {
      this.mortgage.address.country = city.country;
      this.mortgage.address.province = city.state;
    },
    addCity: function addCity() {
      this.showCity = true;
    },
    closeCityModal: function closeCityModal() {
      this.showCity = false;
    },
    acceptNumber: function acceptNumber(field) {
      // var x = this.mortgage.phone.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
      // this.mortgage.phone = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
      var value = this.mortgage[field].replace(/\D/g, "");

      if (value.length <= 10) {
        var x = this.mortgage[field].replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
        this.mortgage[field] = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
      }

      if (value.length == 11) {
        var x = this.mortgage[field].replace(/\D/g, '').match(/(\d{1})(\d{3})(\d{3})(\d{4})/);
        this.mortgage[field] = x[1] + ' (' + x[2] + ') ' + x[3] + '-' + x[4];
      }

      if (value.length > 11) {
        var x = this.mortgage[field].replace(/\D/g, '').match(/(\d{2})(\d{3})(\d{3})(\d{4})/);
        this.mortgage[field] = x[1] + ' (' + x[2] + ') ' + x[3] + '-' + x[4];
      }
    },
    postalCode: function postalCode(field) {
      this.mortgage.address[field] = this.mortgage.address[field].toUpperCase();
      var str = this.mortgage.address[field];
      var matched = true;
      var x = '';

      switch (str.length) {
        case 1:
          x = this.mortgage.address[field].match(/[A-Z]/g);
          break;

        case 2:
          x = this.mortgage.address[field].match(/[A-Z][0-9]/g);
          break;

        case 3:
          x = this.mortgage.address[field].match(/[A-Z][0-9][A-Z]/g);
          break;

        case 4:
          x = this.mortgage.address[field].match(/[A-Z][0-9][A-Z][ ]/g);
          break;

        case 5:
          x = this.mortgage.address[field].match(/[A-Z][0-9][A-Z][ ][0-9]/g);
          break;

        case 6:
          x = this.mortgage.address[field].match(/[A-Z][0-9][A-Z][ ][0-9][A-Z]/g);
          break;

        case 7:
          x = this.mortgage.address[field].match(/[A-Z][0-9][A-Z][ ][0-9][A-Z][0-9]/g);
      }

      if (x == null) {
        this.mortgage.address[field] = this.mortgage.address[field].substring(0, this.mortgage.address[field].length - 1);

        if (str.length == 4) {
          this.mortgage.address[field] = this.mortgage.address[field] + ' ';
        }
      }

      if (str.length == 3) {
        this.form.mortgage.address[field] = this.form.mortgage.address[field] + ' ';
      }

      if (str.length > 7) {
        this.mortgage.address[field] = this.mortgage.address[field].substring(0, 7);
      } // var x = this.form.address[field].match(/[A-Z][0-9][A-Z][ ][0-9][A-Z][0-9]/g);

    },
    getContactAddress: function getContactAddress() {
      var self = this;
      var url = '';

      if (this.mortgage.contact == 'solicitor' && this.mortgage.solicitor_id > 0) {
        url = Munshi.base_url + '/solicitors/' + this.mortgage.solicitor_id;
      } else if (this.mortgage.contact == 'mortgagee' && this.mortgage.mortgagee_id > 0) {
        url = Munshi.base_url + '/contacts/' + this.mortgage.mortgagee_id;
      }

      if (url != '') {
        self.city = false;
        axios.get(url).then(function (response) {
          var detail = null;

          if (response.data.solicitor) {
            detail = response.data.solicitor;
          } else if (response.data.contact) {
            detail = response.data.contact;
          }

          self.mortgage.address.number = detail.address ? detail.address.number : '';
          self.mortgage.address.street = detail.address ? detail.address.street : '';
          self.mortgage.address.province = detail.address ? detail.address.province : '';
          self.mortgage.address.country = detail.address ? detail.address.country : '';
          self.mortgage.address.postal_code = detail.address ? detail.address.postal_code : '';
          self.mortgage.phone = detail ? detail.cell_phone : '';
          self.mortgage.fax = detail ? detail.fax : '';
          self.mortgage.email = detail ? detail.email : '';
          self.mortgage.attention = detail ? detail.attention : '';

          if (detail.address) {
            self.initialCity = [{
              'text': detail.address.city.city_name,
              'id': detail.address.city_id
            }];
            self.selectedCity = [detail.address.city_id];
          }

          self.city = true;
        })["catch"](function (error) {
          self.city = true;
          console.log(error);
        });
      }
    },
    addCharges: function addCharges() {
      this.mortgage.additional_charges.push(getCharge());
    },
    removeCharges: function removeCharges(index) {
      this.mortgage.additional_charges.splice(index, 1);
    }
  }
});

/***/ }),

/***/ "./node_modules/mini-css-extract-plugin/dist/loader.js??clonedRuleSet-10[0].rules[0].use[0]!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-10[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ProjectComponents/Matters/Mortgage/MortgageTab copy.vue?vue&type=style&index=0&lang=css&":
/*!***************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/mini-css-extract-plugin/dist/loader.js??clonedRuleSet-10[0].rules[0].use[0]!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-10[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ProjectComponents/Matters/Mortgage/MortgageTab copy.vue?vue&type=style&index=0&lang=css& ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/js/components/ProjectComponents/Matters/Mortgage/MortgageTab copy.vue":
/*!*****************************************************************************************!*\
  !*** ./resources/js/components/ProjectComponents/Matters/Mortgage/MortgageTab copy.vue ***!
  \*****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _MortgageTab_copy_vue_vue_type_template_id_6d7116b7___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./MortgageTab copy.vue?vue&type=template&id=6d7116b7& */ "./resources/js/components/ProjectComponents/Matters/Mortgage/MortgageTab copy.vue?vue&type=template&id=6d7116b7&");
/* harmony import */ var _MortgageTab_copy_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./MortgageTab copy.vue?vue&type=script&lang=js& */ "./resources/js/components/ProjectComponents/Matters/Mortgage/MortgageTab copy.vue?vue&type=script&lang=js&");
/* harmony import */ var _MortgageTab_copy_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./MortgageTab copy.vue?vue&type=style&index=0&lang=css& */ "./resources/js/components/ProjectComponents/Matters/Mortgage/MortgageTab copy.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _MortgageTab_copy_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _MortgageTab_copy_vue_vue_type_template_id_6d7116b7___WEBPACK_IMPORTED_MODULE_0__.render,
  _MortgageTab_copy_vue_vue_type_template_id_6d7116b7___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ProjectComponents/Matters/Mortgage/MortgageTab copy.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ProjectComponents/Matters/Mortgage/MortgageTab copy.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************!*\
  !*** ./resources/js/components/ProjectComponents/Matters/Mortgage/MortgageTab copy.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MortgageTab_copy_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./MortgageTab copy.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ProjectComponents/Matters/Mortgage/MortgageTab copy.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MortgageTab_copy_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/ProjectComponents/Matters/Mortgage/MortgageTab copy.vue?vue&type=style&index=0&lang=css&":
/*!**************************************************************************************************************************!*\
  !*** ./resources/js/components/ProjectComponents/Matters/Mortgage/MortgageTab copy.vue?vue&type=style&index=0&lang=css& ***!
  \**************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_mini_css_extract_plugin_dist_loader_js_clonedRuleSet_10_0_rules_0_use_0_node_modules_css_loader_dist_cjs_js_clonedRuleSet_10_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_10_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_MortgageTab_copy_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/mini-css-extract-plugin/dist/loader.js??clonedRuleSet-10[0].rules[0].use[0]!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-10[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./MortgageTab copy.vue?vue&type=style&index=0&lang=css& */ "./node_modules/mini-css-extract-plugin/dist/loader.js??clonedRuleSet-10[0].rules[0].use[0]!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-10[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ProjectComponents/Matters/Mortgage/MortgageTab copy.vue?vue&type=style&index=0&lang=css&");


/***/ }),

/***/ "./resources/js/components/ProjectComponents/Matters/Mortgage/MortgageTab copy.vue?vue&type=template&id=6d7116b7&":
/*!************************************************************************************************************************!*\
  !*** ./resources/js/components/ProjectComponents/Matters/Mortgage/MortgageTab copy.vue?vue&type=template&id=6d7116b7& ***!
  \************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MortgageTab_copy_vue_vue_type_template_id_6d7116b7___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MortgageTab_copy_vue_vue_type_template_id_6d7116b7___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MortgageTab_copy_vue_vue_type_template_id_6d7116b7___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./MortgageTab copy.vue?vue&type=template&id=6d7116b7& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ProjectComponents/Matters/Mortgage/MortgageTab copy.vue?vue&type=template&id=6d7116b7&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ProjectComponents/Matters/Mortgage/MortgageTab copy.vue?vue&type=template&id=6d7116b7&":
/*!***************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ProjectComponents/Matters/Mortgage/MortgageTab copy.vue?vue&type=template&id=6d7116b7& ***!
  \***************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      staticClass: "tab-pane fade",
      class: { "show active": _vm.index == 0 },
      attrs: {
        id: "mortgage" + _vm.index,
        role: "tabpanel",
        "aria-labelledby": "mortgage-tab_" + _vm.index,
      },
    },
    [
      _c(
        "div",
        { staticClass: "form-horizontal" },
        [
          _c("div", { staticClass: "card-body" }, [
            _c("div", { staticClass: "form-row" }, [
              _c("div", { staticClass: "col-md-3" }, [
                _c("div", { staticClass: "form-group" }, [
                  _c(
                    "label",
                    {
                      staticClass: "in-label-title ",
                      attrs: { for: "instrument_no" },
                    },
                    [_vm._v("Instrument number")]
                  ),
                  _vm._v(" "),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.mortgage.instrument_no,
                        expression: "mortgage.instrument_no",
                      },
                    ],
                    staticClass: "form-control",
                    class: {
                      "is-invalid": _vm.form.errors.get(
                        "mortgages." + _vm.index + ".instrument_no"
                      ),
                    },
                    attrs: { type: "text" },
                    domProps: { value: _vm.mortgage.instrument_no },
                    on: {
                      input: function ($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(
                          _vm.mortgage,
                          "instrument_no",
                          $event.target.value
                        )
                      },
                    },
                  }),
                  _vm._v(" "),
                  _vm.form.errors.get(
                    "mortgages." + _vm.index + ".instrument_no"
                  )
                    ? _c(
                        "span",
                        {
                          staticClass: "invalid-feedback",
                          attrs: { id: "basic-msg" },
                        },
                        [
                          _vm._v(
                            _vm._s(
                              _vm.form.errors.get(
                                "mortgages." + _vm.index + ".instrument_no"
                              )
                            )
                          ),
                        ]
                      )
                    : _vm._e(),
                ]),
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-3" }, [
                _c(
                  "div",
                  {
                    staticClass: "form-group",
                    class: {
                      "is-invalid": _vm.form.errors.get(
                        "mortgages." + _vm.index + ".instrument_date"
                      ),
                    },
                  },
                  [
                    _c(
                      "label",
                      {
                        staticClass: "in-label-title ",
                        attrs: { for: "instrument_date" },
                      },
                      [_vm._v("Instrument Date")]
                    ),
                    _vm._v(" "),
                    _c("date-picker", {
                      attrs: { "class-name": "instrument_date" },
                      model: {
                        value: _vm.mortgage.instrument_date,
                        callback: function ($$v) {
                          _vm.$set(_vm.mortgage, "instrument_date", $$v)
                        },
                        expression: "mortgage.instrument_date",
                      },
                    }),
                    _vm._v(" "),
                    _vm.form.errors.get(
                      "mortgages." + _vm.index + ".instrument_date"
                    )
                      ? _c(
                          "span",
                          {
                            staticClass: "invalid-feedback",
                            attrs: { id: "basic-msg" },
                          },
                          [
                            _vm._v(
                              _vm._s(
                                _vm.form.errors.get(
                                  "mortgages." + _vm.index + ".instrument_date"
                                )
                              )
                            ),
                          ]
                        )
                      : _vm._e(),
                  ],
                  1
                ),
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-3" }, [
                _c("div", { staticClass: "form-group" }, [
                  _c(
                    "label",
                    {
                      staticClass: "in-label-title ",
                      attrs: { for: "instrument_type " },
                    },
                    [_vm._v("Instrument Type")]
                  ),
                  _vm._v(" "),
                  _c(
                    "select",
                    {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.mortgage.instrument_type,
                          expression: "mortgage.instrument_type ",
                        },
                      ],
                      staticClass: "form-control",
                      class: {
                        "is-invalid": _vm.form.errors.get(
                          "mortgages." + _vm.index + ".instrument_type"
                        ),
                      },
                      on: {
                        change: function ($event) {
                          var $$selectedVal = Array.prototype.filter
                            .call($event.target.options, function (o) {
                              return o.selected
                            })
                            .map(function (o) {
                              var val = "_value" in o ? o._value : o.value
                              return val
                            })
                          _vm.$set(
                            _vm.mortgage,
                            "instrument_type",
                            $event.target.multiple
                              ? $$selectedVal
                              : $$selectedVal[0]
                          )
                        },
                      },
                    },
                    [
                      _c("option", { attrs: { value: "Charge" } }, [
                        _vm._v("Charge"),
                      ]),
                      _vm._v(" "),
                      _c("option", { attrs: { value: "Bridge-Loan" } }, [
                        _vm._v("Bridge-Loan"),
                      ]),
                      _vm._v(" "),
                      _c("option", { attrs: { value: "Postponement" } }, [
                        _vm._v("Postponement"),
                      ]),
                      _vm._v(" "),
                      _c(
                        "option",
                        { attrs: { value: "Condo or construction Lien" } },
                        [_vm._v("Condo or construction Lien")]
                      ),
                      _vm._v(" "),
                      _c("option", { attrs: { value: "Notice" } }, [
                        _vm._v("Notice"),
                      ]),
                      _vm._v(" "),
                      _c("option", { attrs: { value: "Security Interest" } }, [
                        _vm._v("Security Interest"),
                      ]),
                      _vm._v(" "),
                      _c("option", { attrs: { value: "Other" } }, [
                        _vm._v("Other"),
                      ]),
                    ]
                  ),
                  _vm._v(" "),
                  _vm.form.errors.get(
                    "mortgages." + _vm.index + ".instrument_type"
                  )
                    ? _c(
                        "span",
                        {
                          staticClass: "invalid-feedback",
                          attrs: { id: "basic-msg" },
                        },
                        [
                          _vm._v(
                            _vm._s(
                              _vm.form.errors.get(
                                "mortgages." + _vm.index + ".instrument_type"
                              )
                            )
                          ),
                        ]
                      )
                    : _vm._e(),
                ]),
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-3" }, [
                _c("div", { staticClass: "form-group" }, [
                  _c(
                    "label",
                    {
                      staticClass: "in-label-title ",
                      attrs: { for: "obtaining_discharge " },
                    },
                    [_vm._v("Obtaining Discharge")]
                  ),
                  _vm._v(" "),
                  _c(
                    "select",
                    {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.mortgage.obtaining_discharge,
                          expression: "mortgage.obtaining_discharge",
                        },
                      ],
                      staticClass: "form-control",
                      class: {
                        "is-invalid": _vm.form.errors.get(
                          "mortgages." + _vm.index + ".obtaining_discharge"
                        ),
                      },
                      on: {
                        change: function ($event) {
                          var $$selectedVal = Array.prototype.filter
                            .call($event.target.options, function (o) {
                              return o.selected
                            })
                            .map(function (o) {
                              var val = "_value" in o ? o._value : o.value
                              return val
                            })
                          _vm.$set(
                            _vm.mortgage,
                            "obtaining_discharge",
                            $event.target.multiple
                              ? $$selectedVal
                              : $$selectedVal[0]
                          )
                        },
                      },
                    },
                    [
                      _c("option", { attrs: { value: "Y" } }, [_vm._v("Yes")]),
                      _vm._v(" "),
                      _c("option", { attrs: { value: "N" } }, [_vm._v("No")]),
                    ]
                  ),
                  _vm._v(" "),
                  _vm.form.errors.get(
                    "mortgages." + _vm.index + ".obtaining_discharge"
                  )
                    ? _c(
                        "span",
                        {
                          staticClass: "invalid-feedback",
                          attrs: { id: "basic-msg" },
                        },
                        [
                          _vm._v(
                            _vm._s(
                              _vm.form.errors.get(
                                "mortgages." +
                                  _vm.index +
                                  ".obtaining_discharge"
                              )
                            )
                          ),
                        ]
                      )
                    : _vm._e(),
                ]),
              ]),
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "form-row" }, [
              _c("div", { staticClass: "col-md-3" }, [
                _c("div", { staticClass: "form-group" }, [
                  _c(
                    "label",
                    {
                      staticClass: "in-label-title ",
                      attrs: { for: "mortgagee_reference_number" },
                    },
                    [_vm._v("Mortgage Reference Number")]
                  ),
                  _vm._v(" "),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.mortgage.mortgagee_reference_number,
                        expression: "mortgage.mortgagee_reference_number",
                      },
                    ],
                    staticClass: "form-control",
                    class: {
                      "is-invalid": _vm.form.errors.get(
                        "mortgages." + _vm.index + ".mortgagee_reference_number"
                      ),
                    },
                    attrs: { type: "text" },
                    domProps: {
                      value: _vm.mortgage.mortgagee_reference_number,
                    },
                    on: {
                      input: function ($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(
                          _vm.mortgage,
                          "mortgagee_reference_number",
                          $event.target.value
                        )
                      },
                    },
                  }),
                  _vm._v(" "),
                  _vm.form.errors.get(
                    "mortgages." + _vm.index + ".mortgagee_reference_number"
                  )
                    ? _c(
                        "span",
                        {
                          staticClass: "invalid-feedback",
                          attrs: { id: "basic-msg" },
                        },
                        [
                          _vm._v(
                            _vm._s(
                              _vm.form.errors.get(
                                "mortgages." +
                                  _vm.index +
                                  ".mortgagee_reference_number"
                              )
                            )
                          ),
                        ]
                      )
                    : _vm._e(),
                ]),
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-3" }, [
                _c("div", { staticClass: "form-group" }, [
                  _c(
                    "label",
                    {
                      staticClass: "in-label-title",
                      attrs: { for: "closing_date" },
                    },
                    [_vm._v("Closing Date")]
                  ),
                  _vm._v(" "),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.closing_date,
                        expression: "closing_date",
                      },
                    ],
                    staticClass: "form-control ",
                    attrs: { disabled: "", type: "text" },
                    domProps: { value: _vm.closing_date },
                    on: {
                      input: function ($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.closing_date = $event.target.value
                      },
                    },
                  }),
                ]),
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-3" }, [
                _c("div", { staticClass: "form-group" }, [
                  _c(
                    "label",
                    {
                      staticClass: "in-label-title ",
                      attrs: { for: "principal_amount" },
                    },
                    [_vm._v("Principal Amount ")]
                  ),
                  _vm._v(" "),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.mortgage.principal_amount,
                        expression: "mortgage.principal_amount",
                      },
                    ],
                    staticClass: "form-control",
                    class: {
                      "is-invalid": _vm.form.errors.get(
                        "mortgages." + _vm.index + ".principal_amount"
                      ),
                    },
                    attrs: { type: "text" },
                    domProps: { value: _vm.mortgage.principal_amount },
                    on: {
                      input: function ($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(
                          _vm.mortgage,
                          "principal_amount",
                          $event.target.value
                        )
                      },
                    },
                  }),
                  _vm._v(" "),
                  _vm.form.errors.get(
                    "mortgages." + _vm.index + ".principal_amount"
                  )
                    ? _c(
                        "span",
                        {
                          staticClass: "invalid-feedback",
                          attrs: { id: "basic-msg" },
                        },
                        [
                          _vm._v(
                            _vm._s(
                              _vm.form.errors.get(
                                "mortgages." + _vm.index + ".principal_amount"
                              )
                            )
                          ),
                        ]
                      )
                    : _vm._e(),
                ]),
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-3" }, [
                _c("div", { staticClass: "form-group" }, [
                  _c(
                    "label",
                    {
                      staticClass: "in-label-title ml-5 mt-4",
                      attrs: { for: "principal_amount" },
                    },
                    [
                      _vm._v(
                        " $" + _vm._s(_vm.mortgage.principal_amount) + ".00 "
                      ),
                    ]
                  ),
                ]),
              ]),
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "form-row" }, [
              _c("div", { staticClass: "col-md-3" }, [
                _c("div", { staticClass: "form-group" }, [
                  _c(
                    "label",
                    {
                      staticClass: "in-label-title ",
                      attrs: { for: "per_diem" },
                    },
                    [_vm._v("Per Diem")]
                  ),
                  _vm._v(" "),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.mortgage.per_diem,
                        expression: "mortgage.per_diem",
                      },
                    ],
                    staticClass: "form-control",
                    class: {
                      "is-invalid": _vm.form.errors.get(
                        "mortgages." + _vm.index + ".per_diem"
                      ),
                    },
                    attrs: { type: "text" },
                    domProps: { value: _vm.mortgage.per_diem },
                    on: {
                      input: function ($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(_vm.mortgage, "per_diem", $event.target.value)
                      },
                    },
                  }),
                  _vm._v(" "),
                  _vm.form.errors.get("mortgages." + _vm.index + ".per_diem")
                    ? _c(
                        "span",
                        {
                          staticClass: "invalid-feedback",
                          attrs: { id: "basic-msg" },
                        },
                        [
                          _vm._v(
                            _vm._s(
                              _vm.form.errors.get(
                                "mortgages." + _vm.index + ".per_diem"
                              )
                            )
                          ),
                        ]
                      )
                    : _vm._e(),
                ]),
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-3" }, [
                _c(
                  "div",
                  {
                    staticClass: "form-group",
                    class: {
                      "is-invalid": _vm.form.errors.get(
                        "mortgages." + _vm.index + ".discharged_on"
                      ),
                    },
                  },
                  [
                    _c(
                      "label",
                      {
                        staticClass: "in-label-title ",
                        attrs: { for: "discharged_on" },
                      },
                      [_vm._v("Discharged On")]
                    ),
                    _vm._v(" "),
                    _c("date-picker", {
                      attrs: { "class-name": "discharged_on" },
                      model: {
                        value: _vm.mortgage.discharged_on,
                        callback: function ($$v) {
                          _vm.$set(_vm.mortgage, "discharged_on", $$v)
                        },
                        expression: "mortgage.discharged_on",
                      },
                    }),
                    _vm._v(" "),
                    _vm.form.errors.get(
                      "mortgages." + _vm.index + ".discharged_on"
                    )
                      ? _c(
                          "span",
                          {
                            staticClass: "invalid-feedback",
                            attrs: { id: "basic-msg" },
                          },
                          [
                            _vm._v(
                              _vm._s(
                                _vm.form.errors.get(
                                  "mortgages." + _vm.index + ".discharged_on"
                                )
                              )
                            ),
                          ]
                        )
                      : _vm._e(),
                  ],
                  1
                ),
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-3" }, [
                _c("div", { staticClass: "form-group" }, [
                  _c(
                    "label",
                    {
                      staticClass: "in-label-title mt-4",
                      attrs: { for: "discharged_on" },
                    },
                    [_vm._v("Days :" + _vm._s(_vm.extra_days))]
                  ),
                ]),
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-3" }, [
                _c("div", { staticClass: "form-group" }, [
                  _c(
                    "label",
                    {
                      staticClass: "in-label-title ",
                      attrs: { for: "extra_interest" },
                    },
                    [_vm._v("Extra Charge")]
                  ),
                  _vm._v(" "),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.extra_interest,
                        expression: "extra_interest",
                      },
                    ],
                    staticClass: "form-control",
                    class: {
                      "is-invalid": _vm.form.errors.get(
                        "mortgages." + _vm.index + ".extra_interest"
                      ),
                    },
                    attrs: { disabled: "", type: "text" },
                    domProps: { value: _vm.extra_interest },
                    on: {
                      input: function ($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.extra_interest = $event.target.value
                      },
                    },
                  }),
                  _vm._v(" "),
                  _vm.form.errors.get(
                    "mortgages." + _vm.index + ".extra_interest"
                  )
                    ? _c(
                        "span",
                        {
                          staticClass: "invalid-feedback",
                          attrs: { id: "basic-msg" },
                        },
                        [
                          _vm._v(
                            _vm._s(
                              _vm.form.errors.get(
                                "mortgages." + _vm.index + ".extra_interest"
                              )
                            )
                          ),
                        ]
                      )
                    : _vm._e(),
                ]),
              ]),
            ]),
            _vm._v(" "),
            _c(
              "fieldset",
              { staticClass: "fieldset" },
              [
                _c("legend", [_vm._v(" Additional Charges")]),
                _vm._v(" "),
                _vm._l(
                  _vm.mortgage.additional_charges,
                  function (charge, index) {
                    return _c("mortgage-charge", {
                      key: charge.random,
                      attrs: { index: index, charge: charge, form: _vm.form },
                      on: { removeCharges: _vm.removeCharges },
                    })
                  }
                ),
                _vm._v(" "),
                _c(
                  "button",
                  {
                    staticClass: "btn btn-primary",
                    on: {
                      click: function ($event) {
                        $event.preventDefault()
                        return _vm.addCharges()
                      },
                    },
                  },
                  [_vm._v("Add")]
                ),
              ],
              2
            ),
            _vm._v(" "),
            _c("div", { staticClass: "form-row" }, [
              _c("div", { staticClass: "col-md-3 offset-9" }, [
                _c("div", { staticClass: "form-group" }, [
                  _c(
                    "label",
                    { staticClass: "in-label-title ", attrs: { for: "total" } },
                    [_vm._v("Total")]
                  ),
                  _vm._v(" "),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.total_charge,
                        expression: "total_charge",
                      },
                    ],
                    staticClass: "form-control",
                    class: {
                      "is-invalid": _vm.form.errors.get(
                        "mortgages." + _vm.index + ".total"
                      ),
                    },
                    attrs: { type: "text", disabled: "" },
                    domProps: { value: _vm.total_charge },
                    on: {
                      input: function ($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.total_charge = $event.target.value
                      },
                    },
                  }),
                  _vm._v(" "),
                  _vm.form.errors.get("mortgages." + _vm.index + ".total")
                    ? _c(
                        "span",
                        {
                          staticClass: "invalid-feedback",
                          attrs: { id: "basic-msg" },
                        },
                        [
                          _vm._v(
                            _vm._s(
                              _vm.form.errors.get(
                                "mortgages." + _vm.index + ".total"
                              )
                            )
                          ),
                        ]
                      )
                    : _vm._e(),
                ]),
              ]),
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "form-row" }, [
              _c("div", { staticClass: "col-md-3" }, [
                _c("div", { staticClass: "form-group" }, [
                  _c(
                    "label",
                    {
                      staticClass: "in-label-title ",
                      attrs: { for: "contact_id" },
                    },
                    [_vm._v("Contact")]
                  ),
                  _vm._v(" "),
                  _c(
                    "select",
                    {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.mortgage.contact,
                          expression: "mortgage.contact",
                        },
                      ],
                      staticClass: "form-control",
                      class: {
                        "is-invalid": _vm.form.errors.get(
                          "mortgages." + _vm.index + ".contact_id"
                        ),
                      },
                      on: {
                        change: [
                          function ($event) {
                            var $$selectedVal = Array.prototype.filter
                              .call($event.target.options, function (o) {
                                return o.selected
                              })
                              .map(function (o) {
                                var val = "_value" in o ? o._value : o.value
                                return val
                              })
                            _vm.$set(
                              _vm.mortgage,
                              "contact",
                              $event.target.multiple
                                ? $$selectedVal
                                : $$selectedVal[0]
                            )
                          },
                          _vm.getContactAddress,
                        ],
                      },
                    },
                    [
                      _c("option", { attrs: { value: "solicitor" } }, [
                        _vm._v("Solicitor"),
                      ]),
                      _vm._v(" "),
                      _c("option", { attrs: { value: "mortgagee" } }, [
                        _vm._v("Mortgagee"),
                      ]),
                    ]
                  ),
                  _vm._v(" "),
                  _vm.form.errors.get("mortgages." + _vm.index + ".contact_id")
                    ? _c(
                        "span",
                        {
                          staticClass: "invalid-feedback",
                          attrs: { id: "basic-msg" },
                        },
                        [
                          _vm._v(
                            _vm._s(
                              _vm.form.errors.get(
                                "mortgages." + _vm.index + ".contact_id"
                              )
                            )
                          ),
                        ]
                      )
                    : _vm._e(),
                ]),
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-3" }, [
                _c(
                  "div",
                  {
                    staticClass: "form-group",
                    class: {
                      "is-invalid": _vm.form.errors.get(
                        "mortgages." + _vm.index + ".mortgagee_id"
                      ),
                    },
                  },
                  [
                    _c(
                      "label",
                      {
                        staticClass: "in-label-title ",
                        attrs: { for: "mortgagee_id" },
                      },
                      [_vm._v("Mortgagee")]
                    ),
                    _vm._v(" "),
                    _vm.show
                      ? _c("contact-select", {
                          attrs: {
                            initials: _vm.initialContact,
                            selected: _vm.selectedContact,
                            type: "mortgagee",
                            index: _vm.form.random,
                          },
                          on: { updateContact: _vm.getContactAddress },
                          model: {
                            value: _vm.mortgage.mortgagee_id,
                            callback: function ($$v) {
                              _vm.$set(_vm.mortgage, "mortgagee_id", $$v)
                            },
                            expression: "mortgage.mortgagee_id",
                          },
                        })
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.form.errors.get(
                      "mortgages." + _vm.index + ".mortgagee_id"
                    )
                      ? _c(
                          "span",
                          {
                            staticClass: "invalid-feedback",
                            attrs: { id: "basic-msg" },
                          },
                          [
                            _vm._v(
                              _vm._s(
                                _vm.form.errors.get(
                                  "mortgages." + _vm.index + ".mortgagee_id"
                                )
                              )
                            ),
                          ]
                        )
                      : _vm._e(),
                  ],
                  1
                ),
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-3" }, [
                _c(
                  "div",
                  {
                    staticClass: "form-group",
                    class: {
                      "is-invalid": _vm.form.errors.get(
                        "mortgages." + _vm.index + ".solicitor_id"
                      ),
                    },
                  },
                  [
                    _c(
                      "label",
                      {
                        staticClass: "in-label-title ",
                        attrs: { for: "solicitor_id" },
                      },
                      [_vm._v("Solicitor")]
                    ),
                    _vm._v(" "),
                    _vm.show
                      ? _c("solicitor-select", {
                          attrs: {
                            initials: _vm.initialSolicitor,
                            selected: _vm.selectedSolicitor,
                            type: "solicitor",
                            index: _vm.mortgage.random,
                          },
                          on: { updateSolicitor: _vm.getContactAddress },
                          model: {
                            value: _vm.mortgage.solicitor_id,
                            callback: function ($$v) {
                              _vm.$set(_vm.mortgage, "solicitor_id", $$v)
                            },
                            expression: "mortgage.solicitor_id",
                          },
                        })
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.form.errors.get(
                      "mortgages." + _vm.index + ".solicitor_id"
                    )
                      ? _c(
                          "span",
                          {
                            staticClass: "invalid-feedback",
                            attrs: { id: "basic-msg" },
                          },
                          [
                            _vm._v(
                              _vm._s(
                                _vm.form.errors.get(
                                  "mortgages." + _vm.index + ".solicitor_id"
                                )
                              )
                            ),
                          ]
                        )
                      : _vm._e(),
                  ],
                  1
                ),
              ]),
            ]),
            _vm._v(" "),
            _c("fieldset", { staticClass: "fieldset" }, [
              _c("legend", [_vm._v(" Address")]),
              _vm._v(" "),
              _c("div", { staticClass: "form-row" }, [
                _c("div", { staticClass: "col" }, [
                  _c(
                    "div",
                    {
                      staticClass: "form-group",
                      class: {
                        "is-invalid": _vm.form.errors.get(
                          "mortgages." + _vm.index + ".address.number"
                        ),
                      },
                    },
                    [
                      _c(
                        "label",
                        {
                          staticClass: "in-label-title ",
                          attrs: { for: "number" },
                        },
                        [_vm._v("Number")]
                      ),
                      _vm._v(" "),
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.mortgage.address.number,
                            expression: "mortgage.address.number",
                          },
                        ],
                        staticClass: "form-control",
                        attrs: { type: "text" },
                        domProps: { value: _vm.mortgage.address.number },
                        on: {
                          input: function ($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(
                              _vm.mortgage.address,
                              "number",
                              $event.target.value
                            )
                          },
                        },
                      }),
                      _vm._v(" "),
                      _vm.form.errors.get("mortgage.address.number")
                        ? _c(
                            "span",
                            {
                              staticClass: "invalid-feedback",
                              attrs: { id: "basic-msg" },
                            },
                            [
                              _vm._v(
                                _vm._s(
                                  _vm.form.errors.get("mortgage.address.number")
                                )
                              ),
                            ]
                          )
                        : _vm._e(),
                    ]
                  ),
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col" }, [
                  _c(
                    "div",
                    {
                      staticClass: "form-group",
                      class: {
                        "is-invalid": _vm.form.errors.get(
                          "mortgages." + _vm.index + ".address.street"
                        ),
                      },
                    },
                    [
                      _c(
                        "label",
                        {
                          staticClass: "in-label-title ",
                          attrs: { for: "street" },
                        },
                        [_vm._v("Street")]
                      ),
                      _vm._v(" "),
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.mortgage.address.street,
                            expression: "mortgage.address.street",
                          },
                        ],
                        staticClass: "form-control",
                        attrs: { type: "text" },
                        domProps: { value: _vm.mortgage.address.street },
                        on: {
                          input: function ($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(
                              _vm.mortgage.address,
                              "street",
                              $event.target.value
                            )
                          },
                        },
                      }),
                      _vm._v(" "),
                      _vm.form.errors.get(
                        "mortgages." + _vm.index + ".address.street"
                      )
                        ? _c(
                            "span",
                            {
                              staticClass: "invalid-feedback",
                              attrs: { id: "basic-msg" },
                            },
                            [
                              _vm._v(
                                _vm._s(
                                  _vm.form.errors.get(
                                    "mortgages." + _vm.index + ".address.street"
                                  )
                                )
                              ),
                            ]
                          )
                        : _vm._e(),
                    ]
                  ),
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col" }, [
                  _c(
                    "div",
                    {
                      staticClass: "form-group",
                      class: {
                        "is-invalid": _vm.form.errors.get(
                          "mortgages." + _vm.index + ".address.city_id"
                        ),
                      },
                    },
                    [
                      _c(
                        "label",
                        {
                          staticClass: "in-label-title ",
                          attrs: { for: "city_id" },
                        },
                        [_vm._v("City")]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "input-group flex-nowrap mb-3" },
                        [
                          _c(
                            "div",
                            { staticClass: "w-100" },
                            [
                              _vm.city
                                ? _c("city-select", {
                                    class: {
                                      "is-invalid":
                                        _vm.form.errors.get("city_id"),
                                    },
                                    attrs: {
                                      index:
                                        _vm.random + "_" + _vm.index + "_1",
                                      initials: _vm.initialCity,
                                      selected: _vm.selectedCity,
                                      type: "text",
                                    },
                                    on: { updateCity: _vm.updateCity },
                                    model: {
                                      value: _vm.mortgage.address.city_id,
                                      callback: function ($$v) {
                                        _vm.$set(
                                          _vm.mortgage.address,
                                          "city_id",
                                          $$v
                                        )
                                      },
                                      expression: "mortgage.address.city_id",
                                    },
                                  })
                                : _vm._e(),
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _c("div", { staticClass: "input-group-append" }, [
                            _c(
                              "button",
                              {
                                staticClass: "btn iw-add-new-btn",
                                on: {
                                  click: function ($event) {
                                    $event.preventDefault()
                                    return _vm.addCity()
                                  },
                                },
                              },
                              [_c("span", { staticClass: "mdi mdi-plus" })]
                            ),
                          ]),
                        ]
                      ),
                      _vm._v(" "),
                      _vm.form.errors.get(
                        "mortgages." + _vm.index + ".address.city_id"
                      )
                        ? _c(
                            "span",
                            {
                              staticClass: "invalid-feedback",
                              attrs: { id: "basic-msg" },
                            },
                            [
                              _vm._v(
                                _vm._s(
                                  _vm.form.errors.get(
                                    "mortgages." +
                                      _vm.index +
                                      ".address.city_id"
                                  )
                                )
                              ),
                            ]
                          )
                        : _vm._e(),
                    ]
                  ),
                ]),
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "form-row" }, [
                _c("div", { staticClass: "col" }, [
                  _c("div", { staticClass: "form-group" }, [
                    _c(
                      "label",
                      {
                        staticClass: "in-label-title ",
                        attrs: { for: "province" },
                      },
                      [_vm._v("Province")]
                    ),
                    _vm._v(" "),
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.mortgage.address.province,
                          expression: "mortgage.address.province",
                        },
                      ],
                      staticClass: "form-control",
                      class: {
                        "is-invalid": _vm.form.errors.get(
                          "mortgages." + _vm.index + ".address.province"
                        ),
                      },
                      attrs: { disabled: "", type: "text" },
                      domProps: { value: _vm.mortgage.address.province },
                      on: {
                        input: function ($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(
                            _vm.mortgage.address,
                            "province",
                            $event.target.value
                          )
                        },
                      },
                    }),
                    _vm._v(" "),
                    _vm.form.errors.get(
                      "mortgages." + _vm.index + ".address.province"
                    )
                      ? _c(
                          "span",
                          {
                            staticClass: "invalid-feedback",
                            attrs: { id: "basic-msg" },
                          },
                          [
                            _vm._v(
                              _vm._s(
                                _vm.form.errors.get(
                                  "mortgages." + _vm.index + ".address.province"
                                )
                              )
                            ),
                          ]
                        )
                      : _vm._e(),
                  ]),
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col" }, [
                  _c("div", { staticClass: "form-group" }, [
                    _c(
                      "label",
                      {
                        staticClass: "in-label-title ",
                        attrs: { for: "country" },
                      },
                      [_vm._v("Country")]
                    ),
                    _vm._v(" "),
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.mortgage.address.country,
                          expression: "mortgage.address.country",
                        },
                      ],
                      staticClass: "form-control",
                      class: {
                        "is-invalid": _vm.form.errors.get(
                          "mortgages." + _vm.index + ".address.country"
                        ),
                      },
                      attrs: { disabled: "", type: "text" },
                      domProps: { value: _vm.mortgage.address.country },
                      on: {
                        input: function ($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(
                            _vm.mortgage.address,
                            "country",
                            $event.target.value
                          )
                        },
                      },
                    }),
                    _vm._v(" "),
                    _vm.form.errors.get(
                      "mortgages." + _vm.index + ".address.country"
                    )
                      ? _c(
                          "span",
                          {
                            staticClass: "invalid-feedback",
                            attrs: { id: "basic-msg" },
                          },
                          [
                            _vm._v(
                              _vm._s(
                                _vm.form.errors.get(
                                  "mortgages." + _vm.index + ".address.country"
                                )
                              )
                            ),
                          ]
                        )
                      : _vm._e(),
                  ]),
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col" }, [
                  _c("div", { staticClass: "form-group" }, [
                    _c(
                      "label",
                      {
                        staticClass: "in-label-title ",
                        attrs: { for: "postal_code" },
                      },
                      [_vm._v("Postal Code")]
                    ),
                    _vm._v(" "),
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.mortgage.address.postal_code,
                          expression: "mortgage.address.postal_code",
                        },
                      ],
                      staticClass: "form-control",
                      class: {
                        "is-invalid": _vm.form.errors.get(
                          "mortgages." + _vm.index + ".address.postal_code"
                        ),
                      },
                      attrs: { type: "text" },
                      domProps: { value: _vm.mortgage.address.postal_code },
                      on: {
                        input: [
                          function ($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(
                              _vm.mortgage.address,
                              "postal_code",
                              $event.target.value
                            )
                          },
                          function ($event) {
                            return _vm.postalCode("postal_code")
                          },
                        ],
                      },
                    }),
                    _vm._v(" "),
                    _vm.form.errors.get(
                      "mortgages." + _vm.index + ".address.postal_code"
                    )
                      ? _c(
                          "span",
                          {
                            staticClass: "invalid-feedback",
                            attrs: { id: "basic-msg" },
                          },
                          [
                            _vm._v(
                              _vm._s(
                                _vm.form.errors.get(
                                  "mortgages." +
                                    _vm.index +
                                    ".address.postal_code"
                                )
                              )
                            ),
                          ]
                        )
                      : _vm._e(),
                  ]),
                ]),
              ]),
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "form-row" }, [
              _c("div", { staticClass: "col-md-3" }, [
                _c("div", { staticClass: "form-group" }, [
                  _c(
                    "label",
                    { staticClass: "in-label-title ", attrs: { for: "phone" } },
                    [_vm._v("Phone Number")]
                  ),
                  _vm._v(" "),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.mortgage.phone,
                        expression: "mortgage.phone",
                      },
                    ],
                    staticClass: "form-control",
                    class: {
                      "is-invalid": _vm.form.errors.get(
                        "mortgages." + _vm.index + ".phone"
                      ),
                    },
                    attrs: { type: "text" },
                    domProps: { value: _vm.mortgage.phone },
                    on: {
                      input: [
                        function ($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(_vm.mortgage, "phone", $event.target.value)
                        },
                        function ($event) {
                          return _vm.acceptNumber("phone")
                        },
                      ],
                    },
                  }),
                  _vm._v(" "),
                  _vm.form.errors.get("mortgages." + _vm.index + ".phone")
                    ? _c(
                        "span",
                        {
                          staticClass: "invalid-feedback",
                          attrs: { id: "basic-msg" },
                        },
                        [
                          _vm._v(
                            _vm._s(
                              _vm.form.errors.get(
                                "mortgages." + _vm.index + ".phone"
                              )
                            )
                          ),
                        ]
                      )
                    : _vm._e(),
                ]),
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-3" }, [
                _c("div", { staticClass: "form-group" }, [
                  _c(
                    "label",
                    { staticClass: "in-label-title ", attrs: { for: "fax" } },
                    [_vm._v("Fax ")]
                  ),
                  _vm._v(" "),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.mortgage.fax,
                        expression: "mortgage.fax",
                      },
                    ],
                    staticClass: "form-control",
                    class: {
                      "is-invalid": _vm.form.errors.get(
                        "mortgages." + _vm.index + ".address.fax"
                      ),
                    },
                    attrs: { type: "text" },
                    domProps: { value: _vm.mortgage.fax },
                    on: {
                      input: [
                        function ($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(_vm.mortgage, "fax", $event.target.value)
                        },
                        function ($event) {
                          return _vm.acceptNumber("fax")
                        },
                      ],
                    },
                  }),
                  _vm._v(" "),
                  _vm.form.errors.get("mortgages." + _vm.index + ".address.fax")
                    ? _c(
                        "span",
                        {
                          staticClass: "invalid-feedback",
                          attrs: { id: "basic-msg" },
                        },
                        [
                          _vm._v(
                            _vm._s(
                              _vm.form.errors.get(
                                "mortgages." + _vm.index + ".address.fax"
                              )
                            )
                          ),
                        ]
                      )
                    : _vm._e(),
                ]),
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-3" }, [
                _c("div", { staticClass: "form-group" }, [
                  _c(
                    "label",
                    { staticClass: "in-label-title ", attrs: { for: "email" } },
                    [_vm._v("Email")]
                  ),
                  _vm._v(" "),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.mortgage.email,
                        expression: "mortgage.email",
                      },
                    ],
                    staticClass: "form-control",
                    class: {
                      "is-invalid": _vm.form.errors.get(
                        "mortgages." + _vm.index + ".email"
                      ),
                    },
                    attrs: { type: "text" },
                    domProps: { value: _vm.mortgage.email },
                    on: {
                      input: function ($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(_vm.mortgage, "email", $event.target.value)
                      },
                    },
                  }),
                  _vm._v(" "),
                  _vm.form.errors.get("mortgages." + _vm.index + ".email")
                    ? _c(
                        "span",
                        {
                          staticClass: "invalid-feedback",
                          attrs: { id: "basic-msg" },
                        },
                        [
                          _vm._v(
                            _vm._s(
                              _vm.form.errors.get(
                                "mortgages." + _vm.index + ".email"
                              )
                            )
                          ),
                        ]
                      )
                    : _vm._e(),
                ]),
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-3" }, [
                _c("div", { staticClass: "form-group" }, [
                  _c(
                    "label",
                    {
                      staticClass: "in-label-title ",
                      attrs: { for: "attention" },
                    },
                    [_vm._v("Attention")]
                  ),
                  _vm._v(" "),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.mortgage.attention,
                        expression: "mortgage.attention",
                      },
                    ],
                    staticClass: "form-control",
                    class: {
                      "is-invalid": _vm.form.errors.get(
                        "mortgages." + _vm.index + ".attention"
                      ),
                    },
                    attrs: { type: "text" },
                    domProps: { value: _vm.mortgage.attention },
                    on: {
                      input: function ($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(_vm.mortgage, "attention", $event.target.value)
                      },
                    },
                  }),
                  _vm._v(" "),
                  _vm.form.errors.get("mortgages." + _vm.index + ".attention")
                    ? _c(
                        "span",
                        {
                          staticClass: "invalid-feedback",
                          attrs: { id: "basic-msg" },
                        },
                        [
                          _vm._v(
                            _vm._s(
                              _vm.form.errors.get(
                                "mortgages." + _vm.index + ".attention"
                              )
                            )
                          ),
                        ]
                      )
                    : _vm._e(),
                ]),
              ]),
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "form-row" }, [
              _c("div", { staticClass: "col-md-3" }, [
                _c("div", { staticClass: "form-group" }, [
                  _c(
                    "label",
                    {
                      staticClass: "in-label-title ",
                      attrs: { for: "discharge_no" },
                    },
                    [_vm._v("Discharge Number")]
                  ),
                  _vm._v(" "),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.mortgage.discharge_no,
                        expression: "mortgage.discharge_no",
                      },
                    ],
                    staticClass: "form-control",
                    class: {
                      "is-invalid": _vm.form.errors.get(
                        "mortgages." + _vm.index + ".discharge_no"
                      ),
                    },
                    attrs: { type: "text" },
                    domProps: { value: _vm.mortgage.discharge_no },
                    on: {
                      input: function ($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(
                          _vm.mortgage,
                          "discharge_no",
                          $event.target.value
                        )
                      },
                    },
                  }),
                  _vm._v(" "),
                  _vm.form.errors.get(
                    "mortgages." + _vm.index + ".discharge_no"
                  )
                    ? _c(
                        "span",
                        {
                          staticClass: "invalid-feedback",
                          attrs: { id: "basic-msg" },
                        },
                        [
                          _vm._v(
                            _vm._s(
                              _vm.form.errors.get(
                                "mortgages." + _vm.index + ".discharge_no"
                              )
                            )
                          ),
                        ]
                      )
                    : _vm._e(),
                ]),
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-3" }, [
                _c(
                  "div",
                  {
                    staticClass: "form-group",
                    class: {
                      "is-invalid": _vm.form.errors.get(
                        "mortgages." + _vm.index + ".discharge_date"
                      ),
                    },
                  },
                  [
                    _c(
                      "label",
                      {
                        staticClass: "in-label-title ",
                        attrs: { for: "discharge_date" },
                      },
                      [_vm._v("Discharge Date ")]
                    ),
                    _vm._v(" "),
                    _c("date-picker", {
                      attrs: {
                        "class-name": "discharge_date",
                        yearsRange: "-100:+100",
                      },
                      model: {
                        value: _vm.mortgage.discharge_date,
                        callback: function ($$v) {
                          _vm.$set(_vm.mortgage, "discharge_date", $$v)
                        },
                        expression: "mortgage.discharge_date",
                      },
                    }),
                    _vm._v(" "),
                    _vm.form.errors.get(
                      "mortgages." + _vm.index + ".discharge_date"
                    )
                      ? _c(
                          "span",
                          {
                            staticClass: "invalid-feedback",
                            attrs: { id: "basic-msg" },
                          },
                          [
                            _vm._v(
                              _vm._s(
                                _vm.form.errors.get(
                                  "mortgages." + _vm.index + ".discharge_date"
                                )
                              )
                            ),
                          ]
                        )
                      : _vm._e(),
                  ],
                  1
                ),
              ]),
            ]),
          ]),
          _vm._v(" "),
          _vm.showCity
            ? _c("city-form", { on: { closeTriggered: _vm.closeCityModal } })
            : _vm._e(),
        ],
        1
      ),
    ]
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);