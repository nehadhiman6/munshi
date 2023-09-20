"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ProjectComponents_Download_WithLetterHeadDocuments_LetterToBrokerageT-a39c69"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ProjectComponents/Download/WithLetterHeadDocuments/LetterToBrokerageToPayoutCommission1.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ProjectComponents/Download/WithLetterHeadDocuments/LetterToBrokerageToPayoutCommission1.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var docx__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! docx */ "./node_modules/docx/build/index.js");
/* harmony import */ var docx__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(docx__WEBPACK_IMPORTED_MODULE_1__);


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['client_name', 'client_sub_title', 'client_address', 'file_opening_id', 'client_phone', 'client_email', 'file_opening'],
  computed: {
    componentInstance: function componentInstance() {
      var name = lh_no;
      return function () {
        return __webpack_require__("./resources/js/components/ProjectComponents/Download lazy recursive ^\\.\\/.*$")("./".concat(name));
      };
    }
  },
  data: function data() {
    return {
      content: ''
    };
  },
  mounted: function mounted() {
    this.getImageContent();
  },
  methods: {
    getImageContent: function getImageContent() {
      var self = this;

      var getBase64FromUrl = /*#__PURE__*/function () {
        var _ref = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee(url) {
          var data, blob;
          return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
            while (1) {
              switch (_context.prev = _context.next) {
                case 0:
                  _context.next = 2;
                  return fetch(url);

                case 2:
                  data = _context.sent;
                  _context.next = 5;
                  return data.blob();

                case 5:
                  blob = _context.sent;
                  return _context.abrupt("return", new Promise(function (resolve) {
                    var reader = new FileReader();
                    reader.readAsDataURL(blob);

                    reader.onloadend = function () {
                      var base64data = reader.result;
                      resolve(base64data);
                    };
                  }));

                case 7:
                case "end":
                  return _context.stop();
              }
            }
          }, _callee);
        }));

        return function getBase64FromUrl(_x) {
          return _ref.apply(this, arguments);
        };
      }();

      var image_url = '';
      getBase64FromUrl('https://lh3.googleusercontent.com/i7cTyGnCwLIJhT1t2YpLW-zHt8ZKalgQiqfrYnZQl975-ygD_0mOXaYZMzekfKW_ydHRutDbNzeqpWoLkFR4Yx2Z2bgNj2XskKJrfw8').then(function (url) {
        self.getContent(url.replace(/^data:image\/(png|jpg);base64,/, ""));
      });
    },
    getContent: function getContent(image_url) {
      var self = this;
      var section = [];
      var current_date = moment().format('LL');
      var closing_date = self.file_opening.closing_date ? moment(self.file_opening.closing_date, 'DD-MM-YYYY').format("LL") : "";
      var seller1 = '';

      if (self.file_opening.sellers && self.file_opening.sellers.length > 0) {
        seller1 += self.file_opening.sellers[0].first_name ? self.file_opening.sellers[0].first_name + ' ' : '';
        seller1 += self.file_opening.sellers[0].middle_name ? self.file_opening.sellers[0].middle_name + ' ' : '';
        seller1 += self.file_opening.sellers[0].last_name ? self.file_opening.sellers[0].last_name + ' ' : '';

        if (seller1 == '') {
          seller1 = 'Seller 1';
        }
      }

      var seller2 = '';

      if (self.file_opening.sellers && self.file_opening.sellers.length > 1) {
        seller2 += self.file_opening.sellers[1].first_name ? self.file_opening.sellers[1].first_name + ' ' : '';
        seller2 += self.file_opening.sellers[1].middle_name ? self.file_opening.sellers[1].middle_name + ' ' : '';
        seller2 += self.file_opening.sellers[1].last_name ? self.file_opening.sellers[1].last_name + ' ' : '';

        if (seller2 == '') {
          seller2 = 'Seller 2';
        }
      }

      var purchaser1 = "";
      var to = "";
      var purchasers = self.file_opening.purchasers ? self.file_opening.purchasers : [];
      purchasers.forEach(function (element, index) {
        if (element.salutation == "Corporation") {
          to += element.company_name + " ";
        } else {
          to += element.first_name ? element.first_name + " " : " ";
          to += element.middle_name ? element.middle_name + " " : "";
          to += element.last_name ? element.last_name + " " : "";
        }

        if (index == 0) {
          purchaser1 = to;
        }

        if (index < purchasers.length - 1 && index != purchasers.length - 2) {
          to += ",";
        } else if (index == purchasers.length - 2) {
          to += " and ";
        }

        to += " ";
      });
      var property = self.file_opening.property;
      console.log(property);

      if (property) {
        var re = "";
        re += property.street_no ? property.street_no + ", " : "";
        re += property.street_name ? property.street_name + ", " : "";
        re += property.unit_no ? property.unit_no + ", " : " ";
        re += property.city ? property.city.city_name + ", " : "";
        re += property.province ? property.province + ", " : "";
        re += property.postal_code ? property.postal_code : "";
      }

      var str = self.client_name;
      var matches = str.match(/\b(\w)/g); // ['L','G']

      var acronym = matches.join(' '); //

      section.push({
        children: [new docx__WEBPACK_IMPORTED_MODULE_1__.Paragraph({
          children: [new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: current_date,
            "break": 2
          }), new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: seller1 + " and " + seller2,
            "break": 2
          }), new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: property.street_no ? property.street_no + ", " + property.street_name : "",
            "break": 1
          }), new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: property.city ? property.city.city_name + ", " + property.province : "",
            "break": 1
          }), new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: "Dear Mr. and Mrs.:",
            "break": 2
          }), new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: "RE:",
            "break": 2
          }), new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: "\t " + seller1 + "and " + seller2 + " (the 'Vendor') s/t " + to
          }), new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: "\t " + purchaser1 + " (the \"Purchaser\")",
            "break": 1
          }), new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: "\t " + re + " (the \"Property\")",
            "break": 1
          }), new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: '\t Closing Date:' + '\t ' + closing_date,
            "break": 1
          }), new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: '\t Our File No:' + '\t ' + self.file_opening.file_no,
            "break": 1
          })],
          border: {
            bottom: {
              color: "auto",
              space: 5,
              value: "single",
              size: 7
            }
          },
          spacing: {
            after: 200,
            before: 200
          }
        }), new docx__WEBPACK_IMPORTED_MODULE_1__.Paragraph({
          children: [new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: "In furtherance to our initial letter, please note as part of our practice our office would be contacting all the utilities to notify about the ownership change to new purchase’s name. However, these department require owners to contact as well. It is your responsibility to pay for these accounts before the date of closing. "
          }), new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: "If the closing date changes, please advise the utility companies of the new date.",
            bold: true
          })],
          spacing: {
            after: 200,
            before: 200
          }
        }), new docx__WEBPACK_IMPORTED_MODULE_1__.Paragraph({
          children: [new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: "Following are the contact numbers for the utilities as well as the website link of the departments to close the accounts online:"
          })],
          spacing: {
            after: 200,
            before: 200
          }
        }), new docx__WEBPACK_IMPORTED_MODULE_1__.Paragraph({
          children: [new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: "Alectra Utilities-\t\t "
          }), new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: "Ph: 	(905) 840-6300"
          }), new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: "\t\t\t Email: ",
            "break": 1
          }), new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: "BramptonCS@alectrautilities.com",
            color: 'blue'
          }), new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: "\t\t\t Online: ",
            "break": 1
          }), new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: "\t\t\t https://alectrautilities.com/residential-customer-open-transfer-or-close-account?",
            color: 'blue',
            "break": 1
          })],
          spacing: {
            after: 200,
            before: 200
          }
        }), new docx__WEBPACK_IMPORTED_MODULE_1__.Paragraph({
          children: [new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: "Water Department:\t "
          }), new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: "Ph: 	(905) 791-7400 / (905) 791-8711"
          }), new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: "\t\t\t Email: ",
            "break": 1
          }), new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: "utilityarrearscertificates@peelregion.ca",
            color: 'blue'
          }), new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: "\t\t\t Online: ",
            "break": 1
          }), new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: "\t\t\t https://peelregion.ca/water/billing/changes.asp",
            color: 'blue',
            "break": 1
          })],
          spacing: {
            after: 200,
            before: 200
          }
        }), new docx__WEBPACK_IMPORTED_MODULE_1__.Paragraph({
          children: [new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: "Gas Department:\t "
          }), new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: "Ph: 	(877) 362-7434 / (519) 352-3100"
          }), new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: "\t\t\t Online: ",
            "break": 1
          }), new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: "\t\t\t https://www.enbridgegas.com/Contact-Us",
            color: 'blue',
            "break": 1
          })],
          spacing: {
            after: 200,
            before: 200
          }
        }), new docx__WEBPACK_IMPORTED_MODULE_1__.Paragraph({
          children: [new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: "Tax Department:\t "
          }), new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: "Ph: 	(905) 874-2200"
          }), new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: "\t\t\t Email: ",
            "break": 1
          }), new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: "311@brampton.ca",
            color: 'blue'
          }), new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: "\t\t\t Online: ",
            "break": 1
          }), new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: "\t\t\t https://www.brampton.ca/EN/Residents/Taxes-Assessment/TaxOnline/Pages/Welcome.aspx",
            color: 'blue',
            "break": 1
          }) // new PageBreak()
          ],
          spacing: {
            after: 200,
            before: 200
          }
        }), new docx__WEBPACK_IMPORTED_MODULE_1__.Paragraph({
          children: [new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: "Please contact the departments listed above at your earliest convinience.",
            bold: true,
            "break": 1
          }), new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: "Yours very truly,",
            "break": 2
          }), new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: "Lakhwinder Gill",
            "break": 3
          }), new docx__WEBPACK_IMPORTED_MODULE_1__.TextRun({
            text: acronym,
            "break": 2
          })]
        })]
      });
      console.log(section);
      self.content = section;
    }
  }
});

