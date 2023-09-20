"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ProjectComponents_Matters_Accounts_AccountStatementTab_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ProjectComponents/Matters/Accounts/AccountStatementTab.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ProjectComponents/Matters/Accounts/AccountStatementTab.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
function getTransactionForm() {
  return new Form({
    id: 0,
    edit_index: -1,
    additional_credit_to: '',
    additional_credit_type: '',
    additional_credit_amount: '',
    total_amount: '',
    from_date: '',
    to_date: '',
    remarks: ''
  });
}

function getNewTransaction() {
  return {
    id: 0,
    additional_credit_to: '',
    additional_credit_type: '',
    additional_credit_amount: '',
    total_amount: '',
    from_date: '',
    to_date: '',
    remarks: '',
    random: Utilities.getRandomNumber()
  };
}

function getNewForm() {
  return new Form({
    file_opening_id: 0,
    date: '',
    account_statement: {
      id: 0,
      file_opening_id: '',
      sale_price: '',
      deposit: '',
      property_tax: '',
      total_taxes: '',
      taxes_paid: '',
      seller_share: '',
      total: '',
      remarks: '',
      balance_due: '',
      seller_credit: '0.00'
    },
    account_statement_transactions: []
  });
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['file_opening_id', 'form'],
  data: function data() {
    return {
      create_url: 'account-statements',
      base_url: Munshi.base_url,
      credit_types: [],
      additional_form: getTransactionForm(),
      initialCreditType: [],
      selectedCreditType: [],
      show: true
    };
  },
  computed: {
    seller_share: function seller_share() {
      var share = this.form.account_statement.property_tax == 'previous' ? this.form.account_statement.total_taxes : 0;

      if (this.form.account_statement.total_taxes != '' && this.one_day_share > 0 && this.form.account_statement.property_tax != 'previous') {
        var share = Utilities.round(this.one_day_share * this.taxes_days);
      }

      this.form.account_statement.seller_share = share;
      return share;
    },
    total_amount: function total_amount() {
      var amt = Utilities.round(Utilities.round(this.form.account_statement.sale_price) - Utilities.round(this.form.account_statement.deposit));
      return Utilities.round(amt - this.tax_to_be_paid);
    },
    tax_to_be_paid: function tax_to_be_paid() {
      if (Utilities.round(this.form.account_statement.seller_share) == 0) {
        return 0;
      }

      return Utilities.round(Utilities.round(this.form.account_statement.seller_share) - Utilities.round(this.form.account_statement.taxes_paid));
    },
    purchaser_credit: function purchaser_credit() {
      if (this.form.account_statement.seller_share - this.form.account_statement.taxes_paid > 0) {
        return Utilities.round(this.form.account_statement.seller_share - this.form.account_statement.taxes_paid);
      }

      return 0; // if(this.total_amount < 0){
      //     return -this.total_amount;
      // }
      // return 0;
    },
    seller_credit: function seller_credit() {
      if (this.form.account_statement.seller_share - this.form.account_statement.taxes_paid < 0) {
        return -Utilities.round(this.form.account_statement.seller_share - this.form.account_statement.taxes_paid);
      }

      return 0; //   if(this.total_amount > 0){
      //     return this.total_amount;
      // }
      // return 0;
    },
    taxes_days: function taxes_days() {
      var days = 0;

      if (this.form.date) {
        // var today = moment(new Date());
        var first_day = moment(new Date().setFullYear(new Date().getFullYear(), 0, 1));
        var closing_date = moment(new Date(this.form.date));
        days = closing_date.diff(first_day, 'days'); // =1
      }

      return days;
    },
    one_day_share: function one_day_share() {
      var one_day_share = 0;

      if (this.form.account_statement.total_taxes != '') {
        one_day_share = Utilities.round(Utilities.round(this.form.account_statement.total_taxes) / 365);
      }

      return one_day_share;
    },
    purchaser_total: function purchaser_total() {
      var self = this;
      var total = Utilities.round(Utilities.round(this.purchaser_credit) + Utilities.round(this.form.account_statement.deposit));
      this.form.account_statement_transactions.forEach(function (element) {
        if (element.additional_credit_to == 'purchaser') {
          total += Utilities.round(element.additional_credit_amount);
        }
      });
      return Utilities.round(total);
    },
    seller_total: function seller_total() {
      var self = this;
      var total = Utilities.round(Utilities.round(this.seller_credit) + Utilities.round(this.form.account_statement.sale_price));
      console.log("now total is " + total);
      this.form.account_statement_transactions.forEach(function (element) {
        if (element.additional_credit_to == 'seller') {
          total += Utilities.round(element.additional_credit_amount);
        }
      });
      return Utilities.round(total);
    },
    balance_due: function balance_due() {
      var bal = this.purchaser_total - this.seller_total;
      this.form.account_statement.balance_due = bal;
      return Utilities.round(bal);
    },
    balance_payable: function balance_payable() {
      return Math.abs(this.balance_due);
    }
  },
  mounted: function mounted() {
    this.show = true;
    this.form.file_opening_id = this.file_opening_id;
    this.form.account_statement.file_opening_id = this.file_opening_id;
    this.getAccountStatement();
  },
  methods: {
    getAccountStatement: function getAccountStatement() {
      var self = this;
      axios.get(this.base_url + '/file-page/' + this.file_opening_id).then(function (response) {
        if (response.data.success) {
          // self.form = getNewForm();
          var account_statement = response.data.file_opening.account_statement;
          console.log(account_statement);
          self.credit_types = response.data.credit_types;
          var account_statement_transactions = response.data.file_opening.account_statement_transactions;
          var file_opening = response.data.file_opening;
          self.form.date = file_opening.closing_date;
          self.form.file_opening_id = self.file_opening_id;

          if (account_statement) {
            self.form.account_statement = account_statement;
            self.form.account_statement.file_opening_id = self.file_opening_id;
          }

          account_statement_transactions.forEach(function (element) {
            var account_statement_transaction = getNewTransaction();
            Utilities.copyProperties(element, account_statement_transaction);
            self.form.account_statement_transactions.push(account_statement_transaction);
          });
        }
      })["catch"](function (error) {
        console.log(error.response);
      });
    },
    calculateCreditAmount: function calculateCreditAmount() {
      var self = this;
      var from_date = moment(this.additional_form.from_date, 'MM-DD-YYYY');
      var to_date = moment(this.additional_form.to_date, 'MM-DD-YYYY');
      var closing_date = moment(this.form.date, 'MM-DD-YYYY');
      var amount_days = to_date.diff(from_date, 'days');
      var per_day_amount = Utilities.round(this.additional_form.total_amount / amount_days);
      var before_closing_days = closing_date.diff(from_date, 'days');
      var after_closing_days = to_date.diff(closing_date, 'days');

      if (closing_date.isBefore(from_date) || closing_date.isAfter(to_date)) {
        self.additional_form.additional_credit_amount = this.additional_form.total_amount;
        return;
      }

      if (self.additional_form.additional_credit_to == 'purchaser') {
        self.additional_form.additional_credit_amount = Utilities.round(after_closing_days * per_day_amount);
      } else if (self.additional_form.additional_credit_to == 'seller') {
        self.additional_form.additional_credit_amount = Utilities.round(before_closing_days * per_day_amount);
      }
    },
    submitForm: function submitForm() {
      var self = this;
      Utilities.showConfirmationPopMessage('Do you want to save the changes?', function (save) {
        if (save == true) {
          self.form['postForm'](self.base_url + '/' + self.create_url).then(function (response) {
            if (response.success) {
              Utilities.showToast(self, 'success', 'Account Statement updated successfully', 2200, true);
              self.$emit('closeTriggered');
            }
          })["catch"](function (error) {
            console.log(error);
          });
        }
      }, true, false);
    },
    addAdditionalForm: function addAdditionalForm() {
      var errors = false;
      var erors_object = {};

      if (this.additional_form.additional_credit_type == '') {
        erors_object.additional_credit_type = ["credit type required"];
        errors = true;
      }

      if (this.additional_form.additional_credit_amount == '') {
        erors_object.additional_credit_amount = ["additional credit amount required"];
        errors = true;
      }

      if (this.additional_form.from_date == '') {
        erors_object.from_date = ["from date is required"];
        errors = true;
      }

      if (this.additional_form.to_date == '') {
        erors_object.to_date = ["To date is required"];
        errors = true;
      }

      if (moment(this.additional_form.from_date, 'MM-DD-YYYY').isAfter(moment(this.additional_form.to_date, 'MM-DD-YYYY'))) {
        erors_object.to_date = ["To date should be greater than from date"];
        errors = true;
      }

      this.additional_form.errors.record(erors_object);

      if (errors == true) {
        return;
      }

      var self = this;
      var detail = getNewTransaction();
      var is_index = this.additional_form.edit_index;
      this.additional_form.edit_index = -1;
      Utilities.copyProperties(this.additional_form, detail);
      console.log("is_index");
      console.log(is_index);

      if (is_index >= 0) {
        this.form.account_statement_transactions[is_index] = detail;
      } else {
        this.form.account_statement_transactions.push(detail);
      }

      this.additional_form = getTransactionForm();
      this.initialCreditType = [];
      this.selectedCreditType = [];
    },
    getPurchaserCredit: function getPurchaserCredit(statement, index) {
      if (statement.additional_credit_to == 'purchaser') {
        return statement.additional_credit_amount;
      } else {
        return 0;
      } //*************************old below */


      var self = this;
      var total = this.purchaser_credit;
      this.form.account_statement_transactions.forEach(function (element, ind) {
        if (element.additional_credit_to == 'purchaser' && ind <= index) {
          total += Utilities.round(element.additional_credit_amount);
        }
      });
      return Utilities.round(total);
    },
    getSellerCredit: function getSellerCredit(statement, index) {
      if (statement.additional_credit_to == 'seller') {
        return statement.additional_credit_amount;
      } else {
        return 0;
      } //*************************old below */


      var self = this;
      var total = this.seller_credit;
      this.form.account_statement_transactions.forEach(function (element, ind) {
        if (element.additional_credit_to == 'seller' && ind <= index) {
          console.log("element is");
          console.log(element);
          console.log("ind : " + ind);
          console.log("index : " + index);
          total += Utilities.round(element.additional_credit_amount);
          console.log("amount added in total " + element.additional_credit_amount);
          console.log(" Now  TOtal is  " + total);
        }
      });
      return Utilities.round(total);
    },
    removeTransaction: function removeTransaction(index) {
      this.form.account_statement_transactions.splice(index, 1);
    },
    editTransaction: function editTransaction(index) {
      var self = this;
      this.additional_form = getTransactionForm();
      this.additional_form.edit_index = index;
      this.show = false;
      Utilities.copyProperties(this.form.account_statement_transactions[index], this.additional_form);
      this.initialCreditType = [{
        'text': this.form.account_statement_transactions[index].additional_credit_type,
        'id': 0
      }];
      this.selectedCreditType = [0];
      setTimeout(function () {
        self.show = true;
      }, 200);
    }
  }
});