/***/ }),

/***/ "./resources/js/components/ProjectComponents/Download/WithLetterHeadDocuments/LetterToBrokerageToPayoutCommission1.vue":
/*!*****************************************************************************************************************************!*\
  !*** ./resources/js/components/ProjectComponents/Download/WithLetterHeadDocuments/LetterToBrokerageToPayoutCommission1.vue ***!
  \*****************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _LetterToBrokerageToPayoutCommission1_vue_vue_type_template_id_4c07ebaf___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./LetterToBrokerageToPayoutCommission1.vue?vue&type=template&id=4c07ebaf& */ "./resources/js/components/ProjectComponents/Download/WithLetterHeadDocuments/LetterToBrokerageToPayoutCommission1.vue?vue&type=template&id=4c07ebaf&");
/* harmony import */ var _LetterToBrokerageToPayoutCommission1_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./LetterToBrokerageToPayoutCommission1.vue?vue&type=script&lang=js& */ "./resources/js/components/ProjectComponents/Download/WithLetterHeadDocuments/LetterToBrokerageToPayoutCommission1.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _LetterToBrokerageToPayoutCommission1_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _LetterToBrokerageToPayoutCommission1_vue_vue_type_template_id_4c07ebaf___WEBPACK_IMPORTED_MODULE_0__.render,
  _LetterToBrokerageToPayoutCommission1_vue_vue_type_template_id_4c07ebaf___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ProjectComponents/Download/WithLetterHeadDocuments/LetterToBrokerageToPayoutCommission1.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ProjectComponents/Download/WithLetterHeadDocuments/LetterToBrokerageToPayoutCommission1.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************!*\
  !*** ./resources/js/components/ProjectComponents/Download/WithLetterHeadDocuments/LetterToBrokerageToPayoutCommission1.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_LetterToBrokerageToPayoutCommission1_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./LetterToBrokerageToPayoutCommission1.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ProjectComponents/Download/WithLetterHeadDocuments/LetterToBrokerageToPayoutCommission1.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_LetterToBrokerageToPayoutCommission1_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/ProjectComponents/Download/WithLetterHeadDocuments/LetterToBrokerageToPayoutCommission1.vue?vue&type=template&id=4c07ebaf&":
/*!************************************************************************************************************************************************************!*\
  !*** ./resources/js/components/ProjectComponents/Download/WithLetterHeadDocuments/LetterToBrokerageToPayoutCommission1.vue?vue&type=template&id=4c07ebaf& ***!
  \************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_LetterToBrokerageToPayoutCommission1_vue_vue_type_template_id_4c07ebaf___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_LetterToBrokerageToPayoutCommission1_vue_vue_type_template_id_4c07ebaf___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_LetterToBrokerageToPayoutCommission1_vue_vue_type_template_id_4c07ebaf___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./LetterToBrokerageToPayoutCommission1.vue?vue&type=template&id=4c07ebaf& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ProjectComponents/Download/WithLetterHeadDocuments/LetterToBrokerageToPayoutCommission1.vue?vue&type=template&id=4c07ebaf&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ProjectComponents/Download/WithLetterHeadDocuments/LetterToBrokerageToPayoutCommission1.vue?vue&type=template&id=4c07ebaf&":
/*!***************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ProjectComponents/Download/WithLetterHeadDocuments/LetterToBrokerageToPayoutCommission1.vue?vue&type=template&id=4c07ebaf& ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************************/
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
  return _c(_vm.componentInstance, {
    tag: "component",
    attrs: {
      caption: "Letter to inform about utilities and POA ",
      "file-name":
        "letter_to_inform_about_utilities_and_poa" + _vm.file_opening.file_no,
      content: _vm.content,
      client_name: _vm.client_name,
      client_sub_title: _vm.client_sub_title,
      client_address: _vm.client_address,
      client_phone: _vm.client_phone,
      client_email: _vm.client_email,
    },
  })
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);