/***/ }),

/***/ "./node_modules/mini-css-extract-plugin/dist/loader.js??clonedRuleSet-10[0].rules[0].use[0]!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-10[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ProjectComponents/Matters/Accounts/AccountStatementTab.vue?vue&type=style&index=0&lang=css&":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/mini-css-extract-plugin/dist/loader.js??clonedRuleSet-10[0].rules[0].use[0]!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-10[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ProjectComponents/Matters/Accounts/AccountStatementTab.vue?vue&type=style&index=0&lang=css& ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/js/components/ProjectComponents/Matters/Accounts/AccountStatementTab.vue":
/*!********************************************************************************************!*\
  !*** ./resources/js/components/ProjectComponents/Matters/Accounts/AccountStatementTab.vue ***!
  \********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _AccountStatementTab_vue_vue_type_template_id_56de55b2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./AccountStatementTab.vue?vue&type=template&id=56de55b2& */ "./resources/js/components/ProjectComponents/Matters/Accounts/AccountStatementTab.vue?vue&type=template&id=56de55b2&");
/* harmony import */ var _AccountStatementTab_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./AccountStatementTab.vue?vue&type=script&lang=js& */ "./resources/js/components/ProjectComponents/Matters/Accounts/AccountStatementTab.vue?vue&type=script&lang=js&");
/* harmony import */ var _AccountStatementTab_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./AccountStatementTab.vue?vue&type=style&index=0&lang=css& */ "./resources/js/components/ProjectComponents/Matters/Accounts/AccountStatementTab.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _AccountStatementTab_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _AccountStatementTab_vue_vue_type_template_id_56de55b2___WEBPACK_IMPORTED_MODULE_0__.render,
  _AccountStatementTab_vue_vue_type_template_id_56de55b2___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ProjectComponents/Matters/Accounts/AccountStatementTab.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ProjectComponents/Matters/Accounts/AccountStatementTab.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************!*\
  !*** ./resources/js/components/ProjectComponents/Matters/Accounts/AccountStatementTab.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AccountStatementTab_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./AccountStatementTab.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ProjectComponents/Matters/Accounts/AccountStatementTab.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AccountStatementTab_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/ProjectComponents/Matters/Accounts/AccountStatementTab.vue?vue&type=style&index=0&lang=css&":
/*!*****************************************************************************************************************************!*\
  !*** ./resources/js/components/ProjectComponents/Matters/Accounts/AccountStatementTab.vue?vue&type=style&index=0&lang=css& ***!
  \*****************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_mini_css_extract_plugin_dist_loader_js_clonedRuleSet_10_0_rules_0_use_0_node_modules_css_loader_dist_cjs_js_clonedRuleSet_10_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_10_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_AccountStatementTab_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/mini-css-extract-plugin/dist/loader.js??clonedRuleSet-10[0].rules[0].use[0]!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-10[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./AccountStatementTab.vue?vue&type=style&index=0&lang=css& */ "./node_modules/mini-css-extract-plugin/dist/loader.js??clonedRuleSet-10[0].rules[0].use[0]!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-10[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ProjectComponents/Matters/Accounts/AccountStatementTab.vue?vue&type=style&index=0&lang=css&");


/***/ }),

/***/ "./resources/js/components/ProjectComponents/Matters/Accounts/AccountStatementTab.vue?vue&type=template&id=56de55b2&":
/*!***************************************************************************************************************************!*\
  !*** ./resources/js/components/ProjectComponents/Matters/Accounts/AccountStatementTab.vue?vue&type=template&id=56de55b2& ***!
  \***************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AccountStatementTab_vue_vue_type_template_id_56de55b2___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AccountStatementTab_vue_vue_type_template_id_56de55b2___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AccountStatementTab_vue_vue_type_template_id_56de55b2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./AccountStatementTab.vue?vue&type=template&id=56de55b2& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ProjectComponents/Matters/Accounts/AccountStatementTab.vue?vue&type=template&id=56de55b2&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ProjectComponents/Matters/Accounts/AccountStatementTab.vue?vue&type=template&id=56de55b2&":
/*!******************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ProjectComponents/Matters/Accounts/AccountStatementTab.vue?vue&type=template&id=56de55b2& ***!
  \******************************************************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "form-horizontal" }, [
    _c("div", { staticClass: "card-body" }, [
      _c("div", { staticClass: "form-row" }, [
        _c("div", { staticClass: "col-md-3" }, [
          _c("div", { staticClass: "form-group" }, [
            _c(
              "label",
              { staticClass: "in-label-title ", attrs: { for: "date" } },
              [_vm._v(" Adjustment Date")]
            ),
            _vm._v(" "),
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.form.date,
                  expression: "form.date",
                },
              ],
              staticClass: "form-control",
              class: { "is-invalid": _vm.form.errors.get("date") },
              attrs: { disabled: "", type: "text" },
              domProps: { value: _vm.form.date },
              on: {
                input: function ($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.$set(_vm.form, "date", $event.target.value)
                },
              },
            }),
            _vm._v(" "),
            _vm.form.errors.get("date")
              ? _c(
                  "span",
                  {
                    staticClass: "invalid-feedback",
                    attrs: { id: "basic-msg" },
                  },
                  [_vm._v(_vm._s(_vm.form.errors.get("date")))]
                )
              : _vm._e(),
          ]),
        ]),
      ]),
      _vm._v(" "),
      _c("table", { staticClass: "table" }, [
        _vm._m(0),
        _vm._v(" "),
        _c(
          "tbody",
          [
            _c("tr", [
              _c("td", [_vm._v("Sale Price")]),
              _vm._v(" "),
              _c("td"),
              _vm._v(" "),
              _c("td", [
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.form.account_statement.sale_price,
                      expression: "form.account_statement.sale_price",
                    },
                  ],
                  staticClass: "form-control",
                  class: { "is-invalid": _vm.form.errors.get("sale_price") },
                  attrs: { type: "text" },
                  domProps: { value: _vm.form.account_statement.sale_price },
                  on: {
                    input: function ($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.$set(
                        _vm.form.account_statement,
                        "sale_price",
                        $event.target.value
                      )
                    },
                  },
                }),
              ]),
            ]),
            _vm._v(" "),
            _c("tr", [
              _c("td", [_vm._v("Deposit ")]),
              _vm._v(" "),
              _c("td", [
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.form.account_statement.deposit,
                      expression: "form.account_statement.deposit",
                    },
                  ],
                  staticClass: "form-control",
                  class: { "is-invalid": _vm.form.errors.get("deposit") },
                  attrs: { type: "text" },
                  domProps: { value: _vm.form.account_statement.deposit },
                  on: {
                    input: function ($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.$set(
                        _vm.form.account_statement,
                        "deposit",
                        $event.target.value
                      )
                    },
                  },
                }),
              ]),
              _vm._v(" "),
              _c("td"),
            ]),
            _vm._v(" "),
            _c("tr", [
              _c("td", [
                _vm._v("Property Taxes\n                        "),
                _c(
                  "select",
                  {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.form.account_statement.property_tax,
                        expression: "form.account_statement.property_tax",
                      },
                    ],
                    staticClass: "form-control",
                    class: {
                      "is-invalid": _vm.form.errors.get("property_tax"),
                    },
                    attrs: { "aria-placeholder": "Select" },
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
                          _vm.form.account_statement,
                          "property_tax",
                          $event.target.multiple
                            ? $$selectedVal
                            : $$selectedVal[0]
                        )
                      },
                    },
                  },
                  [
                    _c("option", { attrs: { value: "final" } }, [
                      _vm._v("Final"),
                    ]),
                    _vm._v(" "),
                    _c("option", { attrs: { value: "interim" } }, [
                      _vm._v("Interim"),
                    ]),
                    _vm._v(" "),
                    _c("option", { attrs: { value: "previous" } }, [
                      _vm._v("Previous"),
                    ]),
                  ]
                ),
              ]),
              _vm._v(" "),
              _c("td"),
              _vm._v(" "),
              _c("td"),
            ]),
            _vm._v(" "),
            _c("tr", [
              _c("td", [
                _vm._v("Total Taxes\n                         "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.form.account_statement.total_taxes,
                      expression: "form.account_statement.total_taxes",
                    },
                  ],
                  staticClass: "form-control",
                  class: { "is-invalid": _vm.form.errors.get("total_taxes") },
                  attrs: { type: "text" },
                  domProps: { value: _vm.form.account_statement.total_taxes },
                  on: {
                    input: function ($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.$set(
                        _vm.form.account_statement,
                        "total_taxes",
                        $event.target.value
                      )
                    },
                  },
                }),
              ]),
              _vm._v(" "),
              _c("td"),
              _vm._v(" "),
              _c("td"),
            ]),
            _vm._v(" "),
            _c("tr", [
              _c("td", [
                _vm._v("Taxes Paid\n                          "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.form.account_statement.taxes_paid,
                      expression: "form.account_statement.taxes_paid",
                    },
                  ],
                  staticClass: "form-control",
                  class: { "is-invalid": _vm.form.errors.get("taxes_paid") },
                  attrs: { type: "text" },
                  domProps: { value: _vm.form.account_statement.taxes_paid },
                  on: {
                    input: function ($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.$set(
                        _vm.form.account_statement,
                        "taxes_paid",
                        $event.target.value
                      )
                    },
                  },
                }),
              ]),
              _vm._v(" "),
              _c("td"),
              _vm._v(" "),
              _c("td"),
            ]),
            _vm._v(" "),
            _c("tr", [
              _c("td", [
                _vm._v("Seller share\n                        "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.seller_share,
                      expression: "seller_share",
                    },
                  ],
                  staticClass: "form-control",
                  class: { "is-invalid": _vm.form.errors.get("seller_share") },
                  attrs: { type: "text", disabled: "" },
                  domProps: { value: _vm.seller_share },
                  on: {
                    input: function ($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.seller_share = $event.target.value
                    },
                  },
                }),
              ]),
              _vm._v(" "),
              _c("td", [
                _c("span", [_vm._v(" ")]),
                _vm._v(" "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.purchaser_credit,
                      expression: "purchaser_credit",
                    },
                  ],
                  staticClass: "form-control",
                  attrs: { type: "text", disabled: "" },
                  domProps: { value: _vm.purchaser_credit },
                  on: {
                    input: function ($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.purchaser_credit = $event.target.value
                    },
                  },
                }),
              ]),
              _vm._v(" "),
              _c("td", [
                _c("span", [_vm._v(" ")]),
                _vm._v(" "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.seller_credit,
                      expression: "seller_credit",
                    },
                  ],
                  staticClass: "form-control",
                  attrs: { type: "text", disabled: "" },
                  domProps: { value: _vm.seller_credit },
                  on: {
                    input: function ($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.seller_credit = $event.target.value
                    },
                  },
                }),
              ]),
            ]),
            _vm._v(" "),
            _vm._l(
              _vm.form.account_statement_transactions,
              function (statement, index) {
                return _c("tr", { key: statement.random }, [
                  _c("td", [
                    _c("span", [
                      _c("strong", [
                        _vm._v(_vm._s(statement.additional_credit_type)),
                      ]),
                    ]),
                    _vm._v(" "),
                    _c(
                      "span",
                      {
                        staticClass: "iw-edit-icon",
                        attrs: { title: "edit" },
                        on: {
                          click: function ($event) {
                            $event.preventDefault()
                            return _vm.editTransaction(index)
                          },
                        },
                      },
                      [_c("span", { staticClass: "mdi mdi-pencil" })]
                    ),
                    _vm._v(" "),
                    _c(
                      "span",
                      {
                        staticClass: "iw-remove-icon",
                        attrs: { title: "delete" },
                        on: {
                          click: function ($event) {
                            $event.preventDefault()
                            return _vm.removeTransaction()
                          },
                        },
                      },
                      [_c("span", { staticClass: "mdi mdi-delete" })]
                    ),
                    _vm._v(" "),
                    _c("p", { staticClass: "my-1" }, [
                      _vm._v(_vm._s(statement.remarks)),
                    ]),
                  ]),
                  _vm._v(" "),
                  _c("td", [
                    _c("input", {
                      staticClass: "form-control",
                      attrs: { type: "text", disabled: "" },
                      domProps: {
                        value: _vm.getPurchaserCredit(statement, index),
                      },
                    }),
                  ]),
                  _vm._v(" "),
                  _c("td", [
                    _c("input", {
                      staticClass: "form-control",
                      attrs: { type: "text", disabled: "" },
                      domProps: {
                        value: _vm.getSellerCredit(statement, index),
                      },
                    }),
                  ]),
                ])
              }
            ),
            _vm._v(" "),
            _c("tr", [
              _vm._m(1),
              _vm._v(" "),
              _c("td", [
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.purchaser_total,
                      expression: "purchaser_total",
                    },
                  ],
                  staticClass: "form-control",
                  class: {
                    "is-invalid": _vm.form.errors.get("purchaser_total"),
                  },
                  attrs: { type: "text", disabled: "" },
                  domProps: { value: _vm.purchaser_total },
                  on: {
                    input: function ($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.purchaser_total = $event.target.value
                    },
                  },
                }),
              ]),
              _vm._v(" "),
              _c("td", [
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.seller_total,
                      expression: "seller_total",
                    },
                  ],
                  staticClass: "form-control",
                  class: { "is-invalid": _vm.form.errors.get("seller_total") },
                  attrs: { type: "text", disabled: "" },
                  domProps: { value: _vm.seller_total },
                  on: {
                    input: function ($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.seller_total = $event.target.value
                    },
                  },
                }),
              ]),
            ]),
            _vm._v(" "),
            _c("tr", [
              _c("td", [_vm._v("Balance on Closing ")]),
              _vm._v(" "),
              _c("td", [
                _vm.balance_due < 0
                  ? _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.balance_payable,
                          expression: "balance_payable",
                        },
                      ],
                      staticClass: "form-control",
                      class: {
                        "is-invalid": _vm.form.errors.get("balance_due"),
                      },
                      attrs: { type: "text", disabled: "" },
                      domProps: { value: _vm.balance_payable },
                      on: {
                        input: function ($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.balance_payable = $event.target.value
                        },
                      },
                    })
                  : _vm._e(),
              ]),
              _vm._v(" "),
              _c("td", [
                _vm.balance_due >= 0
                  ? _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.balance_payable,
                          expression: "balance_payable",
                        },
                      ],
                      staticClass: "form-control",
                      class: {
                        "is-invalid": _vm.form.errors.get("balance_due"),
                      },
                      attrs: { type: "text", disabled: "" },
                      domProps: { value: _vm.balance_payable },
                      on: {
                        input: function ($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.balance_payable = $event.target.value
                        },
                      },
                    })
                  : _vm._e(),
              ]),
            ]),
            _vm._v(" "),
            _c("tr", [
              _c("td", { attrs: { colspan: "3" } }, [
                _c("div", { staticClass: "d-flex align-items-center" }, [
                  _c("span", { staticClass: "mr-2" }, [_vm._v("Remarks")]),
                  _vm._v(" "),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.form.account_statement.remarks,
                        expression: "form.account_statement.remarks",
                      },
                    ],
                    staticClass: "form-control",
                    class: { "is-invalid": _vm.form.errors.get("remarks") },
                    attrs: { type: "text" },
                    domProps: { value: _vm.form.account_statement.remarks },
                    on: {
                      input: function ($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(
                          _vm.form.account_statement,
                          "remarks",
                          $event.target.value
                        )
                      },
                    },
                  }),
                ]),
              ]),
            ]),
          ],
          2
        ),
      ]),
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "card-body" }, [
      _c("fieldset", [
        _c("legend", [_vm._v("Additional Credit")]),
        _vm._v(" "),
        _c("div", [
          _c("div", { staticClass: "form-row" }, [
            _c("div", { staticClass: "col-md-2" }, [
              _c(
                "div",
                { staticClass: "form-group" },
                [
                  _c(
                    "label",
                    {
                      staticClass: "in-label-title",
                      attrs: { for: "from_date" },
                    },
                    [_vm._v("From date")]
                  ),
                  _vm._v(" "),
                  _c("input", {
                    class: {
                      "is-invalid": _vm.additional_form.errors.get("from_date"),
                    },
                    attrs: { type: "hidden" },
                  }),
                  _vm._v(" "),
                  _c("date-picker", {
                    attrs: {
                      "class-name": _vm.additional_form.errors.get("from_date")
                        ? "from_date is-invalid"
                        : "from_date",
                    },
                    model: {
                      value: _vm.additional_form.from_date,
                      callback: function ($$v) {
                        _vm.$set(_vm.additional_form, "from_date", $$v)
                      },
                      expression: "additional_form.from_date",
                    },
                  }),
                  _vm._v(" "),
                  _vm.additional_form.errors.get("from_date")
                    ? _c(
                        "span",
                        {
                          staticClass: "invalid-feedback",
                          attrs: { id: "basic-msg" },
                        },
                        [
                          _vm._v(
                            _vm._s(_vm.additional_form.errors.get("from_date"))
                          ),
                        ]
                      )
                    : _vm._e(),
                ],
                1
              ),
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-md-2" }, [
              _c(
                "div",
                { staticClass: "form-group" },
                [
                  _c(
                    "label",
                    {
                      staticClass: "in-label-title",
                      attrs: { for: "to_date" },
                    },
                    [_vm._v("To date")]
                  ),
                  _vm._v(" "),
                  _c("input", {
                    class: {
                      "is-invalid": _vm.additional_form.errors.get("to_date"),
                    },
                    attrs: { type: "hidden" },
                  }),
                  _vm._v(" "),
                  _c("date-picker", {
                    attrs: {
                      "class-name": _vm.additional_form.errors.get("to_date")
                        ? "to_date is-invalid"
                        : "to_date",
                    },
                    model: {
                      value: _vm.additional_form.to_date,
                      callback: function ($$v) {
                        _vm.$set(_vm.additional_form, "to_date", $$v)
                      },
                      expression: "additional_form.to_date",
                    },
                  }),
                  _vm._v(" "),
                  _vm.additional_form.errors.get("to_date")
                    ? _c(
                        "span",
                        {
                          staticClass: "invalid-feedback",
                          attrs: { id: "basic-msg" },
                        },
                        [
                          _vm._v(
                            _vm._s(_vm.additional_form.errors.get("to_date"))
                          ),
                        ]
                      )
                    : _vm._e(),
                ],
                1
              ),
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col" }, [
              _c("div", { staticClass: "form-group" }, [
                _c(
                  "label",
                  {
                    staticClass: "in-label-title",
                    attrs: { for: "additional_credit_to" },
                  },
                  [_vm._v("Additional Credit to")]
                ),
                _vm._v(" "),
                _c(
                  "select",
                  {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.additional_form.additional_credit_to,
                        expression: "additional_form.additional_credit_to",
                      },
                    ],
                    staticClass: "form-control",
                    class: {
                      "is-invalid": _vm.additional_form.errors.get(
                        "additional_credit_to"
                      ),
                    },
                    attrs: { "aria-placeholder": "Select" },
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
                          _vm.additional_form,
                          "additional_credit_to",
                          $event.target.multiple
                            ? $$selectedVal
                            : $$selectedVal[0]
                        )
                      },
                    },
                  },
                  [
                    _c("option", { attrs: { value: "purchaser" } }, [
                      _vm._v("Purchaser"),
                    ]),
                    _vm._v(" "),
                    _c("option", { attrs: { value: "seller" } }, [
                      _vm._v("Seller"),
                    ]),
                  ]
                ),
                _vm._v(" "),
                _vm.additional_form.errors.get("additional_credit_to")
                  ? _c(
                      "span",
                      {
                        staticClass: "invalid-feedback",
                        attrs: { id: "basic-msg" },
                      },
                      [
                        _vm._v(
                          _vm._s(
                            _vm.additional_form.errors.get(
                              "additional_credit_to"
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
              _c(
                "div",
                { staticClass: "form-group" },
                [
                  _c(
                    "label",
                    {
                      staticClass: "in-label-title",
                      attrs: { for: "additional_credit_type" },
                    },
                    [_vm._v("Credit Type")]
                  ),
                  _vm._v(" "),
                  _vm.show
                    ? _c("credit-type-select", {
                        class: {
                          "is-invalid": _vm.additional_form.errors.get(
                            "additional_credit_type"
                          ),
                        },
                        attrs: {
                          initials: _vm.initialCreditType,
                          selected: _vm.selectedCreditType,
                          "string-value": true,
                          "aria-placeholder": "Select",
                        },
                        model: {
                          value: _vm.additional_form.additional_credit_type,
                          callback: function ($$v) {
                            _vm.$set(
                              _vm.additional_form,
                              "additional_credit_type",
                              $$v
                            )
                          },
                          expression: "additional_form.additional_credit_type",
                        },
                      })
                    : _vm._e(),
                  _vm._v(" "),
                  _vm.additional_form.errors.get("additional_credit_type")
                    ? _c(
                        "span",
                        {
                          staticClass: "invalid-feedback",
                          attrs: { id: "basic-msg" },
                        },
                        [
                          _vm._v(
                            _vm._s(
                              _vm.additional_form.errors.get(
                                "additional_credit_type"
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
          _c("div", { staticClass: "form-row align-items-end" }, [
            _c("div", { staticClass: "col" }, [
              _c("div", { staticClass: "form-group" }, [
                _c(
                  "label",
                  {
                    staticClass: "in-label-title",
                    attrs: { for: "total_amount" },
                  },
                  [_vm._v("Total Amount")]
                ),
                _vm._v(" "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.additional_form.total_amount,
                      expression: "additional_form.total_amount",
                    },
                  ],
                  staticClass: "form-control",
                  class: {
                    "is-invalid":
                      _vm.additional_form.errors.get("total_amount"),
                  },
                  attrs: { type: "text", "aria-placeholder": "Select" },
                  domProps: { value: _vm.additional_form.total_amount },
                  on: {
                    input: function ($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.$set(
                        _vm.additional_form,
                        "total_amount",
                        $event.target.value
                      )
                    },
                  },
                }),
                _vm._v(" "),
                _vm.additional_form.errors.get("total_amount")
                  ? _c(
                      "span",
                      {
                        staticClass: "invalid-feedback",
                        attrs: { id: "basic-msg" },
                      },
                      [
                        _vm._v(
                          _vm._s(_vm.additional_form.errors.get("total_amount"))
                        ),
                      ]
                    )
                  : _vm._e(),
              ]),
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col" }, [
              _c("div", { staticClass: "form-group text-right" }, [
                _c(
                  "button",
                  {
                    staticClass: "btn btn-primary",
                    on: {
                      click: function ($event) {
                        $event.preventDefault()
                        return _vm.calculateCreditAmount()
                      },
                    },
                  },
                  [_vm._v("Calculate")]
                ),
              ]),
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col" }, [
              _c("div", { staticClass: "form-group" }, [
                _c(
                  "label",
                  {
                    staticClass: "in-label-title",
                    attrs: { for: "additional_credit_amount" },
                  },
                  [_vm._v("Additional Credit Amount")]
                ),
                _vm._v(" "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.additional_form.additional_credit_amount,
                      expression: "additional_form.additional_credit_amount",
                    },
                  ],
                  staticClass: "form-control",
                  class: {
                    "is-invalid": _vm.additional_form.errors.get(
                      "additional_credit_amount"
                    ),
                  },
                  attrs: { type: "text", "aria-placeholder": "Select" },
                  domProps: {
                    value: _vm.additional_form.additional_credit_amount,
                  },
                  on: {
                    input: function ($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.$set(
                        _vm.additional_form,
                        "additional_credit_amount",
                        $event.target.value
                      )
                    },
                  },
                }),
                _vm._v(" "),
                _vm.additional_form.errors.get("additional_credit_amount")
                  ? _c(
                      "span",
                      {
                        staticClass: "invalid-feedback",
                        attrs: { id: "basic-msg" },
                      },
                      [
                        _vm._v(
                          _vm._s(
                            _vm.additional_form.errors.get(
                              "additional_credit_amount"
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
            _c("div", { staticClass: "col" }, [
              _c("div", { staticClass: "form-group" }, [
                _c(
                  "label",
                  { staticClass: "in-label-title", attrs: { for: "re" } },
                  [_vm._v("Remarks")]
                ),
                _vm._v(" "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.additional_form.remarks,
                      expression: "additional_form.remarks",
                    },
                  ],
                  staticClass: "form-control",
                  class: {
                    "is-invalid": _vm.additional_form.errors.get("remarks"),
                  },
                  attrs: { type: "text" },
                  domProps: { value: _vm.additional_form.remarks },
                  on: {
                    input: function ($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.$set(
                        _vm.additional_form,
                        "remarks",
                        $event.target.value
                      )
                    },
                  },
                }),
              ]),
            ]),
          ]),
          _vm._v(" "),
          _c(
            "button",
            {
              staticClass: "btn btn-primary",
              on: {
                click: function ($event) {
                  $event.preventDefault()
                  return _vm.addAdditionalForm($event)
                },
              },
            },
            [_c("span", { staticClass: "mdi mdi-plus" }), _vm._v(" Add")]
          ),
        ]),
      ]),
    ]),
  ])
}
var staticRenderFns = [
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", { attrs: { scope: "col" } }, [_vm._v("Particulars")]),
        _vm._v(" "),
        _c("th", { attrs: { scope: "col", width: "220" } }, [
          _vm._v("Purchaser Credit"),
        ]),
        _vm._v(" "),
        _c("th", { attrs: { scope: "col", width: "220" } }, [
          _vm._v("Seller Credit"),
        ]),
      ]),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("td", [
      _c("strong", [
        _vm._v("\n                        Total\n                        "),
      ]),
    ])
  },
]
render._withStripped = true



/***/ })

}]);